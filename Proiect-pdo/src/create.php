<?php
require_once 'connection.php';

// Set error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 1. Create first table - FIXED: Removed trailing comma
    $sql = "
    CREATE TABLE IF NOT EXISTS placements (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        imagine VARCHAR(80) NOT NULL,
        scor VARCHAR(80) NOT NULL,
        nume VARCHAR(80) NOT NULL
    )";
    $con->exec($sql);
    echo "<p>✅ Table 'placements' created or already exists</p>";

    // 2. Create second table
    $sql_update = " 
    CREATE TABLE IF NOT EXISTS placements_update (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nume VARCHAR(80),
        status VARCHAR(80),
        endtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"; 
    $con->exec($sql_update);
    echo "<p>✅ Table 'placements_update' created or already exists</p>";
    
    // 3. Clear existing data (be careful with this in production!)
    $con->exec("TRUNCATE TABLE placements");
    echo "<p>✅ Old data cleared from placements table</p>";
    
    // 4. Insert sample data
    $insert = $con->prepare("
        INSERT INTO placements (imagine, scor, nume)
        VALUES (:imagine, :scor, :nume)
    ");

    $users = [
        ["images/222.jpg", "345", "raul"],
        ["images/333.jpg", "123", "stefan"],
        ["images/444.jpg", "100", "admin"]
    ];

    $count = 0;
    foreach ($users as $u) {
        $insert->execute([
            ":imagine" => $u[0],
            ":scor" => $u[1],
            ":nume" => $u[2]
        ]);
        $count++;
    }
    echo "<p>✅ Inserted $count sample records</p>";

    // 5. Create triggers
    // Insert triggers
    $con->exec("DROP TRIGGER IF EXISTS BeforeInsertTrigger");
    $con->exec("
        CREATE TRIGGER BeforeInsertTrigger
        BEFORE INSERT ON placements
        FOR EACH ROW
        BEGIN
            SET NEW.nume = UPPER(NEW.nume);
        END
    ");
    echo "<p>✅ BeforeInsertTrigger created</p>";

    $con->exec("DROP TRIGGER IF EXISTS AfterInsertTrigger");
    $con->exec("
        CREATE TRIGGER AfterInsertTrigger
        AFTER INSERT ON placements
        FOR EACH ROW
        BEGIN
            INSERT INTO placements_update(nume, status, endtime)
            VALUES (NEW.nume, 'INSERTED', NOW());
        END
    ");
    echo "<p>✅ AfterInsertTrigger created</p>";

    // Update triggers
    $con->exec("DROP TRIGGER IF EXISTS BeforeUpdateTrigger");
    $con->exec("
        CREATE TRIGGER BeforeUpdateTrigger
        BEFORE UPDATE ON placements
        FOR EACH ROW
        BEGIN
            SET NEW.nume = LOWER(NEW.nume);
        END
    ");
    echo "<p>✅ BeforeUpdateTrigger created</p>";

    $con->exec("DROP TRIGGER IF EXISTS AfterUpdateTrigger");
    $con->exec("
        CREATE TRIGGER AfterUpdateTrigger
        AFTER UPDATE ON placements
        FOR EACH ROW
        BEGIN
            INSERT INTO placements_update(nume, status, endtime)
            VALUES (NEW.nume, 'UPDATED', NOW());
        END
    ");
    echo "<p>✅ AfterUpdateTrigger created</p>";

    // Delete trigger
    $con->exec("DROP TRIGGER IF EXISTS BeforeDeleteTrigger");
    $con->exec("
        CREATE TRIGGER BeforeDeleteTrigger
        BEFORE DELETE ON placements
        FOR EACH ROW
        BEGIN
            INSERT INTO placements_update(nume, status, endtime)
            VALUES (OLD.nume, 'DELETED', NOW());
        END
    ");
    echo "<p>✅ BeforeDeleteTrigger created</p>";

    echo "<h2 style='color: green;'>✔️ All tables and triggers created successfully!</h2>";
    
    // Show sample of what was inserted
    $stmt = $con->query("SELECT * FROM placements");
    $results = $stmt->fetchAll();
    
    echo "<h3>Sample Data Inserted:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Image</th><th>Score</th><th>Name</th></tr>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['imagine']) . "</td>";
        echo "<td>" . htmlspecialchars($row['scor']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
    echo "<p>Check your database connection and permissions.</p>";
}

exit;
?>
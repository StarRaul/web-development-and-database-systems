<?php
$con = mysqli_connect("mysql_db", "root", "toor", "scores");

// Auto-migration: adauga coloana 'joc' daca nu exista
$check = mysqli_query($con, "SHOW COLUMNS FROM placements LIKE 'joc'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($con, "ALTER TABLE placements ADD COLUMN joc VARCHAR(50) NOT NULL DEFAULT 'alanwake'");
}
?>

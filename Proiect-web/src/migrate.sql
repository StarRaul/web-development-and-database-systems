-- Run this once in your MySQL/MariaDB database to add the 'joc' column
ALTER TABLE placements ADD COLUMN joc VARCHAR(50) NOT NULL DEFAULT 'alanwake';

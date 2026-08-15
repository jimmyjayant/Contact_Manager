<?php

requireFile("../app/Config/Database_Connection.php");

$sql = "CREATE TABLE IF NOT EXISTS contacts(
user_id INT(6) UNSIGNED,
FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE,
form_number INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(255) NOT NULL,
middle_name VARCHAR(255),
last_name VARCHAR(255),
nickname VARCHAR(100),
gender ENUM('male', 'female'),
mobile_number VARCHAR(100) NULL UNIQUE,
landline_number VARCHAR(100) NULL UNIQUE,
addr VARCHAR(255),
relationship VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$result = $conn->query($sql);

if($result)
{
    echo "Table created successfully!";
}
else
{
    echo "Error creating table!";
}
?>

<?php

require_once "../app/Config/Database_Connection.php";

$sql = "CREATE TABLE IF NOT EXISTS user(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(200) NOT NULL,
lastname VARCHAR(200) NOT NULL,
email VARCHAR(200) NOT NULL UNIQUE,
user_password VARCHAR(255) NOT NULL,
contact INT(10) NOT NULL,
created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
token VARCHAR(100) NOT NULL UNIQUE
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

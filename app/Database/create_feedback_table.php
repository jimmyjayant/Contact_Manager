<?php

require("../app/Config/Database_Connection.php");

$sql = "CREATE TABLE IF NOT EXISTS feedback(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(200) NOT NULL,
lastname VARCHAR(200) NOT NULL,
contact INT(10) NOT NULL,
email VARCHAR(200) NOT NULL,
subject VARCHAR(255) NOT NULL,
msg VARCHAR(255) NOT NULL,
created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

<?php
require("../app/Config/Database_Connection.php");

$sql = "CREATE TABLE IF NOT EXISTS additional_fields(
userID INT(6) UNSIGNED,
FOREIGN KEY(userID) REFERENCES user(id) ON DELETE CASCADE,
form_no INT(6) UNSIGNED,
FOREIGN KEY(form_no) REFERENCES contacts(form_number) ON DELETE CASCADE,
field_name VARCHAR(255) NOT NULL,
field_value VARCHAR(255) NOT NULL
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

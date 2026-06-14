<?php
// PHP Script for fetching contact list of logged in user
require "../app/Views/sessionstart.php";
require_once "../app/Config/Database_Connection.php";

$token = $_SESSION['user_token'];
// sql query
$sql = "SELECT id FROM user WHERE token='{$token}'";

$result = $conn->query($sql);

if($result->num_rows > 0)
{
    $row = $result->fetch_assoc();

    $sql = "SELECT * FROM contacts WHERE user_id={$row['id']}";

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        echo "<table>";
        echo "<tr>";
        echo "<th>First Name</th>";
        echo "<th>Middle Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Nickname</th>";
        echo "<th>Gender</th>";
        echo "<th>Mobile Number</th>";
        echo "<th>Landline Number</th>";
        echo "<th>Address</th>";
        echo "<th>Relationship</th>";
        echo "<th>Created At</th>";
        echo "</tr>";

        while($row = $result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row['first_name'] ."</td>";
            echo "<td>" . $row['middle_name'] ."</td>";
            echo "<td>" . $row['last_name'] ."</td>";
            echo "<td>" . $row['nickname'] ."</td>";
            echo "<td>" . $row['gender'] ."</td>";
            echo "<td>" . $row['mobile_number'] ."</td>";
            echo "<td>" . $row['landline_number'] ."</td>";
            echo "<td>" . $row['addr'] ."</td>";
            echo "<td>" . $row['relationship'] ."</td>";
            echo "<td>" . $row['created_at'] ."</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    else
    {
        echo json_encode("No contact list!");
    }
}
?>

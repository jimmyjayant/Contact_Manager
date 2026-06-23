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
/*
    $sql = "SELECT * FROM contacts 
    LEFT JOIN additional_fields 
    ON contacts.form_number = additional_fields.form_no
    WHERE contacts.user_id={$row['id']}
    ORDER BY contacts.form_number";
*/

    $sql = "SELECT * FROM contacts WHERE user_id={$row['id']}";

    $result = $conn->query($sql);
    //$row = $result->fetch_assoc();
    //print_r($row);
    
    if($result->num_rows > 0)
    {
        ob_start();

        echo "<table>";
        echo "<tr>";
        echo "<th>Serial Number</th>";
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
            $formNumber = $row['form_number'];
            echo "<tr>";
            echo "<td>" . $row['form_number'] ."</td>";
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

            $sql = "SELECT * FROM additional_fields WHERE form_no = $formNumber";

            $result1 = $conn->query($sql);

            if($result1->num_rows > 0)
            {
                while($row = $result1->fetch_assoc())
                {
                    echo "<th>" . $row['field_name'] . "</th>";
                    echo "<td>" . $row['field_value'] . "</td>";
                }
            }
        }
        echo "</tr>";
        echo "</table>";

        $data['data'] = ob_get_contents();
        ob_end_clean();

        $data['status'] = "success";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
    }
    else
    {
        $data['status'] = "error";
        $data['data'] = "No contact list!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
    }
}
?>

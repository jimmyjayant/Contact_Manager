<?php
// PHP Script for fetching contact list of logged in user
require_once "../app/Views/sessionstart.php";
require_once "../app/Config/Database_Connection.php";

ini_set("display_errors", 0);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$token = $_SESSION['user_token'];
// sql query
$sql = "SELECT id FROM user WHERE token='{$token}'";

try
{
    if(!$conn)
    {
        $data['status'] = "error";
        $data['data'] = "Database server unavailable. Please try again later!";
        $data = json_encode($data);
        echo $data;
        exit();
    }

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $id = $row['id'];

        $sql = "SELECT COUNT(*) AS total FROM contacts WHERE user_id={$id}";

        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            // Total number of records
            $data['total_records'] = $row['total'];

            if($data['total_records'] == 0)
            {
                $data['status'] = "error";
                $data['data'] = "No contact list!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            $total_pages = ceil($data['total_records'] / 10);

            function test_input($input)
            {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input;
            }

            $page = $_GET['page'] ?? 1;

            $page = test_input($page);

            $page = floor((int)$page);

            if($page < 1 || $page > $total_pages)
            {
                $data['status'] = "error";
                $data['data'] = "Page Number must be between 1-$total_pages";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }

            $startingIndex = (($page - 1) * 10);

            $sql = "SELECT * FROM contacts WHERE user_id=$id LIMIT $startingIndex, 10";

            $result = $conn->query($sql);
            //$row = $result->fetch_assoc();
            //print_r($row);
            
            if($result->num_rows > 0)
            {
                ob_start();

                echo "<table>";
                echo "<tr>";
                echo "<th colspan='2'>Action</th>";
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
                    echo "<td>";
                    echo "<img src='public/images/edit_btn.png' class='edit_contact_btn' data-id='{$formNumber}'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<img src='public/images/delete_btn.png' class='delete_contact_btn' data-id='{$formNumber}'>";
                    echo "</td>";
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

                    $sql = "SELECT COUNT(*) AS total_fields FROM additional_fields WHERE form_no = $formNumber";

                    $result1 = $conn->query($sql);

                    if($result1->num_rows > 0)
                    {
                        $row = $result1->fetch_assoc();
                        $total_additional_fields = $row['total_fields'];
                        $total_additional_fields_pages = ceil($total_additional_fields / 10);

                        // Pagination here must be created in the future

                        $sql = "SELECT * FROM additional_fields WHERE form_no=$formNumber";

                        $result2 = $conn->query($sql);

                        if($result2->num_rows > 0)
                        {
                            while($row = $result2->fetch_assoc())
                            {
                                echo "<th>" . $row['field_name'] . "</th>";
                                echo "<td>" . $row['field_value'] . "</td>";
                            }
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
    }
}
catch(mysqli_sql_exception $e)
{
    error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
    $data['status'] = "error";
    $data['data'] = "Database server unavailable. Please try again later!";
    $data = json_encode($data);
    echo $data;
    exit();
}
?>

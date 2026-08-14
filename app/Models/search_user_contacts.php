<?php
    // Search User Contacts

    require_once "../app/Views/sessionstart.php";
    require_once "../app/Config/Database_Connection.php";

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $data['status'] = "error";
        $data['data'] = "Request Method is not POST!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

    if(!isset($_SESSION['user_token']))
    {
        $data['status'] = "error";
        $data['data'] = "Please login!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    $firstname = test_input($_POST['firstname']);

    if(empty($firstname))
    {
        $data['status'] = "error";
        $data['data'] = "Firstname cannot be empty!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
    else if(strlen($firstname) > 100)
    {
        $data['status'] = "error";
        $data['data'] = "Firstname cannot be more than 100 characters!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
    else if(preg_match_all("/\d/", $firstname))
    {
        $data['status'] = "error";
        $data['data'] = "Firstname cannot contain digits!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
    else if(preg_match_all("/\s/", $firstname))
    {
        $data['status'] = "error";
        $data['data'] = "Firstname cannot contain whitespaces!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
    else if(preg_match_all("/\W/", $firstname))
    {
        $data['status'] = "error";
        $data['data'] = "Firstname cannot contain special characters!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

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
            header("Content-Type: application/json");
            echo $data;
            exit();
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            $sql = "SELECT COUNT(*) AS total FROM contacts WHERE user_id={$id} AND first_name='$firstname'";

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

                $page = $_POST['page'] ?? 1;

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

                $sql = "SELECT * FROM contacts WHERE user_id=$id AND first_name='$firstname' LIMIT $startingIndex, 10";

                $result = $conn->query($sql);

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
                        echo "<td data-label='edit'>";
                        echo "<img src='public/images/edit_btn.png' class='edit_contact_btn' data-id='{$formNumber}'>";
                        echo "</td>";
                        echo "<td data-label='delete'>";
                        echo "<img src='public/images/delete_btn.png' class='delete_contact_btn' data-id='{$formNumber}'>";
                        echo "</td>";
                        echo "<td data-id='Serial Number'>" . $row['form_number'] ."</td>";
                        echo "<td data-id='First Name'>" . $row['first_name'] ."</td>";
                        echo "<td data-id='Middle Name'>" . $row['middle_name'] ."</td>";
                        echo "<td data-id='Last Name'>" . $row['last_name'] ."</td>";
                        echo "<td data-id='Nickname'>" . $row['nickname'] ."</td>";
                        echo "<td data-id='Gender'>" . $row['gender'] ."</td>";
                        echo "<td data-id='Mobile Number'>" . $row['mobile_number'] ."</td>";
                        echo "<td data-id='Landline Number'>" . $row['landline_number'] ."</td>";
                        echo "<td data-id='Address'>" . $row['addr'] ."</td>";
                        echo "<td data-id='Relationship'>" . $row['relationship'] ."</td>";
                        echo "<td data-id='Created At'>" . $row['created_at'] ."</td>";

                        $sql = "SELECT COUNT(*) AS total_fields FROM additional_fields WHERE form_no = $formNumber";

                        $result1 = $conn->query($sql);

                        if($result1->num_rows > 0)
                        {
                            $row = $result1->fetch_assoc();
                            $total_additional_fields = $row['total_fields'];
                            $total_additional_fields_pages = ceil($total_additional_fields / 10);

                            // Pagination here must be created in the future

                            $sql = "SELECT field_name, field_value FROM additional_fields WHERE form_no=$formNumber";

                            $result2 = $conn->query($sql);

                            if($result2->num_rows > 0)
                            {
                                while($row = $result2->fetch_assoc())
                                {
                                    echo "<th data-id='hidden'>" . $row['field_name'] . "</th>";
                                    echo "<td data-id='{$row['field_name']}'>" . $row['field_value'] . "</td>";
                                }
                            }
                        }
                    }
                    echo "</tr>";
                    echo "</table>";

                    $data['data'] = ob_get_contents();
                    ob_end_clean();

                    $data['status'] = "success";
                    $data['total_pages'] = $total_pages;
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }
            }
            else
            {
                $data['status'] = "error";
                $data['data'] = "Nothing found!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $data['status'] = "error";
        $data['data'] = "Please try again later!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
?>

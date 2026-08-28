<?php
    requireFile('../app/Views/sessionstart.php');
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $data['status'] = "error";
        $data['data'] = "Request Method is not POST!";
        header("Content-Type: application/json");
        echo json_encode($data);
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

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Check and sanitize the user input that is form data
    $filter_firstname = sanitize_input($data['filter_firstname']);
    $filter_middlename = sanitize_input($data['filter_middlename']);
    $filter_lastname = sanitize_input($data['filter_lastname']);
    $filter_nickname = sanitize_input($data['filter_nickname']);
    $filter_gender = sanitize_input($data['filter_gender']);
    $filter_mobile = sanitize_input($data['filter_mobile']);
    $filter_landline = sanitize_input($data['filter_landline']);
    $filter_address = sanitize_input($data['filter_address']);
    $filter_relationship = sanitize_input($data['filter_relationship']);


    if(!empty($filter_firstname))
    {
        validate_firstname($filter_firstname, 100, '', false, true);
    }

    if(!empty($filter_middlename))
    {
        validate_middlename($filter_middlename, 100, '', false, true);
    }

    if(!empty($filter_lastname))
    {
        validate_lastname($filter_lastname, 100, '', false, true);
    }

    if(!empty($filter_nickname))
    {
        validate_nickname($filter_nickname, 100, '', false, true);
    }

    if(!empty($filter_gender))
    {
        validate_gender($filter_gender, '', true);
    }

    validate_mobile_number($filter_mobile, '', true);

    validate_landline_number($filter_landline, '', true);

    if(!empty($filter_address))
    {
        if(strlen($filter_address) > 500)
        {
            $data['status'] = "error";
            $data['data'] = "Address cannot contain more than 500 characters!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
    }

    if(!empty($filter_relationship))
    {
        if(strlen($filter_relationship) > 100)
        {
            $data['status'] = "error";
            $data['data'] = "Relationship cannot contain more than 100 characters!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
    }

    // If all input fields are empty
    if(empty($filter_firstname) && empty($filter_middlename) && empty($filter_lastname) && empty($filter_nickname) &&
        empty($filter_gender) && empty($filter_mobile) && empty($filter_landline) && empty($filter_address) && empty($filter_relationship))
    {
        $data['status'] = "error";
        $data['data'] = "Please provide atleast one input!";
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
        $conn = $GLOBALS['conn'];
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

            $sql = "SELECT * FROM contacts WHERE ";
            
            $parameter = "user_id = {$id} AND ";

            if(!empty($filter_firstname))
            {
                $parameter .= "first_name LIKE '%{$filter_firstname}%' ";
            }

            if(!empty($filter_middlename))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "middle_name LIKE '%{$filter_middlename}%'";
                }
                else
                {
                    $parameter .= "AND middle_name LIKE '%{$filter_middlename}%'";
                }
            }

            if(!empty($filter_lastname))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "last_name LIKE '%{$filter_lastname}%'";
                }
                else
                {
                    $parameter .= " AND last_name LIKE '%{$filter_lastname}%'";
                }
            }

            if(!empty($filter_nickname))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "nickname LIKE '%{$filter_nickname}%'";
                }
                else
                {
                    $parameter .= "AND nickname LIKE '%{$filter_nickname}%'";
                }
            }

            if(!empty($filter_gender))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "gender = '{$filter_gender}'";
                }
                else
                {
                    $parameter .= "AND gender = '{$filter_gender}'";
                }
            }

            if(!empty($filter_mobile))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "mobile_number = '{$filter_mobile}'";
                }
                else
                {
                    $parameter .= "AND mobile_number = '{$filter_mobile}'";
                }
            }

            if(!empty($filter_landline))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "landline_number = '{$filter_landline}'";
                }
                else
                {
                    $parameter .= "AND landline_number = '{$filter_landline}'";
                }
            }

            if(!empty($filter_address))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "addr LIKE '%{$filter_address}%'";
                }
                else
                {
                    $parameter .= "AND addr LIKE '%{$filter_address}%'";
                }
            }

            if(!empty($filter_relationship))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "relationship LIKE '%{$filter_relationship}%'";
                }
                else
                {
                    $parameter .= "AND relationship LIKE '%{$filter_relationship}%'";
                }
            }

            $sql .= $parameter;

            // Finding the total number of contacts based on provided filter data
            $totalContactsQuery = "SELECT COUNT(*) AS total FROM contacts WHERE ";
            $totalContactsQuery .= $parameter;

            $totalContactsQueryResult = $conn->query($totalContactsQuery);

            if($totalContactsQueryResult->num_rows > 0)
            {
                $row = $totalContactsQueryResult->fetch_assoc();

                $total_records = $row['total'];

                if($total_records == 0)
                {
                    $data['status'] = "error";
                    $data['data'] = "No contact list!";
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }

                $total_pages = ceil($total_records / 10);

                // Pagination
                $page = $data['page'] ?? 1;

                $page = sanitize_input($page);

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

                $sql .= " LIMIT $startingIndex, 10";

                $result = $conn->query($sql);

                if($result->num_rows > 0)
                {
                    ob_start();

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

                            if($total_additional_fields_pages == 0)
                            {
                                echo "<td data-id='Additional Fields'></td>";
                            }
                            else if($total_additional_fields_pages >= 1)
                            {   
                                echo "<td data-id='Additional Fields'>";
                                echo "<button class='additional_fields_btn' data-additionalpage='1' 
                                data-form='{$formNumber}'>Show</button>";
                                echo "</td>";
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
                else
                {
                    $data['status'] = "error";
                    $data['data'] = "No contact found!";
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }
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

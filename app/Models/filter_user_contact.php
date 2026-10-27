<?php
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");
    requireFile("../app/Filters/IsLoggedIn.php");
    requireFile("../app/Filters/IsPost.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    IsPost(true);

    IsLoggedIn(true);

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Loop through the key value pairs in $data superglobal array
    foreach($data as $x => $y)
    {
        // Check and sanitize the user input that is form data
        $$x = sanitize_input($y);
        // Put form data in a session variable array in case validation fails
        $_SESSION['filter']['formData'][$x] = $y;
    }

    if(!empty($_SESSION['filter']['formData']['csrf_token']))
    {
        if(!isset($_SESSION['csrf_token'], $_SESSION['filter']['formData']['csrf_token']) &&
        !hash_equals($_SESSION['csrf_token'], $_SESSION['filter']['formData']['csrf_token']))
        {
            $data['status'] = "error";
            $data['data'] = "Session expired. Please refresh the webpage!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
    }

    validateFirstname('filter', $_SESSION['filter']['formData']['firstname'], 100, true);

    validateMiddlename('filter', $_SESSION['filter']['formData']['middlename'], 100, true);

    validateLastname('filter', $_SESSION['filter']['formData']['lastname'], 100, true);

    validateNickname('filter', $_SESSION['filter']['formData']['nickname'], 100, true);

    validateGender('filter', $_SESSION['filter']['formData']['gender']);

    validateMobile('filter', $_SESSION['filter']['formData']['mobile']);

    validateLandline('filter', $_SESSION['filter']['formData']['landline']);

    validateAddress('filter', $_SESSION['filter']['formData']['address'], true);

    validateRelationship('filter', $_SESSION['filter']['formData']['relationship'], true);

    // Display validation errors if exists
    DisplayValidationErrors('filter', 'filter', true);

    // If all input fields are empty
    if(count(array_filter($_SESSION['filter']['formData'])) == 0)
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

            if(!empty($_SESSION['filter']['formData']['firstname']))
            {
                $parameter .= "first_name LIKE '%{$_SESSION['filter']['formData']['firstname']}%' ";
            }

            if(!empty($_SESSION['filter']['formData']['middlename']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "middle_name LIKE '%{$_SESSION['filter']['formData']['middlename']}%'";
                }
                else
                {
                    $parameter .= "AND middle_name LIKE '%{$_SESSION['filter']['formData']['middlename']}%'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['lastname']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "last_name LIKE '%{$_SESSION['filter']['formData']['lastname']}%'";
                }
                else
                {
                    $parameter .= " AND last_name LIKE '%{$_SESSION['filter']['formData']['lastname']}%'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['nickname']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "nickname LIKE '%{$_SESSION['filter']['formData']['nickname']}%'";
                }
                else
                {
                    $parameter .= "AND nickname LIKE '%{$_SESSION['filter']['formData']['nickname']}%'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['gender']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "gender = '{$_SESSION['filter']['formData']['gender']}'";
                }
                else
                {
                    $parameter .= "AND gender = '{$_SESSION['filter']['formData']['gender']}'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['mobile']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "mobile_number = '{$_SESSION['filter']['formData']['mobile']}'";
                }
                else
                {
                    $parameter .= "AND mobile_number = '{$_SESSION['filter']['formData']['mobile']}'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['landline']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "landline_number = '{$_SESSION['filter']['formData']['landline']}'";
                }
                else
                {
                    $parameter .= "AND landline_number = '{$_SESSION['filter']['formData']['landline']}'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['address']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "addr LIKE '%{$_SESSION['filter']['formData']['address']}%'";
                }
                else
                {
                    $parameter .= "AND addr LIKE '%{$_SESSION['filter']['formData']['address']}%'";
                }
            }

            if(!empty($_SESSION['filter']['formData']['relationship']))
            {
                if(str_ends_with($parameter, "AND "))
                {
                    $parameter .= "relationship LIKE '%{$_SESSION['filter']['formData']['relationship']}%'";
                }
                else
                {
                    $parameter .= "AND relationship LIKE '%{$_SESSION['filter']['formData']['relationship']}%'";
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
                $page = $_SESSION['filter']['formData']['page'] ?? 1;

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
                        echo "<img src='images/edit_btn.png' class='edit_contact_btn' data-id='{$formNumber}'>";
                        echo "</td>";
                        echo "<td data-label='delete'>";
                        echo 
                        "<img src='images/delete_btn.png' class='delete_contact_btn' data-id='{$formNumber}'>";
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

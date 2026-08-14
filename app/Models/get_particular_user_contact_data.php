<?php
    // PHP Script for getting details of a particular contact of logged in user
    // Edit.js script file function sends an ajax request to this php script
    require_once "../app/Views/sessionstart.php";
    require_once "../app/Config/Database_Connection.php";

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'GET')
    {
        $data['status'] = "error";
        $data['data'] = "Request Method is not GET!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
    else
    {
        if(!isset($_SESSION['user_token']))
        {
            $data['status'] = "error";
            $data['data'] = "Please login!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }

        if(!isset($_GET['id']))
        {
            $data['status'] = 'error';
            $data['data'] = "URL query parameter 'id' is not set!";
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        }
        else
        {
            function test_input($input)
            {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input;
            }

            $id = test_input($_GET['id']);
            
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
                    $user_id = $row['id'];

                    $sql = "SELECT * FROM contacts WHERE user_id={$user_id} AND form_number={$id}";

                    $result = $conn->query($sql);

                    if($result->num_rows == 1)
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $_SESSION['edit_form_data']['form_number'] = $formNumber = $row['form_number'];
                            $_SESSION['edit_form_data']['first_name'] = $row['first_name'];
                            $_SESSION['edit_form_data']['middle_name'] = $row['middle_name'];
                            $_SESSION['edit_form_data']['last_name'] = $row['last_name'];
                            $_SESSION['edit_form_data']['nickname'] = $row['nickname'];
                            $_SESSION['edit_form_data']['gender'] = $row['gender'];
                            $_SESSION['edit_form_data']['mobile_number'] = $row['mobile_number'];
                            $_SESSION['edit_form_data']['landline_number'] = $row['landline_number'];
                            $_SESSION['edit_form_data']['addr'] = $row['addr'];
                            $_SESSION['edit_form_data']['relationship'] = $row['relationship'];

                            $sql = "SELECT COUNT(*) AS total_fields FROM additional_fields WHERE form_no = $formNumber";

                            $result1 = $conn->query($sql);

                            if($result1->num_rows > 0)
                            {
                                $row = $result1->fetch_assoc();
                                if($row['total_fields'] != 0)
                                {
                                    //$total_additional_fields = $row['total_fields'];
                                    //$total_additional_fields_pages = ceil($total_additional_fields / 10);

                                    // Pagination here must be created in the future

                                    $sql = "SELECT field_name, field_value FROM additional_fields WHERE form_no=$formNumber";

                                    $result2 = $conn->query($sql);

                                    if($result2->num_rows > 0)
                                    {
                                        $counter = 0;
                                        while($row = $result2->fetch_assoc())
                                        {
                                            $counter++;
                                            $_SESSION['edit_form_data']['additional_fields'][$counter]['field_name'] 
                                            = $row['field_name'];
                                            $_SESSION['edit_form_data']['additional_fields'][$counter]['field_value'] 
                                            = $row['field_value'];
                                        }
                                    }
                                }
                            }
                        }

                        $data['status'] = 'success';
                        $data = json_encode($data);
                        header("Content-Type: application/json");
                        echo $data;
                        exit();
                    }
                    else
                    {
                        $data['status'] = "error";
                        $data['data'] = "Contact details not found. Please check provided edit id!";
                        $data = json_encode($data);
                        header("Content-Type: application/json");
                        echo $data;
                        exit();
                    }
                }
                else
                {
                    $data['status'] = "error";
                    $data['data'] = "Database server unavailable. Please try again later!";
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }
            }
            catch(mysqli_sql_exception $e)
            {
                error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
                $data['status'] = "error";
                $data['data'] = "Database server unavailable. Please try again later!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
        }
    }
?>

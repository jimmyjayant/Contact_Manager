<?php
    // PHP Script for getting details of a particular contact of logged in user
    // Edit.js script file function sends an ajax request to this php script
    // requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile('../app/Filters/IsLoggedIn.php');

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
        IsLoggedIn(true);

        if(!isset($GLOBALS['editID']))
        {
            $data['status'] = 'error';
            $data['data'] = "URL query parameter 'id' is not set!";
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        }
        else
        {
            $id = sanitize_input($GLOBALS['editID']);
            
            $token = $_SESSION['user_token'];
            // sql query
            $sql = "SELECT id FROM user WHERE token='{$token}'";

            try
            {
                $conn = $GLOBALS['conn'];
                if(!$conn)
                {
                    throw new Exception("Database server unavailable. Please try again later!");
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
                            foreach($row as $x => $y)
                            {
                                // Put contact data in a session variable array
                                $_SESSION['edit']['formData'][$x] = $y;
                            }

                            // Remove old key value pairs and add new one
                            if(array_key_exists('first_name', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['firstname'] = 
                                $_SESSION['edit']['formData']['first_name'];

                                unset($_SESSION['edit']['formData']['first_name']);
                            }

                            if(array_key_exists('middle_name', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['middlename'] = 
                                $_SESSION['edit']['formData']['middle_name'];

                                unset($_SESSION['edit']['formData']['middle_name']);
                            }

                            if(array_key_exists('last_name', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['lastname'] = 
                                $_SESSION['edit']['formData']['last_name'];

                                unset($_SESSION['edit']['formData']['last_name']);
                            }

                            if(array_key_exists('mobile_number', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['mobile'] = 
                                $_SESSION['edit']['formData']['mobile_number'];

                                unset($_SESSION['edit']['formData']['mobile_number']);
                            }

                            if(array_key_exists('landline_number', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['landline'] = 
                                $_SESSION['edit']['formData']['landline_number'];

                                unset($_SESSION['edit']['formData']['landline_number']);
                            }

                            if(array_key_exists('addr', $_SESSION['edit']['formData']))
                            {
                                $_SESSION['edit']['formData']['address'] = 
                                $_SESSION['edit']['formData']['addr'];

                                unset($_SESSION['edit']['formData']['addr']);
                            }

                            $formNumber = $_SESSION['edit']['formData']['form_number'];

                            $sql = 
                            "SELECT COUNT(*) AS total_fields FROM additional_fields 
                            WHERE form_no = $formNumber";

                            $result1 = $conn->query($sql);

                            if($result1->num_rows > 0)
                            {
                                $row = $result1->fetch_assoc();
                                if($row['total_fields'] != 0)
                                {
                                    $_SESSION['edit']['formData']['custom_fields_number'] = $row['total_fields'];
                                    //$total_additional_fields = $row['total_fields'];
                                    //$total_additional_fields_pages = ceil($total_additional_fields / 10);

                                    // Pagination here must be created in the future

                                    $sql = "SELECT ID, field_name, field_value FROM additional_fields WHERE form_no=$formNumber";

                                    $result2 = $conn->query($sql);

                                    if($result2->num_rows > 0)
                                    {
                                        $i = 1; $j = 1;
                                        while($row = $result2->fetch_assoc())
                                        {
                                            // Put contact data in a session variable array
                                            // $n = $row['ID'];

                                            // $_SESSION['edit']['formData']['extraField'][$n]
                                            // ['customInputElement'. $i] = $row['field_name'];

                                            // $_SESSION['edit']['formData']['extraField'][$n]
                                            // ['customInputElement' . $i+1] = $row['field_value'];

                                            // $i +=2;

                                            $_SESSION['edit']['formData']['fieldName' . $j] = 
                                            $row['ID'];

                                            $_SESSION['edit']['formData']
                                            ['customInputElement'. $i] = $row['field_name'];

                                            $_SESSION['edit']['formData']
                                            ['customInputElement' . $i+1] = $row['field_value'];

                                            $i +=2;
                                            $j++;
                                        }
                                    }
                                }
                            }
                        }

//                         echo "<pre>";
// print_r($_SESSION['edit']['formData']);
// echo "</pre>";
// exit();

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

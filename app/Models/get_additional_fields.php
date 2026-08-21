<?php
    // PHP Script for fetching additional fields of a particular contact list of logged in user
    requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");

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

    if(!isset($_SESSION['user_token']))
    {
        $data['status'] = "error";
        $data['data'] = "Please login!";
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

            function test_input($input)
            {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input;
            }

            $form_number = test_input($_GET['form_number']);

            $page = $_GET['additional_fields_page'] ?? 1;

            $page = test_input($page);

            $page = floor((int)$page);

            $sql = "SELECT COUNT(*) AS total FROM additional_fields WHERE userID=$id AND form_no=$form_number";

            $totalPageResult = $conn->query($sql);

            if($totalPageResult->num_rows > 0)
            {
                $row = $totalPageResult->fetch_assoc();
                $total_pages = $row['total'];

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

                $RetrieveAdditionalFieldsQuery = 
                "SELECT field_name, field_value FROM additional_fields 
                WHERE userID=$id AND form_no=$form_number LIMIT $startingIndex, 10";

                $result = $conn->query($RetrieveAdditionalFieldsQuery);

                if($result->num_rows > 0)
                {
                    ob_start();
                    
                    echo "<table class='additional_fields'>";
                    echo "<th colspan=2>Additional Fields Table</th>";

                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<th data-group='additional-fields' data-id='hidden'>" . $row['field_name'] . "</th>";
                        echo "<td data-group='additional-fields' data-id='{$row['field_name']}'>" . $row['field_value'] . "</td>";
                        echo "</tr>";
                    }

                    if($total_pages > 1)
                    {
                        $next_page = $page + 1;
                        echo "<tr>";
                        echo "<td colspan=2>";
                        echo "<button class='additional_fields_btn' data-additionalpage='{$next_page}' 
                        data-form='{$formNumber}'>Show</button>";
                        echo "</td>";
                        echo "</tr>";
                    }

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
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
?>

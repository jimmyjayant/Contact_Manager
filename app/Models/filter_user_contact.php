<?php
require '../app/Views/sessionstart.php';
require_once("../app/Config/Database_Connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    // Putting all form data in a session variable
    $_SESSION['filter_form_data']['filter_firstname'] = $_POST['filter_firstname'];
    $_SESSION['filter_form_data']['filter_middlename'] = $_POST['filter_middlename'];
    $_SESSION['filter_form_data']['filter_lastname'] = $_POST['filter_lastname'];
    $_SESSION['filter_form_data']['filter_nickname'] = $_POST['filter_nickname'];
    $_SESSION['filter_form_data']['filter_gender'] = $_POST['filter_gender'];
    $_SESSION['filter_form_data']['filter_mobnum'] = $_POST['filter_mobnum'];
    $_SESSION['filter_form_data']['filter_landnum'] = $_POST['filter_landnum'];
    $_SESSION['filter_form_data']['filter_address'] = $_POST['filter_address'];
    $_SESSION['filter_form_data']['filter_relationship'] = $_POST['filter_relationship'];

    $filter_firstname = test_input($_POST['filter_firstname']);

    if(!empty($filter_firstname))
    {
        if(strlen($filter_firstname) > 100)
        {
            $_SESSION['filter_firstname_error'] = "First Name cannot be more than 100 characters!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\d/", $filter_firstname))
        {
            $_SESSION['filter_firstname_error'] = "First Name cannot contain digits!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\s/", $filter_firstname))
        {
            $_SESSION['filter_firstname_error'] = "First Name cannot contain whitespaces!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\W/", $filter_firstname))
        {
            $_SESSION['filter_firstname_error'] = "First Name cannot contain special characters!";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_middlename = test_input($_POST['filter_middlename']);

    if(!empty($filter_middlename))
    {
        if(strlen($filter_middlename) > 100)
        {
            $_SESSION['filter_middlename_error'] = "Middle Name cannot be more than 100 characters!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\d/", $filter_middlename))
        {
            $_SESSION['filter_middlename_error'] = "Middle Name cannot contain digits!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\s/", $filter_middlename))
        {
            $_SESSION['filter_middlename_error'] = "Middle Name cannot contain whitespaces!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\W/", $filter_middlename))
        {
            $_SESSION['filter_middlename_error'] = "Middle Name cannot contain special characters!";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_lastname = test_input($_POST['filter_lastname']);

    if(!empty($filter_lastname))
    {
        if(strlen($filter_lastname) > 100)
        {
            $_SESSION['filter_lastname_error'] = "Last Name cannot be more than 100 characters!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\d/", $filter_lastname))
        {
            $_SESSION['filter_lastname_error'] = "Last Name cannot contain digits!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\s/", $filter_lastname))
        {
            $_SESSION['filter_lastname_error'] = "Last Name cannot contain whitespaces!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\W/", $filter_lastname))
        {
            $_SESSION['filter_lastname_error'] = "Last Name cannot contain special characters!";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_nickname = test_input($_POST['filter_nickname']);

    if(!empty($filter_nickname))
    {
        if(strlen($filter_nickname) > 100)
        {
            $_SESSION['filter_nickname_error'] = "Nick Name cannot be more than 100 characters!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\d/", $filter_nickname))
        {
            $_SESSION['filter_nickname_error'] = "Nick Name cannot contain digits!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\s/", $filter_nickname))
        {
            $_SESSION['filter_nickname_error'] = "Nick Name cannot contain whitespaces!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\W/", $filter_nickname))
        {
            $_SESSION['filter_nickname_error'] = "Nick Name cannot contain special characters!";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_gender = test_input($_POST['filter_gender']);

    if(!empty($filter_gender))
    {
        if(($filter_gender != 'male') && ($filter_gender != 'female'))
        {
            $_SESSION['filter_gender_error'] = "Gender should be either male or female";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_mobnum = test_input($_POST['filter_mobnum']);

    if(!empty($filter_mobnum) && !preg_match("/^\d{10}$/", $filter_mobnum))
    {
        $_SESSION['filter_mobile_error'] = "Mobile Number must contain 10 digits!";
        header("Location: dashboard");
        exit();
    }

    $filter_landnum = test_input($_POST['filter_landnum']);

    if(!empty($filter_landnum) && !preg_match("/^\d{10}$/", $filter_landnum))
    {
        $_SESSION['filter_landline_error'] = "Landline Number must contain 10 digits!";
        header("Location: dashboard");
        exit();
    }

    $filter_address = test_input($_POST['filter_address']);

    if(!empty($filter_address))
    {
        if(strlen($filter_address) > 500)
        {
            $_SESSION['filter_address_error'] = "Address cannot contain more than 500 characters!";
            header("Location: dashboard");
            exit();
        }
    }
    

    $filter_relationship = test_input($_POST['filter_relationship']);

    if(!empty($filter_relationship))
    {
        if(strlen($filter_relationship) > 100)
        {
            $_SESSION['filter_relationship_error'] = "Relationship cannot contain more than 100 characters!";
            header("Location: dashboard");
            exit();
        }
    }
    
    // If all input fields are empty
    if(empty($filter_firstname) && empty($filter_middlename) && empty($filter_lastname) && empty($filter_nickname) &&
        empty($filter_gender) && empty($filter_mobnum) && empty($filter_landnum) && empty($filter_address) && empty($filter_relationship))
    {
        $_SESSION['filter_contact_error'] = "Please provide atleast one input!";
        header("Location: dashboard");
        exit();
    }

    $token = $_SESSION['user_token'];
    // sql query
    $sql = "SELECT id FROM user WHERE token='{$token}'";

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $id = $row['id'];

        $sql = "SELECT * FROM contacts WHERE user_id = {$id} AND ";

        if(!empty($filter_firstname))
        {
            $sql .= "first_name = {$filter_firstname} ";
        }

        if(!empty($filter_middlename))
        {
            if(str_contains($sql, "first_name"))
            {
                $sql .= "AND middle_name = {$filter_middlename}";
            }
            else
            {
                $sql .= "middle_name = {$filter_middlename}";
            }
        }

        if(!empty($filter_lastname))
        {
            if(str_contains($sql, "middle_name"))
            {
                $sql .= "AND last_name = {$filter_lastname}";
            }
            else
            {
                $sql .= "last_name = {$filter_lastname}";
            }
        }

        if(!empty($filter_nickname))
        {
            if(str_contains($sql, "last_name"))
            {
                $sql .= "AND nickname = {$filter_nickname}";
            }
            else
            {
                $sql .= "nickname = {$filter_nickname}";
            }
        }

        if(!empty($filter_gender))
        {
            if(str_contains($sql, "nickname"))
            {
                $sql .= "AND gender = {$filter_gender}";
            }
            else
            {
                $sql .= "gender = {$filter_gender}";
            }
        }

        if(!empty($filter_mobnum))
        {
            if(str_contains($sql, "gender"))
            {
                $sql .= "AND mobile_number = {$filter_mobnum}";
            }
            else
            {
                $sql .= "mobile_number = {$filter_mobnum}";
            }
        }

        if(!empty($filter_landnum))
        {
            if(str_contains($sql, "mobile_number"))
            {
                $sql .= "AND landline_number = {$filter_landnum}";
            }
            else
            {
                $sql .= "landline_number = {$filter_landnum}";
            }
        }

        if(!empty($filter_address))
        {
            if(str_contains($sql, "landline_number"))
            {
                $sql .= "AND addr = {$filter_address}";
            }
            else
            {
                $sql .= "addr = {$filter_address}";
            }
        }

        if(!empty($filter_relationship))
        {
            if(str_contains($sql, "addr"))
            {
                $sql .= "AND relationship = {$filter_relationship}";
            }
            else
            {
                $sql .= "relationship = {$filter_relationship}";
            }
        }

        

        // Pagination
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

        $sql .= " LIMIT $startingIndex, 10";

        $result = $conn->query($sql);

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
?>

<?php
// PHP Script for deleting contact of a logged in user
require_once "../app/Views/sessionstart.php";
require_once "../app/Config/Database_Connection.php";

ini_set("display_errors", 0);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    $_SESSION['edit_contact_error'] = "Request Method is not POST!";
    header("Location: edit");
    exit();
}

function test_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Putting all form data in a session variable
$_SESSION['edit_form_data']['edit_form_number'] = $_POST['edit_form_number'];
$_SESSION['edit_form_data']['edit_firstname'] = $_POST['edit_firstname'];
$_SESSION['edit_form_data']['edit_middlename'] = $_POST['edit_middlename'];
$_SESSION['edit_form_data']['edit_lastname'] = $_POST['edit_lastname'];
$_SESSION['edit_form_data']['edit_nickname'] = $_POST['edit_nickname'];
$_SESSION['edit_form_data']['edit_gender'] = $_POST['edit_gender'];
$_SESSION['edit_form_data']['edit_mobnum'] = $_POST['edit_mobnum'];
$_SESSION['edit_form_data']['edit_landnum'] = $_POST['edit_landnum'];
$_SESSION['edit_form_data']['edit_address'] = $_POST['edit_address'];
$_SESSION['edit_form_data']['edit_relationship'] = $_POST['edit_relationship'];


$firstname = test_input($_POST['edit_firstname']);

if(empty($firstname))
{
    $_SESSION['edit_firstname_error'] = "Firstname cannot be empty!";
    header("Location: edit");
    exit();
}
else if(strlen($firstname) > 100)
{
    $_SESSION['edit_firstname_error'] = "First Name cannot be more than 100 characters!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\d/", $firstname))
{
    $_SESSION['edit_firstname_error'] = "First Name cannot contain digits!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\s/", $firstname))
{
    $_SESSION['edit_firstname_error'] = "First Name cannot contain whitespaces!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\W/", $firstname))
{
    $_SESSION['edit_firstname_error'] = "First Name cannot contain special characters!";
    header("Location: edit");
    exit();
}


$middlename = test_input($_POST['edit_middlename']);

if(strlen($middlename) > 100)
{
    $_SESSION['edit_middlename_error'] = "Middle Name cannot be more than 100 characters!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\d/", $middlename))
{
    $_SESSION['edit_middlename_error'] = "Middle Name cannot contain digits!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\s/", $middlename))
{
    $_SESSION['edit_middlename_error'] = "Middle Name cannot contain whitespaces!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\W/", $middlename))
{
    $_SESSION['edit_middlename_error'] = "Middle Name cannot contain special characters!";
    header("Location: edit");
    exit();
}


$lastname = test_input($_POST['edit_lastname']);

if(strlen($lastname) > 100)
{
    $_SESSION['edit_lastname_error'] = "Last Name cannot be more than 100 characters!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\d/", $lastname))
{
    $_SESSION['edit_lastname_error'] = "Last Name cannot contain digits!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\s/", $lastname))
{
    $_SESSION['edit_lastname_error'] = "Last Name cannot contain whitespaces!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\W/", $lastname))
{
    $_SESSION['edit_lastname_error'] = "Last Name cannot contain special characters!";
    header("Location: edit");
    exit();
}


$nickname = test_input($_POST['edit_nickname']);

if(strlen($nickname) > 100)
{
    $_SESSION['edit_nickname_error'] = "Nick Name cannot be more than 100 characters!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\d/", $nickname))
{
    $_SESSION['edit_nickname_error'] = "Nick Name cannot contain digits!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\s/", $nickname))
{
    $_SESSION['edit_nickname_error'] = "Nick Name cannot contain whitespaces!";
    header("Location: edit");
    exit();
}
else if(preg_match_all("/\W/", $nickname))
{
    $_SESSION['edit_nickname_error'] = "Nick Name cannot contain special characters!";
    header("Location: edit");
    exit();
}


$gender = test_input($_POST['edit_gender']);

if(empty($gender))
{
    $_SESSION['edit_gender_error'] = "Gender cannot be empty!";
    header("Location: edit");
    exit();
}
else if(($gender != 'male') && ($gender != 'female'))
{
    $_SESSION['edit_gender_error'] = "Gender should be either male or female";
    header("Location: edit");
    exit();
}

$mobnum = test_input($_POST['edit_mobnum']);

if(!empty($mobnum) && !preg_match("/^\d{10}$/", $mobnum))
{
    $_SESSION['edit_mobile_error'] = "Mobile Number must contain 10 digits!";
    header("Location: edit");
    exit();
}


$landnum = test_input($_POST['edit_landnum']);

if(!empty($landnum) && !preg_match("/^\d{8}$/", $landnum))
{
    $_SESSION['edit_landline_error'] = "Landline Number must contain 8 digits!";
    header("Location: edit");
    exit();
}

if(empty($mobnum) && empty($landnum))
{
    $_SESSION['edit_contact_error'] = "Please provide either mobile or landline number!";
    header("Location: edit");
    exit();
}

$mobnum = empty($mobnum) ? "NULL" : "'$mobnum'";
$landnum = empty($landnum) ? "NULL" : "'$landnum'";

$address = test_input($_POST['edit_address']);

if(strlen($address) > 500)
{
    $_SESSION['edit_address_error'] = "Address cannot contain more than 500 characters!";
    header("Location: edit");
    exit();
}

$relationship = test_input($_POST['edit_relationship']);

if(strlen($relationship) > 100)
{
    $_SESSION['edit_relationship_error'] = "Relationship cannot contain more than 100 characters!";
    header("Location: edit");
    exit();
}


if(!isset($_SESSION['user_token']))
{
    $_SESSION['edit_contact_error'] = "Please login!";
    header("Location: edit");
    exit();
}


$token = $_SESSION['user_token'];
// sql query
$sql = "SELECT id FROM user WHERE token='{$token}'";


try
{
    if(!$conn)
    {
        $_SESSION['edit_contact_error'] = "Database server unavailable. Please try again later!";
        header("Location: edit");
        exit();
    }

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $id = $row['id'];

        // sql query to update contact record of a particular logged in user 
        $sql = "UPDATE contacts 
                SET first_name='$firstname',
                    middle_name='$middlename',
                    last_name='$lastname',
                    nickname='$nickname',
                    gender='$gender',
                    mobile_number=$mobnum,
                    landline_number=$landnum,
                    addr='$address',
                    relationship='$relationship'
                WHERE user_id=$id 
                AND form_number=$formNumber";

        try
        {
            $result = $conn->query($sql);
        }
        catch(mysqli_sql_exception $e)
        {
            if($e->getCode() == 1062)
            {
                $_SESSION['edit_contact_error'] = "Mobile or Landline Number Already Exists!";
                header("Location: edit");
                exit();
            }
            else
            {
                $_SESSION['edit_contact_error'] = "Error Editing Contact. Please try again later!";
                header("Location: edit");
                exit();
            }
        }
    }
    else
    {
        $_SESSION['edit_contact_error'] = "Error Editing Contact. Please try again later!";
        header("Location: edit");
        exit();
    }

    // If custom fields are present in form

    if(isset($_POST['custom_fields_present']) && $_POST['custom_fields_present'] == 1)
    {
        if(isset($_POST['custom_fields_number']) && $_POST['custom_fields_number'] != 0)
        {
            $sql = "UPDATE additional_fields
                    SET ";

            try
            {
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $formNumber = $row['form_number'];
                }
            }
            catch(mysqli_sql_exception $e)
            {
                $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
                header("Location: add");
                exit();
            }

            $custom_fields_number = (int)test_input($_POST['custom_fields_number']);
            for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
            {
            $customFieldName = test_input($_POST['customInputElement' . $i]);
            test_field_name($customFieldName, 100);
            $customFieldValue = test_input($_POST['customInputElement' . $i+1]);
            if(strlen($customFieldValue) > 500)
                {
                    $_SESSION['add_contact_error'] = "Field Value cannot be more than 500 characters!";
                    header("Location: add");
                    exit();
                }

                // sql statement to insert additional fields into additional_fields table in contact_manager_db database
                $sql = "INSERT INTO additional_fields(userID, form_no, field_name, field_value) 
                        VALUES($id, $formNumber, '$customFieldName', '$customFieldValue')";

            try
            {
                    $result = $conn->query($sql);
            }
            catch(mysqli_sql_exception $e)
            {
                    if($e->getCode() == 1062)
                    {
                        $_SESSION['add_contact_error'] = "Mobile or Landline Number Already Exists!";
                        header("Location: add");
                        exit();
                    }
                    else
                    {
                        $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later1!";
                        header("Location: add");
                        exit();
                    }
            }
            }

            $_SESSION['add_contact_success'] = "Contact added successfully";
            header("Location: add");
            exit();
        }
    }
    else
    {
        $_SESSION['add_contact_success'] = "Contact added successfully";
        header("Location: add");
        exit();
    }
}
catch(mysqli_sql_exception $e)
{
    error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
    $_SESSION['edit_contact_error'] = "Please try again later!";
    header("Location: edit");
    exit();
}
?>

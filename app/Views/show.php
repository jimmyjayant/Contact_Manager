<?php
requireFile('../app/Views/sessionstart.php');

$GLOBALS['css'] = ["css/show.css", "css/table.css"];

$GLOBALS['js'] = ["script/show.js"];

requireFile('../app/Views/headerandnavbar.php');

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}

if(isset($data) && $data['status'] == 'error')
{
    echo "<script>alert({$data['data']});</script>";
}
?>

<div class="content">
    <div class="intro">
        <h1>Show Contacts</h1>

        <div id="total_contacts"></div>

        <div id="result"></div>
        <div id="pagination">
            <button type="button" id="previous_page">&lt;</button>
            <input type="number" id="page_number" min="1" step="1" value="1">
            <button type="button" id="next_page">&gt;</button>
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>

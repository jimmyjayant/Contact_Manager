<?php
require '../app/Views/sessionstart.php';
$css = "css/dashboard.css";
$js = "script/dashboard.js";
require '../app/Views/headerandnavbar.php';

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}
?>

<div class="content">
    <div class="intro">
        <h1>Dashboard</h1>

        <div class="contact">
            <div id="searchdiv">
                <div id="firstchild">
                    <input type="text" name="searchtext">
                    <button type="button" id="search">Search</button>
                </div>

                <div id="secondchild">
                    <button type="button" id="add">Add</button>
                    <button type="button" id="filter">Filter</button>
                </div>                
            </div>

            <div id="result">
                
            </div>
        </div>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>

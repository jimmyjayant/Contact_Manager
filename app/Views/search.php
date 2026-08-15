<?php
requireFile('../app/Views/sessionstart.php');

$GLOBALS['css'] = ["css/search.css", "css/table.css"];

$GLOBALS['js'] = ["script/search.js"];

requireFile('../app/Views/headerandnavbar.php');

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}
?>


<div class="content">
    <div class="intro">
        <h1>Search Contacts</h1>

        <div class="contact">
            <div id="searchdiv">
                <div id="firstchild">
                    <div id="input-wrapper">
                        <input type="text" name="searchtext" id="searchtext" placeholder="Enter the firstname of your contact" maxlength="100">
                        <button type="button" id="clearSearch" class="hide">X</button>
                    </div>
                    
                    <button type="button" id="search">Search</button>
                    <!--
                    <button type="button" id="searchimg">
                        <img src="public/images/search_btn.png">
                    </button>
                    -->
                </div>                
            </div>

            <div id="search_contact_error"></div>

            <div id="contact_data" class="hide">
                <div id="result"></div>
                <div id="pagination">
                    <button type="button" id="previous_page">&lt;</button>
                    <input type="number" id="page_number" min="1" step="1" value="1">
                    <button type="button" id="next_page">&gt;</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>

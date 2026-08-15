<?php
requireFile('../app/Views/sessionstart.php');

$css = ["css/index.css"];

requireFile('../app/Views/headerandnavbar.php');
?>

<div class="content">
    <div class="intro">
        <h1>Welcome to the Contact Manager!</h1>

        <div>
            The perfect platform for your contact storage.
            <br>
            Store and manage your contacts hassle free.
            <br>
            <?php
                if(!isset($_SESSION['user_token']))
                {
                    echo "<a href='login' target='_self'>Sign In</a>";
                    echo "<a href='register' target='_self'>Sign Up</a>";
                }
            ?>
        </div>
    </div>

    <div id="feature">
        <h3><u>Have a look at the features</u></h3>

        <div>
            <div>
                <h4>Well Organised Representation</h4>

                <p>
                    The contacts are represented in a well organised manner to the user.
                </p>
            </div>
            <div>
                <img src="" alt="Well Organised">
            </div>
        </div>

        <div>
            <div>
                <h4>Custom Contact Fields</h4>

                <p>
                    Besides the default fields present to insert the contact, you can create your own custom fields.
                </p>
            </div>
            <div>
                <img src="" alt="Custom Fields Setup">
            </div>
        </div>

        <div>
            <div>
                <h4>Sorting, Searching & Filtering</h4>

                <p>
                    You can do sorting, searching and filtering of the contacts. 
                </p>
            </div>
            <div>
                <img src="" alt="Sorting, Searching, Filtering">
            </div>
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>

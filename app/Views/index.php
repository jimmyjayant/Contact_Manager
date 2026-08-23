<?php
requireFile('../app/Views/sessionstart.php');

$GLOBALS['css'] = ["css/index.css"];

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
                <h4>Dashboard</h4>

                <p>
                    The dashboard provides a nice interface to show, add, filter, search, edit and delete the contacts. 
                </p>
            </div>
            <div>
                <img src="images/dashboard.png" alt="Dashboard">
            </div>
        </div>

        <div>
            <div>
                <h4>Well Organised Representation</h4>

                <p>
                    The contacts are represented in a well organised manner to the user.
                </p>
            </div>
            <div>
                <img src="images/well_organised.png" alt="Well Organised">
            </div>
        </div>

        <div>
            <div>
                <h4>Adding New Contacts</h4>

                <p>
                    You can add new contact information very easily. 
                </p>
            </div>
            <div>
                <img src="images/adding.png" alt="Adding New Contacts">
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
                <img src="images/custom_fields.png" alt="Custom Fields Setup">
            </div>
        </div>

        <div>
            <div>
                <h4>Filtering of Contacts</h4>

                <p>
                    You can filter the contacts in an easy manner.  
                </p>
            </div>
            <div>
                <img src="images/filtering.png" alt="Filtering">
            </div>
        </div>

        <div>
            <div>
                <h4>Searching of Contacts</h4>

                <p>
                    You can search the contacts in an easy manner.  
                </p>
            </div>
            <div>
                <img src="images/searching.png" alt="Searching">
            </div>
        </div>

        <div>
            <div>
                <h4>Editing & Deleting of Contacts</h4>

                <p>
                    You can edit and delete the contacts in an easy manner.
                </p>
            </div>
            <div>
                <img src="images/edit_delete.png" alt="Editing & Deleting of Contacts">
            </div>
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>

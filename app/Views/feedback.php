<?php
require_once '../app/Views/sessionstart.php';

$css = ["css/feedback.css"];

require_once '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Feedback</h1>

        <?php
            if(isset($_SESSION['feedback_error']))
            {
                echo "<div class='center'><span class='red_font'>" . $_SESSION['feedback_error'] . "</span></div>";
                unset($_SESSION['feedback_error']);
            }

            if(isset($_SESSION['feedback_success']))
            {
                echo "<div class='center'><span class='green_font'>" . $_SESSION['feedback_success'] . "</span></div>";
                unset($_SESSION['feedback_success']);
            }
        ?>

        <form method="post" action="provide_feedback">
            <div class="row">
                <div class="col25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="fname" name="fname" maxlength="100" placeholder="Enter Your First Name" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['fname_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['fname_error'] . "</span></div>";
                        unset($_SESSION['fname_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="lname" name="lname" maxlength="100" placeholder="Enter Your Last Name" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['lname_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['lname_error'] . "</span></div>";
                        unset($_SESSION['lname_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="mob">Contact Number</label>
                </div>
                <div class="col75">
                    <input type="tel" id="mob" name="mob" pattern="[0-9]{10}" placeholder="Enter Your Contact Number" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['contact_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['contact_error'] . "</span></div>";
                        unset($_SESSION['contact_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email Address" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['email_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['email_error'] . "</span></div>";
                        unset($_SESSION['email_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="subject">Subject</label>
                </div>
                <div class="col75">
                    <input type="text" id="subject" name="subject" maxlength="150" placeholder="Enter the Subject" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['subject_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['subject_error'] . "</span></div>";
                        unset($_SESSION['subject_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="msg">Message</label>
                </div>
                <div class="col75">
                    <textarea id="msg" name="msg" maxlength="5000"></textarea>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['msg_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['msg_error'] . "</span></div>";
                        unset($_SESSION['msg_error']);
                    }
                ?>
            </div>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require_once '../app/Views/footer.php'; ?>

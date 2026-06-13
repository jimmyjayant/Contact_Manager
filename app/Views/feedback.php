<?php
require '../app/Views/sessionstart.php';
$css = "css/feedback.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Feedback</h1>

        <?php
            if(isset($_SESSION['feedback_error']))
            {
                echo "<div class='center'><span class='red_font'>" . $_SESSION['feedback_error'] . "</span></div>";
                $_SESSION['feedback_error'] = NULL;
            }

            if(isset($_SESSION['feedback_success']))
            {
                echo "<div class='center'><span class='green_font'>" . $_SESSION['feedback_success'] . "</span></div>";
                $_SESSION['feedback_success'] = NULL;
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
                        $_SESSION['fname_error'] = NULL;
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
                        $_SESSION['lname_error'] = NULL;
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
                        $_SESSION['contact_error'] = NULL;
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
                        $_SESSION['email_error'] = NULL;
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
                        $_SESSION['subject_error'] = NULL;
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
                        $_SESSION['msg_error'] = NULL;
                    }
                ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>

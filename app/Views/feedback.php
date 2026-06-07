<?php
require '../app/Views/sessionstart.php';
$css = "css/feedback.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Feedback</h1>

        <form method="post" action="provide_feedback">
            <div class="row">
                <div class="col25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="fname" placeholder="Enter Your First Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="lname" placeholder="Enter Your Last Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="mob">Contact Number</label>
                </div>
                <div class="col75">
                    <input type="number" id="mob" placeholder="Enter Your Contact Number" required>
                </div>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" placeholder="Enter Your Email Address" required>
                </div>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="subject">Subject</label>
                </div>
                <div class="col75">
                    <input type="text" id="subject" placeholder="Enter the Subject" required>
                </div>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="msg">Message</label>
                </div>
                <div class="col75">
                    <textarea id="msg"></textarea>
                </div>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>

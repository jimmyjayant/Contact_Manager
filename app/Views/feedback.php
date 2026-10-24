<?php
requireFile('../app/Helpers/sanitize_input_helper.php');
requireFile('../app/Helpers/showValidationError.php');
requireFile('../app/Helpers/old.php');

$GLOBALS['css'] = ["css/feedback.css"];

requireFile('../app/Views/headerandnavbar.php');
?>

<div class="content">
    <div class="intro">
        <h1>Feedback</h1>
        <span>Fields marked with * are required.</span>

        <?php
            if(!empty($_SESSION['feedback']['error']))
            {
                echo "<div class='error'>";
                echo "<p>" . $_SESSION['feedback']['error'] . "</p></div>";
                unset($_SESSION['feedback']['error']);
            }

            if(!empty($_SESSION['feedback']['success']))
            {
                echo "<div class='success'>";
                echo "<p>" . $_SESSION['feedback']['success'] . "</p></div>";
                unset($_SESSION['feedback']['success']);
            }
        ?>

        <form method="post" action="feedback">
            <div class="row">
                <div class="col25">
                    <label for="firstname">First Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="firstname" name="firstname" maxlength="100" 
                    placeholder="Enter Your First Name" required 
                    value="<?= old('feedback', 'firstname'); ?>">
                    <br>
                    <span>Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'firstname'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lastname">Last Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="lastname" name="lastname" maxlength="100" 
                    placeholder="Enter Your Last Name" required 
                    value="<?= old('feedback', 'lastname'); ?>">
                    <br>
                    <span>Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'lastname'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="mobile">Contact Number*</label>
                </div>
                <div class="col75">
                    <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" 
                    placeholder="Enter Your Contact Number" required 
                    value="<?= old('feedback', 'mobile'); ?>">
                    <br>
                    <span>Exact 10 digits|Omit +91</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'mobile'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email*</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email Address" 
                    required value="<?= old('feedback', 'email'); ?>">
                    <br>
                    <span>Max 100 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'email'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="subject">Subject*</label>
                </div>
                <div class="col75">
                    <input type="text" id="subject" name="subject" maxlength="150" 
                    placeholder="Enter the Subject" required 
                    value="<?= old('feedback', 'subject'); ?>">
                    <br>
                    <span>Max 150 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'subject'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="message">Message</label>
                </div>
                <div class="col75">
                    <textarea id="message" name="message" maxlength="5000">
                        <?= old('feedback', 'message'); ?>
                    </textarea>
                    <br>
                    <span>Max 5000 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('feedback', 'message'); ?>
            </div>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['feedback']['formData']); ?>

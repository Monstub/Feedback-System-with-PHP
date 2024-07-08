<?php
session_start();

// Handle sign-out button click
if(isset($_POST['signOutBtn'])){
    // Redirect to adminPage.php using JavaScript
    ?>
    <script>
        location.replace("adminPage.php");
    </script>
    <?php
    // Check if 'authen' session variable is not set (user is logged out)
    if(!isset($_SESSION['authen'])) {
        // Alert user that they have been logged out using JavaScript
        echo '<script>alert("You have been Logged Out.");</script>';
        ?>
        <script>
            location.replace("index.php"); // Redirect to index.php
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <div>
                        <div class="logo" style="margin-bottom: 15px;">
                            <a href="index.php"><img src="./img/logo.png" alt="easyclass" /></a>
                            <h4>feedback system</h4>
                        </div>

                        <?php
                        // Check if the 'authen' session variable is set
                        if(isset($_SESSION['authen'])) {
                            $authen = $_SESSION['authen']; // Get the value of 'authen'
                            
                            // Check if the "visited" cookie is set
                            if (!isset($_COOKIE['visited'])) {
                                // If the cookie is not set, this is the user's first visit
                                echo "<h1>Welcome <br>$authen</h1>";
                                
                                // Set the "visited" cookie with an expiration time (1 day in this example)
                                setcookie('visited', 'true', time() + 86400, '/');
                            } else {
                                // If the cookie is set, the user has visited before
                                echo "<h1>Welcome back<br>$authen</h1>";
                            }
                        }
                        ?>

                        <h4>You can perform the following tasks.</h4>
                        <div class="Activity-btn" style="width: 85%; margin-top: 30px;">
                            <a href="page2.php" class="sign-btn">Create Feedback Form</a>
                            <a href="page1.php" class="sign-btn">View Students Feedback</a>
                            <a href="editForm.php" class="sign-btn">Edit Existing Form</a>
                            <a href="change_pass.php" class="sign-btn">Change Password</a>
                            <form method="post" action="">
                                <input type="submit" name="signOutBtn" value="Sign out" class="sign-btn" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="./img/image1.png" class="image img-1 show" alt="" />
                        <img src="./img/image2.png" class="image img-2" alt="" />
                        <img src="./img/image3.png" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Create your own courses</h2>
                                <h2>Customize as you like</h2>
                                <h2>Invite students to your class</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="app.js"></script>
</body>
</html>

<?php 
// Check if 'authen' session variable is not set (user is logged out)
if(!isset($_SESSION['authen'])) {
    // Alert user that they have been logged out using JavaScript
    echo '<script>alert("You have been Logged Out.");</script>';
    ?>
    <script>
        location.replace("index.php"); // Redirect to index.php
    </script>
    <?php
}
?>

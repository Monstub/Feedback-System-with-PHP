<?php

session_start();
include ("dbcon.php");

if (isset($_POST['ConfirmBtn'])) {
    $tableName = mysqli_real_escape_string($con, $_POST['FeedID']);

    $table_query = "SELECT * FROM usertablename WHERE tableName='$tableName'";
   // echo "table_query: " . $table_query . "<br>";

    $check_table_name = mysqli_query($con, $table_query);
    if (!$check_table_name) {
        die("Error in executing query: " . mysqli_error($con));
    }

    $table_name_count = mysqli_num_rows($check_table_name);
    //echo "table_name_count: " . $table_name_count . "<br>";

    if ($table_name_count > 0) {
        $_SESSION['EditName'] = $tableName;
        ?>
      <script>
        location.replace("studentDash1.php");
      </script>
      <?php
    }else{
        echo '<script>alert("Form Id is incorrect Or there is no such form exists.");</script>'; 
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="width:80%" method="post">
                    <div class="logo" >
                        <a href="adminPage.php"><img src="./img/back.png" alt="easyclass" /></a>
                        <h4>feedback system</h4>                         
                    </div>                       
                    <h1 style="margin-top: 10px;">Get the Feedback Form</h1>
                    <br>
                    <h5>Please enter the feedback form ID.</h5> 
                    <div class="actual-form" style="margin-top:20px">                                                                                  
                        <div class="input-wrap">
                            <input
                            name="FeedID"
                            type="text"
                            minlength="4"
                            class="input-field"                                 
                            autocomplete="off"
                            required
                            />
                            <label>form ID</label>
                        </div>
                    
                        <input name="ConfirmBtn"type="submit" value="Next" class="sign-btn" />
                              
                    </div>
                </form>

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

<?php
  session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>feedbackForm</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      .scrollable-div {
            height: 300px; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }
    </style>
</head>
<body>

<?php

include ("dbcon.php");

if (isset($_POST['ConfirmBtn'])) {
    $tableName = mysqli_real_escape_string($con, $_POST['formName']);
    $totalRows = mysqli_real_escape_string($con, $_POST['totalRows']);
    $totalUId = mysqli_real_escape_string($con, $_POST['TableQ']);
    $formTITLE = mysqli_real_escape_string($con, $_POST['FeedTitile']);
    $rollFrom = mysqli_real_escape_string($con, $_POST['rollNoFrom']);
    $rollTo = mysqli_real_escape_string($con, $_POST['rollNoTo']);
    $UserName = $_SESSION['authen'];

    $User_query = "SELECT * FROM usertablename WHERE UserName='$UserName'";
    $check_User_name = mysqli_query($con, $User_query);

    if (!$check_User_name) {
        die("Error in executing query: " . mysqli_error($con));
    } $User_name_count = mysqli_num_rows($check_User_name);

    if ($User_name_count > 2) {
      ?>
        <script>
            alert("Apologies, but you've exceeded the maximum limit of form generations. To create new forms, kindly consider removing existing ones or explore our premium feedback membership option. Thank you for your understanding.");
        </script>
    <?php
    } else {

    $_SESSION['FORMNAME'] = $tableName;

    $table_query = "SELECT * FROM usertablename WHERE tableName='$tableName'";
    $check_table_name = mysqli_query($con, $table_query);

    if (!$check_table_name) {
        die("Error in executing query: " . mysqli_error($con));
    } $table_name_count = mysqli_num_rows($check_table_name);

    if ($table_name_count > 0) {
        echo "Table name exists";
    } else {
        

      // SQL statement to create a new table
      $create_table = "CREATE TABLE $tableName (
        Sr_No INT AUTO_INCREMENT PRIMARY KEY,
        faculty_name VARCHAR(255) NOT NULL,
        faculty_sub VARCHAR(255) NOT NULL
      )";

      // Execute the SQL statement
      if (mysqli_query($con, $create_table)) {
        echo "Table created successfully";
      } else {
        echo "Error creating table: " . mysqli_error($con);
      }

      $_SESSION['ROLLFROM'] = $rollFrom;
      $_SESSION['ROLLTO'] = $rollTo;
      
        $insertTableQuery = "INSERT INTO usertablename (UserName, totalRows, totalAttri, tableName, formTitle, rollNumFrom, rollNumTo) VALUES (?, ?, ?, ?, ?, ?, ?)";
       // echo "insertTableQuery: " . $insertTableQuery . "<br>";

        $binding = mysqli_prepare($con, $insertTableQuery);
        if (!$binding) {
            die("Error in preparing statement: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($binding, "sssssss", $UserName, $totalRows, $totalUId, $tableName, $formTITLE, $rollFrom, $rollTo);

        $testQuery = mysqli_stmt_execute($binding);
       // echo "testQuery: " . $testQuery . "<br>";

        if ($testQuery && mysqli_affected_rows($con) > 0) {
            // Insertion successful
            echo '<script>alert("Connection successful");</script>';
        } else {
            // Insertion failed
            echo "Error: " . mysqli_error($con);
        }

        header('Location:/feedback-proj/page3.php');
    }
  }
}

?>

    <main>
        <div class="box">
            <div class="inner-box">   
                <div class="forms-wrap-demo" style="margin-top:20px">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-right: 30px;" method="post">
                        <div class="logo" >
                          <a href="adminPage.php"><img src="./img/back.png" alt="easyclass" /></a>
                          <h4>feedback system</h4>
                          
                        </div>
                          
                        <h1 style="margin-top: 10px;">Step No. 01/02</h1>
                        <br>
                        <h5>Please fill the following details.</h5> 
                        <div class="scrollable-div">
                        <div class="actual-form" style="margin-top:20px">                            
                               
                              <div class="input-wrap">
                                      <input
                                        name="FeedTitile"
                                        type="text"
                                        minlength="4"
                                        class="input-field"                                 
                                        autocomplete="off"
                                        required
                                      />
                                      <label>Title of feedback form</label>
                                    </div> 
                              <div class="input-wrap">
                                <input
                                  name="formName"
                                  type="text"
                                  minlength="4"
                                  class="input-field"
                                  autocomplete="off"
                                  pattern="^[A-Za-z0-9]+$"
                                  required
                                />
                                <label>Form ID</label>
                              </div>

                              <div class="input-wrap">
                                <input
                                  name="totalRows"
                                  type="number"
                                  minlength="4"
                                  class="input-field"
                                  min="01" max="08"
                                  autocomplete="off"
                                  required
                                />
                                <label>Total faculty members</label>
                              </div>

                              <div class="input-wrap">
                                <input
                                  name="TableQ"
                                  type="text"
                                  class="input-field"  
                                  min="01" max="20"                                
                                  autocomplete="off"
                                  required
                                />
                                <label>Total attributes</label>
                              </div>

                              <div class="input-wrap">
                                <input
                                  name="rollNoFrom"
                                  type="number"
                                  class="input-field"                              
                                  autocomplete="off"
                                  required
                                />
                                <label>Student Roll no.(FROM)</label>
                              </div>

                              <div class="input-wrap">
                                <input
                                  name="rollNoTo"
                                  type="number"
                                  pattern="^[0-9]+$"
                                  class="input-field"                                 
                                  autocomplete="off"
                                  required
                                />
                                <label>Student Roll no.(TO)</label>
                              </div>

                            
                        </div>
                        
                        </div>
                        <input name="ConfirmBtn"type="submit" value="Confirm & Submit" class="sign-btn" />
                              <h5>
                                Note: In form id only alphabatic characters (letters A-Z and a-z no space) are accepted.                          
                              </h5>
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
                          <h2>Generate three forms for free</h2>
                          <h2>Customize as you like</h2>
                          <h2>Invite students by form ID</h2>
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

    <script>
      const inputs = document.querySelectorAll(".input-field");
        const toggle_btn = document.querySelectorAll(".toggle");
        const main = document.querySelector("main");
        const bullets = document.querySelectorAll(".bullets span");
        const images = document.querySelectorAll(".image");

        inputs.forEach((inp) => {
          inp.addEventListener("focus", () => {
            inp.classList.add("active");
          });
          inp.addEventListener("blur", () => {
            if (inp.value != "") return;
            inp.classList.remove("active");
          });
        });

        toggle_btn.forEach((btn) => {
          btn.addEventListener("click", () => {
            main.classList.toggle("sign-up-mode");
          });
        });

        function moveSlider() {
          let index = this.dataset.value;

          let currentImage = document.querySelector(`.img-${index}`);
          images.forEach((img) => img.classList.remove("show"));
          currentImage.classList.add("show");

          const textSlider = document.querySelector(".text-group");
          textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

          bullets.forEach((bull) => bull.classList.remove("active"));
          this.classList.add("active");
        }

        bullets.forEach((bullet) => {
          bullet.addEventListener("click", moveSlider);
        });
    </script>
</body>
</html>


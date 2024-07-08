<?php
  session_start();
  $name = $_SESSION['EditName'];
  include("dbcon.php");


  if(isset($_POST['ConfirmBtn'])){
    $New_Faculty = mysqli_real_escape_string($con, $_POST['NewFaculty']) ;
    $New_Subject = mysqli_real_escape_string($con, $_POST['NewSubject']) ;

    $Faculty_query = "SELECT * FROM $name WHERE faculty_name='$New_Faculty'";
   // echo "table_query: " . $table_query . "<br>";

    $check_faculty_name = mysqli_query($con, $Faculty_query);
    if (!$check_faculty_name) {
        die("Error in executing query: " . mysqli_error($con));
    }

    $faculty_name_count = mysqli_num_rows($check_faculty_name);
    //echo "table_name_count: " . $table_name_count . "<br>";

    if ($faculty_name_count > 0) {
        echo "Data already exists";
    }else{
        $insert_New = "INSERT INTO $name (faculty_name, faculty_sub) VALUES ('$New_Faculty','$New_Subject')";

        $result1 = mysqli_query($con, $insert_New);

        // Check if the insertion was successful
        if ($result1) {
            echo "Values inserted successfully.";
        } else {
            echo "Error inserting values: " . mysqli_error($con);
        }

        header('Location:/feedback-proj/actualEdit.php');

    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>feedbackForm</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">   
                <div class="forms-wrap-demo" style="margin-top:20px">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-right: 30px;" method="post">
                        <div class="logo" >
                          <a href="adminPage.php"><img src="./img/back.png" alt="easyclass" /></a>
                          <h4>feedback system</h4>
                          
                        </div>
                          
                        <h1 style="margin-top: 10px;">Add new faculty or subject for existing one.</h1>
                        <span style="margin-top:10px">Fill the following details.</span>

                        <div class="actual-form" style="margin-top:30px">       
                        
                              <div class="input-wrap" style="margin-top:20px">
                                <input
                                  name="NewFaculty"                                
                                  type="text"
                                  minlength="4"
                                  class="input-field"
                                  autocomplete="off"
                                  required
                                />
                                <label>Faculty Name</label>
                              </div>                        

                              <div class="input-wrap">
                                <input
                                  name="NewSubject"
                                  type="text"
                                  minlength="5"
                                  class="input-field"                                                            
                                  autocomplete="off"
                                  required
                                />
                                <label>Subject Name</label>
                              </div>

                            <input name="ConfirmBtn"type="submit" value="Confirm & Submit" class="sign-btn" />
                              
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
                          <h2>Form will be in tabular form</h2>
                          <h2>Customize as you like</h2>
                          <h2>Invite students by form name</h2>
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


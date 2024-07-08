<?php
  session_start();
  include ("dbcon.php");

  if(isset($_POST['ConfirmBtn'])){
    $Old_pass = mysqli_real_escape_string($con, $_POST['Oldpass']) ;
    $New_pass = mysqli_real_escape_string($con, $_POST['Newpass']) ;
    $confirmNew_pass = mysqli_real_escape_string($con, $_POST['Newpass2']) ;
    $userName = $_SESSION['authen'];
  
    $pass_search = " select * from users where name='$userName' ";
    $query_check = mysqli_query($con, $pass_search);
  
    $valid_user = mysqli_num_rows($query_check);
  
    if($valid_user){
      $user_pass = mysqli_fetch_assoc($query_check);
      $db_pass = $user_pass['passward'];
  
 
      if($New_pass == $confirmNew_pass){
        $sql = "UPDATE users SET passward = '$New_pass' where name='$userName' ";
        if ($con->query($sql) === TRUE) {
            
            echo '<script>alert("Password changed Successfully.");</script>';
        ?>
        <script>
          location.replace("adminPage.php");
        </script>
        <?php
        } else {
            echo "Error updating data: " . $con->error;
        }
        
        
      }else{
        echo '<script>alert("New password and confirmative password not matched. Try again");</script>';
      }
    }else {
      echo '<script>alert("Password is incorrect. Try again");</script>';
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
                          
                        <h1 style="margin-top: 10px;">Change the Password</h1>
                        <br>
                        <h5>Please fill the following details.</h5> 
                        <div class="actual-form" style="margin-top:20px">                            
                               
                                    <div class="input-wrap">
                                      <input
                                        name="Oldpass"
                                        type="password"
                                        minlength="4"
                                        class="input-field"                                 
                                        autocomplete="off"
                                        required
                                      />
                                      <label>Old Password</label>
                                    </div> 

                                    <div class="input-wrap">
                                      <input
                                        name="Newpass"
                                        type="password"
                                        minlength="4"
                                        class="input-field"                                 
                                        autocomplete="off"
                                        required
                                      />
                                      <label>New Password</label>
                                    </div> 

                                    <div class="input-wrap">
                                      <input
                                        name="Newpass2"
                                        type="password"
                                        minlength="4"
                                        class="input-field"                                 
                                        autocomplete="off"
                                        required
                                      />
                                      <label>Confirm New Password</label>
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


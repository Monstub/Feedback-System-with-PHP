<?php
  session_start(); // Start session for session variables

  // Include database connection file
  include("dbcon.php");

  // Handle form submission for user registration
  if(isset($_POST['submit'])) {
      // Sanitize and retrieve form data
      $username = mysqli_real_escape_string($con, $_POST['USERNAME']);
      $password = mysqli_real_escape_string($con, $_POST['PASSWORD']);
      $email = mysqli_real_escape_string($con, $_POST['EMAIL']);

      // Hash password for secure storage
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Check if email already exists in database
      $email_query = "SELECT * FROM users WHERE email='$email'";
      $query = mysqli_query($con, $email_query);
      $email_count = mysqli_num_rows($query);

      if($email_count > 0){
          echo "Username already exists";
      } else {
          // Prepare insert query and bind parameters securely
          $insert_query = "INSERT INTO users (name, passward, email) VALUES (?, ?, ?)";
          $stmt = mysqli_prepare($con, $insert_query);
          if (!$stmt) {
              die("Error in preparing statement: " . mysqli_error($con));
          }
          mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);

          // Execute the statement and handle success or failure
          $insert_result = mysqli_stmt_execute($stmt);
          if ($insert_result && mysqli_affected_rows($con) > 0) {
              echo '<script>alert("Registration successful");</script>';
          } else {
              echo "Error: " . mysqli_error($con);
          }
      }
  }

  // Handle form submission for user login
  if(isset($_POST['loginBtn'])){
      $login_name = mysqli_real_escape_string($con, $_POST['userName']);
      $login_pass = mysqli_real_escape_string($con, $_POST['passWord']);

      // Query database to check if username exists
      $name_search_query = "SELECT * FROM users WHERE name='$login_name'";
      $query_check = mysqli_query($con, $name_search_query);

      // Check if user exists
      $valid_user = mysqli_num_rows($query_check);

      if($valid_user){
          $user_data = mysqli_fetch_assoc($query_check);
          $db_password = $user_data['passward'];

          // Set session variable upon successful login
          $_SESSION['authen'] = $user_data['name'];

          // Validate password and redirect if successful
          if($login_pass == $db_password){
              echo '<script>alert("You have logged in successfully.");</script>';
              ?>
              <script>
                location.replace("adminPage.php");
              </script>
              <?php
          } else {
              echo '<script>alert("Invalid Password");</script>';
          }
      } else {
          echo '<script>alert("Invalid Username");</script>';
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in & Sign up Form</title>
  <link rel="stylesheet" href="style.css"> <!-- Include CSS stylesheet -->
</head>
<body>
  <main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <!-- Sign-in form -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" class="sign-in-form" method="post">
            <div class="logo">
              <img src="./img/logo.png" alt="easyclass" />
              <h4>Feedback System</h4>
            </div>

            <div class="heading">
              <h2>Welcome Back</h2>
              <h6>Not registered yet?</h6>
              <a href="#" class="toggle">Sign up</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input
                  name="userName"
                  type="text"
                  minlength="4"
                  class="input-field"
                  autocomplete="off"
                  required
                />
                <label>Name</label>
              </div>

              <div class="input-wrap">
                <input
                  name="passWord"
                  type="password"
                  minlength="4"
                  class="input-field"
                  autocomplete="off"
                  required
                />
                <label>Password</label>
              </div>

              <input name="loginBtn" type="submit" value="Sign In" class="sign-btn" />
              <h4>Are you a student?
                <a href="studentDash.php">Press here</a> to give feedback</h4>
            </div>
          </form>

          <!-- Sign-up form -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" class="sign-up-form" method="post">
            <div class="logo">
              <img src="./img/logo.png" alt="easyclass" />
              <h4>Feedback System</h4>
            </div>

            <div class="heading">
              <h2>Get Started</h2>
              <h6>Already have an account?</h6>
              <a href="#" class="toggle">Sign in</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input
                  name="USERNAME"
                  type="text"
                  minlength="4"
                  class="input-field"
                  autocomplete="off"
                  required
                />
                <label>Name</label>
              </div>

              <div class="input-wrap">
                <input
                  name="EMAIL"
                  type="email"
                  class="input-field"
                  pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$"
                  autocomplete="off"
                  required
                />
                <label>Email</label>
              </div>

              <div class="input-wrap">
                <input
                  name="PASSWORD"
                  type="password"
                  minlength="4"
                  class="input-field"
                  autocomplete="off"
                  required
                />
                <label>Password</label>
              </div>

              <input type="submit" name="submit" value="Sign Up" class="sign-btn" />

              <p class="text">
                By signing up, I agree to the
                <a href="#">Terms of Services</a> and
                <a href="#">Privacy Policy</a>
              </p>
            </div>
          </form>
        </div>

        <!-- Carousel section -->
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

  <!-- JavaScript -->
  <script>
    const inputs = document.querySelectorAll(".input-field");
    const toggle_btn = document.querySelectorAll(".toggle");
    const main = document.querySelector("main");
    const bullets = document.querySelectorAll(".bullets span");
    const images = document.querySelectorAll(".image");

    // Event listeners for input fields
    inputs.forEach((inp) => {
      inp.addEventListener("focus", () => {
        inp.classList.add("active");
      });
      inp.addEventListener("blur", () => {
        if (inp.value != "") return;
        inp.classList.remove("active");
      });
    });

    // Event listener for toggle buttons
    toggle_btn.forEach((btn) => {
      btn.addEventListener("click", () => {
        main.classList.toggle("sign-up-mode");
      });
    });

    // Function to move slider
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

    // Event listeners for slider bullets
    bullets.forEach((bullet) => {
      bullet.addEventListener("click", moveSlider);
    });
  </script>
</body>
</html>

<?php
session_start(); // Start session to manage user authentication

// Include necessary CSS and JavaScript files here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Feedback Form</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        /* Custom styles */
        .scrollable-div {
            height: 70%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .scrollable-div1 {
            height: 90%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .buttonNext {
            display: flex;
            width: 20%;
            height: 43px;
            background-color: #151111;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 0.8rem;
            font-size: 0.8rem;
            margin-bottom: 2rem;
            transition: 0.3s;
            text-decoration: none;
            place-items: center;
            justify-content: center;
        }

        .buttonNext:hover {
            background-color: #8371fd;
        }
    </style>
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="logo">
                    <a href="adminPage.php"><img src="./img/back.png" alt="easyclass" /></a>
                    <h4>feedback system</h4>
                </div>

                <?php
                include("dbcon.php"); // Include database connection

                $name = $_SESSION['FORMNAME']; // Retrieve session variable for form name

                // Retrieve number of fields and attributes from the database
                $query = "SELECT totalRows FROM usertablename where tableName = '$name' ";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                $numberOfFields = $row['totalRows'];

                $query69 = "SELECT totalAttri FROM usertablename where tableName = '$name' ";
                $result69 = mysqli_query($con, $query69);
                $row69 = mysqli_fetch_assoc($result69);
                $numberOfAttrib = $row69['totalAttri'];

                // Generate HTML for input fields dynamically based on retrieved data
                $inputFields = '';
                for ($i = 1; $i <= $numberOfFields; $i++) {
                    $inputFields .= '<div class="input-wrap">';
                    $inputFields .= '<input name="Faculty'.$i.'" type="text" minlength="4" class="input-field" autocomplete="off" required/>';
                    $inputFields .= '<label>Name of Faculty</label>';
                    $inputFields .= '</div>';
                }

                $subjectFields = '';
                for ($j = 1; $j <= $numberOfFields; $j++) {
                    $subjectFields .= '<div class="input-wrap">';
                    $subjectFields .= '<input name="Subject'.$j.'" type="text" minlength="2" class="input-field" autocomplete="off" required/>';
                    $subjectFields .= '<label>Subject Name</label>';
                    $subjectFields .= '</div>';
                }

                $attributeFields = '';
                for ($k = 1; $k <= $numberOfAttrib; $k++) {
                    $attributeFields .= '<div class="input-wrap" style="width: 50%;">';
                    $attributeFields .= '<input name="Attribute'.$k.'" type="text" minlength="4" class="input-field" autocomplete="off" required/>';
                    $attributeFields .= '<label>Attribute No.'.$k.'</label>';
                    $attributeFields .= '</div>';
                }

                // Output the form with dynamic input fields
                echo '
                <form action="process_form.php" method="post" style="margin-right: 30px;">
                    <h1 style="margin-top: 10px;">Just one step Closer</h1>
                    <span style="margin-top:10px">Fill the following details.</span>

                    <div class="scrollable-div">
                        <div class="actual-form" style="margin-top:30px">
                            <table class="table" style="width: 80%;">
                                <thead>
                                    <tr>
                                        <th>01. Faculty Name</th>
                                        <th>Subject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $inputFields . '</td>
                                        <td>' . $subjectFields . '</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>02. Define various attributes for feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $attributeFields . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <center>
                        <input name="ConfirmBtn" type="submit" value="Confirm & Submit" class="buttonNext" />
                    </center>
                </form>
                ';
                ?>
            </div>
        </div>
    </main>
    <script src="app.js"></script> <!-- Include your JavaScript file -->
</body>
</html>

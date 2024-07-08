<?php
session_start(); // Start session to manage user authentication

// Include necessary CSS and JavaScript files here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Faculty Members</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Inline styles for specific elements -->
    <style>
        /* Your custom styles here */
        .button, .buttonRemove, .buttonNext {
            /* Button styles */
        }

        .scrollable-div {
            /* Styles for scrollable div */
        }

        .link-container {
            /* Styles for link container */
        }

        /* Additional styles as needed */
    </style>

</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="logo">
                    <img src="./img/logo.png" alt="easyclass" />
                    <h4>feedback system</h4>
                </div>

                <div class="heading">
                    <h2>Manage faculty members.</h2>
                    <h6>Don't worry, your identity is hidden.</h6>
                </div>

                <br>
                <h6>I. Preview the faculty members.</h6>

                <div class="scrollable-div">
                    <!-- Table to display faculty members -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Faculty Name</th>
                                <th>Subject</th>
                                <th>Add New Entry</th>
                                <th>Delete Faculty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("dbcon.php"); // Include database connection

                            // Retrieve session data for faculty name
                            $name = $_SESSION['EditName'];

                            // Query to fetch faculty members from database
                            $sql = "SELECT * FROM $name ORDER BY faculty_name ASC";
                            $result = $con->query($sql);

                            // Check if query execution was successful
                            if ($result === false) {
                                echo "Error executing the query: " . $con->error(); // Display error message if query fails
                            } else {
                                // Loop through fetched data and display in table rows
                                $rowCount = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["faculty_sub"] . "</td>";
                                    echo "<td><a href=\"add_subject1.php?srNo=" . $row['Sr_No'] . "\" class=\"button\">Add</a></td>";
                                    echo "<td><a href=\"delete_faculty1.php?srNo=" . $row['Sr_No'] . "\" class=\"buttonRemove\">Delete</a></td>";
                                    echo "</tr>";
                                    $rowCount++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <br>

                <center style="margin-top: 30px;">
                    <a href="page51.php" class="buttonNext">View Form</a>
                </center>
            </div>
        </div>
    </main>

    <script src="app.js"></script> <!-- Include your JavaScript file -->

</body>
</html>

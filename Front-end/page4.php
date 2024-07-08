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
    <title>Feedback System - Preview Data</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        /* Custom styles */
        .button {
            display: inline-block;
            padding: 0.5em 1em;
            background-color: #2eb125;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #000000;
        }

        .buttonRemove {
            display: inline-block;
            padding: 0.5em 1em;
            background-color: #e91919;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .buttonRemove:hover {
            background-color: #000000;
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

        .scrollable-div {
            height: 150px; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .link-container {
            display: grid;
            grid-template-columns: auto auto;
            column-gap: 10px; /* Add some spacing between the columns */
        }
    </style>
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box" style="margin-right: 30px;">

                <!-- Logo and Title Section -->
                <div class="logo">
                    <img src="./img/logo.png" alt="easyclass" />
                    <h4>Feedback System</h4>
                </div>

                <!-- Heading Section -->
                <div class="heading">
                    <h2>Check out your data fields.</h2>
                    <h6>Don't worry, your identity is hidden.</h6>
                </div>

                <br>

                <!-- Faculty Members Section -->
                <h6>I. Preview the faculty members.</h6>
                <div class="scrollable-div">
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
                            $name = $_SESSION['FORMNAME']; // Retrieve session variable for form name

                            $sql = "SELECT * FROM $name ORDER BY faculty_name ASC";
                            $result = $con->query($sql);

                            if ($result === false) {
                                // Query execution failed, handle the error
                                echo "Error executing the query: " . $con->error;
                            } else {
                                // Proceed with fetching the results
                                $rowCount = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["faculty_sub"] . "</td>";
                                    echo "<td><a href=\"add_subject.php?srNo=" . $row['Sr_No'] . "\" class=\"button\">Add</a></td>";
                                    echo "<td><a href=\"delete_faculty.php?srNo=" . $row['Sr_No'] . "\" class=\"buttonRemove\">Delete</a></td>";
                                    echo "</tr>";
                                    $rowCount++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <br>

                <!-- Attributes Section -->
                <h6>II. Preview the attributes.</h6>
                <div class="scrollable-div">
                    <?php
                    // Retrieve the dynamic array from the session
                    $dynamicArray = isset($_SESSION['ARRAY']) ? $_SESSION['ARRAY'] : [];

                    // Generate HTML table for attributes
                    echo '<table class="table" style="width: 50%;">';
                    echo '<thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Attribute Description</th>
                            </tr>
                        </thead>';
                    echo '<tbody>';

                    $rowCounter = 1; // Initialize the row counter

                    foreach ($dynamicArray as $row) {
                        echo '<tr>';
                        echo '<td>' . $rowCounter . '</td>'; // Print the row counter
                        echo '<td>' . $row . '</td>'; // Print the attribute description
                        echo '</tr>';
                        $rowCounter++; // Increment the row counter
                    }

                    echo '</tbody>';
                    echo '</table>';
                    ?>
                </div>

                <!-- Navigation to Form Section -->
                <center style="margin-top: 30px;">
                    <a href="page5.php" class="buttonNext">View Form</a>
                </center>
            </div>
        </div>
    </main>

    <script src="app.js"></script> <!-- Include your JavaScript file -->
</body>
</html>

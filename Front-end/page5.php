<?php
session_start(); // Start session to manage user authentication

include("dbcon.php"); // Include database connection
$name = $_SESSION['FORMNAME']; // Retrieve session variable for form name

// Query to fetch form title from database
$query = "SELECT formTitle FROM usertablename WHERE tableName='$name'";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $TitleOfForm = $row['formTitle'];
    } else {
        echo 'No data found.';
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $TitleOfForm; ?></title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        /* Custom styles */
        .scrollable-div {
            height: 70%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .horizontal-scroll {
            height: 90%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
            white-space: nowrap; /* Ensure contents stay in a single line */
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
                <!-- Logo and Title Section -->
                <div class="logo">
                    <img src="./img/logo.png" alt="easyclass" />
                    <h4>Feedback System</h4>
                </div>

                <!-- Form Heading Section -->
                <div class="heading">
                    <h2><?php echo $TitleOfForm; ?></h2>
                </div>

                <br>

                <!-- Scrollable Instructions Section -->
                <div class="scrollable-div">
                    <div class="instructions">
                        <h6>I. Instructions:</h6>
                        <h6>1) Rate each attribute on a scale of 1 to 10, with 1 being the lowest and 10 being the highest rating.</h6>
                        <h6>2) Provide any additional comments or suggestions in the space provided.</h6>
                    </div>

                    <br>

                    <!-- Attribute Descriptions Section -->
                    <h6>II. Attribute descriptions for the table:</h6>
                    <?php
                    // Query to fetch attribute descriptions from database
                    $query = "SELECT attribute FROM usertablename WHERE tableName='$name'";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $serializedData = $row['attribute'];

                            // Unserialize the data to retrieve array of attribute descriptions
                            $dataArray = unserialize($serializedData);

                            // Print the attribute descriptions
                            $rowCounter = 1; // Initialize the row counter
                            foreach ($dataArray as $row) {
                                echo '<h6>' . $rowCounter . ') Q' . $rowCounter . ': ' . $row . '</h6>';
                                $rowCounter++; // Increment the row counter
                            }
                        } else {
                            echo 'No data found.';
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($con);
                    }
                    ?>

                    <br>

                    <!-- Feedback Form Table -->
                    <span>III. Fill the feedback form given below.</span>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Faculty Name</th>
                                <th>Subject</th>
                                <?php
                                // Query to fetch column names of the form table
                                $query = "DESCRIBE $name";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    // Fetch and print column names excluding the first three (assuming they are IDs or non-data columns)
                                    $columnNames = array();
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $columnNames[] = $row['Field'];
                                    }
                                    array_splice($columnNames, 0, 3); // Remove first three elements

                                    foreach ($columnNames as $columnName) {
                                        echo '<th>' . $columnName . '</th>';
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch feedback data
                            $sql = "SELECT * FROM $name ORDER BY faculty_name ASC";
                            $result = $con->query($sql);

                            if ($result === false) {
                                // Handle query execution error
                                echo "Error executing the query: " . $con->error;
                            } else {
                                // Print feedback data rows
                                $rowCount = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["faculty_sub"] . "</td>";

                                    // Print N/A for each attribute column (assuming attribute columns start after the first three)
                                    for ($i = 1; $i < count($columnNames); $i++) {
                                        echo "<td>N/A</td>";
                                    }

                                    echo "<td>None</td>"; // Additional column for actions like delete
                                    echo "</tr>";
                                    $rowCount++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Button to Confirm and Upload -->
                <center style="margin-top: 30px;">
                    <a href="adminPage.php" class="buttonNext">Confirm & Upload</a>
                </center>
            </div>
        </div>
    </main>

    <script src="app.js"></script> <!-- Include your JavaScript file -->
</body>
</html>

<?php
session_start();

include("dbcon.php");

// Fetch form title based on session variable
$name = isset($_SESSION['EditName']) ? $_SESSION['EditName'] : '';
if (!empty($name)) {
    $query = "SELECT formTitle FROM usertablename WHERE tableName='$name'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $TitleOfForm = $row['formTitle'];
        } else {
            $TitleOfForm = 'Form Title Not Found';
        }
    } else {
        $TitleOfForm = 'Error fetching form title: ' . mysqli_error($con);
    }
} else {
    $TitleOfForm = 'Session variable EditName not set.';
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
        .scrollable-div {
            height: 70%;
            width: 100%;
            overflow: auto;
        }

        .horizontal-scroll {
            height: 90%;
            width: 100%;
            overflow: auto;
            white-space: nowrap;
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
                <img src="./img/logo.png" alt="easyclass" />
                <h4>Feedback System</h4>
            </div>
            <div class="heading">
                <h2><?php echo $TitleOfForm; ?></h2>
            </div>
            <br>
            <div class="scrollable-div">
                <div class="instructions">
                    <span>I. Instructions:</span>
                    <h6>1) Rate each attribute on a scale of 1 to 10, with 1 being the lowest and 10 being the highest rating.</h6>
                    <h6>2) Provide any additional comments or suggestions in the space provided.</h6>
                </div>
                <br>
                <span>II. Attribute description for table:</span>
                <?php
                // Fetch attribute descriptions based on session variable
                if (!empty($name)) {
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
                            echo 'No attribute data found.';
                        }
                    } else {
                        echo "Error fetching attribute data: " . mysqli_error($con);
                    }
                } else {
                    echo "Session variable EditName not set.";
                }
                ?>
                <br>
                <span>III. Fill the feedback form given below.</span>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Faculty Name</th>
                        <th>Subject</th>
                        <?php
                        // Fetch column names of the form table
                        if (!empty($name)) {
                            $query = "DESCRIBE $name";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                // Fetch the column names excluding the first three (assuming they are IDs or non-data columns)
                                $columnNames = array();
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $columnNames[] = $row['Field'];
                                }
                                array_splice($columnNames, 0, 3); // Remove first three elements

                                // Print the remaining column names
                                foreach ($columnNames as $columnName) {
                                    echo '<th>' . $columnName . '</th>';
                                }
                            } else {
                                echo "Error fetching column names: " . mysqli_error($con);
                            }
                        } else {
                            echo "Session variable EditName not set.";
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Fetch feedback data based on session variable
                    if (!empty($name)) {
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
                    } else {
                        echo "Session variable EditName not set.";
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            <center style="margin-top: 30px;">
                <a href="adminPage.php" class="buttonNext">Confirm & Upload</a>
            </center>
        </div>
    </div>
</main>

<script src="app.js"></script> <!-- Include your JavaScript file -->
</body>
</html>

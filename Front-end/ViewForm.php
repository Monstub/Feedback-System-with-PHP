<?php
session_start();

include("dbcon.php");

// Initialize variables
$distinctFaculty = $distinctSubject = $distinctStudent = 0;

// Fetch distinct counts from main table ($name)
$name = isset($_SESSION['EditName']) ? $_SESSION['EditName'] : '';
if (!empty($name)) {
    // Query for distinct faculty names count
    $sql = "SELECT COUNT(DISTINCT faculty_name) AS distinct_count FROM $name";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $distinctFaculty = $row['distinct_count'];
    } else {
        echo "Error fetching distinct faculty count: " . $con->error;
    }

    // Query for distinct subject count
    $sql = "SELECT COUNT(DISTINCT faculty_sub) AS distinct_count FROM $name";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $distinctSubject = $row['distinct_count'];
    } else {
        echo "Error fetching distinct subject count: " . $con->error;
    }

    // Query for distinct student count from new table ($newName)
    $newName = $name . 'New';
    $sql = "SELECT COUNT(DISTINCT column1) AS distinct_count FROM $newName";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $distinctStudent = $row['distinct_count'];
    } else {
        echo "Error fetching distinct student count: " . $con->error;
    }
} else {
    echo "Session variable EditName not set.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        /* CSS styles for the navbar and scrollable div */
        .scrollable-div {
            height: 80%;
            width: 100%;
            overflow: auto;
        }

        .navbar {
            background-color: #f2f2f2;
            border-radius: 10px;
            padding: 10px;
            width: 100%;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
        }

        .navbar li {
            display: inline-block;
        }

        .navbar li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .navbar li a:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
<main>
    <div class="box">
        <div class="inner-box">
            <!-- Navbar -->
            <div class="HeaderPart">
                <nav class="navbar">
                    <ul>
                        <li><a href="adminPage.php"><img src="./img/back.png" width="25" height="25" style="margin-top:7px"/></a></li>
                        <li><h5 style="margin-top:7px; margin-right:50px;">Feedback System</h5></li>
                        <li style="margin-top:7px"><a href="#">View Form</a></li>
                        <li style="margin-top:7px"><a href="#">Charts</a></li>
                        <li style="margin-top:7px"><a href="#">Comments</a></li>
                        <li style="margin-top:7px"><a href="#">Other</a></li>
                    </ul>
                </nav>
            </div>

            <!-- Feedback Form Information -->
            <div class="formInfo" style="margin-top:10px; margin-left:7px">
                <h2 style="text-decoration:underline">TITLE OF FORM</h2>
                <br>
                <span>Feedback form info.</span><br>
                <span>1) Total no. of faculty members: <?php echo $distinctFaculty; ?></span><br>
                <span>2) Total subjects: <?php echo $distinctSubject; ?></span><br>
                <span>3) No. of students who filled the form: <?php echo $distinctStudent; ?></span><br>
            </div>
            <br>

            <!-- Scrollable Table -->
            <div class="scrollable-div" style="margin-left:7px">
                <table class="table" id="viewTable">
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
                                    // Fetch the column names
                                    $columnNames = array();
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $columnNames[] = $row['Field'];
                                    }

                                    // Remove the first three elements from the array (assuming they are IDs or non-data columns)
                                    array_splice($columnNames, 0, 3);

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
                            <th>Overall</th>                              
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
                                // Proceed with fetching the results
                                $query69 = "SELECT totalAttri FROM usertablename WHERE tableName = '$name'";
                                $result69 = mysqli_query($con, $query69);
                                $row69 = mysqli_fetch_assoc($result69);
                                $numberOfAttrib = $row69['totalAttri'];

                                $rowCount = 1;

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["faculty_sub"] . "</td>";

                                    $faculty_name = $row["faculty_sub"];
                                    $columnCount = 4; // Start column count for attribute data

                                    $sum = 0;
                                    $count = 0;

                                    for ($k = 1; $k <= $numberOfAttrib; $k++) {
                                        $ColumnName = 'column' . $columnCount;
                                        $query = "SELECT SUM($ColumnName) AS total FROM $newName WHERE column3='$faculty_name'";
                                        $result2 = mysqli_query($con, $query);

                                        if ($result2) {
                                            $row2 = mysqli_fetch_assoc($result2);
                                            $total = $row2['total'];
                                            echo "<td>$total</td>";

                                            // Calculate the sum and count for average calculation
                                            $sum += $total;
                                            $count++;
                                        } else {
                                            echo "<td>Error</td>";
                                        }

                                        $columnCount++;
                                    }

                                    // Calculate the average
                                    $average = $count > 0 ? $sum / $count : 0;

                                    // Round the average up to the nearest positive integer
                                    $average = ceil($average);

                                    echo "<td>" . $average . "</td>";
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
        </div>
    </div>
</main>

<script>
    // Get the table reference
    var table = document.getElementById("viewTable");

    // Calculate and update the average for each row
    function calculateAverages() {
        // Loop through each row (excluding the header row)
        for (var i = 1; i < table.rows.length; i++) {
            var row = table.rows[i];
            var sum = 0;
            var count = 0;

            // Loop through each cell (excluding the last column)
            for (var j = 0; j < row.cells.length - 1; j++) {
                var cell = row.cells[j];
                var value = parseFloat(cell.innerHTML); // Parse the cell value as a float

                if (!isNaN(value)) {
                    sum += value;
                    count++;
                }
            }

            // Calculate the average
            var average = count > 0 ? sum / count : 0;

            // Update the last cell with the average
            row.cells[row.cells.length - 1].innerHTML = average.toFixed(2); // Update the cell content with the average (rounded to 2 decimal places)
        }
    }

    // Call the calculateAverages function initially
    calculateAverages();
</script>
</body>
</html>

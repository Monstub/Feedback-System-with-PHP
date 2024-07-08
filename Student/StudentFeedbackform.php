<?php
session_start();

include ("dbcon.php");
    $name = $_SESSION['EditName'];

    $query = "SELECT formTitle FROM usertablename WHERE tableName='$name' ";
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

    if (isset($_POST['ConfirmBtn'])) {
    ?>
    <script>
      location.replace("demo.php");
    </script>
    <?php
    }

// Assuming the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedNumbers = $_POST['selectedNumbers'];

    // Iterate through the selected numbers
    foreach ($selectedNumbers as $number) {
        echo "Selected number: " . $number . "<br>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        .scrollable-div {
            height: 80%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .horizontal-scroll{
            height: 90%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
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
                        <h4>feedback system</h4>
                    </div>
                    <div class="heading">
                        <h2><?php echo $TitleOfForm;?></h2>
                    </div>
                    <br>
                    <div class="scrollable-div">
                        <div class="instructions">
                            <h6>I. Instructions:</h4>
                            <h6>1) Rate each attribute on a scale of 1 to 10, with 1 being the lowest and 10 being the highest rating.</h6>
                            <h6>2) Provide any additional comments or suggestions in the space provided.</h6>
                        </div>
                        <br>
                        <h6>II. Attribute decription for table:</h6>
                        <?php
                            include ("dbcon.php");
                            $name = $_SESSION['EditName'];

                            $query = "SELECT attribute FROM usertablename WHERE tableName='$name' ";
                            $result = mysqli_query($con, $query);
        
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $serializedData = $row['attribute'];
        
                                            // Unserialize the data
                                            $dataArray = unserialize($serializedData);
        
                                            // Print the array
        
                                        } else {
                                            echo 'No data found.';
                                        }
                                    } else {
                                        echo "Error executing query: " . mysqli_error($con);
                                    }
        
        
                                    $rowCounter = 1; // Initialize the row counter
        
                                    foreach ($dataArray as $row) {
                                        echo '<h6>' . $rowCounter . ') Q' . $rowCounter . ': ' . $row . '</h6>';
                                        $rowCounter++; // Increment the row counter
                                    }
                            
                        ?>
                        <br>
                        <span>III. Fill the feedback form given below.</span>
                        
<form action="demo.php" method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Faculty Name</th>
                                    <th>Subject</th>
                                    <?php
                                        include("dbcon.php");
                                        $name = $_SESSION['EditName'];

                                        $tableName = $name;
                                        $query = "DESCRIBE $tableName";

                                        // Execute the query
                                        $result = mysqli_query($con, $query);

                                        if ($result) {
                                            // Fetch the column names
                                            $columnNames = array();
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $columnNames[] = $row['Field'];
                                            }

                                            // Remove the first three elements from the array
                                            array_splice($columnNames, 0, 3);

                                            // Print the remaining column names
                                            foreach ($columnNames as $columnName) {
                                                echo '<th>' . $columnName . '</th>';
                                            }
                                        }
                                    ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include("dbcon.php");
                                $name = $_SESSION['EditName'];

                                $sql = "SELECT * FROM $name ORDER BY faculty_name ASC";
                                $result = $con->query($sql);

                                if ($result === false) {
                                // Query execution failed, handle the error
                                echo "Error executing the query: " . $con->error();
                                } else {
                                // Proceed with fetching the results

                                $query69 = "SELECT totalAttri FROM usertablename where tableName = '$name' ";
                                $result69 = mysqli_query($con, $query69);
                                $row69 = mysqli_fetch_assoc($result69);
                                $numberOfAttrib = $row69['totalAttri'];
                                $AttributFields = '';
                                for ($k = 1; $k <= $numberOfAttrib; $k++) {
                                    $AttributFields .= '<div class="input-wrap" style="width: 50%;">';
                                    $AttributFields .= '<input name="Attribute'.$k.'" type="text" minlength="4" class="input-field" autocomplete="off" required/>';
                                    $AttributFields .= '<label>Attribute No.'.$k.'</label>';
                                    $AttributFields .= '</div>';
                                }

                                $rowCount = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["faculty_sub"] . "</td>";
                                    // Get the length of the array
                                    $length = count($columnNames);

                                   // Loop through the length of the array
                                    for ($i = 1; $i < $length; $i++) {
                                        echo '<td>
                                            <div class="input-wrap">
                                                <select class="input-field" name="selectedNumbers[]" required>
                                                    <option value=""></option>';
                                        
                                        // Generate options for numbers one to ten
                                        for ($number = 1; $number <= 10; $number++) {
                                            echo '<option value="' . $number . '">' . $number . '</option>';
                                        }
                                        
                                        echo '</select>
                                            </div>
                                        </td>';
                                    }


                                    echo "<td>None</td>";                           
                                    echo "</tr>";
                                    $rowCount++;
                                }
                                }
                                ?>
                            </tbody>
                        </table> 
                        <center style="margin-top: 30px;">
                            <input name="ConfirmBtn"type="submit" value="Confirm & Submit" class="buttonNext" />
                        </center> 
                        </form>
                    </div>
                    
            </div>
        </div>
    </main>




    <script src="app.js"></script>

</body>
</html>

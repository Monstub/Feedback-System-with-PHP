<?php

include ("dbcon.php");
session_start();

$name = $_SESSION['FORMNAME'];
// Retrieve the number from the database table
$query = "SELECT totalRows FROM usertablename where tableName = '$name' ";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$numberOfFields = $row['totalRows'];

$query69 = "SELECT totalAttri FROM usertablename where tableName = '$name' ";
$result69 = mysqli_query($con, $query69);
$row69 = mysqli_fetch_assoc($result69);
$numberOfAttrib = $row69['totalAttri'];

// Get the input values from the form
$inputs = [];
for ($i = 1; $i <= $numberOfFields; $i++) {
  $inputName = 'Fauclty' . $i;
  if (isset($_POST[$inputName])) {
    $inputs[$i] = mysqli_real_escape_string($con, $_POST[$inputName]);
  }
}
/*
// Iterate over the input values array
foreach ($inputs as $value) {
    // Sanitize and escape the value before inserting (optional but recommended)
    $escapedValue = mysqli_real_escape_string($con, $value);

    // Prepare the INSERT statement
    $insertQuery = "INSERT INTO $name (faculty_name) VALUES ('$escapedValue')";

    // Execute the INSERT statement
    $result = mysqli_query($con, $insertQuery);

    // Check if the insertion was successful
    if ($result) {
        echo "Value '$escapedValue' inserted successfully into $name.";
    } else {
        echo "Error inserting value '$escapedValue': " . mysqli_error($con);
    }
}
*/
$Subjectinputs = [];
for ($i = 1; $i <= $numberOfFields; $i++) {
  $SubjectIName = 'Subject' . $i;
  if (isset($_POST[$SubjectIName])) {
    $Subjectinputs[$i] = mysqli_real_escape_string($con, $_POST[$SubjectIName]);
  }
}

$Attributetinputs = [];
for ($i = 1; $i <= $numberOfAttrib; $i++) {
  $AttributeName = 'Attribute' . $i;
  if (isset($_POST[$AttributeName])) {
    $Attributetinputs[$i] = mysqli_real_escape_string($con, $_POST[$AttributeName]);
  }
}

$_SESSION['ARRAY'] = $Attributetinputs;


/*
// Iterate over the input values array
foreach ($Subjectinputs as $value) {
    // Sanitize and escape the value before inserting (optional but recommended)
    $escapedValue = mysqli_real_escape_string($con, $value);

    // Prepare the INSERT statement
    $insertQuery = "INSERT INTO $name (faculty_sub) VALUES ('$escapedValue')";

    // Execute the INSERT statement
    $result = mysqli_query($con, $insertQuery);

    // Check if the insertion was successful
    if ($result) {
        echo "Value '$escapedValue' inserted successfully into $name.";
    } else {
        echo "Error inserting value '$escapedValue': " . mysqli_error($con);
    }
}
*/

  $insertQuery = "INSERT INTO $name (faculty_name, faculty_sub) VALUES ";

    // Construct the values for each row
    $bows = [];
    for ($i = 1; $i <=count($inputs); $i++) {
        $value1 = mysqli_real_escape_string($con, $inputs[$i]);
        $value2 = mysqli_real_escape_string($con, $Subjectinputs[$i]);
        $bows[] = "('$value1', '$value2')";
    }

    // Append the rows to the INSERT statement
    $insertQuery .= implode(', ', $bows);

    // Execute the INSERT statement
    $result1 = mysqli_query($con, $insertQuery);

    // Check if the insertion was successful
    if ($result1) {
        echo "Values inserted successfully.";
    } else {
        echo "Error inserting values: " . mysqli_error($con);
    }

    // Determine the number of values in the array
      $numValues = count($Attributetinputs);

      // Create the ALTER TABLE query string
      $alterQuery = "ALTER TABLE $name";

      // Add the necessary number of columns with auto-generated names
      for ($i = 1; $i <= $numValues; $i++) {
          $column = "Q$i";
          $alterQuery .= " ADD $column VARCHAR(255),";
      }

      // Remove the trailing comma from the ALTER TABLE query
      $alterQuery = rtrim($alterQuery, ',');

      // Execute the ALTER TABLE query
      if (mysqli_query($con, $alterQuery)) {
          echo "Columns added successfully.";
      } else {
          echo "Error adding columns: " . mysqli_error($con);
      }
      $commentQuery = "ALTER TABLE $name ADD Comments VARCHAR(255)";

      // Execute the ALTER TABLE query
      if (mysqli_query($con, $commentQuery)) {
          echo "New column added successfully.";
      } else {
          echo "Error adding column: " . mysqli_error($con);
      }

                        // Create a new table name by appending 'New' to the original name
                        $newName = $name . 'New';

                        // Create a SQL statement to create the table with one column for the primary key
                        $sql = "CREATE TABLE $newName (Sr_No INT AUTO_INCREMENT PRIMARY KEY)";

                        // Execute the SQL statement and check for errors
                        if (mysqli_query($con, $sql)) {
                            echo "Table created successfully";
                        } else {
                            echo "Error creating table: " . mysqli_error($con);
                        }

                        // Determine the number of columns to add to the table
                        $numColumns = $numValues + 3;

                        // Create an array of column names with auto-generated names
                        $columns = array_map(function ($i) {
                            return "column$i";
                        }, range(1, $numColumns));

                        // Create a SQL statement to add the columns to the table
                        $sql = "ALTER TABLE $newName ADD " . implode(" VARCHAR(255), ADD ", $columns) . " VARCHAR(255)";

                        // Execute the SQL statement and check for errors
                        if (mysqli_query($con, $sql)) {
                            echo "Columns added successfully.";
                        } else {
                            echo "Error adding columns: " . mysqli_error($con);
                        }

                        // Create a SQL statement to add a column for comments to the table
                        $sql = "ALTER TABLE $newName ADD Comments VARCHAR(255)";

                        // Execute the SQL statement and check for errors
                        if (mysqli_query($con, $sql)) {
                            echo "Column added successfully.";
                        } else {
                            echo "Error adding column: " . mysqli_error($con);
                        }



      // Data array
      //$dataArray = array('John', 'Jane', 'Mark');

      // Serialize the array
      $serializedData = serialize($Attributetinputs);

      // Escape the serialized data
      $escapedData = mysqli_real_escape_string($con, $serializedData);

      // Insert the serialized data into the database
      $query = "UPDATE usertablename SET attribute='$escapedData' WHERE tableName='$name'";
      $result = mysqli_query($con, $query);
      if ($result) {
          echo 'Array stored successfully.';
      } else {
          echo 'Error storing array: ' . mysqli_error($con);
      }

header('Location:/feedback-proj/page4.php');


?>


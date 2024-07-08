<?php

session_start();
include("dbcon.php");

///=========================================================
// Assuming the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedNumbers = $_POST['selectedNumbers'];

    // Iterate through the selected numbers
    foreach ($selectedNumbers as $number) {
        echo "Selected number: " . $number . "<br>";
    }
}
//---------------------------------------------------------------------------
// Assuming you have established a database connection

// Specified column names
$column1 = 'faculty_name';
$column2 = 'faculty_sub';
$name = $_SESSION['EditName'];

// Query to retrieve values from the specified columns
$query = "SELECT $column1, $column2 FROM $name ORDER BY faculty_name ASC";

// Execute the query
$result = $con->query($query);

// Check if the query was successful
if ($result) {
    // Create an empty array to store the values
    $valuesArray = [];

    // Fetch each row and store the values in the array
    while ($row = $result->fetch_assoc()) {
        // Store the value from column1 in the array
        $valuesArray[] = $row[$column1];

        // Store the value from column2 in the array
        $valuesArray[] = $row[$column2];
    }

    // Free the result set
    $result->free();

    // Output the array of values
    print_r($valuesArray); echo '<br>';
} else {
    echo "Error executing query: " . $con->error();
}

//- --- - - - - - - - - -- --//

//$valuesArray = ['element1', 'element2', 'element3', 'element4', 'element5', 'element6', 'element7', 'element8', 'element9'];
$elementToAdd = $_SESSION['RollNumber'];
$interval = 2;

$dynamicElements = [];

// Add the element at the start
array_unshift($dynamicElements, $elementToAdd);

// Add the element after every 2 elements
for ($i = 0; $i < count($valuesArray); $i++) {
    $dynamicElements[] = $valuesArray[$i];
    if (($i + 1) % $interval === 0) {
        $dynamicElements[] = $elementToAdd;
    }
}
array_pop($dynamicElements);
print_r($dynamicElements); echo '<br>';
;


//=============================================================================

$tableName = $name . 'New';;
$query = "DESCRIBE $tableName";

// Execute the query
$result = mysqli_query($con, $query);

if ($result) {
    // Fetch the column names
    $columnNames = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $columnNames[] = $row['Field'];
    }


    // Remove the first element
    array_shift($columnNames);

    // Remove the last element
    array_pop($columnNames);

    print_r($columnNames); echo '<br>';
    /*
    // Print the remaining column names
    foreach ($columnNames as $columnName) {
        echo '<th>' . $columnName . '</th>';
    }*/
}

//=================================================================================


//$array = ['element1', 'element2', 'element3', 'element4', 'element5', 'element6', 'element7', 'element8', 'element9'];

//$dynamicElements = ['dynamicElement1', 'dynamicElement2'];

//$OldArray1 = ['Element1', 'Element2', 'Element3', 'Element4', 'Element5', 'Element6', 'Element7', 'Element8', 'Element9', 'Element10', 'Element11', 'Element12', 'Element13', 'Element14', 'Element15'];
//$OldArray2 = ['dynamicElement1', 'dynamicElement2', 'dynamicElement3', 'dynamicElement4', 'dynamicElement5', 'dynamicElement6', 'dynamicElement7', 'dynamicElement8', 'dynamicElement9'];

$FinalArray = [];

$dynamicIndex = 0;

// Add elements from OldArray2 and OldArray1 in a specific pattern
foreach ($selectedNumbers as $elements) {
    if ($dynamicIndex < count($dynamicElements)) {
        $FinalArray[] = $dynamicElements[$dynamicIndex++];
    }
    $FinalArray[] = $elements;
}

// Add remaining elements from OldArray2 if any
while ($dynamicIndex < count($dynamicElements)) {
    $FinalArray[] = $dynamicElements[$dynamicIndex++];
}

print_r($FinalArray); echo '<br>';

//-------------------------------------------------------------------------



$query = "SELECT totalAttri FROM usertablename where tableName = '$name' ";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$TotalAttribute = $row['totalAttri'];

$No = $TotalAttribute + 3;
$const = $No;
$CONSTANT = $TotalAttribute + 4;


//-------------------------------------------------------------------------

$array1 = ['element1', 'element2', 'element3', 'element4', 'element5'];
$array2 = ['elementA', 'elementB', 'elementC'];

// Add the first three elements of array1 to the beginning of array2
$selectedNumbers = array_merge(array_slice($dynamicElements, 0, 3), $selectedNumbers);

// Remove the first three elements from array1
$dynamicElements = array_slice($dynamicElements, 3);

// Print the updated arrays
print_r($dynamicElements); echo '<br>';
print_r($selectedNumbers); echo '<br>';

//======================================================================

$array1 = ['element1', 'element2', 'element3', 'element4', 'element5'];
$array2 = ['elementA', 'elementB', 'elementC', 'elementD', 'elementE', 'elementF', 'elementG'];


while (!empty($dynamicElements)) {
    // Get the first three elements from array1
    $elementsToAdd = array_slice($dynamicElements, 0, 3);

    // Insert the elements after the 6th element of array2
    array_splice($selectedNumbers, $No, 0, $elementsToAdd);

    // Remove the first three elements from array1
    $dynamicElements = array_slice($dynamicElements, 3);

    // Print the updated arrays
    print_r($dynamicElements); echo '<br>';
    print_r($selectedNumbers); echo '<br>';
    $No = $No + $const;
}

//=====================================================================


// Define the batch size
$batchSize = count($columnNames);

// Define the target column names for each batch
$targetColumns = ['column1', 'column2', 'column3', 'column4'];

// Calculate the total number of elements in the array
$totalElements = count($selectedNumbers);

// Calculate the total number of batches
$totalBatches = ceil($totalElements / $batchSize);

// Iterate through the array in batches
for ($batch = 0; $batch < $totalBatches; $batch++) {
    // Calculate the starting index for the current batch
    $startIndex = $batch * $batchSize;

    // Extract the batch of distinct values from the array
    $distinctSubset = array_slice($selectedNumbers, $startIndex, $batchSize);
    print_r($distinctSubset); echo '<br>';

    // Construct the INSERT query
$newName = $name . 'new';
$query = "INSERT INTO $newName (";

// Add the target column names for the current batch
$query .= implode(", ", $columnNames);

$query .= ") VALUES ";

$values = [];
foreach ($distinctSubset as $value) {
    // Escape the values to prevent SQL injection
    $escapedValue = $con->real_escape_string($value);

    // Add quotes around the escaped value
    $quotedValue = "'" . $escapedValue . "'";

    // Add the quoted value to the values array
    $values[] = $quotedValue;
}

// Combine the values into a comma-separated string
$valuesString = implode(", ", $values);


// Enclose the values string within parentheses
$valuesString = "(" . $valuesString . ")";

// Add the values string to the query
$query .= $valuesString;

// Execute the INSERT query
if ($con->query($query) === TRUE) {
    echo "Batch inserted successfully!";
} else {
    echo "Error inserting data: " . $con->error;
    echo "Query: " . $query . "<br>";

}

}

?>
      <script>
        location.replace("greetings.php");
      </script>
      <?php

?>

?>
<?php

session_start();
include("dbcon.php");


// Example array of distinct values
$distinctValues = ['distinct1', 'distinct2', 'distinct3', 'distinct4', 'distinct5', 'distinct6', 'distinct7', 'distinct8', 'distinct9', 'distinct10'];

// Define the batch size
$batchSize = 4;

// Define the target column names for each batch
$targetColumns = ['column1', 'column2', 'column3', 'column4'];

// Example array of values for the WHERE clause
$whereValues = ['value1', 'value2', 'value3', 'value4']; // Example values for WHERE clause

// Calculate the total number of elements in the array
$totalElements = count($distinctValues);

// Calculate the total number of batches
$totalBatches = ceil($totalElements / $batchSize);

// Assuming you have a database connection established
//$conn = new mysqli('localhost', 'username', 'password', 'database_name');

// Iterate through the array in batches
for ($batch = 0; $batch < $totalBatches; $batch++) {
    // Calculate the starting index for the current batch
    $startIndex = $batch * $batchSize;

    // Extract the batch of distinct values from the array
    $distinctSubset = array_slice($distinctValues, $startIndex, $batchSize);

    // Construct the INSERT query
    $query = "INSERT INTO your_table (";
    $query .= implode(", ", $targetColumns);
    $query .= ") VALUES ";

    $values = [];
    foreach ($distinctSubset as $value) {
        // Escape the values to prevent SQL injection
        $escapedValue = $conn->real_escape_string($value);
        $values[] = "('" . $escapedValue . "')";
    }

    $query .= implode(", ", $values);

    // Construct the WHERE clause dynamically
    $whereClause = '';
    foreach ($whereValues as $whereValue) {
        // Escape the values to prevent SQL injection
        $escapedWhereValue = $conn->real_escape_string($whereValue);
        $whereClause .= ($whereClause === '') ? '' : ' OR ';
        $whereClause .= "column_name = '" . $escapedWhereValue . "'";
    }

    // Add the WHERE clause to the query
    $query .= " WHERE " . $whereClause;

    // Execute the INSERT query
    if ($conn->query($query) === TRUE) {
        echo "Batch inserted successfully!";
    } else {
      //  echo "Error inserting data: " . $conn->error;
    }
}

// Close the database connection
$conn->close();


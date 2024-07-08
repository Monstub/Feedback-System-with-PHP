<?php

session_start();
$name = $_SESSION['FORMNAME'];

// Check if the "srNo" parameter is present in the URL
if (isset($_GET['srNo'])) {
    // Retrieve the "srNo" value from the URL
    $srNo = $_GET['srNo'];
    
    // Perform the delete operation using the retrieved "srNo"
    // Assuming you have a database connection established
    include("dbcon.php");

    // Prepare the delete query
    $deleteQuery = "DELETE FROM $name WHERE Sr_No = ?";
    
    // Prepare the statement
    $statement = mysqli_prepare($con, $deleteQuery);
    
    // Bind the "srNo" value to the statement
    mysqli_stmt_bind_param($statement, "i", $srNo);
    
    // Execute the statement
    $result = mysqli_stmt_execute($statement);
    
    // Check if the deletion was successful
    if ($result) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
    
    // Close the statement and database connection
    mysqli_stmt_close($statement);
    mysqli_close($con);
    
    // Redirect back to the original page
    header("Location: page4.php");
    exit;
} else {
    echo "Invalid request.";
}
?>

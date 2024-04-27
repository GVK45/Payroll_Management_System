<?php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $DepartmentID = $_POST["DepartmentID"];
    $DepartmentName = $_POST["DepartmentName"];
    $EmployeeID = $_POST["EmployeeID"];
    $PositionID = $_POST["PositionID"];

    // Validate and sanitize form data
    $DepartmentID = intval($DepartmentID);
    $DepartmentName = htmlspecialchars(trim($DepartmentName));
    $EmployeeID = intval($EmployeeID);
    $PositionID = intval($PositionID);

    // Example: Connect to database and insert data into Department table
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "payroll_database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO Department (DepartmentID, DepartmentName, EmployeeID, PositionID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issi", $DepartmentID, $DepartmentName, $EmployeeID, $PositionID);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New department entry added successfully";
        header("Location: success_page.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
ob_end_flush();
?>

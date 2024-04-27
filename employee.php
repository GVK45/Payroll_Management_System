<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST["EmployeeID"];
    $first_name = $_POST["FirstName"];
    $last_name = $_POST["LastName"];
    $ssn = $_POST["SSN"];
    $birth_date = $_POST["BirthDate"];
    $hire_date = $_POST["HireDate"];
    $payroll_id = $_POST["PayrollID"];

    $employee_id = intval($employee_id);
    $first_name = htmlspecialchars(trim($first_name));
    $last_name = htmlspecialchars(trim($last_name));
    $ssn = preg_replace('/[^0-9-]/', '', $ssn); 
    $payroll_id = intval($payroll_id);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "payroll_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Employee (EmployeeID, FirstName, LastName, SSN, BirthDate, HireDate, PayrollID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isssssi", $employee_id, $first_name, $last_name, $ssn, $birth_date, $hire_date, $payroll_id);

    if ($stmt->execute()) {
        echo "New employee entry added successfully";
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

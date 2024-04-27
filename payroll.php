<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $payroll_id = $_POST["PayrollID"];
    $pay_period_start = $_POST["PayPeriodStart"];
    $pay_period_end = $_POST["PayPeriodEnd"];
    $gross_pay = $_POST["GrossPay"];
    $net_pay = $_POST["NetPay"];
    $taxes = $_POST["Taxes"];
    $tax_id = $_POST["TaxID"];

    // Validate and sanitize form data (you can add more validation as needed)
    $payroll_id = intval($payroll_id);
    $pay_period_start = htmlspecialchars(trim($pay_period_start));
    $pay_period_end = htmlspecialchars(trim($pay_period_end));
    $gross_pay = floatval($gross_pay);
    $net_pay = floatval($net_pay);
    $taxes = floatval($taxes);
    $tax_id = intval($tax_id);

    // Example: Connect to database and insert data into Payroll table
    // Ensure these credentials are correct for your database
    $servername = "localhost";
    $username = "root"; // Default username for local environments
    $password = ""; // Default password for local environments
    $dbname = "payroll_database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO Payroll (PayrollID, PayPeriodStart, PayPeriodEnd, GrossPay, NetPay, Taxes, TaxID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issddii", $payroll_id, $pay_period_start, $pay_period_end, $gross_pay, $net_pay, $taxes, $tax_id);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New payroll entry added successfully";
        // Redirect to a new page to avoid form resubmission
        header("Location: success_page.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

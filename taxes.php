<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TaxID = intval($_POST["TaxID"]);
    $TaxType = htmlspecialchars(trim($_POST["TaxType"]));
    $TaxRate = floatval($_POST["TaxRate"]);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "payroll_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Taxes (TaxID, TaxType, TaxRate) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iss", $TaxID, $TaxType, $TaxRate);

    if ($stmt->execute()) {
        // Redirect to another page after form submission
        header("Location: index.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

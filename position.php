<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $position_id = intval($_POST["position_id"]);
    $position_title = htmlspecialchars(trim($_POST["position_title"]));
    $base_salary = floatval($_POST["base_salary"]);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "payroll_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Position (PositionID, PositionTitle, BaseSalary) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isd", $position_id, $position_title, $base_salary);

    if ($stmt->execute()) {
        echo "New position entry added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

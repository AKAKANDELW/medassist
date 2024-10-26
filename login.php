<?php
session_start();
require 'db_connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch patient data
$patient_id = $_SESSION['patient_id'];

// Fetch lab results
$query_lab = "SELECT * FROM lab_results WHERE patient_id = ?";
$stmt_lab = $conn->prepare($query_lab);
$stmt_lab->bind_param("s", $patient_id);
$stmt_lab->execute();
$result_lab = $stmt_lab->get_result();

// Fetch prescriptions
$query_prescriptions = "SELECT * FROM prescriptions WHERE patient_name = ?";
$stmt_prescriptions = $conn->prepare($query_prescriptions);
$stmt_prescriptions->bind_param("s", $patient_id); // Assuming patient_name matches patient_id
$stmt_prescriptions->execute();
$result_prescriptions = $stmt_prescriptions->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <h2>Your Lab Results</h2>
        <table>
            <tr>
                <th>Test Date</th>
                <th>Result</th>
                <th>Technician</th>
            </tr>
            <?php while ($row = $result_lab->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['test_date']; ?></td>
                <td><?php echo $row['result']; ?></td>
                <td><?php echo $row['technician_username']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Your Prescriptions</h2>
        <table>
            <tr>
                <th>Prescription Number</th>
                <th>Medication</th>
                <th>Dosage</th>
                <th>Frequency</th>
                <th>Diagnosis</th>
                <th>Prescription Date</th>
            </tr>
            <?php while ($row = $result_prescriptions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['prescription_number']; ?></td>
                <td><?php echo $row['medication_name']; ?></td>
                <td><?php echo $row['dosage']; ?></td>
                <td><?php echo $row['frequency']; ?></td>
                <td><?php echo $row['diagnosis']; ?></td>
                <td><?php echo $row['prescription_date']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
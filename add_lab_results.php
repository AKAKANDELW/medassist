<?php
// Start session
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['lab_technician'])) {
    header("Location: lab_technician_login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'hpc');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert lab results
    $stmt = $conn->prepare("INSERT INTO lab_results (patient_id, technician_username, result, test_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_POST['patient_id'], $_SESSION['lab_technician'], $_POST['result'], $_POST['test_date']);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<div class='alert success'>Lab results added successfully!</div>";
    } else {
        echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
    }

    // Close connections
    $stmt->close();
}

// Fetch doctors for the dropdown
$doctors = [];
$result = $conn->query("SELECT email FROM doctors");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row['email'];
    }
}

// Fetch lab results history
$lab_results = [];
$result = $conn->query("SELECT patient_id, result, test_date FROM lab_results WHERE technician_username = '" . $_SESSION['lab_technician'] . "'");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $lab_results[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Lab Results</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body {
    font-family: 'Arial', sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
    color: #333;
}
h2 {
    color: #007BFF; /* Blue theme */
}
.form-group {
    margin-bottom: 15px;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
input[type="text"], input[type="date"], select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
.button {
    padding: 10px 20px;
    background-color: #007BFF; /* Blue theme */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
.button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
.alert {
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
}
.success {
    background-color: #dff0d8; /* Light green */
    color: #3c763d; /* Dark green */
}
.error {
    background-color: #f2dede; /* Light red */
    color: #a94442; /* Dark red */
}
.logout {
    margin-top: 20px;
}
</style>
</head>
<body>

<h2><i class="fas fa-file-medical"></i> Add Lab Results</h2>
<form method="POST" action="">
<div class="form-group">
<label for="patient_id">Patient ID:</label>
<input type="text" id="patient_id" name="patient_id" required>
</div>
<div class="form-group">
<label for="result">Lab Result:</label>
<input type="text" id="result" name="result" required>
</div>
<div class="form-group">
<label for="test_date">Test Date:</label>
<input type="date" id="test_date" name="test_date" required>
</div>
<div class="form-group">
<label for="doctor_email">Select Doctor:</label>
<select id="doctor_email" name="doctor_email" required>
<option value="">--Select Doctor--</option>
<?php foreach ($doctors as $email): ?>
<option value="<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></option>
<?php endforeach; ?>
</select>
</div>
<button type="submit" class="button">Add Result</button>
</form>

<h2><i class="fas fa-history"></i> Lab Results History</h2>
<table>
<thead>
<tr>
<th>Patient ID</th>
<th>Lab Result</th>
<th>Test Date</th>
</tr>
</thead>
<tbody>
<?php if (empty($lab_results)): ?>
<tr>
<td colspan="3" style="text-align: center;">No lab results found.</td>
</tr>
<?php else: ?>
<?php foreach ($lab_results as $result): ?>
<tr>
<td><?php echo htmlspecialchars($result['patient_id']); ?></td>
<td><?php echo htmlspecialchars($result['result']); ?></td>
<td><?php echo htmlspecialchars($result['test_date']); ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<a href="lab_technician_login.php" class="button logout"><i class="fas fa-sign-out-alt"></i> Logout</a>

</body>
</html>
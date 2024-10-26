<?php
// db.php - Database connection
$servername = "localhost"; // or your server
$username = "root";
$password = "";
$dbname = "hpc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// registration.php - Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient-id'];
    $full_name = $_POST['full-name'];
    $dob = $_POST['dob'];
    $blood_group = $_POST['blood-group'];
    $sex = $_POST['sex'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $primary_physician = $_POST['primary-physician'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO patients (patient_id, full_name, dob, blood_group, sex, height, weight, address, city, state, primary_physician, phone, email)
            VALUES ('$patient_id', '$full_name', '$dob', '$blood_group', '$sex', '$height', '$weight', '$address', '$city', '$state', '$primary_physician', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "New patient registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
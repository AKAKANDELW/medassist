<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "hpc");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO prescriptions (prescription_number, patient_name, doctor_name, allergy_history, type_drug_allergy, pharmacy_name, diagnosis, prescription_date, queue_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $prescription_number, $patient_name, $doctor_name, $allergy_history, $type_drug_allergy, $pharmacy_name, $diagnosis, $prescription_date, $queue_number);

    // Set parameters and execute
    $prescription_number = $_POST['prescription'];
    $patient_name = $_POST['patient'];
    $doctor_name = $_POST['doctor'];
    $allergy_history = $_POST['allergy_history'];
    $type_drug_allergy = $_POST['type_drug_allergy'];
    $pharmacy_name = $_POST['pharmacy'];
    $diagnosis = $_POST['diagnosis'];
    $prescription_date = $_POST['date'];
    $queue_number = $_POST['queue'];

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portal</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        :root {
            --primary-color: #1a73e8;
            --primary-light: #4285f4;
            --background: #f0f2f5;
            --card-bg: rgba(255, 255, 255, 0.9);
            --text-primary: #333;
            --text-secondary: #666;
            --button-text: #ffffff;
            --shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
        }

        .dark-mode {
            --primary-color: #4285f4;
            --primary-light: #64b5f6;
            --background: #1a1a1a;
            --card-bg: rgba(30, 30, 30, 0.9);
            --text-primary: #fff;
            --text-secondary: #ccc;
            --button-text: #ffffff;
            --shadow: 20px 20px 60px #0a0a0a, -20px -20px 60px #2a2a2a;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-light));
            opacity: 0.1;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            position: relative;
        }

        h1 {
            color: var(--text-primary);
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 700;
        }

        label {
            font-size: 1rem;
            color: var(--text-secondary);
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="date"], select, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid var(--text-secondary);
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .button {
            background-color: var(--primary-color);
            color: var(--button-text);
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            display: block;
            margin: 30px auto 0;
            width: 100%;
        }

        .button:hover {
            background-color: var(--primary-light);
        }

        .logout-button {
            background-color: #dc3545;
        }

        .logout-button:hover {
            background-color: #c82333;
        }

        h2 {
            margin-top: 40px;
            color: var(--text-primary);
            font-size: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid var(--text-secondary);
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            input[type="text"], input[type="date"], select, textarea {
                font-size: 0.9rem;
            }

            .button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>
    <div class="container">
        <h1>Prescription Details</h1>
        <button class="button logout-button" onclick="logout()">Logout</button>
        <form id="prescriptionForm" action="submit_prescription.php" method="POST">
            <div class="form-row">
                <div class="form-col">
                    <label for="prescription">Prescription #</label>
                    <input type="text" id="prescription" name="prescription" placeholder="Prescription Number" required>
                </div>
                <div class="form-col">
                    <label for="patient_id">Patient ID</label>
                    <input type="text" id="patient_id" name="patient_id" placeholder="Patient ID" required>
                </div>
                <div class="form-col">
                    <label for="patient">Patient</label>
                    <input type="text" id="patient" name="patient" placeholder="Patient Name" required>
                </div>
                <div class="form-col">
                    <label for="doctor">Prescribing Doctor</label>
                    <input type="text" id="doctor" name="doctor" placeholder="Doctor Name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="allergy_history">History of Drug Allergy</label>
                <textarea id="allergy_history" name="allergy_history" rows="4" placeholder="Describe drug allergies"></textarea>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="type_drug_allergy">Type of Drug Allergy</label>
                    <select id="type_drug_allergy" name="type_drug_allergy">
                        <option value="">Select allergy type</option>
                        <option value="antibiotic">Antibiotic</option>
                        <option value="ace">ACE</option>
                        <option value="arbs">ARBS</option>
                        <option value="anti-inflammatory">Anti-Inflammatory</option>
                        <option value="aspirin">Aspirin</option>
                        <option value="penicillin">Penicillin</option>
                        <option value="sulfa">Sulfa</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-col">
                    <label for="pharmacy">Pharmacy</label>
                    <input type="text" id="pharmacy" name="pharmacy" placeholder="Pharmacy Name">
                </div>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis</label>
                <textarea id="diagnosis" name="diagnosis" rows="2" placeholder="Describe diagnosis" required></textarea>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="date">Prescription Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-col">
                    <label for="queue">Queue #</label>
                    <input type="text" id="queue" name="queue" placeholder="Queue Number">
                </div>
            </div>
            
            <h2>Medication Details</h2>
            <div class="form-row">
                <div class="form-col">
                    <label for="medication_name">Medication Name</label>
                    <input type="text" id="medication_name" name="medication_name" placeholder="Enter medication name" required>
                </div>
                <div class="form-col">
                    <label for="dosage">Dosage</label>
                    <input type="text" id="dosage" name="dosage" placeholder="e.g., 500mg" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="frequency">Frequency</label>
                    <input type="text" id="frequency" name="frequency" placeholder="e.g., twice daily" required>
                </div>
                <div class="form-col">
                    <label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g., 7 days" required>
                </div>
            </div>

            <button type="submit" class="button">Submit</button>
        </form>
    </div>

    <script>
        function logout() {
            // Redirect to logout handler or perform logout action
           

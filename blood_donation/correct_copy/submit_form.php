<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood donation"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $age = (int)$_POST['age'];
    $gender = $conn->real_escape_string($_POST['gender']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $city = $conn->real_escape_string($_POST['city']);

    // Insert data into the table using a prepared statement
    $stmt = $conn->prepare("INSERT INTO donors (full_name, age, gender, blood_group, email, phone, city) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $full_name, $age, $gender, $blood_group, $email, $phone, $city);

    if ($stmt->execute()) {
        echo "New donor record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Blood Donation</title>
    <link rel="stylesheet" type = "text/css" href="styles.css">
    <style>
        th {
            
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Red Circle</h1>
        <p>Your contribution can save lives!</p>
    </header>
    <a style = "color : red; text-align : center" href = "http://localhost/blood_donation/view_donors.php?blood_group=B%2B&city=Chennai">View donors</a>


    <main>
        <section id="donor-form">
            <h2 style="text-align: center;">Register as a Donor</h2>
            <form method="POST" action="submit_form.php">
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full_name" required>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label for="blood-group">Blood Group:</label>
                <select id="blood-group" name="blood_group" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <a style = "color : red; text-align : center" href = "http://localhost/blood_donation/view_donors.php?blood_group=B%2B&city=Chennai">View donors</a>
</body>
</html>

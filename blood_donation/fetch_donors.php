<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood donation"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : '';
$city = isset($_GET['city']) ? $_GET['city'] : '';

$sql = "SELECT * FROM donors WHERE 1";

if ($blood_group) {
    $sql .= " AND blood_group = '$blood_group'";
}

if ($city) {
    $sql .= " AND city LIKE '%$city%'";
}

$result = $conn->query($sql);

$donors = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($donors);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Blood Donation</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Fetch and display donors from the database
        function fetchDonors() {
            fetch('fetch_donors.php')
                .then(response => response.json())
                .then(data => {
                    let donorList = '';
                    data.forEach((donor, index) => {
                        donorList += `<div class="donor">
                                        <p>Name: ${donor.full_name}</p>
                                        <p>Age: ${donor.age}</p>
                                        <p>Gender: ${donor.gender}</p>
                                        <p>Blood Group: ${donor.blood_group}</p>
                                        <p>Email: ${donor.email}</p>
                                        <p>Phone: ${donor.phone}</p>
                                        <p>City: ${donor.city}</p>
                                    </div>`;
                    });
                    document.getElementById('donor-list').innerHTML = donorList;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Apply Filters
        function applyFilters() {
            let bloodGroup = document.getElementById('filter-blood-group').value;
            let city = document.getElementById('filter-city').value;

            fetch(`fetch_donors.php?blood_group=${bloodGroup}&city=${city}`)
                .then(response => response.json())
                .then(data => {
                    let donorList = '';
                    data.forEach((donor, index) => {
                        donorList += `<div class="donor">
                                        <p>Name: ${donor.full_name}</p>
                                        <p>Age: ${donor.age}</p>
                                        <p>Gender: ${donor.gender}</p>
                                        <p>Blood Group: ${donor.blood_group}</p>
                                        <p>Email: ${donor.email}</p>
                                        <p>Phone: ${donor.phone}</p>
                                        <p>City: ${donor.city}</p>
                                    </div>`;
                    });
                    document.getElementById('donor-list').innerHTML = donorList;
                })
                .catch(error => console.error('Error applying filters:', error));
        }

        // Fetch donors when the page loads
        window.onload = function() {
            fetchDonors();
        }
    </script>
</head>
<body>
    <header>
        <h1>Welcome to red circle</h1>
        <p>Your contribution can save lives!</p>
    </header>

    <main>
        <section id="donor-form">
            <h2 style = "text-align : center;">Register as a Donor</h2>
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

        <section id="filter-section">
            <h2 style = "text-align : center;">Filter Donors</h2>
            <label for="filter-blood-group">Blood Group:</label>
            <select id="filter-blood-group">
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="filter-city">City:</label>
            <input type="text" id="filter-city">

            <button type="button" onclick="applyFilters()">Apply Filters</button>
        </section>

        <section id="donor-list"></section>
    </main>
</body>
</html>

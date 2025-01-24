<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donors</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Red Circle</h1>
        <p>Your contribution can save lives!</p>
    </header>

    <main>
        <section id="donor-list">
            <?php
            // Include the database connection
            include 'db.php';
            include 'styles.css';

            // Get the filter values from the URL query parameters
            $blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : '';
            $city = isset($_GET['city']) ? $_GET['city'] : '';

            // Prepare the query with conditions
            $sql = "SELECT * FROM donors WHERE 1";

            if ($blood_group) {
                $sql .= " AND blood_group = '$blood_group'";
            }
            if ($city) {
                $sql .= " AND city LIKE '%$city%'";
            }

            // Run the query
            $result = $conn->query($sql);

            // Display the result
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>Age</th><th>Gender</th><th>Blood Group</th><th>Email</th><th>Phone</th><th>City</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['blood_group'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No matching donors found.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </section>
    </main>
</body>
</html>

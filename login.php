<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; 
    $password = $_POST['password'];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashed_password_from_db = $row['password']; // Fetch hashed password from the database
               
                if (password_verify($password, $hashed_password_from_db)) { // Verify hashed password
                    $_SESSION['email'] = $row['username'];
                    header('Location: login_success.html');

        } else {
            echo '<script>alert("Incorrect password");</script>'; 
        }
    } else {
        echo '<script>alert("User not found");</script>';
    }

    $stmt->close();
    $conn->close();
}
?>

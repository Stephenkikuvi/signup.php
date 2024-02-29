<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $gender = $_POST["Gender"];
    $contact_address = $_POST["add"];
    $email = $_POST["mail"];
    $password = $_POST["pass"];

   
    $first_name= htmlspecialchars(trim($first_name));
    $last_name = htmlspecialchars(trim($last_name));
    $gender = htmlspecialchars(trim($gender));
    $contact_address= htmlspecialchars(trim($contact_address));
    $email = htmlspecialchars(trim($email));
    $password= htmlspecialchars(trim($password));

  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "auth";


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "INSERT INTO signup (first_name, last_name, gender, contact_address, email, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssss", $first_name, $last_name, $gender, $contact_address, $email, $hashed_password);
        $stmt->execute();
        $stmt->close(); 
    
        header("Location: signup_success.html");
        exit();
    } else {
        echo 'Error preparing statement: ' . $conn->error;
    }
    
}

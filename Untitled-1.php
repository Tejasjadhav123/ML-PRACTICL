<?php
session_start();
include 'includes/conn.php';

if(isset($_POST['login'])){
    // Sanitize user input to prevent SQL injection
    $voter = mysqli_real_escape_string($conn, $_POST['voter']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM voters WHERE voters_id = '$voter'";
    $query = $conn->query($sql);

    if($query->num_rows < 1){
        // Set an error message for the user
        $_SESSION['error'] = 'Cannot find a voter with the ID';
    }
    else{
        $row = $query->fetch_assoc();
        // Use password_verify to check the hashed password
        if(password_verify($password, $row['password'])){
            // Set a session variable to indicate the user is logged in
            $_SESSION['voter_id'] = $row['id'];
        }
        else{
            // Set an error message for incorrect password
            $_SESSION['error'] = 'Incorrect password';
        }
    }
}
else {
    // Set an error message for when login data is not provided
    $_SESSION['error'] = 'Input voter credentials first';
}

// Redirect to the appropriate page (index.php)
header('location: index.php');
?>

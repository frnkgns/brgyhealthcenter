<!-- itong file na to iba to sa mga files -->
<!-- yung ibang files kasi may designs and html -->
<!--pero dito pure on database manipulation -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

// sa signpup page kapag clinick nila yung sign up btn don ito yung mag rurun
if (isset($_POST['signup'])) {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: Insert into a database (replace with actual database code)
    // Hash the password for security

    // SQL query to insert user into database
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($con, $sql)) {
        // Registration successful
        header('Location: index.php?signup=success');
        exit;
    } else {
        // Registration failed
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
        // You can handle the error as per your application's requirements
        exit;
    }
}

// If somehow someone accesses process.php without submitting the form, redirect to index.php
header('Location: index.php');
exit;
?>

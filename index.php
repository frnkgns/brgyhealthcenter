<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .medical-image {
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        .welcome-container {
            display: flex;
            justify-content: center;
            background-color: #fff;
            border-radius: 8px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        p {
            width:900px;
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .welcome-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .welcome-container h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .welcome-container p {
            font-size: 1.5rem;
            text-align: center;
            max-width: 100%;
        }

    </style>
</head>
<body>
    <!-- yung mga images na ginagamit natin nasa images folder lang  -->
    <!-- halos similar lang lahat to bali ang pinag kaiba lang is yung query sa line 99 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Barangay Health Center</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="tel:117">Emergency: (63+)9345627184 (PNP)</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link text-white" href="tel:911">Fire: (63+)9814253647 (BFP)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-7">

                <!-- so kapag nag retrieve tayo ng image ito na images/file.name -->
                <img src="images/welcome.jpg" alt="Medical Image" class="medical-image">
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">Login</div>
                    <div class="card-body">
                        <form action="index.php" method="POST">
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Login</button>
                            <a href="signup.php" class="btn btn-link mt-3">Sign Up</a>
                        </form>
                        <?php
                        // sa ganon lang ulit check if nag start naba connection
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }
                            
                            //then kapag pinindot na nya yung login btn
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                include("db.php");

                                //kaunti lang query natin dito since username and pass lang naman needed
                                $username = $_POST['username'];
                                $password = $_POST['password'];

                                // Sanitize input (if needed)
                                $username = mysqli_real_escape_string($con, $username);
                                $password = mysqli_real_escape_string($con, $password);

                                //so select * natin pero isang row lang kukunin natin
                                $sql = "SELECT * FROM admin WHERE username = '{$username}' LIMIT 1";
                                $result = mysqli_query($con, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $stored_password = $row['password'];

                                    // Verify password
                                    //if match ang username at password 
                                    if ($password == $stored_password) {
                                        // Passwords match, authentication successful
                                        $_SESSION['username'] = $username;
                                        echo '<div class="alert alert-success mt-3">Authorized, proceeding to dashboard.</div>';
                                        
                                        //ipupunta natin sya sa dashboard.php makikita mo sa baba
                                        echo "
                                            <script>
                                                setTimeout(function() {
                                                    window.location.href = 'dashboard.php'; 
                                                }, 1000); 
                                            </script>
                                        ";

                                        exit;
                                    } else {
                                        // Passwords do not match papakita natin to sa form ng log in
                                        echo '<div class="alert alert-danger mt-3">Invalid credentials. Please try again.</div>';
                                    }
                                } else {
                                    // No user found with that username ganon din dito
                                    echo '<div class="alert alert-danger mt-3">Invalid credentials. Please try again.</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-container">
        <h1 class="text-center">Welcome, Admin!</h1>
        <p></p>
    </div>

    <!-- tapos dito kaunting design lang nilagyan lang natin ng typing eefect animation -->
    <script>
        function typeWriter(element, text, delay = 50) {
            const textArray = text.split('');
            let i = 0;

            function printText() {
                if (i < textArray.length) {
                    element.innerHTML += textArray[i];
                    i++;
                    setTimeout(printText, delay);
                }
            }

            printText();
        }


        const paragraph = document.querySelector('.welcome-container p');
        const textToType = "Your role is critical in ensuring the accuracy and security of medical information. Explore the tools provided to streamline record management processes.";
        typeWriter(paragraph, textToType);
    </script>
</body>
</html>

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
            max-width: 400px; /* Adjust as per your image size */
            height: auto;
        }

        .welcome-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        p {
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
    <div>
        <img src="images/graph1.png" style="height:500px; position:absolute; margin-top:50px; margin-left:160px; z-index: -1;">
    <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Emergency Hotlines</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="tel:117">Emergency: 117 (PNP)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tel:911">Fire: 911 (BFP)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-7">
                <img src="images/hospitalicon.png" alt="Medical Image" class="medical-image">
                <div class="welcome-container position-absolute">
                    <h1 class="text-center">Welcome, Admin!</h1>
                    <p></p>
                </div>
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
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                session_start();
                                include("db.php"); // Include your database connection file

                                $username = $_POST['username'];
                                $password = $_POST['password'];

                                // Sanitize input (if needed)
                                $username = mysqli_real_escape_string($con, $username);
                                $password = mysqli_real_escape_string($con, $password);

                                // Query to fetch user from database based on username
                                $sql = "SELECT * FROM admin WHERE username = '{$username}' LIMIT 1";
                                $result = mysqli_query($con, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $stored_password = $row['password'];

                                    // Verify password
                                    if ($password == $stored_password) {
                                        // Passwords match, authentication successful
                                        $_SESSION['username'] = $username;
                                        echo '<div class="alert alert-success mt-3">Authorized, proceeding to dashboard.</div>';
                                        //delay natin ng 2 seconds bago pumunta sa dashboard para makita yung authorized notice
                                        echo "
                                            <script>
                                                setTimeout(function() {
                                                    window.location.href = 'dashboard.php';
                                                }, 1000); 
                                            </script>
                                        ";

                                        exit;
                                    } else {
                                        // Passwords do not match
                                        echo '<div class="alert alert-danger mt-3">Invalid credentials. Please try again.</div>';
                                    }
                                } else {
                                    // No user found with that username
                                    echo '<div class="alert alert-danger mt-3">Invalid credentials. Please try again.</div>';
                                }

                                // Close the database connection
                                mysqli_close($con);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to simulate typing effect
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

        // Select the paragraph element
        const paragraph = document.querySelector('.welcome-container p');

        // Text to be typed out
        const textToType = "Your role is critical in ensuring the accuracy and security of medical information. Explore the tools provided to streamline record management processes.";

        // Start typing effect
        typeWriter(paragraph, textToType);
    </script>
</body>
</html>

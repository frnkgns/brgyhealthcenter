
<!-- similar sa log in page yung mga functionalies -->
<!-- pero yung query para mag sign up nasa process.php -->
<!-- doon mo makikita kung paano sya mag insert ng admin -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                    <div class="card-header bg-primary text-white">Sign Up</div>
                    <div class="card-body">
                        <form action="process.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="signup" class="btn btn-primary mt-3" >Sign Up</button>
                            <a href="dashboard.php" class="btn btn-link mt-3">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-container">
        <h1 class="text-center">Welcome, Admin!</h1>
        <p></p>
    </div>
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

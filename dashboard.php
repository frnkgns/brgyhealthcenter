<?php

//ito is check natin kung nag start naba yung connection sa database kapag nag start syempre ayaw natin ulit isstart 
//kaya ichecheck natin na kapag hindi ba nag start don palang tayo mag start para maiwasan yung erro sa connection ng db
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//mapapansin mo wala ditong connection sa db dito sa mismong file na dashboard its becuase nilagay natin sa db.php yung 
//connection query
include("db.php");

// Sanitize function to remove whitespace and prevent SQL injection
function sanitize($data) {
    global $con; // ensure natin na maacess sya sa lahat ng file
    return mysqli_real_escape_string($con, trim($data));
}

// Add new patient record kapag nag click si user ng add button ma trigger tong condition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        if (isset($_POST["userid"])) {
            $userid = sanitize($_POST["userid"]);
            $diagnosis = sanitize($_POST["diagnosis"]);
            $name = sanitize($_POST["name"]);
            $age = sanitize($_POST["age"]);
            $gender = sanitize($_POST["gender"]);
            $address = sanitize($_POST["address"]);
            $appointment = sanitize($_POST["appointment"]);
            $medication = sanitize($_POST["medication"]);


            //so ito yung query natin
            $query = "INSERT INTO patient (userid, diagnosis, name, age, gender, address, appointment, medication) 
                      VALUES ('$userid', '$diagnosis', '$name', '$age', '$gender', '$address', '$appointment', '$medication')";
            mysqli_query($con, $query);

            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }

    // Update patient record same as here 
    if (isset($_POST["submit"])) {
        if (isset($_POST["userid"])) {
            $userid = sanitize($_POST["userid"]);
            $diagnosis = sanitize($_POST["diagnosis"]);
            $name = sanitize($_POST["name"]);
            $age = sanitize($_POST["age"]);
            $gender = sanitize($_POST["gender"]);
            $address = sanitize($_POST["address"]);
            $appointment = sanitize($_POST["appointment"]);
            $medication = sanitize($_POST["medication"]);

            $query = "UPDATE patient SET diagnosis='$diagnosis', name='$name', age='$age', gender='$gender', address='$address', appointment='$appointment', medication='$medication' WHERE userid='$userid'";
            mysqli_query($con, $query);

            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }

    // Delete patient record ganun din dito every time na nag cliclcik sila ng button 
    //itong mga conditions na to ma tritrigger
    if (isset($_POST["deleteConfirmed"])) {
        if (isset($_POST["userid"])) {
            $userid = sanitize($_POST["userid"]);
            $query = "DELETE FROM patient WHERE userid='$userid'";
            mysqli_query($con, $query);

            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }
}

// pag load ng page ipakita natin laaht ng data sa datbbase
$query = "SELECT userid, diagnosis, name, age, gender, address, appointment, medication FROM patient";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patients</title>

    <!-- gamit tayo framework for better and faster design so bootstrap pinili natin -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!-- lahat ng elements dito puro bootstrap makikita mo yung mga class nila laaht yan bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

        <!-- navigation bar nato sa taas ng website makikita yung barangay tyaka hotline -->
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

        <!-- ito namang mga buttons nato ito yung sa taas ng table yung add patient medicine log out -->
        <div> 
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                Add Patient
            </button>
            <button type="button" class="btn btn-success mb-3" onclick="window.location.href = 'meddashboard.php';">
                Medicine
            </button>
            <button type="button" class="btn btn-danger mb-3" onclick="window.location.href = 'index.php';">
                Log Out
            </button>
        </div>

        <!-- dito naman na yung table ng mga patient natin as well as the meddashboard -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Patient ID</th>
                        <th>Diagnosis</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Appointment</th>
                        <th>Medication</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- then para malagyan ng laman yung table of course need natin ng query or mag retrieve ng data sa databse -->
                    <!-- so basically kinukuha natin yung mga attributes ng data sa database and yung mismong data per row -->
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr id="row_<?php echo $row["userid"]; ?>">
                            <td><?php echo $row["userid"]; ?></td>
                            <td><?php echo htmlspecialchars($row["diagnosis"]); ?></td>
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["age"]); ?></td>
                            <td><?php echo htmlspecialchars($row["gender"]); ?></td>
                            <td><?php echo htmlspecialchars($row["address"]); ?></td>
                            <td><?php echo htmlspecialchars($row["appointment"]); ?></td>
                            <td><?php echo htmlspecialchars($row["medication"]); ?></td>
                            <td>
                                <!-- then dito naman sa baba yung mga buttons tapos nagpapasa tayo ng id kapag clinick nila to -->
                                <!-- ma tritrigger yung query natin sa taas or yung sql code natin depende sa button na clinick mo-->
                                <!-- so kapag edit mag tritrigger yung edit na sql-->
                                <!-- so kapag naman view mag tritrigger yung view na sql-->
                                <!-- as well as sa delete makikita mo ulit sa taas yung sql query natin-->

                                <button type="button" class="btn btn-primary" onclick="editDetails('<?php echo $row["userid"]; ?>')">Edit</button>
                                <button type="button" class="btn btn-info" onclick="viewDetails('<?php echo $row["userid"]; ?>')">View</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete('<?php echo $row["userid"]; ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add Patient -->
    <!-- itong modal naman is yung mga pop up for exampe diba clinick natin yung add patient mag papaopup tong mini form -->
    <!-- then yung sa baba nya is yung laman mismo ng mini form so kapag ito aang gumaga well papakita yung add form -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addPatientModalLabel">Add Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="userid" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userid" name="userid" placeholder="P1">
                        </div>
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <input type="text" class="form-control" id="diagnosis" name="diagnosis">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="appointment" class="form-label">Appointment</label>
                            <input type="text" class="form-control" id="appointment" name="appointment">
                        </div>
                        <div class="mb-3">
                            <label for="medication" class="form-label">Medication</label>
                            <input type="text" class="form-control" id="medication" name="medication">
                        </div>
                        <button type="submit" class="btn btn-primary" name="add">Add Patient</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Edit Patient -->
    <!-- halos similar lang sila ng functionality sa add form pero dito sa edit magpapakita na dito yung record na clinick mo -->
    <!-- then ieedit mo nalang yun  tapos oks na -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="editUserID" name="userid">
                        <div class="mb-3">
                            <label for="editDiagnosis" class="form-label">Diagnosis</label>
                            <input type="text" class="form-control" id="editDiagnosis" name="diagnosis">
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editAge" class="form-label">Age</label>
                            <input type="text" class="form-control" id="editAge" name="age">
                        </div>
                        <div class="mb-3">
                            <label for="editGender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="editGender" name="gender">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="editAppointment" class="form-label">Appointment</label>
                            <input type="text" class="form-control" id="editAppointment" name="appointment">
                        </div>
                        <div class="mb-3">
                            <label for="editMedication" class="form-label">Medication</label>
                            <input type="text" class="form-control" id="editMedication" name="medication">
                        </div>
                        <button type="submit" class="btn btn-info text-white" name="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for View Patient -->
    <!-- so dito naman wala ng edit edit na mangyayare bali ididisplay nya nalang yung mismong details ng record or ni patient-->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="patientDetails">
                        <p><strong>User ID:</strong> <span id="viewUserID"></span></p>
                        <p><strong>Diagnosis:</strong> <span id="viewDiagnosis"></span></p>
                        <p><strong>Name:</strong> <span id="viewName"></span></p>
                        <p><strong>Age:</strong> <span id="viewAge"></span></p>
                        <p><strong>Gender:</strong> <span id="viewGender"></span></p>
                        <p><strong>Address:</strong> <span id="viewAddress"></span></p>
                        <p><strong>Appointment:</strong> <span id="viewAppointment"></span></p>
                        <p><strong>Medication:</strong> <span id="viewMedication"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Confirm Delete -->
    <!-- then dito confimation nalang to, kung talaga bang gusto nyang idelete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this patient?</p>
                    <form id="deleteForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="deleteUserID" name="userid">
                        <button type="submit" class="btn btn-danger" name="deleteConfirmed">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // so yung mga modal kanina hindi pa doon malalagyan ng data or text bali parang ininitialize lang natin sila pero wala pa silang laman
        // para mag ka laman yung modal mag karoon ng text sa loob ito yung function na gagawin yun
        //pwede mong i ctrl + F tapos search mo yung mga id "editUserID" san sila naka pwesto para magets mo ng sobra 

        //so this part is for edit
        function editDetails(userid) {
            var row = document.getElementById("row_" + userid);
            document.getElementById("editUserID").value = row.cells[0].innerText;
            document.getElementById("editDiagnosis").value = row.cells[1].innerText;
            document.getElementById("editName").value = row.cells[2].innerText;
            document.getElementById("editAge").value = row.cells[3].innerText;
            document.getElementById("editGender").value = row.cells[4].innerText;
            document.getElementById("editAddress").value = row.cells[5].innerText;
            document.getElementById("editAppointment").value = row.cells[6].innerText;
            document.getElementById("editMedication").value = row.cells[7].innerText;

            var modal = new bootstrap.Modal(document.getElementById('editPatientModal'), {});
            modal.show();
        }

        //so this part is naman is for viewing
        function viewDetails(userid) {
            var row = document.getElementById("row_" + userid);
            document.getElementById("viewUserID").innerText = row.cells[0].innerText;
            document.getElementById("viewDiagnosis").innerText = row.cells[1].innerText;
            document.getElementById("viewName").innerText = row.cells[2].innerText;
            document.getElementById("viewAge").innerText = row.cells[3].innerText;
            document.getElementById("viewGender").innerText = row.cells[4].innerText;
            document.getElementById("viewAddress").innerText = row.cells[5].innerText;
            document.getElementById("viewAppointment").innerText = row.cells[6].innerText;
            document.getElementById("viewMedication").innerText = row.cells[7].innerText;

            var modal = new bootstrap.Modal(document.getElementById('viewPatientModal'), {});
            modal.show();
        }

        //and lastly delete
        function confirmDelete(userid) {
            document.getElementById("deleteUserID").value = userid;

            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
            modal.show();
        }
    </script>
</body>
</html>

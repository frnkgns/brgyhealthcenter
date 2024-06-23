

<!-- for this file siguro mag refer kanalang sa  -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

function sanitize($data) {
    global $con;
    return mysqli_real_escape_string($con, htmlspecialchars(stripslashes(trim($data))));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new medication record
    if (isset($_POST["add"])) {
        $name = sanitize($_POST["name"]);
        $mindosage = sanitize($_POST["mindosage"]);
        $maxdosage = sanitize($_POST["maxdosage"]);
        $expiration = sanitize($_POST["expiration"]);

        $query = "INSERT INTO medicine (name, mindosage, maxdosage, expiration) 
                  VALUES ('$name', '$mindosage', '$maxdosage', '$expiration')";
        mysqli_query($con, $query);
        
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    if (isset($_POST["submit"])) {
        $name = sanitize($_POST["name"]);
        $mindosage = sanitize($_POST["mindosage"]);
        $maxdosage = sanitize($_POST["maxdosage"]);
        $expiration = sanitize($_POST["expiration"]);

        $identifier = sanitize($_POST["identifier"]); 

        $query = "UPDATE medicine SET name='$name', mindosage='$mindosage', maxdosage='$maxdosage', expiration='$expiration' WHERE name='$identifier'";
        mysqli_query($con, $query);
        
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    if (isset($_POST["deleteConfirmed"])) {
        $identifier = sanitize($_POST["identifier"]);

        $query = "DELETE FROM medicine WHERE name='$identifier'";
        mysqli_query($con, $query);
        
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

$query = "SELECT * FROM medicine";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
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
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
            Add Medication
        </button>
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" onclick="window.location.href = 'dashboard.php';">
            Patien Record
        </button>
        <button type="button" class="btn btn-danger mb-3" onclick="window.location.href = 'index.php';">
                Log Out
            </button>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Min Dosage</th>
                        <th>Max Dosage</th>
                        <th>Expiration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr id="row_<?php echo htmlspecialchars($row["name"]); ?>">
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["mindosage"]); ?></td>
                            <td><?php echo htmlspecialchars($row["maxdosage"]); ?></td>
                            <td><?php echo htmlspecialchars($row["expiration"]); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="editDetails('<?php echo htmlspecialchars($row["name"]); ?>')">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete('<?php echo htmlspecialchars($row["name"]); ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add Medication -->
    <div class="modal fade" id="addMedicationModal" tabindex="-1" aria-labelledby="addMedicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addMedicationModalLabel">Add Medication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="mindosage" class="form-label">Min Dosage</label>
                            <input type="text" class="form-control" id="mindosage" name="mindosage">
                        </div>
                        <div class="mb-3">
                            <label for="maxdosage" class="form-label">Max Dosage</label>
                            <input type="text" class="form-control" id="maxdosage" name="maxdosage">
                        </div>
                        <div class="mb-3">
                            <label for="expiration" class="form-label">Expiration</label>
                            <input type="text" class="form-control" id="expiration" name="expiration" placeholder="dd/mm/yyyy">
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Medication -->
    <div class="modal fade" id="editMedicationModal" tabindex="-1" aria-labelledby="editMedicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="editMedicationModalLabel">Edit Medication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="editIdentifier" name="identifier">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editMindosage" class="form-label">Min Dosage</label>
                            <input type="text" class="form-control" id="editMindosage" name="mindosage">
                        </div>
                        <div class="mb-3">
                            <label for="editMaxdosage" class="form-label">Max Dosage</label>
                            <input type="text" class="form-control" id="editMaxdosage" name="maxdosage">
                        </div>
                        <div class="mb-3">
                            <label for="editExpiration" class="form-label">Expiration</label>
                            <input type="text" class="form-control" id="editExpiration" name="expiration" placeholder="dd/mm/yyyy">
                        </div>
                        <button type="submit" name="submit" class="btn btn-info text-white">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this medication record?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="deleteIdentifier" name="identifier">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteConfirmed" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editDetails(name) {
            var rowId = "row_" + name;
            var mindosage = document.getElementById(rowId).cells[1].innerText;
            var maxdosage = document.getElementById(rowId).cells[2].innerText;
            var expiration = document.getElementById(rowId).cells[3].innerText;

            document.getElementById("editIdentifier").value = name;
            document.getElementById("editName").value = name;
            document.getElementById("editMindosage").value = mindosage;
            document.getElementById("editMaxdosage").value = maxdosage;
            document.getElementById("editExpiration").value = expiration;

            var modal = new bootstrap.Modal(document.getElementById('editMedicationModal'), {
                keyboard: false
            });
            modal.show();
        }

        function confirmDelete(name) {
            document.getElementById("deleteIdentifier").value = name;

            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
                keyboard: false
            });
            modal.show();
        }
    </script>
</body>
</html>

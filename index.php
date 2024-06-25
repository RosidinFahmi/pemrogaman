<?php
include 'koneksi.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pemrograman WHERE id=$id";
    $conn->query($sql);
}

// Handle edit request
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM pemrograman WHERE id=$id");
    $data = $result->fetch_assoc();
}

// Handle POST request for adding and editing data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    if (!empty($_POST['id'])) {
        // Update data
        $id = $_POST['id'];
        $sql = "UPDATE pemrograman SET name='$name', class='$class' WHERE id=$id";
    } else {
        // Insert new data
        $sql = "INSERT INTO pemrograman (name, class) VALUES ('$name', '$class')";
    }
    $conn->query($sql);
    header('Location: koneksi.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="my-4">Elearning Pertemuan 21</h2>

    <!-- Form for Adding and Editing Data -->
    <form action="koneksi.php" method="post" class="mb-4">
        <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="class">Kelas:</label>
            <input type="text" id="class" name="class" class="form-control" value="<?php echo isset($data['class']) ? $data['class'] : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo isset($data['id']) ? 'Update' : 'Add'; ?></button>
    </form>

    <h2>Data List</h2>

    <!-- Display Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM pemrograman";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['class']}</td>";
                echo "<td>
                        <a href='koneksi.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='koneksi.php?delete={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
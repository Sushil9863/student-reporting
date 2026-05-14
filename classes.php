<?php include "includes/auth.php"; ?>
<?php if (!isAdmin()) { header("Location: index.php"); exit; } ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>🏫 Class Management</h2>

    <!-- ADD CLASS -->
    <div style="margin-bottom: 2rem;">
        <h3>➕ Add new class</h3>
        <form method="POST" class="form-row">
            <div class="form-group">
                <label>Class name</label>
                <input type="text" name="name" placeholder="e.g., Grade 1, Class 5A" required>
            </div>
            <div>
                <button type="submit" name="add" style="margin-top: 1.3rem;">➕ Add Class</button>
            </div>
        </form>
    </div>

    <!-- CLASS LIST -->
    <div>
        <h3>📋 All classes</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>ID</th><th>Class Name</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM classes ORDER BY id DESC");
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this class? All students inside will also be affected (if cascade).')" style="color:#dc2626; text-decoration:none;">🗑️ Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// ADD LOGIC
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    if ($name) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        echo "<div class='alert-success' style='margin-bottom:1rem;'>✅ Class added successfully!</div>";
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM classes WHERE id=$id");
    echo "<script>window.location='classes.php';</script>";
}
?>

<?php include "includes/footer.php"; ?>
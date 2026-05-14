<?php include "includes/auth.php"; ?>
<?php if (!isAdmin()) { header("Location: index.php"); exit; } ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>👨‍🎓 Students Management</h2>

    <?php if (isAdmin() || isTeacher()): ?>
    <div style="margin-bottom: 1.5rem;">
        <button id="openAddModalBtn" style="background:#2563eb; color:white; border:none; padding:0.6rem 1.2rem; border-radius:1rem; cursor:pointer;">➕ Add New Student</button>
    </div>
    <?php endif; ?>

    <div>
        <h3>📋 Student list</h3>
        <div class="table-wrapper">
            <table id="studentTable">
                <thead><tr><th>ID</th><th>Name</th><th>Class</th><th>Section</th><th>Father</th><th>Mother</th><th>Contact</th><th>Guardian</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                // Filter by teacher's assigned classes if teacher
                $class_filter = "";
                if (isTeacher()) {
                    $teacherClassIds = getTeacherClassIds();
                    if ($teacherClassIds) {
                        $class_filter = "AND students.class_id IN (" . implode(',', $teacherClassIds) . ")";
                    } else {
                        $class_filter = "AND 0";
                    }
                }
                $sql = "SELECT students.*, classes.name AS class_name FROM students JOIN classes ON students.class_id = classes.id WHERE 1 $class_filter ORDER BY students.id DESC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <tr id="student-row-<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['class_name']) ?></td>
                    <td><?= htmlspecialchars($row['section']) ?></td>
                    <td><?= htmlspecialchars($row['father_name']) ?></td>
                    <td><?= htmlspecialchars($row['mother_name']) ?></td>
                    <td><?= htmlspecialchars($row['parent_contact']) ?></td>
                    <td><?= htmlspecialchars($row['guardian_name']) ?><br><small><?= htmlspecialchars($row['guardian_relation']) ?></small></td>
                    <td>
                        <button class="edit-student-btn" data-id="<?= $row['id'] ?>" style="background:#f59e0b; color:white; border:none; padding:0.3rem 0.8rem; border-radius:1rem;">✏️ Edit</button>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')" style="color:#dc2626; margin-left:0.5rem;">🗑️ Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL (same as before) -->
<div id="studentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
    <div style="background:white; max-width:600px; width:90%; border-radius:1.5rem; padding:1.5rem; max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between;">
            <h3 id="modalTitle">Add Student</h3>
            <button id="closeModalBtn" style="background:none; border:none; font-size:1.5rem;">&times;</button>
        </div>
        <form id="studentForm">
            <input type="hidden" id="studentId" name="id">
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem;">
                <div class="form-group"><label>Student Name *</label><input type="text" id="name" name="name" required></div>
                <div class="form-group"><label>Class *</label>
                    <select id="class_id" name="class_id" required>
                        <option value="">-- Select Class --</option>
                        <?php
                        $classes_sql = "SELECT * FROM classes";
                        if (isTeacher()) {
                            $teacherClassIds = getTeacherClassIds();
                            if ($teacherClassIds) {
                                $classes_sql .= " WHERE id IN (" . implode(',', $teacherClassIds) . ")";
                            } else {
                                $classes_sql .= " WHERE 0";
                            }
                        }
                        $classes = $conn->query($classes_sql);
                        while($c = $classes->fetch_assoc()):
                        ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group"><label>Section</label><input type="text" id="section" name="section"></div>
                <div class="form-group"><label>Father's Name</label><input type="text" id="father_name" name="father_name"></div>
                <div class="form-group"><label>Mother's Name</label><input type="text" id="mother_name" name="mother_name"></div>
                <div class="form-group"><label>Parent Contact</label><input type="text" id="parent_contact" name="parent_contact"></div>
                <div class="form-group"><label>Address</label><input type="text" id="address" name="address"></div>
                <div class="form-group"><label>Guardian Name</label><input type="text" id="guardian_name" name="guardian_name"></div>
                <div class="form-group"><label>Guardian Relation</label><input type="text" id="guardian_relation" name="guardian_relation"></div>
            </div>
            <div style="margin-top:1.5rem; text-align:right;">
                <button type="button" id="cancelModalBtn">Cancel</button>
                <button type="submit">💾 Save</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('studentModal');
const modalTitle = document.getElementById('modalTitle');
const studentForm = document.getElementById('studentForm');
const studentIdInput = document.getElementById('studentId');

document.getElementById('openAddModalBtn')?.addEventListener('click', () => {
    modalTitle.innerText = 'Add Student';
    studentIdInput.value = '';
    studentForm.reset();
    modal.style.display = 'flex';
});

function closeModal() { modal.style.display = 'none'; }
document.getElementById('closeModalBtn').addEventListener('click', closeModal);
document.getElementById('cancelModalBtn').addEventListener('click', closeModal);

studentForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const studentId = studentIdInput.value;
    const action = studentId ? 'edit' : 'add';
    const formData = new FormData(studentForm);
    formData.append('action', action);
    if (action === 'edit') formData.append('id', studentId);
    fetch('ajax_student.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') { alert(data.message); window.location.reload(); }
            else alert('Error: ' + data.message);
        })
        .catch(err => alert('Request failed'));
});

document.querySelectorAll('.edit-student-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const studentId = this.getAttribute('data-id');
        fetch(`ajax_get_student.php?id=${studentId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    modalTitle.innerText = 'Edit Student';
                    studentIdInput.value = data.student.id;
                    document.getElementById('name').value = data.student.name;
                    document.getElementById('class_id').value = data.student.class_id;
                    document.getElementById('section').value = data.student.section;
                    document.getElementById('father_name').value = data.student.father_name;
                    document.getElementById('mother_name').value = data.student.mother_name;
                    document.getElementById('parent_contact').value = data.student.parent_contact;
                    document.getElementById('address').value = data.student.address;
                    document.getElementById('guardian_name').value = data.student.guardian_name;
                    document.getElementById('guardian_relation').value = data.student.guardian_relation;
                    modal.style.display = 'flex';
                } else alert('Could not fetch student');
            });
    });
});
</script>

<?php
// Delete logic
if (isset($_GET['delete']) && (isAdmin() || isTeacher())) {
    $id = (int)$_GET['delete'];
    if (isTeacher()) {
        // Ensure student belongs to one of the teacher's assigned classes
        $check = $conn->query("SELECT class_id FROM students WHERE id=$id");
        $row = $check->fetch_assoc();
        if (!teacherHasClass($row['class_id'])) {
            echo "<div class='alert-success'>Access denied.</div>";
        } else {
            $conn->query("DELETE FROM students WHERE id=$id");
            echo "<script>window.location='students.php?deleted=1';</script>";
        }
    } else {
        $conn->query("DELETE FROM students WHERE id=$id");
        echo "<script>window.location='students.php?deleted=1';</script>";
    }
}
if (isset($_GET['deleted'])) echo "<div class='alert-success'>Student deleted.</div>";
?>

<?php include "includes/footer.php"; ?>
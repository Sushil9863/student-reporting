<?php include "includes/auth.php"; ?>
<?php if (!isAdmin()) { header("Location: index.php"); exit; } ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>👩‍🏫 Teacher Management</h2>

    <!-- Add Subject Form -->
    <div style="margin-bottom: 2rem;">
        <h3>➕ Add Subject</h3>
        <form method="POST" class="form-row" style="flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            <div class="form-group" style="flex:1;"><label>Subject Name</label><input type="text" name="subject_name" required></div>
            <div><button type="submit" name="add_subject">➕ Add Subject</button></div>
        </form>
        <div style="margin-top: 1rem;">
            <h4>Existing Subjects</h4>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>ID</th><th>Subject</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $subjectList = $conn->query("SELECT * FROM subjects ORDER BY name"); while ($s = $subjectList->fetch_assoc()): ?>
                        <tr>
                            <td><?= $s['id'] ?></td>
                            <td><?= htmlspecialchars($s['name']) ?></td>
                            <td><a href="?delete_subject=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Delete this subject?')">🗑️ Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Teacher Form -->
    <div style="margin-bottom: 2rem;">
        <h3>➕ Add New Teacher</h3>
        <form method="POST" class="form-row" style="flex-wrap: wrap;">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
            <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group" style="width:100%;">
                <label>Assign classes and subjects</label>
                <div style="display:flex; flex-wrap:wrap; gap:1rem; align-items:flex-end;">
                    <div style="min-width:180px; flex:1;">
                        <select id="addClassSelect">
                            <option value="">-- Select Class --</option>
                            <?php $classes = $conn->query("SELECT * FROM classes ORDER BY name"); while($c = $classes->fetch_assoc()): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div style="min-width:220px; flex:1;">
                        <select id="addSubjectSelect" multiple size="5" style="width:100%; min-height: 10rem;"></select>
                    </div>
                    <div style="flex:0 0 auto;">
                        <button type="button" id="addAssignmentBtn">➕ Add</button>
                    </div>
                </div>
                <small>Select a class, choose subjects, and click Add.</small>
                <div id="addAssignmentsList" style="margin-top:0.75rem;"></div>
                <div id="addAssignmentsInputs"></div>
            </div>
            <div><button type="submit" name="add_teacher">➕ Add Teacher</button></div>
        </form>
    </div>

    <!-- List Teachers -->
    <div>
        <h3>📋 Teacher List</h3>
        <div class="table-wrapper">
            <table>
                <thead><tr><th>ID</th><th>Full Name</th><th>Username</th><th>Assigned Class / Subjects</th><th>Action</th></tr></thead>
                <tbody>
                <?php
                $teachers = $conn->query("SELECT users.id, users.full_name, users.username, GROUP_CONCAT(DISTINCT CONCAT(classes.name, ': ', subjects.name) ORDER BY classes.name, subjects.name SEPARATOR '; ') AS assignment_names FROM users LEFT JOIN teacher_subjects ON users.id = teacher_subjects.teacher_id LEFT JOIN classes ON teacher_subjects.class_id = classes.id LEFT JOIN subjects ON teacher_subjects.subject_id = subjects.id WHERE role='teacher' GROUP BY users.id, users.full_name, users.username ORDER BY users.id DESC");
                while($t = $teachers->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['full_name']) ?></td>
                    <td><?= htmlspecialchars($t['username']) ?></td>
                    <td><?= htmlspecialchars($t['assignment_names'] ?: 'Not assigned') ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal(<?= $t['id'] ?>)">✏️ Edit</button>
                            <a href="?delete=<?= $t['id'] ?>" class="btn-delete" onclick="return confirm('Delete this teacher?')">🗑️ Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:white; padding:2rem; border-radius:0.5rem; width:90%; max-width:500px; max-height:90vh; overflow-y:auto;">
            <h3>✏️ Edit Teacher</h3>
            <form id="editForm" class="form-row" style="flex-wrap: wrap;">
                <input type="hidden" id="editTeacherId" name="teacher_id">
                
                <div class="form-group" style="width: 100%;">
                    <label>Full Name</label>
                    <input type="text" id="editFullName" name="full_name" required>
                </div>
                
                <div class="form-group" style="width: 100%;">
                    <label>Username</label>
                    <input type="text" id="editUsername" name="username" required>
                </div>
                
                <div class="form-group" style="width: 100%;">
                    <label>Password (Leave blank to keep current password)</label>
                    <input type="password" id="editPassword" name="password">
                </div>
                
                <div class="form-group" style="width: 100%;">
                    <label>Assign classes and subjects</label>
                    <div style="display:flex; flex-wrap:wrap; gap:1rem; align-items:flex-end;">
                        <div style="min-width:180px; flex:1;">
                            <select id="editClassSelect">
                                <option value="">-- Select Class --</option>
                                <?php $classes = $conn->query("SELECT * FROM classes ORDER BY name"); while($c = $classes->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div style="min-width:220px; flex:1;">
                            <select id="editSubjectSelect" multiple size="5" style="width:100%; min-height: 10rem;"></select>
                        </div>
                        <div style="flex:0 0 auto;">
                            <button type="button" id="editAssignmentBtn">➕ Add</button>
                        </div>
                    </div>
                    <small>Select a class, choose subjects, and click Add.</small>
                    <div id="editAssignmentsList" style="margin-top:0.75rem;"></div>
                    <div id="editAssignmentsInputs"></div>
                </div>
                
                <div style="width: 100%; margin-top: 1rem; display: flex; gap: 1rem;">
                    <button type="submit" style="flex: 1;">💾 Update Teacher</button>
                    <button type="button" onclick="closeEditModal()" style="flex: 1; background:#6c757d;">❌ Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
function parseTeacherAssignments($raw) {
    $assignments = [];
    if (!is_array($raw)) {
        return $assignments;
    }

    foreach ($raw as $class_id => $subject_ids) {
        $class_id = (int)$class_id;
        if ($class_id <= 0 || !is_array($subject_ids)) {
            continue;
        }

        $subject_ids = array_values(array_unique(array_filter(array_map('intval', $subject_ids))));
        if ($subject_ids) {
            $assignments[$class_id] = $subject_ids;
        }
    }

    return $assignments;
}

if (isset($_POST['add_subject'])) {
    $subject_name = trim($_POST['subject_name'] ?? '');
    if ($subject_name !== '') {
        $stmt = $conn->prepare("INSERT IGNORE INTO subjects (name) VALUES (?)");
        $stmt->bind_param("s", $subject_name);
        $stmt->execute();
        echo "<div class='alert-success'>Subject added!</div>";
    }
}

if (isset($_GET['delete_subject'])) {
    $subject_id = (int)$_GET['delete_subject'];
    if ($subject_id > 0) {
        $conn->query("DELETE FROM subjects WHERE id=$subject_id");
    }
    echo "<script>window.location='teachers.php';</script>";
}

if (isset($_POST['add_teacher'])) {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $assignments = parseTeacherAssignments($_POST['assignments'] ?? []);
    $default_class = array_key_first($assignments);

    if ($default_class !== null) {
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role, class_id) VALUES (?, ?, ?, 'teacher', ?)");
        $stmt->bind_param("sssi", $full_name, $username, $password, $default_class);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, 'teacher')");
        $stmt->bind_param("sss", $full_name, $username, $password);
    }
    $stmt->execute();
    $teacher_id = $stmt->insert_id;

    if ($teacher_id && $assignments) {
        $stmtClass = $conn->prepare("INSERT IGNORE INTO teacher_classes (teacher_id, class_id) VALUES (?, ?)");
        $stmtSubject = $conn->prepare("INSERT IGNORE INTO teacher_subjects (teacher_id, class_id, subject_id) VALUES (?, ?, ?)");
        foreach ($assignments as $class_id => $subject_ids) {
            $stmtClass->bind_param("ii", $teacher_id, $class_id);
            $stmtClass->execute();

            foreach ($subject_ids as $subject_id) {
                $stmtSubject->bind_param("iii", $teacher_id, $class_id, $subject_id);
                $stmtSubject->execute();
            }
        }
        $stmtClass->close();
        $stmtSubject->close();
    }

    echo "<div class='alert-success'>Teacher added!</div>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM teacher_classes WHERE teacher_id=$id");
    $conn->query("DELETE FROM users WHERE id=$id AND role='teacher'");
    echo "<script>window.location='teachers.php';</script>";
}
?>

<script>
const teacherAssignmentData = { add: {}, edit: {} };

function initAssignmentControls(prefix) {
    const classSelect = document.getElementById(prefix + 'ClassSelect');
    const subjectSelect = document.getElementById(prefix + 'SubjectSelect');
    const addBtn = document.getElementById(prefix + 'AssignmentBtn');

    if (!classSelect || !subjectSelect) {
        return;
    }

    classSelect.addEventListener('change', () => loadAssignmentSubjects(prefix));
    if (addBtn) {
        addBtn.addEventListener('click', () => addAssignment(prefix));
    }
    renderAssignments(prefix);
}

function loadAssignmentSubjects(prefix) {
    const classSelect = document.getElementById(prefix + 'ClassSelect');
    const subjectSelect = document.getElementById(prefix + 'SubjectSelect');
    if (!classSelect || !subjectSelect) {
        return;
    }

    const classId = classSelect.value;
    if (!classId) {
        subjectSelect.innerHTML = '<option value="">Select class first</option>';
        subjectSelect.disabled = true;
        return;
    }

    subjectSelect.disabled = true;
    subjectSelect.innerHTML = '<option value="">Loading...</option>';

    fetch(`get_subjects.php?class_id=${classId}`)
        .then(response => response.json())
        .then(subjects => {
            subjectSelect.disabled = false;
            if (!subjects.length) {
                subjectSelect.innerHTML = '<option value="">No subjects assigned</option>';
                return;
            }
            let options = '<option value="">-- Select Subject --</option>';
            subjects.forEach(subject => {
                options += `<option value="${subject.id}">${escapeHtml(subject.name)}</option>`;
            });
            subjectSelect.innerHTML = options;
        })
        .catch(() => {
            subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
            subjectSelect.disabled = true;
        });
}

function addAssignment(prefix) {
    const classSelect = document.getElementById(prefix + 'ClassSelect');
    const subjectSelect = document.getElementById(prefix + 'SubjectSelect');
    if (!classSelect || !subjectSelect) {
        return;
    }

    const classId = classSelect.value;
    const className = classSelect.selectedOptions[0]?.text || '';
    if (!classId) {
        alert('Select a class first');
        return;
    }

    const selectedSubjects = Array.from(subjectSelect.selectedOptions)
        .filter(option => option.value)
        .map(option => ({ id: parseInt(option.value, 10), name: option.text }));

    if (!selectedSubjects.length) {
        alert('Select one or more subjects');
        return;
    }

    if (!teacherAssignmentData[prefix][classId]) {
        teacherAssignmentData[prefix][classId] = { name: className, subjects: [] };
    }

    selectedSubjects.forEach(subject => {
        if (!teacherAssignmentData[prefix][classId].subjects.some(item => item.id === subject.id)) {
            teacherAssignmentData[prefix][classId].subjects.push(subject);
        }
    });

    renderAssignments(prefix);
}

function renderAssignments(prefix) {
    const list = document.getElementById(prefix + 'AssignmentsList');
    const inputs = document.getElementById(prefix + 'AssignmentsInputs');
    if (!list || !inputs) {
        return;
    }

    list.innerHTML = '';
    inputs.innerHTML = '';

    const assignments = teacherAssignmentData[prefix] || {};
    const classIds = Object.keys(assignments);
    if (!classIds.length) {
        list.innerHTML = '<div class="small">No class/subject assignments yet.</div>';
        return;
    }

    classIds.forEach(classId => {
        const assignment = assignments[classId];
        const chipWrapper = document.createElement('div');
        chipWrapper.style.marginBottom = '0.75rem';
        let subjectChips = '';
        assignment.subjects.forEach(subject => {
            subjectChips += `<span style="display:inline-flex; align-items:center; gap:0.4rem; margin:0.15rem 0.35rem 0.15rem 0; padding:0.3rem 0.5rem; border-radius:999px; background:#eef2ff; color:#1e40af; font-size:0.85rem;">
                ${escapeHtml(subject.name)}
                <button type="button" onclick="removeAssignment('${prefix}', ${classId}, ${subject.id})" style="border:none; background:none; color:#1e40af; font-weight:700; cursor:pointer; line-height:1;">×</button>
            </span>`;
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `assignments[${classId}][]`;
            input.value = subject.id;
            inputs.appendChild(input);
        });
        chipWrapper.innerHTML = `<strong>${escapeHtml(assignment.name)}</strong>: ${subjectChips}`;
        list.appendChild(chipWrapper);
    });
}

function removeAssignment(prefix, classId, subjectId) {
    const assignment = teacherAssignmentData[prefix]?.[classId];
    if (!assignment) {
        return;
    }
    assignment.subjects = assignment.subjects.filter(subject => subject.id !== subjectId);
    if (!assignment.subjects.length) {
        delete teacherAssignmentData[prefix][classId];
    }
    renderAssignments(prefix);
}

function openEditModal(teacherId) {
    const modal = document.getElementById('editModal');

    fetch('ajax_teacher.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'action=get_teacher&teacher_id=' + teacherId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('editTeacherId').value = data.teacher.id;
            document.getElementById('editFullName').value = data.teacher.full_name;
            document.getElementById('editUsername').value = data.teacher.username;
            document.getElementById('editPassword').value = '';

            teacherAssignmentData.edit = {};
            Object.entries(data.assigned_subjects).forEach(([classId, subjects]) => {
                const option = document.querySelector(`#editClassSelect option[value='${classId}']`);
                const className = option ? option.text : `Class ${classId}`;
                teacherAssignmentData.edit[classId] = {
                    name: className,
                    subjects: subjects.map(subject => ({ id: subject.id, name: subject.name }))
                };
            });
            renderAssignments('edit');
            loadAssignmentSubjects('edit');

            modal.style.display = 'flex';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading teacher data');
    });
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.addEventListener('DOMContentLoaded', function() {
    initAssignmentControls('add');
    initAssignmentControls('edit');
});

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('action', 'update');

    fetch('ajax_teacher.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            closeEditModal();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
});

window.addEventListener('click', function(event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        closeEditModal();
    }
});

function escapeHtml(str) { return String(str).replace(/[&<>]/g, function(m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; }); }
</script>

<?php include "includes/footer.php"; ?>
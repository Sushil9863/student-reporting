<?php include "includes/auth.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>📝 Daily Student Records</h2>
    <div class="form-row">
        <div class="form-group">
            <label>Select Class</label>
            <?php if (isAdmin()): ?>
            <select id="class_id" onchange="loadStudents()">
                <option value="">-- Select Class --</option>
                <?php $classes = $conn->query("SELECT * FROM classes ORDER BY name"); while($c = $classes->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <?php else:
                $teacherClassIds = getTeacherClassIds();
                if (count($teacherClassIds) > 1):
                    $classIdsCsv = implode(',', $teacherClassIds);
                    $teacherClasses = $conn->query("SELECT * FROM classes WHERE id IN ($classIdsCsv) ORDER BY name");
            ?>
                <select id="class_id" onchange="loadStudents()">
                    <?php while ($c = $teacherClasses->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == getTeacherClassId() ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            <?php else:
                $class_id = getTeacherClassId();
                $cname = $conn->query("SELECT name FROM classes WHERE id=$class_id")->fetch_assoc()['name'] ?? 'Not assigned';
            ?>
                <input type="text" value="<?= htmlspecialchars($cname) ?>" readonly disabled style="background:#f1f5f9;">
                <input type="hidden" id="class_id" value="<?= getTeacherClassId() ?>">
            <?php endif; endif; ?>
        </div>
        <div class="form-group">
            <label>Select Subject</label>
            <select id="subject_id" disabled>
                <option value="">Select class first</option>
            </select>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" id="date" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
            <small>(Only today or past dates)</small>
        </div>
    </div>
    <div id="studentsPanel">👈 Select a class to load students</div>
</div>

<script>
function loadSubjects(classId) {
    const subjectSelect = document.getElementById('subject_id');
    if (!subjectSelect) {
        return;
    }

    if (!classId) {
        subjectSelect.innerHTML = '<option value="">Select class first</option>';
        subjectSelect.disabled = true;
        return;
    }

    subjectSelect.disabled = true;
    subjectSelect.innerHTML = '<option value="">Loading...</option>';

    fetch(`get_subjects.php?class_id=${classId}`)
        .then(res => res.json())
        .then(subjects => {
            subjectSelect.disabled = false;
            if (!subjects.length) {
                subjectSelect.innerHTML = '<option value="">No subjects assigned</option>';
                return;
            }
            let options = '<option value="">-- Select Subject --</option>';
            subjects.forEach(s => {
                options += `<option value="${s.id}">${escapeHtml(s.name)}</option>`;
            });
            subjectSelect.innerHTML = options;
        })
        .catch(() => {
            subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
            subjectSelect.disabled = true;
        });
}

function loadStudents() {
    let classId = document.getElementById('class_id') ? document.getElementById('class_id').value : '';
    loadSubjects(classId);
    if (!classId) { document.getElementById('studentsPanel').innerHTML = '<div style="text-align:center;">👈 Select a class</div>'; return; }
    document.getElementById('studentsPanel').innerHTML = '<div style="text-align:center;"><div class="loader"></div> Loading...</div>';
    fetch(`get_students.php?class_id=${classId}`)
        .then(res => res.json())
        .then(data => {
            let html = `<form id="recordForm"><div class="table-wrapper"><table><thead><tr><th>Name</th><th>HW</th><th>CW</th><th>Behavior</th><th>Discipline</th><th>Uniform</th><th>Handwriting</th><th>Remarks</th></tr></thead><tbody>`;
            data.forEach(s => {
                html += `<tr><td>${escapeHtml(s.name)}<input type="hidden" name="student_id[]" value="${s.id}"></td>
                        <td><input type="checkbox" name="hw[]" class="hwcheck" checked></td>
                        <td><input type="checkbox" name="cw[]" checked></td>
                        <td><select name="behavior[]"><option value="good">Good</option><option value="average">Average</option><option value="poor">Poor</option></select></td>
                        <td><select name="discipline[]"><option value="good">Good</option><option value="warning">Warning</option><option value="bad">Bad</option></select></td>
                        <td><select name="uniform[]"><option value="proper">Proper</option><option value="improper">Improper</option></select></td>
                        <td><select name="handwriting[]"><option value="improving">Improving</option><option value="same">Same</option><option value="poor">Poor</option></select></td>
                        <td><input type="text" name="remarks[]" placeholder="Optional"></td></tr>`;
            });
            html += `</tbody></table></div><button type="button" onclick="saveRecords()">💾 Save Records</button></form>`;
            document.getElementById('studentsPanel').innerHTML = html;
        })
        .catch(() => { document.getElementById('studentsPanel').innerHTML = '<div style="color:red;">Error</div>'; });
}

function saveRecords() {
    let form = document.getElementById('recordForm');
    if (!form) return;
    let subjectId = document.getElementById('subject_id') ? document.getElementById('subject_id').value : '';
    if (!subjectId) { alert('Select a subject before saving'); return; }
    let formData = new FormData(form);
    let studentIds = formData.getAll("student_id[]");
    let hwChecks = document.querySelectorAll('.hwcheck');
    let cwChecks = document.querySelectorAll('input[name="cw[]"]');
    let behavior = formData.getAll("behavior[]");
    let discipline = formData.getAll("discipline[]");
    let uniform = formData.getAll("uniform[]");
    let handwriting = formData.getAll("handwriting[]");
    let remarks = formData.getAll("remarks[]");
    let date = document.getElementById('date').value;
    if (!date) { alert("Select date"); return; }
    if (date > new Date().toISOString().split('T')[0]) { alert("Cannot save future date"); return; }
    let data = [];
    for (let i = 0; i < studentIds.length; i++) {
        data.push({
            student_id: studentIds[i], date: date, subject_id: subjectId,
            homework: hwChecks[i]?.checked ? 1 : 0,
            classwork: cwChecks[i]?.checked ? 1 : 0,
            behavior: behavior[i], discipline: discipline[i],
            uniform: uniform[i], handwriting: handwriting[i],
            remarks: remarks[i] || ''
        });
    }
    fetch("save_records.php", { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(data) })
        .then(() => alert("Saved!"))
        .catch(() => alert("Error"));
}

function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){ if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }

<?php if (!isAdmin()): ?>
window.addEventListener('DOMContentLoaded', loadStudents);
<?php endif; ?>
</script>

<?php include "includes/footer.php"; ?>
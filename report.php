<?php include "includes/auth.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>📊 Student Report</h2>
    <div class="form-row">
        <?php if (isAdmin()): ?>
        <div class="form-group">
            <label>Select Student</label>
            <select id="studentFilter" required>
                <option value="">-- Select Student --</option>
                <?php $students = $conn->query("SELECT students.id, students.name, classes.name AS class_name FROM students JOIN classes ON students.class_id = classes.id ORDER BY students.name"); while($s = $students->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name'] . ' (' . $s['class_name'] . ')') ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <?php else: ?>
        <div class="form-group">
            <label>Class</label>
            <?php
                $teacherClassIds = getTeacherClassIds();
                if (count($teacherClassIds) > 1):
                    $classIdsCsv = implode(',', $teacherClassIds);
                    $teacherClasses = $conn->query("SELECT * FROM classes WHERE id IN ($classIdsCsv) ORDER BY name");
            ?>
                <select id="classFilter" required>
                    <option value="">-- Select Class --</option>
                    <?php while ($c = $teacherClasses->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == getTeacherClassId() ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            <?php else:
                $class_id = getTeacherClassId();
                $cname = $conn->query("SELECT name FROM classes WHERE id=$class_id")->fetch_assoc()['name'] ?? 'Not assigned';
            ?>
                <input type="text" value="<?= htmlspecialchars($cname) ?>" readonly disabled>
                <input type="hidden" id="classFilter" value="<?= getTeacherClassId() ?>">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Select Subject</label>
            <select id="subjectFilter" required disabled><option>First pick class</option></select>
        </div>
        <div class="form-group">
            <label>Student</label>
            <select id="studentFilter" required disabled><option>First pick class</option></select>
        </div>
        <?php endif; ?>
        <div class="form-group"><label>Start date</label><input type="date" id="startDate" value="<?= date('Y-m-d', strtotime('-30 days')) ?>"></div>
        <div class="form-group"><label>End date</label><input type="date" id="endDate" value="<?= date('Y-m-d') ?>"></div>
        <div><button id="viewReportBtn" style="margin-top:1.3rem;">🔍 View Report</button></div>
    </div>
</div>
<div id="reportResult" class="card" style="display:none;"></div>

<script>
const classSelect = document.getElementById('classFilter');
const studentSelect = document.getElementById('studentFilter');
const subjectSelect = document.getElementById('subjectFilter');
const isAdminMode = <?= isAdmin() ? 'true' : 'false' ?>;

function loadSubjects(selectedSubjectId = null) {
    if (!subjectSelect) {
        return;
    }
    const classId = classSelect ? classSelect.value : '';
    if (!classId) {
        subjectSelect.disabled = true;
        subjectSelect.innerHTML = '<option value="">Select class first</option>';
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
                options += `<option value="${s.id}"${selectedSubjectId && selectedSubjectId == s.id ? ' selected' : ''}>${escapeHtml(s.name)}</option>`;
            });
            subjectSelect.innerHTML = options;
        })
        .catch(() => {
            subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
            subjectSelect.disabled = true;
        });
}

function loadStudents() {
    let classId = classSelect ? classSelect.value : '';
    loadSubjects();
    if (!classId) {
        studentSelect.disabled = true;
        studentSelect.innerHTML = '<option>Select class first</option>';
        return;
    }
    fetch(`get_students.php?class_id=${classId}`)
        .then(res => res.json())
        .then(students => {
            studentSelect.disabled = false;
            let options = '<option value="">Select student</option>';
            students.forEach(s => { options += `<option value="${s.id}">${escapeHtml(s.name)}</option>`; });
            studentSelect.innerHTML = options;
        });
}

<?php if (!isAdmin()): ?>
window.addEventListener('DOMContentLoaded', () => {
    loadStudents();
    if (classSelect) {
        classSelect.addEventListener('change', () => {
            loadStudents();
        });
    }
});
<?php endif; ?>

document.getElementById('viewReportBtn').addEventListener('click', function() {
    let studentId = studentSelect ? studentSelect.value : '';
    let subjectId = subjectSelect ? subjectSelect.value : '';
    let start = document.getElementById('startDate').value;
    let end = document.getElementById('endDate').value;
    if (!studentId || !start || !end) { alert("Please select student and dates"); return; }
    if (!isAdminMode && !subjectId) { alert("Please select class, subject, and student before viewing"); return; }
    let url = `report.php?student_id=${studentId}&start=${start}&end=${end}&fetch=1`;
    if (!isAdminMode && subjectId) {
        url += `&subject_id=${subjectId}`;
    }
    window.location.href = url;
});

<?php if (isset($_GET['student_id'])): ?>
(function() {
    const params = new URLSearchParams(window.location.search);
    const classId = params.get('class_id');
    const studentId = params.get('student_id');
    const subjectId = params.get('subject_id');
    const start = params.get('start');
    const end = params.get('end');
    if (!isAdminMode) {
        if (classId && classSelect) {
            classSelect.value = classId;
        }
        loadStudents();
        loadSubjects(subjectId);
    }
    if (studentId) {
        const chosenInterval = setInterval(() => {
            if (studentSelect.options.length > 1) {
                studentSelect.value = studentId;
                clearInterval(chosenInterval);
            }
        }, 100);
    }
    fetch(`ajax_report.php?student_id=${studentId}&subject_id=${subjectId}&start=${start}&end=${end}`)
        .then(res => res.json())
        .then(data => renderReport(data))
        .catch(() => { document.getElementById('reportResult').innerHTML = '<div style="color:red;">Error</div>'; document.getElementById('reportResult').style.display = 'block'; });
})();
<?php endif; ?>

function renderReport(data) {
    let html = `<h3>📅 Report for ${escapeHtml(data.student_name)} (${escapeHtml(data.class_name)})</h3><p>📘 Subject: ${escapeHtml(data.subject_name)}</p><p>📆 ${data.start} → ${data.end}</p>`;
    if (data.records.length === 0) html += '<p>No records found.</p>';
    else {
        html += `<div class="table-wrapper"><table><thead><tr><th>Date</th><th>Subject</th><th>HW</th><th>CW</th><th>Behavior</th><th>Discipline</th><th>Uniform</th><th>Remarks</th></tr></thead><tbody>`;
        data.records.forEach(r => {
            html += `<tr><td>${r.date}</td><td>${escapeHtml(r.subject_name || 'N/A')}</td><td>${r.homework_done == 1 ? '✔️' : '❌'}</td><td>${r.classwork_done == 1 ? '✔️' : '❌'}</td><td>${r.behavior}</td><td>${r.discipline}</td><td>${r.uniform}</td><td>${escapeHtml(r.remarks || '')}</td></tr>`;
        });
        html += `</tbody></table></div>`;
        let hwPercent = data.summary.total ? Math.round((data.summary.homework_done / data.summary.total)*100) : 0;
        let goodPercent = data.summary.total ? Math.round((data.summary.good_behaviors / data.summary.total)*100) : 0;
        html += `<div class="card"><h4>Summary</h4><p>Homework: ${hwPercent}%</p><div class="progress-wrapper"><div class="progress-fill" style="width:${hwPercent}%"></div></div><p>Good behavior: ${goodPercent}%</p><div class="progress-wrapper"><div class="progress-fill" style="width:${goodPercent}%"></div></div><p>Discipline issues: ${data.summary.discipline_bad}</p></div>`;
    }
    document.getElementById('reportResult').innerHTML = html;
    document.getElementById('reportResult').style.display = 'block';
}
function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){ if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }
</script>

<?php include "includes/footer.php"; ?>
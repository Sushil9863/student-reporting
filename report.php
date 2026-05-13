<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>📊 Student Report</h2>
    <div class="form-row">
        <div class="form-group">
            <label>Class</label>
            <select id="classFilter" required>
                <option value="">-- Select Class --</option>
                <?php $classes = $conn->query("SELECT * FROM classes"); while($c = $classes->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Student</label>
            <select id="studentFilter" required disabled>
                <option value="">First pick a class</option>
            </select>
        </div>
        <div class="form-group">
            <label>Start date</label>
            <input type="date" id="startDate" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
        </div>
        <div class="form-group">
            <label>End date</label>
            <input type="date" id="endDate" value="<?= date('Y-m-d') ?>">
        </div>
        <div><button id="viewReportBtn" style="margin-top:1.3rem;">🔍 View Report</button></div>
    </div>
</div>

<div id="reportResult" class="card" style="display:none;"></div>

<script>
const classSelect = document.getElementById('classFilter');
const studentSelect = document.getElementById('studentFilter');
const viewBtn = document.getElementById('viewReportBtn');

classSelect.addEventListener('change', function() {
    let classId = this.value;
    if (!classId) {
        studentSelect.disabled = true;
        studentSelect.innerHTML = '<option value="">First pick a class</option>';
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
});

viewBtn.addEventListener('click', function() {
    let studentId = studentSelect.value;
    let start = document.getElementById('startDate').value;
    let end = document.getElementById('endDate').value;
    if (!studentId || !start || !end) { alert("Please select student and date range"); return; }
    window.location.href = `report.php?student_id=${studentId}&start=${start}&end=${end}&fetch=1`;
});

// Load report if parameters exist
<?php if(isset($_GET['student_id'])): ?>
    (function() {
        const params = new URLSearchParams(window.location.search);
        const studentId = params.get('student_id');
        const start = params.get('start');
        const end = params.get('end');
        fetch(`ajax_report.php?student_id=${studentId}&start=${start}&end=${end}`)
            .then(res => res.json())
            .then(data => renderReport(data, studentId, start, end))
            .catch(() => { document.getElementById('reportResult').innerHTML = '<div style="color:red;">Error loading report</div>'; document.getElementById('reportResult').style.display = 'block'; });
    })();
<?php endif; ?>

function renderReport(data, studentId, start, end) {
    let html = `<h3>📅 Report for ${escapeHtml(data.student_name)} (${data.class_name})</h3>
                <p>📆 ${start} → ${end}</p>`;
    if (data.records.length === 0) { html += '<p>No records found.</p>'; }
    else {
        html += `<div class="table-wrapper"><table><thead><tr><th>Date</th><th>HW</th><th>CW</th><th>Behavior</th><th>Discipline</th><th>Uniform</th></tr></thead><tbody>`;
        data.records.forEach(r => {
            html += `<tr><td>${r.date}</td><td>${r.homework_done ? '✔️' : '❌'}</td><td>${r.classwork_done ? '✔️' : '❌'}</td><td>${r.behavior}</td><td>${r.discipline}</td><td>${r.uniform}</td></tr>`;
        });
        html += `</tbody></table></div>`;
        let hwPercent = data.summary.total ? Math.round((data.summary.homework_done / data.summary.total)*100) : 0;
        let goodPercent = data.summary.total ? Math.round((data.summary.good_behaviors / data.summary.total)*100) : 0;
        html += `<div class="card" style="margin-top:1rem;"><h4>📌 Summary</h4>
                 <p>Homework completion</p><div class="progress-wrapper"><div class="progress-fill" style="width:${hwPercent}%"></div></div><span>${hwPercent}%</span>
                 <p>Good behavior days</p><div class="progress-wrapper"><div class="progress-fill" style="width:${goodPercent}%"></div></div><span>${goodPercent}%</span>
                 <p>Discipline issues (bad): ${data.summary.discipline_bad}</p></div>`;
    }
    document.getElementById('reportResult').innerHTML = html;
    document.getElementById('reportResult').style.display = 'block';
}
function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }
</script>

<?php include "includes/footer.php"; ?>
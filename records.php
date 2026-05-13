<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h2>📝 Daily Student Records</h2>
    <div class="form-row">
        <div class="form-group">
            <label>Select Class</label>
            <select id="class_id" onchange="loadStudents()">
                <option value="">-- Select Class --</option>
                <?php
                $classes = $conn->query("SELECT * FROM classes");
                while($c = $classes->fetch_assoc()):
                ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date</label>
            <!-- max attribute set to today's date to prevent future selection -->
            <input type="date" id="date" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
            <small style="color: #475569;">(Only today or past dates allowed)</small>
        </div>
    </div>

    <div id="studentsPanel">
        <div style="text-align:center; padding:2rem;">👈 Select a class to load students</div>
    </div>
</div>

<script>
function loadStudents() {
    let classId = document.getElementById('class_id').value;
    if (!classId) {
        document.getElementById('studentsPanel').innerHTML = '<div style="text-align:center; padding:2rem;">👈 Select a class</div>';
        return;
    }
    document.getElementById('studentsPanel').innerHTML = '<div style="text-align:center; padding:2rem;"><div class="loader"></div> Loading students...</div>';
    fetch(`get_students.php?class_id=${classId}`)
        .then(res => res.json())
        .then(data => {
            let html = `
            <form id="recordForm">
                <div class="table-wrapper">
                <table>
                    <thead><tr>
                        <th>Student Name</th><th>Homework ✔</th><th>Classwork ✔</th><th>Behavior</th>
                        <th>Discipline</th><th>Uniform</th><th>Handwriting</th><th>Remarks</th>
                    </tr></thead>
                    <tbody>`;
            data.forEach(s => {
                html += `<tr>
                    <td>${escapeHtml(s.name)}<input type="hidden" name="student_id[]" value="${s.id}"></td>
                    <td><input type="checkbox" name="hw[]" class="hwcheck"></td>
                    <td><input type="checkbox" name="cw[]"></td>
                    <td><select name="behavior[]"><option value="good">Good</option><option value="average">Average</option><option value="poor">Poor</option></select></td>
                    <td><select name="discipline[]"><option value="good">Good</option><option value="warning">Warning</option><option value="bad">Bad</option></select></td>
                    <td><select name="uniform[]"><option value="proper">Proper</option><option value="improper">Improper</option></select></td>
                    <td><select name="handwriting[]"><option value="improving">Improving</option><option value="same">Same</option><option value="poor">Poor</option></select></td>
                    <td><input type="text" name="remarks[]" placeholder="Optional"></td>
                </tr>`;
            });
            html += `</tbody></table></div>
                <button type="button" onclick="saveRecords()" style="margin-top:1rem;">💾 Save All Records</button>
            </form>`;
            document.getElementById('studentsPanel').innerHTML = html;
        })
        .catch(() => { document.getElementById('studentsPanel').innerHTML = '<div style="color:red;">Error loading students</div>'; });
}

function saveRecords() {
    let form = document.getElementById('recordForm');
    if (!form) return;
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
    if (!date) { alert("Please select a date"); return; }
    
    // Extra safety: check if date is in the future
    let today = new Date().toISOString().split('T')[0];
    if (date > today) {
        alert("Cannot save records for a future date. Please select today or a past date.");
        return;
    }
    
    let data = [];
    for (let i = 0; i < studentIds.length; i++) {
        data.push({
            student_id: studentIds[i],
            date: date,
            homework: hwChecks[i]?.checked ? 1 : 0,
            classwork: cwChecks[i]?.checked ? 1 : 0,
            behavior: behavior[i],
            discipline: discipline[i],
            uniform: uniform[i],
            handwriting: handwriting[i],
            remarks: remarks[i] || ''
        });
    }
    fetch("save_records.php", { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(data) })
        .then(res => res.json())
        .then(() => alert("✅ Records saved successfully!"))
        .catch(() => alert("❌ Error saving records"));
}

function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }
</script>

<?php include "includes/footer.php"; ?>
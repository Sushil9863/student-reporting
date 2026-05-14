<?php include "includes/auth.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="card">
    <h1>📘 Student Tracker Dashboard</h1>

    <?php if (isAdmin()): ?>
        <!-- Admin: class selector (all classes) -->
        <div style="margin-bottom: 2rem;">
            <div class="form-group" style="max-width: 300px;">
                <label for="classSelect">🎓 Select Class</label>
                <select id="classSelect">
                    <option value="">-- Choose a class --</option>
                    <?php
                    $classes = $conn->query("SELECT * FROM classes ORDER BY name");
                    while ($c = $classes->fetch_assoc()):
                    ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    <?php else: ?>
        <!-- Teacher: choose among assigned classes -->
        <div style="margin-bottom: 2rem;">
            <div class="form-group" style="max-width: 300px;">
                <label>Your Class</label>
                <?php
                $teacherClassIds = getTeacherClassIds();
                if (count($teacherClassIds) > 1):
                    $classIdsCsv = implode(',', $teacherClassIds);
                    $teacherClasses = $conn->query("SELECT * FROM classes WHERE id IN ($classIdsCsv) ORDER BY name");
                ?>
                    <select id="classSelect">
                        <?php while ($c = $teacherClasses->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>" <?= $c['id'] == getTeacherClassId() ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                <?php else: ?>
                    <?php
                        $class_id = getTeacherClassId();
                        $cname = $conn->query("SELECT name FROM classes WHERE id=$class_id")->fetch_assoc()['name'] ?? 'Not assigned';
                    ?>
                    <input type="text" value="<?= htmlspecialchars($cname) ?>" readonly disabled style="background:#f1f5f9;">
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div id="studentsContainer" style="min-height: 200px;">
        <div style="text-align: center; padding: 2rem; color: #64748b;">
            👈 Select a class to see students
        </div>
    </div>

    <div class="card" style="margin-top: 1rem;">
        <h3>⚡ Quick Actions</h3>
        <button class="btn-secondary" onclick="location.href='records.php'">➕ Add Today’s Record</button>
    </div>
</div>

<script>
function getLastMonthRange() {
    const today = new Date();
    const lastMonth = new Date();
    lastMonth.setDate(today.getDate() - 30);
    const format = d => d.toISOString().split('T')[0];
    return { start: format(lastMonth), end: format(today) };
}

<?php if (isAdmin()): ?>
document.getElementById('classSelect').addEventListener('change', function() {
    const classId = this.value;
    loadStudents(classId);
});
<?php else: ?>
window.addEventListener('DOMContentLoaded', () => {
    const classSelect = document.getElementById('classSelect');
    const teacherClassId = <?= json_encode(getTeacherClassId()) ?>;
    if (teacherClassId) loadStudents(teacherClassId);
    if (classSelect) {
        classSelect.addEventListener('change', function() {
            loadStudents(this.value);
        });
    }
});
<?php endif; ?>

function loadStudents(classId) {
    const container = document.getElementById('studentsContainer');
    if (!classId) {
        container.innerHTML = '<div style="text-align: center; padding: 2rem;">👈 Select a class to see students</div>';
        return;
    }
    container.innerHTML = '<div style="text-align: center;"><div class="loader"></div> Loading students...</div>';
    fetch(`get_students.php?class_id=${classId}`)
        .then(res => res.json())
        .then(students => {
            if (!students.length) {
                container.innerHTML = '<div style="text-align: center; padding: 2rem;">📭 No students in this class</div>';
                return;
            }
            let html = `<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">`;
            students.forEach(s => {
                const parentInfo = [];
                if (s.father_name) parentInfo.push(`👨 ${escapeHtml(s.father_name)}`);
                if (s.mother_name) parentInfo.push(`👩 ${escapeHtml(s.mother_name)}`);
                const parentText = parentInfo.join(' & ') || 'No parents listed';
                const contact = s.parent_contact ? `📞 ${escapeHtml(s.parent_contact)}` : '';
                const guardian = (s.guardian_name && s.guardian_relation) ? `👤 Guardian: ${escapeHtml(s.guardian_name)} (${escapeHtml(s.guardian_relation)})` : '';
                html += `
                    <div class="student-card" data-student-id="${s.id}" style="background:white; border-radius:1.25rem; padding:1.25rem; box-shadow:0 4px 10px rgba(0,0,0,0.03); cursor:pointer; border:1px solid #eef2ff; transition:0.2s;">
                        <div style="font-size:2rem;">👨‍🎓</div>
                        <div style="font-weight:700; font-size:1.2rem;">${escapeHtml(s.name)}</div>
                        <div style="color:#475569; font-size:0.85rem;">${s.section ? 'Section ' + escapeHtml(s.section) : ''}</div>
                        <div style="margin-top:0.75rem; font-size:0.8rem; border-top:1px solid #eef2ff; padding-top:0.6rem;">
                            <div>${parentText}</div>
                            ${contact ? `<div>${contact}</div>` : ''}
                            ${guardian ? `<div style="font-size:0.75rem; color:#2563eb;">${guardian}</div>` : ''}
                            <div style="margin-top:0.5rem;"><span style="background:#eef2ff; color:#1e40af; padding:0.2rem 0.6rem; border-radius:2rem; font-size:0.7rem;">📅 Last 30 days report</span></div>
                        </div>
                    </div>
                `;
            });
            html += `</div>`;
            container.innerHTML = html;
            document.querySelectorAll('.student-card').forEach(card => {
                card.addEventListener('click', () => {
                    const studentId = card.dataset.studentId;
                    const { start, end } = getLastMonthRange();
                    window.location.href = `report.php?student_id=${studentId}&start=${start}&end=${end}`;
                });
            });
        })
        .catch(() => { container.innerHTML = '<div style="color:red;">Error loading students</div>'; });
}

function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function(m){ if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }
</script>
<style>.student-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1); background:#fefefe; }</style>

<?php include "includes/footer.php"; ?>
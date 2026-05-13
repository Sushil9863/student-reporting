<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

<div class="card">
    <h1>📘 Student Tracker Dashboard</h1>

    <!-- Class selector -->
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

    <!-- Students will appear here as cards -->
    <div id="studentsContainer" style="min-height: 200px;">
        <div style="text-align: center; padding: 2rem; color: #64748b;">
            👈 Select a class to see students
        </div>
    </div>

    <!-- Quick actions -->
    <div class="card" style="margin-top: 1rem;">
        <h3>⚡ Quick Actions</h3>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="btn-secondary" onclick="location.href='records.php'">➕ Add Today’s Record</button>
        </div>
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

document.getElementById('classSelect').addEventListener('change', function() {
    const classId = this.value;
    const container = document.getElementById('studentsContainer');

    if (!classId) {
        container.innerHTML = '<div style="text-align: center; padding: 2rem; color: #64748b;">👈 Select a class to see students</div>';
        return;
    }

    container.innerHTML = '<div style="text-align: center; padding: 2rem;"><div class="loader"></div> Loading students...</div>';

    fetch(`get_students.php?class_id=${classId}`)
        .then(res => res.json())
        .then(students => {
            if (!students.length) {
                container.innerHTML = '<div style="text-align: center; padding: 2rem; color: #64748b;">📭 No students found in this class</div>';
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
                    <div class="student-card" data-student-id="${s.id}" style="
                        background: white;
                        border-radius: 1.25rem;
                        padding: 1.25rem;
                        box-shadow: 0 4px 10px rgba(0,0,0,0.03), 0 1px 2px rgba(0,0,0,0.05);
                        transition: all 0.2s ease;
                        cursor: pointer;
                        border: 1px solid #eef2ff;
                    ">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">👨‍🎓</div>
                        <div style="font-weight: 700; font-size: 1.2rem;">${escapeHtml(s.name)}</div>
                        <div style="color: #475569; font-size: 0.85rem; margin-top: 0.25rem;">
                            ${s.section ? 'Section ' + escapeHtml(s.section) : ''}
                        </div>
                        <div style="margin-top: 0.75rem; font-size: 0.8rem; border-top: 1px solid #eef2ff; padding-top: 0.6rem;">
                            <div>${parentText}</div>
                            ${contact ? `<div>${contact}</div>` : ''}
                            ${guardian ? `<div style="font-size:0.75rem; color:#2563eb;">${guardian}</div>` : ''}
                            <div style="margin-top: 0.5rem;">
                                <span style="background: #eef2ff; color: #1e40af; padding: 0.2rem 0.6rem; border-radius: 2rem; font-size: 0.7rem; font-weight: 500;">
                                    📅 Last 30 days report
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += `</div>`;
            container.innerHTML = html;

            // Attach click event to each card
            document.querySelectorAll('.student-card').forEach(card => {
                card.addEventListener('click', () => {
                    const studentId = card.dataset.studentId;
                    const { start, end } = getLastMonthRange();
                    window.location.href = `report.php?student_id=${studentId}&start=${start}&end=${end}`;
                });
            });
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<div style="color: #dc2626; text-align: center;">⚠️ Failed to load students</div>';
        });
});

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>

<style>
.student-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
    border-color: #cbd5e1;
    background: #fefefe;
}
</style>

<?php include "includes/footer.php"; ?>
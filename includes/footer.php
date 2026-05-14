    <footer>
        <p>Student Tracker — Simple & effective daily monitoring</p>
        <p>Built with ❤️ by Sushil Lamichhane</p>

    </footer>
</div> <!-- close app-container -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (hamburger && sidebar && sidebarClose && sidebarOverlay) {
                hamburger.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                });

                sidebarClose.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                });

                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                });

                // Close sidebar when clicking outside (fallback)
                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
                        sidebar.classList.remove('open');
                    }
                });
            }
        });
    </script>
</body>
</html>
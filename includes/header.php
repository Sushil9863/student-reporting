<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Keep all your existing global styles exactly as before */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fc;
            color: #1e293b;
            line-height: 1.5;
        }

        .app-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
        }

        .navbar {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            padding: 0.75rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            background: #f8fafc;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #334155;
            margin: 3px 0;
            transition: 0.3s;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem 1rem;
            transition: left 0.3s ease;
            z-index: 1001;
            overflow-y: auto;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
            pointer-events: none;
        }

        .sidebar.open + .sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .sidebar .nav-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
            padding-top: 4rem;
        }

        .sidebar .nav-links a,
        .sidebar .nav-links span {
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #334155;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar .nav-links a:hover {
            background: #eef2ff;
            color: #1e40af;
        }

        .sidebar .nav-links a.active {
            background: #2563eb;
            color: white;
        }

        .sidebar-close {
            position: absolute;
            top: 1rem;
            right: -5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }

        .logo {
            font-weight: 700;
            font-size: 1.35rem;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-links a,
        .nav-links span {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 500;
            transition: 0.2s;
            color: #334155;
        }

        .nav-links a:hover {
            background: #eef2ff;
            color: #1e40af;
        }

        .nav-links a.active {
            background: #2563eb;
            color: white;
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 1rem;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            padding: 0.9rem 0.75rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            flex: 1;
            min-width: 220px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.9rem;
            background: #f8fafc;
            font: inherit;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 1rem;
            cursor: pointer;
            min-width: 140px;
        }

        button:hover {
            background: #1d4ed8;
            transition: 0.2s;
        }

        button:active {
            transform: scale(0.98);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
        }

        .btn-edit,
        .btn-delete,
        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.5rem 0.9rem;
            border: none;
            border-radius: 0.6rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            min-width: auto;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        .btn-delete:active,
        .btn-edit:active,
        .btn-view:active {
            transform: translateY(0);
        }

        .btn-view {
            background: #10b981;
            color: white;
        }

        .btn-view:hover {
            background: #059669;
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
            transform: translateY(-2px);
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 0.75rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 1024px) {
            .app-container {
                padding: 1rem 1.25rem;
            }

            .navbar {
                padding: 0.75rem 1rem;
            }

            .form-row {
                gap: 0.75rem;
            }

            .form-group {
                min-width: 180px;
            }
        }

        @media (max-width: 768px) {
            .app-container {
                padding: 1rem;
            }

            .navbar {
                padding: 0.75rem 1rem;
                gap: 0.5rem;
            }

            .hamburger {
                display: flex !important;
            }

            .nav-links {
                display: none;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }

            .nav-links a,
            .nav-links span {
                padding: 0.5rem 0.6rem;
                font-size: 0.9rem;
            }

            .card {
                padding: 1rem;
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr;
                align-items: stretch;
            }

            .form-group {
                min-width: auto;
            }

            button {
                width: 100%;
            }

            th,
            td {
                padding: 0.7rem 0.6rem;
                font-size: 0.95rem;
            }

            .table-wrapper {
                margin-top: 1rem;
            }

            .action-buttons {
                display: flex;
                gap: 0.4rem;
                flex-wrap: nowrap;
            }

            .btn-edit,
            .btn-delete,
            .btn-view {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
                min-width: auto;
                flex: 1;
            }
        }


        footer {
            text-align: center;
            margin-top: 3rem;
            color: #64748b;
            font-size: 0.8rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 2rem;
        }

        .loader {
            border: 2px solid #e2e8f0;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="app-container">
        <div class="navbar">
            <div class="logo">📘 Student Tracker</div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-links">
                <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Dashboard</a>
                <?php if (isAdmin()): ?>
                    <a href="students.php" <?= basename($_SERVER['PHP_SELF']) == 'students.php' ? 'class="active"' : '' ?>>Students</a>
                    <a href="classes.php" <?= basename($_SERVER['PHP_SELF']) == 'classes.php' ? 'class="active"' : '' ?>>Classes</a>
                    <a href="teachers.php" <?= basename($_SERVER['PHP_SELF']) == 'teachers.php' ? 'class="active"' : '' ?>>Teachers</a>
                <?php endif; ?>
                <a href="records.php" <?= basename($_SERVER['PHP_SELF']) == 'records.php' ? 'class="active"' : '' ?>>Daily
                    Records</a>
                <a href="report.php" <?= basename($_SERVER['PHP_SELF']) == 'report.php' ? 'class="active"' : '' ?>>Reports</a>
                <span style="color:#2563eb;">👋 <?= htmlspecialchars($_SESSION['full_name']) ?>
                    (<?= $_SESSION['role'] ?>)</span>
                <a href="logout.php">🚪 Logout</a>
            </div>

        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <div class="sidebar" id="sidebar">
            <button class="sidebar-close" id="sidebarClose">&times;</button>
            <div class="nav-links">
                <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Dashboard</a>
                <?php if (isAdmin()): ?>
                    <a href="students.php" <?= basename($_SERVER['PHP_SELF']) == 'students.php' ? 'class="active"' : '' ?>>Students</a>
                    <a href="classes.php" <?= basename($_SERVER['PHP_SELF']) == 'classes.php' ? 'class="active"' : '' ?>>Classes</a>
                    <a href="teachers.php" <?= basename($_SERVER['PHP_SELF']) == 'teachers.php' ? 'class="active"' : '' ?>>Teachers</a>
                <?php endif; ?>
                <a href="records.php" <?= basename($_SERVER['PHP_SELF']) == 'records.php' ? 'class="active"' : '' ?>>Daily
                    Records</a>
                <a href="report.php" <?= basename($_SERVER['PHP_SELF']) == 'report.php' ? 'class="active"' : '' ?>>Reports</a>
                <span style="color:#2563eb;">👋 <?= htmlspecialchars($_SESSION['full_name']) ?>
                    (<?= $_SESSION['role'] ?>)</span>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>

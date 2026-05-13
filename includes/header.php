<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Student Tracker</title>
    <!-- Google Fonts + simple reset -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
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

        /* global container */
        .app-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
        }

        /* navbar */
        .navbar {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            font-weight: 700;
            font-size: 1.35rem;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .nav-links a {
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

        /* cards & panels */
        .card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        /* form elements */
        input, select, button {
            font-family: inherit;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            transition: 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        button {
            background: #2563eb;
            color: white;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: 0.2s;
        }

        button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #1e293b;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* tables */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 1rem;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
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

        tr:hover td {
            background: #fafcff;
        }

        /* alert / badge */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }

        /* form inline */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            flex: 1;
        }

        .form-group label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #475569;
        }

        /* progress bar */
        .progress-wrapper {
            background: #e2e8f0;
            border-radius: 1rem;
            height: 0.7rem;
            width: 100%;
            overflow: hidden;
            margin: 0.5rem 0;
        }
        .progress-fill {
            background: #3b82f6;
            height: 100%;
            border-radius: 1rem;
            width: 0%;
        }

        /* loading spinner */
        .loader {
            border: 2px solid #e2e8f0;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        footer {
            text-align: center;
            margin-top: 3rem;
            color: #64748b;
            font-size: 0.8rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 2rem;
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="navbar">
        <div class="logo">📘 Student Tracker</div>
        <div class="nav-links">
            <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Dashboard</a>
            <a href="students.php" <?= basename($_SERVER['PHP_SELF']) == 'students.php' ? 'class="active"' : '' ?>>Students</a>
            <a href="classes.php" <?= basename($_SERVER['PHP_SELF']) == 'classes.php' ? 'class="active"' : '' ?>>Classes</a>
            <a href="records.php" <?= basename($_SERVER['PHP_SELF']) == 'records.php' ? 'class="active"' : '' ?>>Daily Records</a>
            <a href="report.php" <?= basename($_SERVER['PHP_SELF']) == 'report.php' ? 'class="active"' : '' ?>>Reports</a>
        </div>
    </div>
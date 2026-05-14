<?php session_start(); ?>
<?php include "includes/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Student Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 20px 35px rgba(0,0,0,0.2);
        }
        h2 { margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.3rem; font-weight: 500; }
        input {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 0.8rem;
            font-family: inherit;
        }
        button {
            width: 100%;
            padding: 0.7rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }
        .error { color: red; margin-top: 0.5rem; text-align: center; }
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-toggle {
            position: absolute;
            right: 0.8rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.3rem;
            color: #666;
            width: auto;
            min-width: auto;
        }
        .password-toggle:hover {
            color: #2563eb;
        }
        #passwordInput {
            padding-right: 2.5rem;
        }
        button:hover {
            background: #1d4ed8;
            transition: 0.2s;
        }
        @media (max-width: 500px) {
            body {
                height: auto;
                min-height: 100vh;
                padding: 1rem 0;
            }
            .login-card {
                padding: 2.5rem 1.5rem;
                width: 95%;
                margin: 1rem auto;
            }
            h2 {
                font-size: 1.8rem;
                margin-bottom: 2rem;
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            label {
                font-size: 1rem;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            input {
                padding: 0.9rem 0.8rem;
                font-size: 1rem;
                border-radius: 0.8rem;
            }
            button {
                padding: 0.9rem;
                font-size: 1rem;
                border-radius: 0.8rem;
            }
            .password-toggle {
                right: 0.8rem;
                font-size: 1.3rem;
            }
            #passwordInput {
                padding-right: 2.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>📘 Student Tracker</h2>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" id="passwordInput" name="password" required>
                    <button type="button" class="password-toggle" id="passwordToggle" onclick="togglePassword()">👁️</button>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];

                $classIds = [];
                if ($user['role'] === 'teacher') {
                    $stmt2 = $conn->prepare("SELECT class_id FROM teacher_classes WHERE teacher_id = ?");
                    if ($stmt2) {
                        $stmt2->bind_param("i", $user['id']);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        while ($row = $result2->fetch_assoc()) {
                            $classIds[] = (int)$row['class_id'];
                        }
                        $stmt2->close();
                    }
                    if (empty($classIds) && isset($user['class_id']) && $user['class_id']) {
                        $classIds[] = (int)$user['class_id'];
                    }
                }

                $_SESSION['class_ids'] = $classIds;
                $_SESSION['class_id'] = $classIds[0] ?? ($user['class_id'] ?? null);

                header("Location: index.php");
                exit;
            } else {
                echo "<div class='error'>Invalid username or password</div>";
            }
        }
        ?>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleBtn = document.getElementById('passwordToggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
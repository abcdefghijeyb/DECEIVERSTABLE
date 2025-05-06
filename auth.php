    <?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        header('Location: index2.php');
        exit();
    }

    require_once "database.php";

    $login_errors = [];
    $register_errors = [];
    $register_success = "";

    if (isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        if (empty($email) || empty($password)) {
            array_push($login_errors, "Email and Password are required.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($login_errors, "Invalid email format.");
        } else {
            $sql = "SELECT id, email, password FROM users WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        $_SESSION["user_id"] = $user["id"];
                        $_SESSION["user_email"] = $user["email"];
                        header("Location: index2.php");
                        exit();
                    } else {
                        array_push($login_errors, "Invalid email or password.");
                    }
                } else {
                    array_push($login_errors, "Invalid email or password.");
                }
                mysqli_stmt_close($stmt);
            } else {
                array_push($login_errors, "Login failed. Please try again later.");
            }
        }
    }

    if (isset($_POST["register"])) {
        $LastName = trim($_POST['LastName']);
        $FirstName = trim($_POST['FirstName']);
        $email = trim($_POST['Email']);
        $password = $_POST['Password'];
        $Repeat_Password = $_POST['repeat_password'];

        if (empty($LastName) || empty($FirstName) || empty($email) || empty($password) || empty($Repeat_Password)) {
            array_push($register_errors, "All fields are required.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($register_errors, "Invalid email format.");
        }
        if (strlen($password) < 8) {
            array_push($register_errors, "Password must be at least 8 characters long.");
        }
        if ($password !== $Repeat_Password) {
            array_push($register_errors, "Passwords do not match.");
        }

        if (empty($register_errors) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql_check = "SELECT id FROM users WHERE email = ?";
            $stmt_check = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_check, $sql_check)) {
                mysqli_stmt_bind_param($stmt_check, "s", $email);
                mysqli_stmt_execute($stmt_check);
                mysqli_stmt_store_result($stmt_check);
                if (mysqli_stmt_num_rows($stmt_check) > 0) {
                    array_push($register_errors, "Email address already registered.");
                }
                mysqli_stmt_close($stmt_check);
            } else {
                array_push($register_errors, "Error checking email. Please try again.");
            }
        }

        if (empty($register_errors)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO users (Last_Name, First_Name, email, password) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
                mysqli_stmt_bind_param($stmt_insert, "ssss", $LastName, $FirstName, $email, $passwordHash);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $register_success = "Registration successful! You can now log in.";
                    $_POST = array();
                } else {
                    array_push($register_errors, "Registration failed. Please try again later.");
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                array_push($register_errors, "Registration failed. Please try again later.");
            }
        }
    }

    $view = 'login';
    if (isset($_GET['view']) && $_GET['view'] === 'register') {
        $view = 'register';
    }
    if (!empty($register_errors) || !empty($register_success)) {
        $view = 'register';
    }
    if (!empty($login_errors)) {
        $view = 'login';
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo ($view === 'register') ? 'Register' : 'Login'; ?> - Cards of Chaos</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            :root {
                --primary-color: #6ee7b7;
                --dark-bg: #1e293b;
                --dark-card: #2c3e50;
                --light-text: #f8f9fa;
                --secondary-text: #d1d5db;
                --error-color: #ef4444;
                --success-color: #86efac;
                --form-control-bg: #374151;
                --border-color: #4a5568;
            }

            body {
                background-color: var(--dark-bg);
                color: var(--light-text);
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column; 
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .game-title {
                color: var(--primary-color);
                font-size: 3em; 
                font-weight: bold;
                margin-bottom: 40px; 
                letter-spacing: 1px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            .auth-card {
                background-color: var(--dark-card);
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                width: 400px;
                max-width: 90%;
            }

            h2 {
                color: var(--light-text);
                text-align: center;
                margin-bottom: 30px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .form-group {
                margin-bottom: 24px;
            }

            label {
                display: block;
                margin-bottom: 8px;
                color: var(--secondary-text);
                font-weight: 500;
            }

            .form-control {
                width: 100%;
                padding: 14px 16px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                background-color: var(--form-control-bg);
                color: var(--light-text);
                box-sizing: border-box;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .form-control:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 2px rgba(110, 231, 183, 0.2);
            }

            .btn-primary,
            .btn-success {
                background-color: var(--primary-color);
                color: var(--dark-bg);
                border: none;
                padding: 14px 24px;
                border-radius: 8px;
                cursor: pointer;
                width: 100%;
                font-weight: 600;
                font-size: 16px;
                transition: background-color 0.15s ease-in-out;
            }

            .btn-primary:hover,
            .btn-success:hover {
                background-color: #52d69e;
            }

            .alert {
                background-color: var(--error-color);
                color: var(--light-text);
                padding: 16px;
                border-radius: 8px;
                margin-bottom: 24px;
            }

            .alert-success {
                background-color: var(--success-color);
                color: var(--dark-bg);
            }

            .text-center {
                text-align: center;
                margin-top: 24px;
                color: var(--secondary-text);
                font-size: 14px;
            }

            .text-center a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 600;
            }

            .text-center a:hover {
                text-decoration: underline;
            }

            .row {
                display: flex;
                gap: 16px;
            }

            .col-md-6 {
                flex: 1;
            }
        </style>
    </head>

    <body>
        <h1 class="game-title">Cards of Chaos</h1>
        <div class="auth-card">

            <?php if ($view === 'login'): ?>
                <h2>Login</h2>

                <?php if (!empty($login_errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($login_errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="auth.php" method="post">
                    <div class="form-group">
                        <label for="loginEmail">Email address</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required
                            value="<?php echo isset($_POST['email']) && isset($_POST['login']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Not registered yet? <a href="auth.php?view=register">Register Here!</a></p>
                </div>

            <?php elseif ($view === 'register'): ?>
                <h2>Register</h2>

                <?php if (!empty($register_errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($register_errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (!empty($register_success)): ?>
                    <div class="alert alert-success" role="alert">
                        <p><?php echo htmlspecialchars($register_success); ?></p>
                    </div>
                <?php endif; ?>

                <form action="auth.php?view=register" method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="regFirstName">First Name</label>
                            <input type="text" class="form-control" id="regFirstName" name="FirstName" required
                                value="<?php echo isset($_POST['FirstName']) && isset($_POST['register']) ? htmlspecialchars($_POST['FirstName']) : ''; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="regLastName">Last Name</label>
                            <input type="text" class="form-control" id="regLastName" name="LastName" required
                                value="<?php echo isset($_POST['LastName']) && isset($_POST['register']) ? htmlspecialchars($_POST['LastName']) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regEmail">Email address</label>
                        <input type="email" class="form-control" id="regEmail" name="Email" required
                            value="<?php echo isset($_POST['Email']) && isset($_POST['register']) ? htmlspecialchars($_POST['Email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="regPassword">Password <small>(Min. 8 characters)</small></label>
                        <input type="password" class="form-control" id="regPassword" name="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="regRepeatPassword">Repeat Password</label>
                        <input type="password" class="form-control" id="regRepeatPassword" name="repeat_password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <p>Already Registered? <a href="auth.php?view=login">Login Here!</a></p>
                </div>

            <?php endif; ?>

        </div>
    </body>

    </html>
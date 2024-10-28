

<?php
include 'db_connect.php';  // Ensure this file connects to your database

session_start();  // Start a session to manage user login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $id;
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Email not registered.";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            background: url('bg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .login-box {
            width: 400px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2em;
            color: #000;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-box {
            margin: 20px 0;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
            font-size: 1em;
            color: #000;
        }

        .input-box input {
            width: 100%;
            height: 40px;
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            outline: none;
        }

        .remember-forgot {
            margin: 15px 0;
            font-size: 0.9em;
            color: #000;
            display: flex;
            justify-content: space-between;
        }

        button {
            width: 100%;
            height: 40px;
            background: #007bff; /* Button color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            color: #fff;
            font-weight: 500;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3; /* Darker shade on hover */
        }

        .register-link {
            font-size: 0.9em;
            color: #000;
            text-align: center;
            margin-top: 15px;
        }

        .register-link p a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section>
        <div class="login-box">
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <div class="input-box">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-box">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit">Login</button>
                <div class="register-link">
                    <p>Don't have an account? <a href="registration.php">Register</a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>

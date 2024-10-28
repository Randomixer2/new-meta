<?php
include 'db_connect.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $check_email = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email is already registered!";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error preparing insert statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "Registration successful! You can now <a href='login.php'>login</a>";
        } else {
            echo "Error executing statement: " . $stmt->error;  
        }

        $stmt->close();  
    }
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
            background: url('reg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .login-box {
            position: relative;
            width: 400px;
            height: auto;
            background: rgba(255, 255, 255, 0.8); /* Light background for contrast */
            border-radius: 20px;
            padding: 20px;
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
            margin-top: 20px;
        }

        button:hover {
            background: #0056b3; /* Darker shade on hover */
        }

        .register-link {
            font-size: .9em;
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
            <form action="registration.php" method="post">
                <h2>Register</h2>
                <div class="input-box">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-box">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-box">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Register</button>
                <div class="register-link">
                    <p>You have an account? <a href="login.php">Log in</a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>

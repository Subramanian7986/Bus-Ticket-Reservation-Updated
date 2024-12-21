<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bus Ticket Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('Images.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .register-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            font-size: 14px;
            color: #333;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        .success-message {
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="input-field">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'db_connection.php';

            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password != $confirm_password) {
                echo "<p class='error-message'>Passwords do not match. Please try again.</p>";
            } else {
                $query = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo "<p class='error-message'>Email already exists. Please use a different email.</p>";
                } else {
                    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
                    if (mysqli_query($conn, $query)) {
                        echo "<p class='success-message'>Registration successful. <a href='login.php'>Login now</a></p>";
                    } else {
                        echo "<p class='error-message'>Something went wrong. Please try again later.</p>";
                    }
                }
            }
        }
        ?>
    </div>

</body>
</html>

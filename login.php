<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bus Ticket Booking</title>
</head>
<body style="
    margin: 0;
    font-family: Arial, sans-serif;
    background: url('Images.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #333;">

    <div style="
        max-width: 400px;
        margin: 80px auto;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        
        <h2 style="text-align: center; margin-bottom: 20px; color: #007BFF;">Login</h2>
        
        <form action="login.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-weight: bold;">Email</label>
                <input type="email" name="email" id="email" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-weight: bold;">Password</label>
                <input type="password" name="password" id="password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-sizing: border-box;">
            </div>

            <button type="submit" name="login" style="width: 100%; background-color: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                Login
            </button>

            <p style="text-align: center; margin-top: 20px;">Don't have an account? <a href="register.php" style="color: #007BFF; text-decoration: none;">Register here</a></p>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'db_connection.php';

            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Login successful
                header("Location: bus_browsing.php");
            } else {
                echo "<p style='text-align: center; color: red;'>Invalid credentials. Please try again.</p>";
            }
        }
        ?>
    </div>
</body>
</html>

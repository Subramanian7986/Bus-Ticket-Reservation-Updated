<?php
session_start();

// Check if total_amount is set, if not redirect to the reservation page
if (!isset($_SESSION['total_amount'])) {
    echo "No booking found. Please make a reservation first.";
    exit();
}

// Check if bus_id is set in the session, if not redirect to the bus browsing page
if (!isset($_SESSION['bus_id'])) {
    header("Location: bus_browsing.php");
    exit();
}

$total_amount = $_SESSION['total_amount'];
$booking_id = $_SESSION['booking_id'];
$bus_id = $_SESSION['bus_id']; // This will now work

// Fetch bus details from the database
include 'db_connection.php';
$query = "SELECT * FROM buses WHERE id = '$bus_id'";
$result = mysqli_query($conn, $query);
$bus = mysqli_fetch_assoc($result);

// Fetch the passenger details from the database
$query_passengers = "SELECT * FROM passengers WHERE booking_id = '$booking_id'";
$passenger_result = mysqli_query($conn, $query_passengers);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
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
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        p ,h4{
            font-size: 16px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            color: #000; /* Set the text color to black for table rows */
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table td a {
            color: #FF4D4D;
            text-decoration: none;
            font-weight: bold;
        }
        table td a:hover {
            text-decoration: underline;
        }
        .payment-section {
            margin-top: 20px;
            text-align: center;
        }
        .payment-section input {
            padding: 10px;
            margin-top: 10px;
            width: 250px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .payment-section button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .payment-section button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Payment Page</h2>
    <p><strong>Booking ID:</strong> <?php echo $booking_id; ?></p>
    <p><strong>Total Amount:</strong> ₹<?php echo $total_amount; ?></p>

    <!-- Your Tickets -->
    <h4>Your Tickets:</h4>
    <table>
        <tr>
            <th>Ticket ID</th>
            <th>Seat No</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Time</th>
            <th>Cancel</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($passenger_result)) {
            $ticket_id = $row['id'];
            $seat_number = $row['seat_number'];
            $name = $row['name'];
            $age = $row['age'];
            $gender = $row['gender'];
            $source = $bus['source'];
            $destination = $bus['destination'];
            $date = $bus['departure_date'];
            $time = $bus['departure_time'];
            echo "<tr>
                    <td>$ticket_id</td>
                    <td>$seat_number</td>
                    <td>$name</td>
                    <td>$age</td>
                    <td>$gender</td>
                    <td>$source</td>
                    <td>$destination</td>
                    <td>$date</td>
                    <td>$time</td>
                    <td><a href='cancel_ticket.php?ticket_id=$ticket_id' onclick='return confirm(\"Are you sure you want to cancel this ticket?\")'>Cancel</a></td>
                </tr>";
        } ?>
    </table>
</div>

</body>
</html>

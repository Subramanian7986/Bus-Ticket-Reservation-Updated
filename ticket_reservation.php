<?php
include 'db_connection.php';
session_start(); // Start the session to store booking data

$bus_id = $_GET['bus_id'];

// Fetch bus details based on bus_id
$query = "SELECT * FROM buses WHERE id = '$bus_id'";
$result = mysqli_query($conn, $query);
$bus = mysqli_fetch_assoc($result);
$available_seats = $bus['available_seats'];

// Fetch booked seats for the bus
$query_booked_seats = "SELECT seat_number FROM passengers WHERE bus_id = '$bus_id'";
$booked_seats_result = mysqli_query($conn, $query_booked_seats);
$booked_seats = [];
while ($row = mysqli_fetch_assoc($booked_seats_result)) {
    $booked_seats[] = $row['seat_number'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seats_booked = count($_POST['seat_numbers']);
    $total_amount = $seats_booked * 500; // Assuming each ticket costs 500
    $user_id = 1; // Get user ID from session if implemented
    $upi_id = mysqli_real_escape_string($conn, $_POST['upi_id']); // Get UPI ID from the form

    // Insert booking into the bookings table
    $insert_booking = "INSERT INTO bookings (user_id, bus_id, seats_booked, total_amount, upiPin) 
                       VALUES ('$user_id', '$bus_id', '$seats_booked', '$total_amount', '$upi_id')";
    mysqli_query($conn, $insert_booking);
    $booking_id = mysqli_insert_id($conn); // Get the ID of the booking

    // Insert passenger details
    foreach ($_POST['passenger_name'] as $index => $name) {
        $age = $_POST['passenger_age'][$index];
        $gender = $_POST['passenger_gender'][$index];
        $seat_number = $_POST['seat_numbers'][$index];

        // Insert passenger details into the database
        $insert_passenger = "INSERT INTO passengers (booking_id, seat_number, bus_id, name, age, gender) 
                             VALUES ('$booking_id', '$seat_number', '$bus_id', '$name', '$age', '$gender')";
        mysqli_query($conn, $insert_passenger);
    }

    // Update available seats in the buses table
    $new_seats = $available_seats - $seats_booked;
    $update_bus = "UPDATE buses SET available_seats = '$new_seats' WHERE id = '$bus_id'";
    mysqli_query($conn, $update_bus);

    // Store the booking details in session for the payment page
    $_SESSION['total_amount'] = $total_amount;
    $_SESSION['booking_id'] = $booking_id;
    $_SESSION['bus_id'] = $bus_id;

    // Redirect to a success page or display a success message
    header("Location: payment.php");
    exit(); // Ensure no further code is executed after the redirect
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Popup styles */
        #popupOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        #confirmationPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            color:black;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 20;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .popup-buttons {
            margin-top: 20px;
        }

        .popup-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup-buttons .confirm {
            background-color: #4CAF50;
            color: white;
        }

        .popup-buttons .cancel {
            background-color: #f44336;
            color: white;
        }

        #reserveButton {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #reserveButton:hover {
            background-color: #0056b3;
        }

        .seat-container label {
            display: inline-block;
            margin: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
        }

        .seat-container label.booked {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .seat-container label.available {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Ticket Reservation</h2>
    <p><strong>Bus Name:</strong> <?php echo $bus['bus_name']; ?></p>
    <p><strong>Departure Date:</strong> <?php echo $bus['departure_date']; ?></p>
    <p><strong>Available Seats:</strong> <?php echo $available_seats; ?></p>

    <form method="POST" action="ticket_reservation.php?bus_id=<?php echo $bus_id; ?>" id="reservationForm">
        <h3>Seat Arrangement</h3>
        <div class="seat-container">
            <?php
            // Dynamically generate seats based on available seats
            $seat_counter = 1;
            $max_seats_per_row = 4; // 4 seats per row
            for ($row = 1; $row <= ceil($available_seats / $max_seats_per_row); $row++) {
                echo "<div>";
                for ($col = 1; $col <= $max_seats_per_row; $col++) {
                    if ($seat_counter > $available_seats) break; // Stop if we reach the available seats count
                    $seat_number = $seat_counter++;
                    $is_booked = in_array($seat_number, $booked_seats) ? 'booked' : 'available';
                    echo "<label class='$is_booked'>";
                    echo $seat_number;
                    if ($is_booked == 'available') {
                        echo "<input type='checkbox' name='seat_numbers[]' value='$seat_number'>";
                    }
                    echo "</label>";
                }
                echo "</div>";
            }
            ?>
        </div>

        <h3>Passenger Details</h3>
        <div id="passenger_details"></div>

        <button type="button" id="reserveButton">Reserve Seats</button>
    </form>

    <!-- Popup and Overlay -->
    <div id="popupOverlay"></div>
    <div id="confirmationPopup">
        <p><strong>Total Amount:</strong> <span id="totalAmount"></span></p>
        <p>Are you sure you want to reserve the selected seats?</p>
        <label for="upi_id">Enter UPI ID for Payment:</label>
        <input type="text" id="upi_id" name="upi_id" placeholder="example@upi" required>
        <div class="popup-buttons">
            <button class="confirm" id="confirmButton">Pay</button>
            <button class="cancel" id="cancelButton">Cancel</button>
        </div>
    </div>

    <script>
        const reserveButton = document.getElementById('reserveButton');
        const confirmationPopup = document.getElementById('confirmationPopup');
        const popupOverlay = document.getElementById('popupOverlay');
        const reservationForm = document.getElementById('reservationForm');
        const confirmButton = document.getElementById('confirmButton');
        const cancelButton = document.getElementById('cancelButton');
        const totalAmountElement = document.getElementById('totalAmount');

        // Show the popup when the Reserve Seats button is clicked
        reserveButton.addEventListener('click', function () {
            const selectedSeats = document.querySelectorAll('input[type="checkbox"]:checked').length;
            if (selectedSeats === 0) {
                alert('Please select at least one seat.');
                return;
            }
            totalAmountElement.textContent = selectedSeats * 500; // Update total amount
            confirmationPopup.style.display = 'block';
            popupOverlay.style.display = 'block';
        });

        // Confirm reservation and submit the form
        confirmButton.addEventListener('click', function () {
            const upiInput = document.getElementById('upi_id');
            if (upiInput.value.trim() === '') {
                alert('Please enter a valid UPI ID.');
                return;
            }
            reservationForm.submit();
        });

        // Cancel and hide the popup
        cancelButton.addEventListener('click', function () {
            confirmationPopup.style.display = 'none';
            popupOverlay.style.display = 'none';
        });

        // Dynamically adjust passenger details based on selected seats
        document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                let seatCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
                const passengerDetailsDiv = document.getElementById('passenger_details');
                while (passengerDetailsDiv.children.length < seatCount) {
                    const passengerDiv = document.createElement('div');
                    passengerDiv.innerHTML = `
                        <label>Name:</label>
                        <input type="text" name="passenger_name[]" required>
                        <label>Age:</label>
                        <input type="number" name="passenger_age[]" required>
                        <label>Gender:</label>
                        <select name="passenger_gender[]" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    `;
                    passengerDetailsDiv.appendChild(passengerDiv);
                }
                                while (passengerDetailsDiv.children.length > seatCount) {
                    passengerDetailsDiv.removeChild(passengerDetailsDiv.lastChild);
                }
            });
        });
    </script>
</body>
</html>


<?php
include 'db_connection.php';

$source = $destination = $date = "";
$buses = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    // Query to fetch buses based on source, destination, and date
    $query = "SELECT * FROM buses WHERE source = '$source' AND destination = '$destination' AND departure_date = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $buses = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Browsing - Bus Ticket Booking</title>
</head>
<body style="
    margin: 0;
    font-family: Arial, sans-serif;
    background: url('Images.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #333;">

    <div style="
        max-width: 800px;
        margin: 40px auto;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <h2 style="text-align: center; margin-bottom: 20px;">Search Buses</h2>

        <form method="POST" action="bus_browsing.php" style="margin-bottom: 30px;">
            <div style="margin-bottom: 15px;">
                <label for="source" style="display: block; font-weight: bold;">Source City</label>
                <select name="source" id="source" required style="width: 100%; padding: 8px;">
                    <option value="Chennai">Chennai</option>
                    <option value="Coimbatore">Coimbatore</option>
                    <option value="Salem">Salem</option>
                    <option value="Tiruchirappalli">Tiruchirappalli</option>
                    <option value="Vellore">Vellore</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="destination" style="display: block; font-weight: bold;">Destination City</label>
                <select name="destination" id="destination" required style="width: 100%; padding: 8px;">
                    <option value="Madurai">Madurai</option>
                    <option value="Trichy">Trichy</option>
                    <option value="Tirunelveli">Tirunelveli</option>
                    <option value="Kanchipuram">Kanchipuram</option>
                    <option value="Erode">Erode</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="date" style="display: block; font-weight: bold;">Departure Date</label>
                <input type="date" name="date" id="date" required style="width: 100%; padding: 8px;">
            </div>

            <button type="submit" style="
                background-color: #007BFF;
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;">
                Search
            </button>
        </form>

        <h3 style="text-align: center; margin-bottom: 20px;">Available Buses</h3>

        <?php if (count($buses) > 0): ?>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #007BFF; color: white;">
                        <th style="padding: 10px;">Bus Name</th>
                        <th style="padding: 10px;">Source</th>
                        <th style="padding: 10px;">Destination</th>
                        <th style="padding: 10px;">Departure Date</th>
                        <th style="padding: 10px;">Departure Time</th>
                        <th style="padding: 10px;">Seats Available</th>
                        <th style="padding: 10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($buses as $bus): ?>
                        <tr style="text-align: center; border-bottom: 1px solid #ccc;">
                            <td style="padding: 10px;"><?php echo $bus['bus_name']; ?></td>
                            <td style="padding: 10px;"><?php echo $bus['source']; ?></td>
                            <td style="padding: 10px;"><?php echo $bus['destination']; ?></td>
                            <td style="padding: 10px;"><?php echo $bus['departure_date']; ?></td>
                            <td style="padding: 10px;"><?php echo $bus['departure_time']; ?></td>
                            <td style="padding: 10px;"><?php echo $bus['available_seats']; ?></td>
                            <td style="padding: 10px;">
                                <form action="ticket_reservation.php" method="GET">
                                    <input type="hidden" name="bus_id" value="<?php echo $bus['id']; ?>">
                                    <input type="hidden" name="available_seats" value="<?php echo $bus['available_seats']; ?>">
                                    <button type="submit" style="
                                        background-color: #28A745;
                                        color: white;
                                        padding: 8px 12px;
                                        border: none;
                                        border-radius: 5px;
                                        cursor: pointer;">
                                        Book Ticket
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No buses found for the selected route and date.</p>
        <?php endif; ?>

    </div>
</body>
</html>

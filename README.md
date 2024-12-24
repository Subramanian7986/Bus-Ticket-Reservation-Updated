
# 🚍 Bus Ticket Reservation System (Updated) 🚌

This project is an **Online Bus Ticket Reservation System** built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**, powered by the **XAMPP** server. It allows users to browse available buses, select seats, book tickets, make payments, and view or cancel bookings. 🌟

---

## ✨ Features  

1. 🔐 **User Authentication**:  
   - Secure login and registration functionality for users.  

2. 🚌 **Bus Browsing and Selection**:  
   - View a list of available buses, including departure times, bus details, and available seats.

3. 🎫 **Seat Selection**:  
   - Choose seats from the available ones on the selected bus.

4. 💳 **Payment Processing**:  
   - Input payment details (such as card number, phone number, UPI ID) to confirm the booking.

5. 📋 **View Bookings**:  
   - View all your bookings along with bus details, seat information, and booking ID.

6. ❌ **Cancel Tickets**:  
   - Cancel previously booked tickets, making seats available for others.

---

## 🛠️ Technologies Used  

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  
- **Server**: XAMPP (Apache & MySQL)  

---

## 🚀 Installation and Setup  

1. **Download and Install XAMPP**:  
   - Download XAMPP from [Apache Friends](https://www.apachefriends.org/) and install it.

2. **Clone the Repository**:  
   - Clone the project or download the ZIP and extract it to the `htdocs` directory inside your XAMPP installation folder:  
     ```bash  
     git clone https://github.com/Subramanian7986/Bus-Ticket-Reservation-Updated.git  
     cd Bus-Ticket-Reservation-Updated  
     ```

3. **Import Database**:  
   - Open **phpMyAdmin** via `http://localhost/phpmyadmin`.  
   - Create a database named `bus_ticket_reservation`.  
   - Import the `bus_ticket_booking.sql` file from the project directory into the newly created database.

4. **Update Database Configuration**:  
   - Open the `db_connection.php` file and make sure the database credentials match your XAMPP setup:  
     ```php  
     $servername = "localhost";  
     $username = "root";  // Default XAMPP username  
     $password = "";  // Default XAMPP password is empty  
     $dbname = "bus_ticket_reservation";  
     ```

5. **Run the Project**:  
   - Start Apache and MySQL from the XAMPP control panel.  
   - Access the project in your browser at `http://localhost/Bus-Ticket-Reservation-Updated`.

---

## 📜 Project Workflow  

1. 🏠 **Homepage**:  
   - Users can log in or register to access the system.  

2. 🚌 **Bus Browsing**:  
   - After logging in, users can browse available buses with details such as bus name, departure time, and available seats.  

3. 🎫 **Seat Selection**:  
   - Choose seats from the available ones for a selected bus.

4. 💳 **Payment**:  
   - Enter payment details such as UPI ID, and confirm the ticket booking.  

5. 📋 **View Bookings**:  
   - Users can view all their booked tickets along with bus and seat details.

6. ❌ **Cancel Booking**:  
   - Users can cancel their bookings, which will make the selected seats available for others to book.

---

## 📂 File Structure  

```plaintext
/Bus-Ticket-Reservation-Updated
├── db_connection.php          # 📊 Database connection file  
├── first.html                 # 🏠 Initial page (optional placeholder)
├── index.php                  # 🏠 Homepage for login/registration
├── register.php               # ✍️ User registration page
├── login.php                  # 🔑 User login page
├── bus_browsing.php           # 🚌 Bus browsing and selection page
├── ticket_reservation.php     # 🎫 Seat selection and reservation page
├── cancel_ticket.php          # ❌ Cancel ticket functionality
├── payment.php                # 💳 Payment processing page
├── view_booked.php            # 📋 View booked tickets page
├── styles.css                 # 💅 CSS for styling the pages
├── bus_ticket_booking.sql     # 🗄️ SQL file for database setup
```

---

## 📊 Database Schema  

Create a database named `bus_ticket_reservation`.

**Tables**:  

1. **users**:  
   - Stores user credentials (ID, username, email, password).  

2. **buses**:  
   - Stores bus details (ID, name, departure/arrival time, route, etc.).  

3. **seats**:  
   - Manages seat availability for each bus.  

4. **tickets**:  
   - Stores ticket booking details (ID, user ID, bus ID, seat number, booking date).  

---

## 🎯 Future Enhancements  

- 📧 **Email Notifications**: Add email notifications for booking confirmations and cancellations.  
- 📈 **Dynamic Pricing**: Introduce dynamic pricing based on demand and available seats.  
- 📱 **Responsive UI**: Enhance the user interface with a responsive design for mobile compatibility.  
- 💰 **Online Payment Gateway**: Integrate real payment gateways like PayPal, Stripe, or UPI for real-time transactions.  

---

## 📜 License  

This project is licensed under the [MIT License](LICENSE).  

---

## 🙌 Author  

- **Subramanian V**  
- 📧 Email: [vsubramanianofficial@gmail.com](mailto:vsubramanianofficial@gmail.com)  
- 💼 LinkedIn: [Subramanian V](https://www.linkedin.com/in/subramanian-v-a93089255/)

---

Now you can easily browse buses, reserve tickets, and manage your bookings with this simple and efficient Bus Ticket Reservation System! 🎉

---

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" href="css/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"/>
    <style>
        button{
            border:none;
            background-color: transparent;
            font: 1em sans-serif;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <a href="#" class="nav-link active" data-section="resorts"><i class="fa-solid fa-car"></i> Resorts</a>
            <a href="#" class="nav-link" data-section="bookings"><i class="fa-solid fa-ticket"></i> Bookings</a>
            <a href="#" class="nav-link" data-section="payments"><i class="fa-solid fa-money-bill"></i> Payments</a>
        </div>
        
        <div class="user-profile">
            <i class="fa-regular fa-user profile-icon"></i>
            <div class="user-column">
                
            <?php   
          
                $isLoggedIn = isset($_SESSION['user']);

                if ($isLoggedIn) {
                    $user = $_SESSION['user'];
                    echo "<h4>" . htmlspecialchars($user['username']) . "</h4>";
                } else {
                    echo "<p>You are not logged in.</p>";
                }
            ?>
            </div>
        </div>
    </div>

    <div class="main-content">
        <section id="resorts" class="content-section">
        <div class="row"> 
            <h2>Resorts</h2>
            <div class="add-button" onclick="openModal()">Add</div>
        </div>
        <table id="resorts-table">
            <thead>
                <tr>
                    <th>Resort ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Price/Day</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </section>

    <section id="bookings" class="content-section" style="display: none;">
        <h2>Bookings</h2>
        <table id="bookings-table">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Resort</th>
                    <th>Customer</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </section>


        <section id="payments" class="content-section" style="display: none;">
            <h2>Payments</h2>
            <table id="payments-table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Resort</th>
                        <th>Customer</th>
                        <th>Amount Paid</th>
                        <th>Method</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </div>

    <div id="addResortModel" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Add resort</h3>
            <form id="addResortForm">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                
                <label for="title">Title:</label>
                <input type="text" id="make" name="title" placeholder="Enter resort title" required>
                
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Enter resort location" required>
                
                <label for="price">Price Per Day:</label>
                <input type="number" id="price" name="price" placeholder="Enter price per day" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Description" rows="5" style="resize: none;" required></textarea>

                
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div id="editResortModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit Resort</h3>
            <form id="editResortForm">
                <input type="hidden" id="edit-id" name="id">
                
                <label for="edit-image">Image (Optional):</label>
                <input type="file" id="edit-image" name="image" accept="image/*">
                
                <label for="edit-title">Title:</label>
                <input type="text" id="edit-title" name="title" placeholder="Enter resort title" required>
                
                <label for="edit-location">Location:</label>
                <input type="text" id="edit-location" name="location" placeholder="Enter resort location" required>
                
                <label for="edit-price">Price Per Day:</label>
                <input type="number" id="edit-price" name="price" placeholder="Enter price per day" required>

                <label for="edit-description">Description:</label>
                <textarea id="edit-description" name="description" placeholder="Description" rows="5" style="resize: none;" required></textarea>
                
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>


    <script src="js/api.js"></script>   

    <script>
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.content-section');

        navLinks.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                navLinks.forEach(link => link.classList.remove('active'));
                sections.forEach(section => section.style.display = 'none');
                link.classList.add('active');
                const sectionId = link.getAttribute('data-section');
                document.getElementById(sectionId).style.display = 'block';
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    fetchBookings();
});

function fetchBookings() {
    fetch('fetch_booking.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const bookingsTableBody = document.querySelector('#bookings-table tbody');
                bookingsTableBody.innerHTML = ''; 
                data.data.forEach(booking => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${booking.id}</td>
                        <td>${booking.title}</td>
                        <td>${booking.username}</td>
                        <td>${booking.checkin}</td>
                        <td>${booking.checkout}</td>
                        <td>${booking.price}</td>
                        <td>${booking.status}</td>
                        <td><button onclick="cancelBooking(${booking.id})"><i class="fa-solid fa-ban"></i></button></td>
                    `;

                    bookingsTableBody.appendChild(row);
                });
            } else {
                console.log('Error fetching bookings:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function cancelBooking(bookingId) {
    const confirmCancel = confirm("Are you sure you want to cancel this booking?");
    if (confirmCancel) {
        fetch('cancel_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: bookingId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Booking canceled successfully');
                fetchBookings();
            } else {
                alert('Error canceling booking');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchPayments();
});

function fetchPayments() {
    fetch('fetch_payments.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const paymentsTableBody = document.querySelector('#payments-table tbody');
                paymentsTableBody.innerHTML = ''; 
                data.data.forEach(payment => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${payment.id}</td>
                        <td>${payment.title}</td>
                        <td>${payment.username}</td>
                        <td>${payment.amount}</td>
                        <td>${payment.method}</td>
                        <td>${payment.time}</td>
                    `;

                    paymentsTableBody.appendChild(row);
                });
            } else {
                console.log('Error fetching payments:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
</script>
</body>
</html>

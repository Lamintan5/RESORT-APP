<?php
session_start();

$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
$username = isset($_SESSION['user']) ? $_SESSION['user']['username'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .resort-details {
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .resort-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            width: 100%;
            gap: 40px;
            margin-top: 20px;
        }

        .resort-image {
            flex: 1;
            max-width: 500px;
            min-width: 300px;
        }

        .resort-image img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .resort-info {
            flex: 2;
            max-width: 600px;
        }

        .resort-info h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .resort-info p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .resort-info strong {
            font-weight: bold;
        }

        .resort-info span {
            font-weight: normal;
        }

        /* Booking Form Styles */
        .booking-container {
            margin-top: 50px;
            width: 100%;
            max-width: 600px;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .booking-container h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .booking-container .form-group {
            margin-bottom: 15px;
        }

        .booking-container label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .booking-container input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .booking-container button {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .booking-container button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<section class="resort-details">
    <div class="resort-container">
        <div class="resort-image">
            <img id="resortImage" src="" alt="Resort Image">
        </div>
        <div class="resort-info">
            <h2 id="resortTitle"></h2>
            <p id="resortLocation"></p>
            <p id="resortDescription"></p>
            <p><strong>Status:</strong> <span id="resortStatus"></span></p>
            <p><strong>Price:</strong> $<span id="resortPrice"></span> per day</p>
        </div>
    </div>

    <div class="booking-container">
        <h3>Book Your Stay</h3>
        <form id="bookingForm" onsubmit="submitBooking(event)">
            <div class="form-group">
                <label for="checkInDate">Check-in Date:</label>
                <input type="date" id="checkInDate" required>
            </div>
            <div class="form-group">
                <label for="checkOutDate">Check-out Date:</label>
                <input type="date" id="checkOutDate" required>
            </div>
            <div class="form-group">
                <label for="creditCardNumber">Credit Card Number:</label>
                <input type="text" id="creditCardNumber" required placeholder="1234 5678 1234 5678">
            </div>
            <div class="form-group">
                <label for="creditCardExpiry">Expiry Date:</label>
                <input type="month" id="creditCardExpiry" required>
            </div>
            <div class="form-group">
                <label for="creditCardCVV">CVV:</label>
                <input type="text" id="creditCardCVV" required placeholder="123">
            </div>
            <div class="form-group">
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" required>
                    <option value="cash">Cash</option>
                    <option value="electronic">Electronic</option>
                </select>
            </div>

            <button type="submit">Book Now</button>
        </form>
    </div>
</section>

<script>
async function fetchResortDetails() {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const resortId = urlParams.get('id');
        
        const response = await fetch(`fetch_single_resort.php?id=${resortId}`);
        const data = await response.json();

        if (data.success) {
            const resort = data.data;
            document.getElementById('resortImage').src = resort.image;
            document.getElementById('resortTitle').innerText = resort.title;
            document.getElementById('resortLocation').innerText = resort.location;
            document.getElementById('resortDescription').innerText = resort.description;
            document.getElementById('resortStatus').innerText = resort.status;
            document.getElementById('resortPrice').innerText = resort.price;
        } else {
            alert('Resort not found');
        }
    } catch (error) {
        console.error('Error fetching resort details:', error);
    }
}

function submitBooking(event) {
    event.preventDefault(); 
    const checkInDate = document.getElementById('checkInDate').value;
    const checkOutDate = document.getElementById('checkOutDate').value;
    const creditCardNumber = document.getElementById('creditCardNumber').value;
    const creditCardExpiry = document.getElementById('creditCardExpiry').value;
    const creditCardCVV = document.getElementById('creditCardCVV').value;

    console.log({
        checkInDate,
        checkOutDate,
        creditCardNumber,
        creditCardExpiry,
        creditCardCVV
    });

    alert('Booking request submitted!');

}

window.onload = fetchResortDetails;

async function submitBooking(event) {
    event.preventDefault(); 

    const checkInDate = document.getElementById('checkInDate').value;
    const checkOutDate = document.getElementById('checkOutDate').value;
    const paymentMethod = document.getElementById('paymentMethod').value;
    const resortId = new URLSearchParams(window.location.search).get('id');
    
    const formData = new FormData();
    formData.append('checkInDate', checkInDate);
    formData.append('checkOutDate', checkOutDate);
    formData.append('paymentMethod', paymentMethod);
    formData.append('resortId', resortId);

    try {
        const response = await fetch('process_booking.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);  
            window.location.href = 'index.php';
        } else {
            alert(result.message); 
        }
    } catch (error) {
        console.error('Error submitting booking:', error);
        alert('Booking failed. Please try again.');
    }
}

</script>

</body>
</html>

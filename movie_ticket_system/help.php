<?php
// help.php
include('header.php'); // Include your header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help - Movie Ticket System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="help-section">
        <h1>How Can We Assist You?</h1>

        <section class="faq">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <h3>How do I book a ticket?</h3>
                <p>To book a ticket, simply choose your preferred movie, select the date and time, and proceed with the payment.</p>
            </div>
            <div class="faq-item">
                <h3>Can I cancel my booking?</h3>
                <p>Yes, cancellations can be made within 24 hours of your booking. Please refer to the cancellation policy on the booking page.</p>
            </div>
            <div class="faq-item">
                <h3>What payment methods do you accept?</h3>
                <p>We accept all major credit and debit cards, as well as PayPal.</p>
            </div>
        </section>

        <section class="contact">
            <h2>Contact Us</h2>
            <p>If you have any further questions or need help, please contact our support team:</p>
            <ul>
                <li>Email: support@movieticketsystem.com</li>
                <li>Phone: +1 234 567 890</li>
            </ul>
        </section>

        <section class="troubleshooting">
            <h2>Troubleshooting</h2>
            <div class="trouble-item">
                <h3>Booking page not loading?</h3>
                <p>Ensure your browser is up to date. Try clearing your browser cache or using a different browser.</p>
            </div>
            <div class="trouble-item">
                <h3>Payment issue?</h3>
                <p>If you face any payment-related issues, please contact our support team for assistance.</p>
            </div>
        </section>

        <section class="feedback">
            <h2>Give Us Feedback</h2>
            <form action="feedback.php" method="POST">
                <label for="feedback">Your Feedback:</label>
                <textarea id="feedback" name="feedback" rows="4" cols="50"></textarea>
                <br>
                <button type="submit">Submit Feedback</button>
            </form>
        </section>
    </div>

    <?php include('footer.php'); // Include your footer ?>
</body>
</html>

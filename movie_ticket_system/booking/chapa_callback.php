<?php
include('../config/db.php'); // Include the database connection

// Check if tx_ref is provided in the query string
if (!isset($_GET['tx_ref'])) {
    die("Transaction reference missing.");
}

$tx_ref = $_GET['tx_ref'];
$chapa_secret_key = "CHASECK_TEST-4HcHXDxRWdUnNpeVGK1LrqRpPdrmF24s"; // Replace with your actual Chapa secret key

// Fetch transaction details from the database
$stmt = $conn->prepare("SELECT payment_method, amount FROM transactions WHERE tx_ref = ?");
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt->bind_param("s", $tx_ref);
$stmt->execute();
$stmt->bind_result($payment_method, $amount);
$stmt->fetch();
$stmt->close();

// Check if transaction data is found
if (empty($payment_method) || empty($amount)) {
    die("Transaction details not found.");
}

// Close the database connection
$conn->close();

// Prepare the data for Chapa payment initialization
$callback_url = "http://localhost/movie_ticket_system/movie_ticket_system/booking/chapa_callback.php"; // Replace with your actual callback URL
$data = [
    'amount' => $amount,
    'currency' => 'ETB',
    'tx_ref' => $tx_ref,
    'return_url' => $callback_url,
    'callback_url' => $callback_url,
    'customization' => [
        'title' => 'Movie Ticket Purchase'
    ],
    'customer' => [
        'payment_method' => $payment_method
    ]
];

// Initialize cURL for payment request
$ch = curl_init("https://api.chapa.co/v1/transaction/initialize");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $chapa_secret_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute request and get response
$response = curl_exec($ch);
if(curl_errno($ch)){
    die("cURL error: " . curl_error($ch));
}
curl_close($ch);

// Decode response
$result = json_decode($response, true);

// Check if payment initialization was successful
if (isset($result['status']) && $result['status'] === 'success' && isset($result['data']['checkout_url'])) {
    // Redirect user to Chapa checkout page
    header("Location: " . $result['data']['checkout_url']);
    exit();
} else {
    echo "Payment initialization failed! Please try again.";
}
?>
<?php
include('../config/db.php');

session_start(); // Start the session to access session variables

$error_message = ''; // Initialize the error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $payment_method = $_POST['payment_method'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $userID = $_SESSION['UserID'] ?? ''; // Get the UserID from the session
    $movieID = $_POST['movie_id'] ?? '';
    $seatNo = $_POST['seat_no'] ?? ''; // Get the seat number from the form

    $tx_ref = "TX-" . time(); // Unique transaction reference

    // Debugging: Log the received UserID and other form data
    error_log("Received Payment Method: " . $payment_method);
    error_log("Received Amount: " . $amount);
    error_log("Received UserID: " . $userID);
    error_log("Received MovieID: " . $movieID);
    error_log("Received SeatNo: " . $seatNo);

    // Add status column to transactions table if it doesn't exist
    $conn->query("ALTER TABLE transactions ADD COLUMN IF NOT EXISTS status VARCHAR(255)");

    // Check if the user ID exists in the user table
    $stmt = $conn->prepare("SELECT UserID FROM user WHERE UserID = ?");
    if ($stmt === false) {
        $error_message = "Error preparing the statement: " . $conn->error;
    } else {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            // If the user ID is not found
            $error_message = "Invalid UserID: " . htmlspecialchars($userID);
        } else {
            // Check if the movie ID exists in the movie table
            $stmt->close(); // Close the previous statement
            $stmt = $conn->prepare("SELECT MovieID FROM movie WHERE MovieID = ?");
            if ($stmt === false) {
                $error_message = "Error preparing the statement: " . $conn->error;
            } else {
                $stmt->bind_param("i", $movieID);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    // If the movie ID is not found
                    $error_message = "Invalid MovieID: " . htmlspecialchars($movieID);
                } else {
                    // Check if the seat number exists in the available_seat table and fetch the SeatID
                    $stmt->close(); // Close the previous statement
                    $stmt = $conn->prepare("SELECT SeatID FROM available_seat WHERE SeatNo = ?");
                    if ($stmt === false) {
                        $error_message = "Error preparing the statement: " . $conn->error;
                    } else {
                        $stmt->bind_param("s", $seatNo);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 0) {
                            // If the seat number is not found
                            $error_message = "Invalid SeatNo: " . htmlspecialchars($seatNo);
                        } else {
                            $stmt->bind_result($seatID);
                            $stmt->fetch();
                            // If the user ID, movie ID, and seat number are valid, proceed with the transaction
                            $stmt->close(); // Close the previous statement
                            $stmt = $conn->prepare("INSERT INTO transactions (UserID, payment_method, MovieID, SeatID, Amount, tx_ref, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
                            if ($stmt === false) {
                                $error_message = "Error preparing the statement: " . $conn->error;
                            } else {
                                $stmt->bind_param("isiids", $userID, $payment_method, $movieID, $seatID, $amount, $tx_ref);
                                if (!$stmt->execute()) {
                                    $error_message = "Database error: " . $stmt->error;
                                } else {
                                    $stmt->close();
                                    $conn->close();
                                    // Chapa secret key (Replace with your actual API key)
                                    $chapa_secret_key = "CHASECK_TEST-4HcHXDxRWdUnNpeVGK1LrqRpPdrmF24s";

                                    // Payment data
                                    $data = [
                                        'amount' => $amount,
                                        'currency' => 'ETB',
                                        'phone' => $_POST['phone'],
                                        'first_name' => $_POST['first_name'],
                                        'last_name' => $_POST['last_name'],
                                        'tx_ref' => $tx_ref,
                                        'callback_url' => 'http://localhost/movie_ticket_system/chapa_callback.php',
                                        'payment_method' => $payment_method
                                    ];

                                    // Make API request to Chapa
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, 'https://api.chapa.co/v1/transaction/initialize');
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                        'Authorization: Bearer ' . $chapa_secret_key,
                                        'Content-Type: application/json'
                                    ]);

                                    // Execute request and get response
                                    $response = curl_exec($ch);
                                    curl_close($ch);

                                    // Decode response
                                    $result = json_decode($response, true);

                                    // Debugging: Print API response (Remove this after testing)
                                    error_log(print_r($result, true));

                                    // Check if payment initialization was successful
                                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['data']['checkout_url'])) {
                                        // Redirect user to Chapa checkout page
                                        header("Location: " . $result['data']['checkout_url']);
                                        exit();
                                    } else {
                                        $error_message = "Payment initialization failed! Please try again.";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $stmt->close();
    }
}
// Fetch user ID, movie ID, and seat number from query parameters
$payment_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : '';
$userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
$movieID = isset($_GET['movie_id']) ? $_GET['movie_id'] : '';
$seatNo = isset($_GET['seat_no']) ? $_GET['seat_no'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout Form</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .checkout-container {
      background: #fff;
      padding: 30px;
      width: 350px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .checkout-container input, .checkout-container select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    .checkout-container button {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      border: none;
      color: #fff;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .checkout-container button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="checkout-container bg-white p-8 rounded-lg shadow-lg w-full max-w-md animate__animated animate__fadeIn">
    <h2 class="text-2xl font-bold mb-6">Book Ticket</h2>
    <?php if ($error_message): ?>
      <div class="bg-red-500 text-white p-4 rounded mb-4">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="checkout.php" method="POST">
      <div class="mb-4">
        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
        <select id="payment_method" name="payment_method" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
          <option value="">Select Payment Method</option>
          <option value="telebirr">Telebirr</option>
          <option value="cbe">CBE</option>
          <option value="mpesa">M-Pesa</option>
          <option value="amole">Amole</option>
        </select>
      </div>
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userID); ?>">
      <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movieID); ?>">
      <div class="mb-4">
        <label for="seat_no" class="block text-sm font-medium text-gray-700">Seat Number</label>
        <input type="text" id="seat_no" name="seat_no" placeholder="Seat Number" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
      </div>
      <div class="mb-4">
        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
        <input type="number" id="amount" name="amount" placeholder="Amount" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
      </div>
      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="Phone" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
      </div>
      <div class="mb-4">
      <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input type="text" id="first_name" name="first_name" placeholder="First Name" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
      </div>
      <div class="mb-4">
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Last Name" required class="mt-1 p-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 text-gray-700">
      </div>
      <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-black font-semibold rounded-md hover:bg-yellow-600 transition duration-300">Pay Now</button>
    </form>
  </div>
</body>
</html>
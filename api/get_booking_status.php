<?php
header('Content-Type: application/json');
require_once 'db.php';

if (isset($_GET['phone'])) {
    $phone = mysqli_real_escape_string($conn, $_GET['phone']);

    // Fetch the most recent booking for this phone number
    $stmt = $conn->prepare("SELECT customer_name, bike_model, problem, service_date, status FROM bike_bookings WHERE phone = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        // Format date
        $booking['service_date'] = date('d M, Y', strtotime($booking['service_date']));
        
        echo json_encode([
            'success' => true,
            'booking' => $booking
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No booking found.'
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
}
mysqli_close($conn);
?>

<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bike_model = mysqli_real_escape_string($conn, $_POST['bike_model']);
    $problem = mysqli_real_escape_string($conn, $_POST['problem']);
    $service_date = mysqli_real_escape_string($conn, $_POST['service_date']);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO bike_bookings (customer_name, phone, bike_model, problem, service_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone, $bike_model, $problem, $service_date);

    if ($stmt->execute()) {
        echo "<script>
                alert('Success! Your bike service booking has been received. We will contact you soon.');
                window.location.href = '../index.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not process booking. Please try again.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    header("Location: ../book-service.html");
}
?>

<?php
session_start();
require_once '../api/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Status Update
if (isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE bike_bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $booking_id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch Bookings
$query = "SELECT * FROM bike_bookings ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AK MECHANIC SERVICES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f7f6; }
        .dashboard-container { padding: 40px; }
        .table-card { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .status-pending { background: #fff3cd; color: #856404; font-weight: 600; }
        .status-in-progress { background: #cfe2ff; color: #084298; font-weight: 600; }
        .status-completed { background: #d1e7dd; color: #0f5132; font-weight: 600; }
        .badge { padding: 8px 12px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-danger" href="#">AK ADMIN PANEL</a>
            <div class="ms-auto text-white">
                <span class="me-3">Welcome, Admin</span>
                <a href="?logout=1" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="container-fluid">
            <h2 class="mb-4 fw-bold">Service Bookings</h2>
            
            <div class="table-card table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Bike Model</th>
                            <th>Problem</th>
                            <th>Service Date</th>
                            <th>Status head</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['customer_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['bike_model']); ?></td>
                            <td style="max-width: 200px;"><?php echo htmlspecialchars($row['problem']); ?></td>
                            <td><?php echo date('d M, Y', strtotime($row['service_date'])); ?></td>
                            <td>
                                <?php 
                                    $statusClass = '';
                                    if($row['status'] == 'Pending') $statusClass = 'status-pending';
                                    elseif($row['status'] == 'In Progress') $statusClass = 'status-in-progress';
                                    elseif($row['status'] == 'Completed') $statusClass = 'status-completed';
                                ?>
                                <span class="badge <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
                            </td>
                            <td>
                                <form action="" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                    <select name="status" class="form-select form-select-sm me-2" style="width: 130px;">
                                        <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="In Progress" <?php if($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                        <option value="Completed" <?php if($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(mysqli_num_rows($result) == 0): ?>
                            <tr><td colspan="8" class="text-center py-4">No bookings found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

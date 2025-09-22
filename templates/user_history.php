<?php
$title = "Booking History · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-clock-history"></i> Your Booking History</h2>
  <p class="mb-0">View all your past and current reservations</p>
</div>

<?php if (empty($history)): ?>
  <div class="alert alert-info">No booking history found.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Parking Lot</th>
          <th>Car</th>
          <th>Reserved</th>
          <th>Entered</th>
          <th>Exited</th>
          <th>Status</th>
          <th>Cost</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($history as $booking): ?>
          <tr>
            <td><?php echo htmlspecialchars($booking['lot_name'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($booking['car_number'] ?? 'N/A'); ?></td>
            <td><?php echo date('M j, Y H:i', strtotime($booking['reserved_at'])); ?></td>
            <td><?php echo $booking['entered_at'] ? date('M j, Y H:i', strtotime($booking['entered_at'])) : '-'; ?></td>
            <td><?php echo $booking['exited_at'] ? date('M j, Y H:i', strtotime($booking['exited_at'])) : '-'; ?></td>
            <td><span class="status-badge status-<?php echo $booking['status']; ?>"><?php echo $booking['status']; ?></span></td>
            <td><?php echo $booking['total_cost'] ? '₹' . $booking['total_cost'] : '-'; ?></td>
            <td>
              <?php if ($booking['status'] === 'Reserved'): ?>
                <form method="post" action="cancel_booking.php" class="d-inline" onsubmit="return confirm('Cancel this booking?')">
                  <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                  <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                </form>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'base.php';
?>
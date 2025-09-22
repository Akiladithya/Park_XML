<?php
$title = "Manage Reservations · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-table"></i> Manage Reservations</h2>
  <p class="mb-0">View and manage all parking reservations</p>
</div>

<div class="row mb-4">
  <div class="col-md-12">
    <form method="get" class="row g-3">
      <div class="col-md-3">
        <input type="text" name="user" class="form-control" placeholder="User name" value="<?php echo htmlspecialchars($_GET['user'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="car" class="form-control" placeholder="Car number" value="<?php echo htmlspecialchars($_GET['car'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option value="">All Status</option>
          <option value="Reserved" <?php echo ($_GET['status'] ?? '') === 'Reserved' ? 'selected' : ''; ?>>Reserved</option>
          <option value="Entered" <?php echo ($_GET['status'] ?? '') === 'Entered' ? 'selected' : ''; ?>>Entered</option>
          <option value="Exited" <?php echo ($_GET['status'] ?? '') === 'Exited' ? 'selected' : ''; ?>>Exited</option>
          <option value="Cancelled" <?php echo ($_GET['status'] ?? '') === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        </select>
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-outline-primary">Filter</button>
        <a href="admin_reservations.php" class="btn btn-outline-secondary">Clear</a>
      </div>
    </form>
  </div>
</div>

<?php if (empty($reservations)): ?>
  <div class="alert alert-info">No reservations found.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>User</th>
          <th>Car</th>
          <th>Lot</th>
          <th>Reserved</th>
          <th>Entered</th>
          <th>Exited</th>
          <th>Status</th>
          <th>Cost</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $res): ?>
          <tr>
            <td><?php echo htmlspecialchars($res['user'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($res['car_number'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($res['lot'] ?? 'N/A'); ?></td>
            <td><?php echo date('M j, H:i', strtotime($res['reserved_at'])); ?></td>
            <td><?php echo $res['entered_at'] ? date('M j, H:i', strtotime($res['entered_at'])) : '-'; ?></td>
            <td><?php echo $res['exited_at'] ? date('M j, H:i', strtotime($res['exited_at'])) : '-'; ?></td>
            <td><span class="status-badge status-<?php echo $res['status']; ?>"><?php echo $res['status']; ?></span></td>
            <td><?php echo $res['total_cost'] ? '₹' . $res['total_cost'] : '-'; ?></td>
            <td>
              <?php if ($res['status'] === 'Reserved'): ?>
                <form method="post" action="booking_action.php" class="d-inline">
                  <input type="hidden" name="booking_id" value="<?php echo $res['id']; ?>">
                  <input type="hidden" name="action" value="enter">
                  <button type="submit" class="btn btn-success btn-sm">Mark Entered</button>
                </form>
              <?php elseif ($res['status'] === 'Entered'): ?>
                <form method="post" action="booking_action.php" class="d-inline">
                  <input type="hidden" name="booking_id" value="<?php echo $res['id']; ?>">
                  <input type="hidden" name="action" value="exit">
                  <button type="submit" class="btn btn-warning btn-sm">Mark Exited</button>
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
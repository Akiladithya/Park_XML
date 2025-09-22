<?php
$title = "Admin Dashboard · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-bar-chart"></i> Admin Dashboard</h2>
  <p class="mb-0">Manage parking lots and monitor occupancy</p>
</div>

<div class="row mb-4">
  <div class="col-md-6">
    <form method="get" class="d-flex">
      <input type="text" name="search" class="form-control" placeholder="Search lots..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
      <button type="submit" class="btn btn-outline-primary ms-2">Search</button>
    </form>
  </div>
  <div class="col-md-6 text-end">
    <a href="create_lot.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Create New Lot</a>
  </div>
</div>

<?php if (empty($lots)): ?>
  <div class="alert alert-info">No parking lots found.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>PIN</th>
          <th>Price/Hour</th>
          <th>Total Spots</th>
          <th>Occupied</th>
          <th>Available</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lots as $lot): ?>
          <tr>
            <td><?php echo htmlspecialchars($lot['name']); ?></td>
            <td><?php echo htmlspecialchars($lot['address']); ?></td>
            <td><?php echo htmlspecialchars($lot['pin']); ?></td>
            <td>₹<?php echo $lot['price_per_unit']; ?></td>
            <td><?php echo $lot['max_spots']; ?></td>
            <td><span class="badge bg-primary"><?php echo $lot['occupied']; ?></span></td>
            <td><span class="badge bg-success"><?php echo $lot['available']; ?></span></td>
            <td>
              <a href="edit_lot.php?id=<?php echo $lot['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <form method="post" action="delete_lot.php" class="d-inline" onsubmit="return confirm('Delete this lot?')">
                <input type="hidden" name="lot_id" value="<?php echo $lot['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
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
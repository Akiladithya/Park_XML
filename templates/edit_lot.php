<?php
$title = "Edit Parking Lot · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-pencil"></i> Edit Parking Lot</h2>
  <p class="mb-0">Update parking facility details</p>
</div>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <form method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Lot Name</label>
              <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($lot['name']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="pin" class="form-label">PIN Code</label>
              <input type="text" name="pin" id="pin" class="form-control" value="<?php echo htmlspecialchars($lot['pin']); ?>" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required><?php echo htmlspecialchars($lot['address']); ?></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="price_per_unit" class="form-label">Price per Hour (₹)</label>
              <input type="number" name="price_per_unit" id="price_per_unit" class="form-control" step="0.01" min="0" value="<?php echo $lot['price_per_unit']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_spots" class="form-label">Maximum Spots</label>
              <input type="number" name="max_spots" id="max_spots" class="form-control" min="1" value="<?php echo $lot['max_spots']; ?>" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">Update Lot</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'base.php';
?>
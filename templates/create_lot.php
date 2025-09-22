<?php
$title = "Create Parking Lot · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-plus-circle"></i> Create New Parking Lot</h2>
  <p class="mb-0">Add a new parking facility</p>
</div>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <form method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Lot Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="pin" class="form-label">PIN Code</label>
              <input type="text" name="pin" id="pin" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="price_per_unit" class="form-label">Price per Hour (₹)</label>
              <input type="number" name="price_per_unit" id="price_per_unit" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_spots" class="form-label">Maximum Spots</label>
              <input type="number" name="max_spots" id="max_spots" class="form-control" min="1" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Create Lot</button>
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
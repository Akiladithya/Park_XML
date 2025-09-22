<?php
$title = "Manage Cars · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-car-front-fill"></i> Manage Your Cars</h2>
  <p class="mb-0">Add or remove your registered vehicles</p>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>Your Registered Cars</h5>
      </div>
      <div class="card-body">
        <?php if (empty($cars)): ?>
          <p class="text-muted">No cars registered yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Car Number</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cars as $car): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($car['car_number']); ?></td>
                    <td>
                      <form method="post" class="d-inline" onsubmit="return confirm('Remove this car?')">
                        <input type="hidden" name="delete_car_id" value="<?php echo $car['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5>Add New Car</h5>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="new_car" class="form-label">Car Number</label>
            <input type="text" name="new_car" id="new_car" class="form-control" placeholder="Enter car number" required>
          </div>
          <button type="submit" name="add_car" class="btn btn-primary w-100">Add Car</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'base.php';
?>
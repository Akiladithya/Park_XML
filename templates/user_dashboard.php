<?php
$title = "User Dashboard · ParkingPro";
ob_start();
?>

<div class="dashboard-header">
  <h2><i class="bi bi-house"></i> Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
  <p class="mb-0">Book your parking spot and manage your reservations</p>
</div>

<?php if ($active_booking): ?>
<div class="alert alert-info">
  <h5><i class="bi bi-car-front"></i> Active Booking</h5>
  <p class="mb-0">You have an active booking at <strong><?php echo htmlspecialchars($active_booking['lot_name']); ?></strong></p>
</div>
<?php endif; ?>

<div class="row">
  <div class="col-md-8">
    <h4>Available Parking Lots</h4>
    <?php if (empty($lots)): ?>
      <div class="alert alert-warning">No parking lots available.</div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($lots as $lot): ?>
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($lot['name']); ?></h5>
                <p class="card-text">
                  <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($lot['address']); ?><br>
                  <i class="bi bi-pin-map"></i> PIN: <?php echo htmlspecialchars($lot['pin']); ?><br>
                  <i class="bi bi-currency-rupee"></i> ₹<?php echo $lot['price_per_unit']; ?>/hour<br>
                  <span class="badge bg-success"><?php echo $lot['available']; ?> spots available</span>
                </p>
                <?php if ($lot['available'] > 0 && !empty($cars)): ?>
                  <form method="post" action="book_spot.php" class="d-inline">
                    <input type="hidden" name="lot_id" value="<?php echo $lot['id']; ?>">
                    <div class="mb-2">
                      <select name="car_id" class="form-select form-select-sm" required>
                        <option value="">Select Car</option>
                        <?php foreach ($cars as $car): ?>
                          <option value="<?php echo $car['id']; ?>"><?php echo htmlspecialchars($car['car_number']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Book Now</button>
                  </form>
                <?php elseif (empty($cars)): ?>
                  <small class="text-muted">Add a car to book spots</small>
                <?php else: ?>
                  <button class="btn btn-secondary btn-sm" disabled>No spots available</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  
  <div class="col-md-4">
    <h4>Quick Actions</h4>
    <div class="list-group">
      <a href="user_history.php" class="list-group-item list-group-item-action">
        <i class="bi bi-clock-history"></i> View Booking History
      </a>
      <a href="user_profile.php" class="list-group-item list-group-item-action">
        <i class="bi bi-car-front-fill"></i> Manage Cars
      </a>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'base.php';
?>
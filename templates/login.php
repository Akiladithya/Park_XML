<?php
$title = "Login · ParkingPro";
ob_start();
?>

<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
  <div class="col-md-5 col-lg-4">
    <div class="card p-4 shadow-sm">
      <h3 class="mb-3 text-center text-primary"><i class="bi bi-box-arrow-in-right"></i> Log in to ParkingPro</h3>
      <form method="POST" novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input required type="email" id="email" name="email" class="form-control" autocomplete="email" autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <input required type="password" id="password" name="password" class="form-control" autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
        <p class="mt-3 text-center">New user? <a href="register.php">Register here</a></p>
      </form>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'base.php';
?>
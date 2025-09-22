<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $title ?? 'Parking Pro'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 + Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary: #1a73e8;
      --secondary: #ff9800;
      --danger: #e53935;
      --success: #43a047;
    }
    .navbar-brand {
      font-weight: 700;
      letter-spacing: 1px;
      font-size: 1.5rem;
    }
    .dashboard-header {
      background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%);
      color: white;
      border-radius: 7px;
      padding: 1.2rem 1.5rem;
      margin-bottom: 2rem;
    }
    .status-badge {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85em;
      border-radius: 20px;
      padding: 2px 10px;
      letter-spacing: 1px;
    }
    .status-Reserved    { background: #ffd54f; color: #333; }
    .status-Entered     { background: #90caf9; color: #01357d; }
    .status-Exited      { background: #c8e6c9; color: #06470c; }
    .status-Cancelled, .status-cancelled { background: #ef9a9a; color: #b71c1c; }
    .status-A { background: #43a047; color: white; }
    .status-R { background: #ffd54f; color: #333; }
    .status-O { background: #1976d2; color: white; }
    .table th, .table td { vertical-align: middle !important; }
    .flash-area { position: fixed; top: 75px; right: 18px; z-index: 9999; width: 330px; }
    .brand-logo { font-size: 2rem; vertical-align: middle; color: var(--primary); margin-right: 8px; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a73e8;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <span class="brand-logo"><i class="bi bi-parking"></i></span>
      ParkingPro
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="bi bi-bar-chart"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_reservations.php"><i class="bi bi-table"></i> Bookings</a></li>
        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user'): ?>
          <li class="nav-item"><a class="nav-link" href="user_dashboard.php"><i class="bi bi-house"></i> Home</a></li>
          <li class="nav-item"><a class="nav-link" href="user_history.php"><i class="bi bi-clock-history"></i> History</a></li>
          <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="bi bi-car-front-fill"></i> Cars</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_name'])): ?>
          <li class="nav-item">
            <span class="navbar-text text-white mx-2">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
          </li>
          <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <!-- Flash messages -->
  <div class="flash-area">
    <?php 
    $flash = getFlashMessage();
    if ($flash): 
    ?>
      <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show shadow-sm" role="alert">
        <?php echo htmlspecialchars($flash['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
  </div>
  
  <?php echo $content ?? ''; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(
      alert => new bootstrap.Alert(alert).close()
    );
  }, 3500);
</script>
</body>
</html>
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
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      --dark-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
    .navbar-brand {
      font-weight: 700;
      letter-spacing: 1px;
      font-size: 1.5rem;
    }
    .dashboard-header {
      background: var(--primary-gradient);
      color: white;
      border-radius: 15px;
      padding: 1.5rem 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }
    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
      background: var(--primary-gradient);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    .btn-success {
      background: var(--success-gradient);
      border: none;
      border-radius: 10px;
      font-weight: 600;
    }
    .btn-warning {
      background: var(--warning-gradient);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      color: #333;
    }
    .btn-danger {
      background: var(--danger-gradient);
      border: none;
      border-radius: 10px;
      font-weight: 600;
    }
    .alert {
      border-radius: 12px;
      border: none;
      backdrop-filter: blur(10px);
    }
    .alert-info {
      background: linear-gradient(135deg, rgba(79, 172, 254, 0.2) 0%, rgba(0, 242, 254, 0.2) 100%);
      color: #0c5460;
    }
    .alert-warning {
      background: linear-gradient(135deg, rgba(67, 233, 123, 0.2) 0%, rgba(56, 249, 215, 0.2) 100%);
      color: #0f5132;
    }
    .status-badge {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85em;
      border-radius: 20px;
      padding: 4px 12px;
      letter-spacing: 1px;
    }
    .status-Reserved { background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); color: white; }
    .status-Entered { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .status-Exited { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .status-Cancelled, .status-cancelled { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
    .status-A { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .status-R { background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); color: white; }
    .status-O { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .badge {
      border-radius: 10px;
      font-weight: 600;
    }
    .bg-success { background: var(--success-gradient) !important; }
    .bg-primary { background: var(--primary-gradient) !important; }
    .table {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td { vertical-align: middle !important; border: none; }
    .table thead th {
      background: var(--primary-gradient);
      color: white;
      font-weight: 600;
    }
    .flash-area { position: fixed; top: 75px; right: 18px; z-index: 9999; width: 330px; }
    .brand-logo { font-size: 2rem; vertical-align: middle; color: white; margin-right: 8px; }
    .list-group-item {
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 10px !important;
      margin-bottom: 8px;
      transition: all 0.3s ease;
    }
    .list-group-item:hover {
      background: var(--primary-gradient);
      color: white;
      transform: translateX(5px);
    }
    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 0.9);
    }
    .form-control:focus, .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);">
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
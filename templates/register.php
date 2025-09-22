<?php
$title = "Register · ParkingPro";
ob_start();
?>

<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card p-4 shadow-sm">
      <h3 class="mb-3 text-center text-primary"><i class="bi bi-person-circle"></i> Register</h3>
      <form method="post" novalidate id="register-form">
        <div class="row g-2 mb-2">
          <div class="col"><input type="text" name="name" required class="form-control" placeholder="Full Name" /></div>
          <div class="col"><input type="email" name="email" required class="form-control" placeholder="Email address" /></div>
        </div>
        <div class="mb-2">
          <input type="password" name="password" required minlength="6" class="form-control" placeholder="Password (min 6 chars)" />
        </div>
        <div id="car-section">
          <label class="form-label mt-2 mb-1">Car Numbers</label>
          <div id="car-numbers-container" class="mb-3"></div>
          <button type="button" class="btn btn-outline-secondary mb-2 w-100" id="add-car-btn">+ Add Another Car</button>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById('car-numbers-container');
  const addBtn = document.getElementById('add-car-btn');

  // Add first car input on load
  container.appendChild(makeInput());
  updateRemoveBtns();

  function makeInput(val='') {
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="car_numbers[]" class="form-control" value="${val}" placeholder="Car Number" required>
      <button type="button" class="btn btn-outline-danger btn-remove-car">Remove</button>`;
    return div;
  }
  
  function updateRemoveBtns() {
    const btns = container.querySelectorAll('.btn-remove-car');
    btns.forEach((btn, idx) => btn.style.display = (btns.length === 1) ? 'none' : 'inline-block');
  }
  
  addBtn.onclick = function() {
    container.appendChild(makeInput());
    updateRemoveBtns();
  };
  
  container.addEventListener('click', function(e){
    if(e.target.classList.contains('btn-remove-car')) {
      e.target.parentElement.remove();
      updateRemoveBtns();
    }
  });
});
</script>

<?php
$content = ob_get_clean();
include 'base.php';
?>
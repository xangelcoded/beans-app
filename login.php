<?php
// login.php
require __DIR__ . '/init.php';
include __DIR__ . '/header.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([ $_POST['email'] ]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: pages/dashboard.php');
        exit;
    } else {
        $error = "Oops! That didn’t match our records.";
    }
}
?>

<div class="content pixel-login">
  <div class="pixel-layout">
    <!-- drifting clouds + grass sprites are pure CSS/JS -->

    <!-- Logo & Steam -->
    <div class="pixel-logo-panel">
      <img src="/static/img/pixel-coffee-robot.png" alt="Bean Bot" class="logo">
      <div class="pixel-title">BEANS</div>
      <div class="steam"></div>
    </div>

    <!-- Sign-In Card -->
    <div class="pixel-card">
      <?php if ($error): ?>
        <div class="alert-pixel"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="welcome-msg">🌱 Welcome to BEANS v1.0 🌱</div>

      <form method="post" action="">
        <div class="form-group">
          <input
            type="email"
            name="email"
            placeholder=" EMAIL"
            required
            class="form-control pixel-input"
          >
        </div>
        <div class="form-group">
          <input
            type="password"
            name="password"
            placeholder=" PASSWORD"
            required
            class="form-control pixel-input"
          >
        </div>
        <div class="form-check mb-3 remember-wrap">
  <input
    type="checkbox"
    name="remember"
    id="remember"
    class="pixel-checkbox"
  >
  <label for="remember" class="pixel-checkbox-label">REMEMBER ME</label>
</div>

        <button type="submit" class="btn-pixel pixel-btn">SIGN IN</button>
      </form>

      <a href="#">I FORGOT MY PASSWORD</a>
      <a href="register.php">REGISTER A NEW ACCOUNT</a>
    </div>
  </div>
</div>


<script>
// bean-particle generator (same as before)
document.addEventListener('DOMContentLoaded', () => {
  const layout = document.querySelector('.pixel-layout');
  for (let i = 0; i < 25; i++) {
    const bean = document.createElement('span');
    bean.className = 'bean';
    bean.style.left = Math.random()*100 + 'vw';
    bean.style.animationDuration = 4 + Math.random()*4 + 's';
    bean.style.animationDelay    = -Math.random()*4 + 's';
    layout.appendChild(bean);
  }
});
</script>

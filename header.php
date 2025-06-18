<?php
// require __DIR__ . '/init.php';  
$loggedIn = ! empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>B.E.A.N.S.</title>

  <link rel="manifest" href="/static/manifest.json">
  <meta name="theme-color" content="#6f4e37">

  <!-- Pixel font -->
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet" />

  <!-- Global styles -->
  <link rel="stylesheet" href="/static/css/styles.css">
</head>
<body class="pixel-ui">

<?php if ($loggedIn): ?>
  <header class="pixel-header">
    <div class="logo">
      <a href="/pages/dashboard.php">
        <img src="/static/img/pixel-coffee-robot.png" alt="Bean Bot">
      </a>
    </div>
    <div class="title">Bean Evaluation & Analytics via Neural System</div>
    <div class="action">
      <a href="/pages/scan.php">Scan Now</a>
    </div>
    <nav class="pixel-nav">
      <a href="/pages/dashboard.php">Dashboard</a>
      <a href="/pages/scan.php">Quick Scan</a>
      <a href="/pages/history.php">History</a>
      <a href="/pages/profile.php">Profile</a>
      <a href="/pages/help.php">Help</a>
      <a href="/pages/logout.php" class="btn-logout">Log Out</a>
    </nav>
  </header>
<?php endif; ?>

<div class="content-wrapper">
  <!-- Page content starts here -->

  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/static/js/sw.js')
          .then(reg => console.log('SW registered:', reg.scope))
          .catch(err => console.error('SW reg failed:', err));
      });
    }
  </script>

<?php
// pages/profile.php
require __DIR__ . '/../init.php';
include __DIR__ . '/../header.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$user_id = (int)$_SESSION['user_id'];

// Handle change password
$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password']  ?? '';
    $new     = $_POST['new_password']      ?? '';
    $confirm = $_POST['confirm_password']  ?? '';

    // Fetch current hash
    $stmt = $db->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $hash = $stmt->fetchColumn();

    if (!password_verify($current, $hash)) {
        $errors[] = 'Current password is incorrect.';
    } elseif (strlen($new) < 6) {
        $errors[] = 'New password must be at least 6 characters.';
    } elseif ($new !== $confirm) {
        $errors[] = 'New passwords do not match.';
    }

    if (empty($errors)) {
        $newHash = password_hash($new, PASSWORD_BCRYPT);
        $upd = $db->prepare("
          UPDATE users
             SET password_hash = ?, updated_at = NOW()
           WHERE id = ?
        ");
        $upd->execute([$newHash, $user_id]);
        $success = 'Password updated successfully!';
    }
}

// Fetch user info
$stmt = $db->prepare("SELECT email, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch scan stats
$stmt = $db->prepare("
  SELECT COUNT(*) AS total,
         AVG(confidence) AS avg_conf
    FROM scans
   WHERE user_id = ?
");
$stmt->execute([$user_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="content pixel-ui">
  <div class="pixel-layout">
    <div class="pixel-card">
      <h2>PROFILE</h2>

      <?php if ($success): ?>
        <div class="alert-pixel"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert-error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
      <?php endif; ?>

      <div class="info-row">
        <p>Email:</p>
        <span><?= htmlspecialchars($user['email']) ?></span>
      </div>
      <div class="info-row">
        <p>Joined:</p>
        <span><?= date('Y-m-d', strtotime($user['created_at'])) ?></span>
      </div>
      <div class="info-row">
        <p>Total Scans:</p>
        <span><?= (int)$stats['total'] ?></span>
      </div>
      <div class="info-row">
        <p>Avg Confidence:</p>
        <span><?= number_format($stats['avg_conf'] ?? 0, 2) ?></span>
      </div>

      <button id="togglePwd" class="btn-pixel">Change Password</button>

      <form id="pwdForm" method="post" action="">
        <div class="form-group">
          <input
            type="password"
            name="current_password"
            placeholder="CURRENT PASSWORD"
            class="form-control"
            required
          >
        </div>
        <div class="form-group">
          <input
            type="password"
            name="new_password"
            placeholder="NEW PASSWORD"
            class="form-control"
            required
          >
        </div>
        <div class="form-group">
          <input
            type="password"
            name="confirm_password"
            placeholder="CONFIRM PASSWORD"
            class="form-control"
            required
          >
        </div>
        <input type="hidden" name="change_password" value="1">
        <button type="submit" class="btn-pixel">Update Password</button>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('togglePwd').addEventListener('click', () => {
  const form = document.getElementById('pwdForm');
  form.style.display = form.style.display === 'block' ? 'none' : 'block';
});
</script>

</body>
</html>

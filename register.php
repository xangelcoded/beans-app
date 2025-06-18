<?php
// register.php
require __DIR__ . '/init.php';
include __DIR__ . '/header.php';

$errors = [];
$name  = $_POST['name']  ?? '';
$email = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (trim($name) === '') {
        $errors[] = 'Please enter your name.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email.';
    }
    if (empty($_POST['password']) || empty($_POST['confirm'])) {
        $errors[] = 'Please enter and confirm your password.';
    } elseif ($_POST['password'] !== $_POST['confirm']) {
        $errors[] = 'Passwords do not match.';
    }
    if (empty($_POST['terms'])) {
        $errors[] = 'You must agree to the terms.';
    }

    if (empty($errors)) {
        $pw = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $db->prepare("
          INSERT INTO users (name, email, password_hash, created_at)
          VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$name, $email, $pw]);
        header('Location: login.php');
        exit;
    }
}
?>

<div class="content pixel-ui">
  <div class="pixel-layout">
    <div class="pixel-card">
      <?php if ($errors): ?>
        <div class="alert-pixel"><?= implode('<br>', $errors) ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="form-group">
          <input
            type="text"
            name="name"
            placeholder="NAME"
            value="<?= htmlspecialchars($name) ?>"
            class="form-control"
            required
          >
        </div>

        <div class="form-group">
          <input
            type="email"
            name="email"
            placeholder="EMAIL"
            value="<?= htmlspecialchars($email) ?>"
            class="form-control"
            required
          >
        </div>

        <div class="form-group">
          <input
            id="password"
            name="password"
            type="password"
            placeholder="PASSWORD"
            class="form-control"
            required
          >
        </div>
        <div id="pw-strength"><div></div></div>
        <div id="pw-strength-text">Strength: </div>

        <div class="form-group">
          <input
            id="confirm"
            name="confirm"
            type="password"
            placeholder="CONFIRM PASSWORD"
            class="form-control"
            required
          >
        </div>

        <div class="form-group">
          <label class="form-check-label">
            <input
              type="checkbox"
              name="terms"
              required
            > I agree to the terms and conditions.
          </label>
        </div>

        <button type="submit" class="btn-pixel">REGISTER</button>
      </form>

      <a href="login.php" class="back-link">← Back to Login</a>
    </div>
  </div>
</div>

<script>
// Password strength meter
const pwFld = document.getElementById('password');
const bar   = document.querySelector('#pw-strength > div');
const txt   = document.getElementById('pw-strength-text');

pwFld.addEventListener('input', () => {
  let v = pwFld.value, s = 0;
  if (v.length > 6)        s++;
  if (/[A-Z]/.test(v))      s++;
  if (/[0-9]/.test(v))      s++;
  if (/[@$!%*?&#]/.test(v)) s++;

  let pct = (s / 4) * 100;
  bar.style.width = pct + '%';

  if (s <= 1)       { bar.style.background = '#dc3545'; txt.textContent = 'Strength: WEAK'; }
  else if (s < 4)   { bar.style.background = '#ffc107'; txt.textContent = 'Strength: MEDIUM'; }
  else              { bar.style.background = '#28a745'; txt.textContent = 'Strength: STRONG'; }
});
</script>

</body>
</html>

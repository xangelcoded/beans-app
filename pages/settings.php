<?php
// pages/settings.php
include __DIR__ . '/../header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// Load existing settings or defaults
$stmt = $db->prepare("SELECT default_threshold, offline_enabled, theme FROM settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$threshold     = $settings['default_threshold'] ?? 0.70;
$offline_en    = isset($settings['offline_enabled']) ? (bool)$settings['offline_enabled'] : true;
$current_theme = $settings['theme'] ?? 'Coffee';

$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $threshold     = (float)($_POST['default_threshold'] ?? $threshold);
    $offline_en    = isset($_POST['offline_enabled']) ? 1 : 0;
    $current_theme = in_array($_POST['theme'], ['Light','Coffee']) ? $_POST['theme'] : 'Coffee';

    // Persist
    $up = $db->prepare("
        REPLACE INTO settings (user_id, default_threshold, offline_enabled, theme)
        VALUES (?, ?, ?, ?)
    ");
    if ($up->execute([$user_id, $threshold, $offline_en, $current_theme])) {
        $success = 'Settings saved successfully!';
    } else {
        $errors[] = 'Failed to save settings.';
    }
}
?>
<style>
  :root {
    --latte-cream:   #fff5e6;
    --coffee-brown:  #6f4e37;
    --dark-roast:    #3e2f25;
    --copper-accent: #b87333;
  }
  @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
  *, *::before, *::after {
    box-sizing:border-box; margin:0; padding:0;
    font-family:'Press Start 2P',monospace!important;
  }
  body { background:var(--latte-cream); }
  .content-wrapper { margin:0!important; padding:0!important; }
  .pixel-layout {
    display:flex; justify-content:center; padding:3rem 1rem;
  }
  .pixel-card {
    background:var(--latte-cream); border:3px solid var(--coffee-brown);
    border-radius:12px; box-shadow:8px 8px 0 var(--dark-roast);
    padding:2rem; width:360px; position:relative;
  }
  .pixel-card h2 {
    text-align:center; margin-bottom:1.5rem;
    color:var(--coffee-brown); font-size:1rem;
  }
  .alert-pixel {
    border:2px solid #28a745; background:rgba(40,167,69,0.1);
    padding:.75rem; margin-bottom:1rem; text-align:center;
    font-size:.75rem;
  }
  .alert-error {
    border:2px solid #dc3545; background:rgba(220,53,69,0.1);
    padding:.75rem; margin-bottom:1rem; text-align:center;
    font-size:.75rem;
  }
  .form-group { margin-bottom:1.25rem; }
  .form-group label {
    display:block; margin-bottom:.5rem; font-size:.75rem;
    color:var(--coffee-brown);
  }
  .form-group input[type="range"] {
    width:100%;
  }
  .form-group input[type="checkbox"] {
    transform:scale(1.2); margin-right:.5rem;
  }
  .form-group select, .form-group input[type="range"] {
    background:#fff8e7; border:3px solid var(--coffee-brown);
    border-radius:6px; box-shadow:inset 2px 2px 0 var(--copper-accent);
    padding:.4rem; font-size:.75rem; width:100%;
  }
  .btn-pixel {
    width:100%; padding:.75rem; background:var(--coffee-brown);
    color:var(--latte-cream); border:3px solid var(--dark-roast);
    border-radius:6px; box-shadow:4px 4px 0 var(--dark-roast);
    text-transform:uppercase; font-size:.8rem; transition:transform .1s;
    cursor:pointer;
  }
  .btn-pixel:hover { transform:translate(2px,2px); }
  #threshVal { text-align:right; font-size:.75rem; color:var(--dark-roast); }
</style>

<div class="content pixel-ui">
  <div class="pixel-layout">
    <div class="pixel-card">
      <h2>SETTINGS</h2>

      <?php if ($success): ?>
        <div class="alert-pixel"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert-error"><?= implode('<br>', $errors) ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="form-group">
          <label for="default_threshold">Default Threshold: <span id="threshVal"><?= number_format($threshold,2) ?></span></label>
          <input type="range" name="default_threshold" id="default_threshold"
                 min="0" max="1" step="0.01" value="<?= htmlspecialchars($threshold) ?>">
        </div>

        <div class="form-group">
          <label>
            <input type="checkbox" name="offline_enabled" <?= $offline_en ? 'checked' : '' ?>>
            Enable Offline Mode
          </label>
        </div>

        <div class="form-group">
          <label for="theme">Theme</label>
          <select name="theme" id="theme">
            <option value="Coffee" <?= $current_theme==='Coffee'?'selected':'' ?>>Coffee</option>
            <option value="Light"  <?= $current_theme==='Light' ?'selected':'' ?>>Light</option>
          </select>
        </div>

        <button type="submit" class="btn-pixel">Save Settings</button>
      </form>
    </div>
  </div>
</div>

<script>
  const range = document.getElementById('default_threshold');
  const val   = document.getElementById('threshVal');
  range.addEventListener('input', () => {
    val.textContent = parseFloat(range.value).toFixed(2);
  });
</script>

<?php include __DIR__ . '/../footer.php'; ?>

<?php
// pages/scan.php
require __DIR__ . '/../init.php';
include __DIR__ . '/../header.php';

// 1) Ensure user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$user_id = (int)$_SESSION['user_id'];

// 2) Threshold from POST or default
$user_thresh = isset($_POST['threshold'])
    ? (float)$_POST['threshold']
    : 0.5;

$result = null;
$error  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3) Upload validation
    if (!isset($_FILES['bean_img']) || $_FILES['bean_img']['error'] !== UPLOAD_ERR_OK) {
        $error = 'Upload error: ' . ($_FILES['bean_img']['error'] ?? 'No file');
    } elseif (!@getimagesize($_FILES['bean_img']['tmp_name'])) {
        $error = 'Invalid image file.';
    } else {
        // 4) Move upload
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['bean_img']['name']);
        $dest     = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['bean_img']['tmp_name'], $dest)) {
            // 5) Run classifier
            $cmd = sprintf(
                'python %s %s %s 2>&1',
                escapeshellarg(__DIR__ . '/../classify.py'),
                escapeshellarg($dest),
                escapeshellarg((string)$user_thresh)
            );
            $out = shell_exec($cmd);
            if ($out === null) {
                $error = 'Failed to run classifier.';
            } else {
                $lines = array_filter(preg_split('/\r\n|\r|\n/', trim($out)));
                $json  = array_pop($lines) ?: '';
                $res   = json_decode($json, true);
                if (!$res || !isset($res['label'], $res['confidence'])) {
                    $error = 'Invalid response from classifier:<br><pre>'
                           . htmlspecialchars($out)
                           . '</pre>';
                } else {
                    // 6) Verdict & save
                    $label      = $res['label'];
                    $confidence = (float)$res['confidence'];
                    $verdict    = $confidence >= $user_thresh
                                ? $label
                                : 'Uncertain';

                    $stmt = $db->prepare("
                      INSERT INTO scans
                        (user_id, image_path, label, confidence, verdict, scanned_at)
                      VALUES
                        (?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([
                        $user_id,
                        'uploads/'.$filename,
                        $label,
                        $confidence,
                        $verdict
                    ]);

                    $result = [
                        'label'      => $label,
                        'confidence' => $confidence,
                        'verdict'    => $verdict
                    ];
                }
            }
        } else {
            $error = 'Could not save uploaded file.';
        }
    }
}
?>

<div class="content pixel-ui">
  <div class="dashboard">

    <!-- Floating coffee capture icon -->
    <div class="capture-icon">
      <img src="/static/img/coffee-cup.png" alt="Capture">
    </div>

    <h2 class="page-title">Quick Scan</h2>

    <form method="POST" enctype="multipart/form-data" id="scanForm">
      <!-- A) Styled file chooser -->
      <div class="form-group pixel-file-group">
        <input
          type="file"
          id="bean_img"
          name="bean_img"
          accept="image/*"
          capture="environment"
          required
          class="pixel-file-input"
        >
        <label for="bean_img" class="pixel-file-button">Choose Bean Image</label>
        <span class="pixel-file-name" id="fileName">No file chosen</span>
      </div>

      <!-- B) Threshold slider & simple multi-line guide -->
      <div class="form-group slider-container">
        <label>Threshold
          <span class="tooltip-icon" data-tooltip="Slide left for more guesses or slide right to only see very sure results.">?</span>
        </label>
        <input
          type="range"
          name="threshold"
          min="0"
          max="1"
          step="0.01"
          value="<?= htmlspecialchars($user_thresh) ?>"
          oninput="this.nextElementSibling.textContent = this.value"
          class="pixel-slider"
        >
        <div class="slider-value"><?= htmlspecialchars($user_thresh) ?></div>
      </div>

      <button type="submit" class="btn-pixel">Classify Bean</button>
    </form>

    <?php if ($error): ?>
      <div class="alert-pixel alert-defective"><?= $error ?></div>
    <?php elseif ($result): ?>
  <div class="alert-pixel alert-<?= strtolower($result['verdict']) ?>">
    <strong><?= htmlspecialchars($result['verdict']) ?></strong><br>
    Confidence: <?= round($result['confidence']*100,1) ?>%
  </div>

  <!-- Show Grad-CAM Heatmap -->
  <div class="heatmap-box">
    <h4>Model Focus (Grad-CAM Heatmap)</h4>
    <img src="data:image/png;base64,<?= $res['heatmap'] ?>" alt="Heatmap" style="max-width:300px; width:100%; border-radius:8px;">

  </div>

  <!-- Show Class Probabilities -->
  <?php if (isset($res['probs']) && is_array($res['probs'])): ?>
    <div class="heatmap-box" style="margin-top: 1.5em;">
      <h4>🧠 Prediction Breakdown</h4>
      <ul style="list-style:none;padding:0;margin:0;text-align:left;max-width:300px;margin:auto;">
        <?php foreach ($res['probs'] as $k => $v): ?>
          <li>
            <strong><?= ucfirst(htmlspecialchars($k)) ?>:</strong>
            <?= round($v * 100, 1) ?>%
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
<?php endif; ?>



    <!-- C) Gamey App Facts -->
    <div class="app-facts">
      <h3 class="facts-title">🖥️ Model Facts</h3>
      <ul class="facts-list">
        <li>Built on EfficientNet-B3, a fast image-recognition network that was pre-trained on millions of photos.</li>
    <li>Fine-tuned on about 20 000 coffee-bean pictures, grouped into Good, Ripe, Underripe, and Defective.</li>
    <li>Uses random flips, rotations, zooms, brightness and contrast tweaks during training to handle real-world variations.</li>
    <li>Balances rare vs. common bean types automatically so it learns each class equally well.</li>
    <li>Achieves around 95 % accuracy when tested on new bean photos it hasn’t seen before.</li>
    <li>Exported to a tiny, quantized file (~3 MB) so it runs on your device in under 200 ms—no internet required.</li>
      </ul>
    </div>

  </div>
</div>

<!-- Spinner overlay -->
<div class="spinner-overlay" id="spinner">
  <img src="/static/img/spinner.png" alt="Loading…" class="spinner">
</div>


<script>
// update file name display
document.getElementById('bean_img').addEventListener('change', e => {
  const name = e.target.files[0]?.name || 'No file chosen';
  document.getElementById('fileName').textContent = name;
});

// falling bean particles + spinner show
document.addEventListener('DOMContentLoaded', () => {
  const dash = document.querySelector('.dashboard');
  for (let i = 0; i < 15; i++) {
    const bean = document.createElement('span');
    bean.className = 'bean';
    bean.style.left = Math.random()*100 + 'vw';
    bean.style.animationDuration = 3 + Math.random()*4 + 's';
    bean.style.animationDelay    = -Math.random()*4 + 's';
    dash.appendChild(bean);
  }
  document.getElementById('scanForm')
          .addEventListener('submit', () => {
    document.getElementById('spinner').style.display = 'flex';
  });
});
</script>

<!-- <form id="multiForm" enctype="multipart/form-data">
  <input type="file" name="img" accept="image/*" required>
  <label>Threshold:
    <input type="range" name="threshold" min="0" max="1" step="0.01" value="0.5">
  </label>
  <button type="submit">Scan Multi-Bean</button>
</form>

<canvas id="beanCanvas" width="640" height="480"></canvas>
<div id="beanInfo" style="margin-top:.5em;color:#fff;"></div>
<canvas id="aggChart" width="260" height="260" style="margin-top:1em;"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
  import { initViewer } from '/static/js/multi_bean.js';
  const viewer = initViewer('beanCanvas','beanInfo','aggChart');
  document.getElementById('multiForm').onsubmit = async e => {
    e.preventDefault();
    const fd = new FormData(e.target);
    const res = await fetch('/api/scan_multi.php', { method:'POST', body:fd });
    const j = await res.json();
    if(j.error) return alert(j.error);
    viewer.load(URL.createObjectURL(fd.get('img')), j);
  };
</script> -->


<!-- Crop Tool for Beans -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>

<script>
const beanInput = document.getElementById('bean_img');
let cropper;
beanInput.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;

  const img = document.createElement('img');
  img.src = URL.createObjectURL(file);
  img.style.maxWidth = '100%';
  img.onload = () => {
    const modal = document.createElement('div');
    modal.style = 'position:fixed;top:0;left:0;width:100%;height:100%;background:#000a;display:flex;align-items:center;justify-content:center;z-index:9999;';
    modal.innerHTML = '<div style="background:white;padding:1em;border-radius:10px;max-width:90%;max-height:90%;overflow:auto;"><h3>Crop the Bean</h3></div>';
    const container = modal.querySelector('div');
    container.appendChild(img);
    const btn = document.createElement('button');
    btn.textContent = 'Done Cropping';
    btn.style = 'margin-top:1em;';
    container.appendChild(btn);
    document.body.appendChild(modal);

    cropper = new Cropper(img, {
      aspectRatio: 1,
      viewMode: 1,
    });

    btn.onclick = () => {
      const canvas = cropper.getCroppedCanvas();
      canvas.toBlob(blob => {
        const dt = new DataTransfer();
        dt.items.add(new File([blob], file.name));
        beanInput.files = dt.files;
        document.body.removeChild(modal);
      }, 'image/jpeg');
    };
  };
});
</script>



</body>
</html>
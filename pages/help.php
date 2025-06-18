<?php
// pages/help.php
require __DIR__ . '/../init.php';
include __DIR__ . '/../header.php';
?>

<div class="content pixel-ui">
  <div class="help-container">
    <div class="help-title">Help &amp; PWA Setup</div>

    <div class="help-panel">
      <details>
        <summary>☕ How to Scan</summary>
        <div class="panel-content">
          <ol>
            <li>Go to the “Quick Scan” page.</li>
            <li>Allow camera access if prompted.</li>
            <li>Position beans under the frame until it turns green.</li>
            <li>Press “Scan Now” and review your results.</li>
          </ol>
          <img src="/static/img/scan-step1.png" alt="Scan Step 1" class="help-img">
        </div>
      </details>
    </div>

    <div class="help-panel">
      <details>
        <summary>📊 Understanding Results</summary>
        <div class="panel-content">
          <ul>
            <li><strong>Label:</strong> Detected class (Good / Ripe / …).</li>
            <li><strong>Confidence:</strong> Model certainty score.</li>
            <li><strong>Verdict:</strong> Final recommendation.</li>
          </ul>
          <img src="/static/img/results-demo.png" alt="Results Demo" class="help-img">
        </div>
      </details>
    </div>

    <div class="help-panel">
      <details>
        <summary>🐞 Troubleshooting</summary>
        <div class="panel-content">
          <ul>
            <li>No camera detected? Check your browser permissions.</li>
            <li>Scan is slow? Try toggling “offline mode” in Settings.</li>
            <li>Getting “Uncertain”? Increase your default threshold.</li>
          </ul>
          <img src="/static/img/troubleshoot.png" alt="Troubleshooting" class="help-img">
        </div>
      </details>
    </div>

    <div class="help-panel">
      <details>
        <summary>📲 PWA Setup</summary>
        <div class="panel-content">
          <ol>
            <li>Add to home screen when prompted.</li>
            <li>Use the app offline thanks to our Service Worker.</li>
            <li>Revisit “Quick Scan” without a network—everything is cached.</li>
            <li>Confirm you see <code>sw.js</code> registered in DevTools → Application.</li>
          </ol>
          <img src="/static/img/pwa-setup.png" alt="PWA Setup" class="help-img">
        </div>
      </details>
    </div>

  </div>
</div>
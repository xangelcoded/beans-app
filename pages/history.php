<?php
// pages/history.php
require __DIR__ . '/../init.php';
include __DIR__ . '/../header.php';

// ─── Filter inputs ───────────────────────────────────────────
$from  = $_GET['from']  ?? date('Y-m-d', strtotime('-7 days'));
$to    = $_GET['to']    ?? date('Y-m-d');
$class = $_GET['class'] ?? 'All';

// ─── Query ────────────────────────────────────────────────────
$labelFilter = ($class === 'All') ? '%' : $class;
$stmt = $db->prepare("
  SELECT id, image_path, label, scanned_at
    FROM scans
   WHERE DATE(scanned_at) BETWEEN ? AND ?
     AND label LIKE ?
   ORDER BY scanned_at DESC
");
$stmt->execute([$from, $to, $labelFilter]);
$scans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content pixel-ui">
  <div class="dashboard history">

    <!-- A) Floating coffee-cup -->
    <div class="capture-icon">
      <img src="/static/img/history.png" alt="Capture">
    </div>

    <!-- B) Page title -->
    <h2 class="page-title">History</h2>

    <!-- C) Sticky filters -->
    <div class="filters-wrap">
      <div class="filters">
        <form method="get" id="filterForm">
          <label>
            From
            <input type="date"
                   name="from"
                   value="<?= htmlspecialchars($from) ?>"
                   class="pixel-input">
          </label>
          <label>
            To
            <input type="date"
                   name="to"
                   value="<?= htmlspecialchars($to) ?>"
                   class="pixel-input">
          </label>
          <label>
            Class
            <select name="class" class="pixel-input">
              <?php foreach (['All','Good','Ripe','Underripe','Defective'] as $opt): ?>
                <option value="<?= $opt ?>"
                  <?= $class === $opt ? 'selected' : '' ?>>
                  <?= $opt ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>
          <button type="submit" class="btn-pixel">Apply</button>
        </form>
      </div>
    </div>

    <!-- D) Result count -->
    <div class="result-count">
      Showing <?= count($scans) ?> scan<?= count($scans) === 1 ? '' : 's' ?>
    </div>

    <!-- E) Scrollable, pixel-framed table -->
    <div class="history-table-wrap">
      <table id="historyTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Preview</th>
            <th>Label</th>
            <th>Scanned At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($scans as $i => $row):
            $path = '/' . ltrim($row['image_path'], '/');
          ?>
          <tr
            data-path="<?= htmlspecialchars($path) ?>"
            data-label="<?= htmlspecialchars($row['label']) ?>"
            data-date="<?= htmlspecialchars($row['scanned_at']) ?>"
          >
            <td><?= $i + 1 ?></td>
            <td>
              <img src="<?= htmlspecialchars($path) ?>"
                   class="thumb"
                   alt="Scan <?= $i + 1 ?>">
            </td>
            <td class="label-cell"
                data-icon="<?= strtolower($row['label']) ?>">
              <?= htmlspecialchars($row['label']) ?>
            </td>
            <td><?= htmlspecialchars($row['scanned_at']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<!-- G) Modal for full-size scan -->
<div class="modal" id="scanModal">
  <div class="modal-content">
    <div class="close">✕</div>
    <img src="" id="modalImg" alt="Scan">
    <p id="modalLabel"></p>
    <p id="modalDate"></p>
  </div>
</div>

<!-- H) Spinner overlay -->
<div class="spinner-overlay" id="spinner">
  <img src="/static/img/spinner.png" alt="Loading…" class="spinner">
</div>

<!-- I) DataTables & jQuery -->
<link
  rel="stylesheet"
  href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script
  src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"
></script>

<!-- … after your DataTables & jQuery includes … -->
<script>
$(function(){
  // 1) Falling beans
  const dash = document.querySelector('.dashboard.history');
  for (let i = 0; i < 15; i++) {
    const bean = document.createElement('span');
    bean.className = 'bean';
    bean.style.left = Math.random()*100 + 'vw';
    bean.style.animationDuration = 3 + Math.random()*3 + 's';
    bean.style.animationDelay    = -Math.random()*3 + 's';
    dash.appendChild(bean);
  }

  // 2) DataTable init
  $('#historyTable').DataTable({
    paging:    false,
    searching: false,
    info:      false,
    order:     [[3,'desc']]
  });

  // 3) Show spinner when filtering
  $('#filterForm').on('submit', () => {
    $('#spinner').show();
  });

  // 4) Row click → open modal
  $('#historyTable tbody').on('click','tr', function(){
    const path  = $(this).data('path'),
          label = $(this).data('label'),
          date  = $(this).data('date');
    $('#modalImg').attr('src', path);
    $('#modalLabel').text('Label: '+label);
    $('#modalDate').text('Scanned at: '+date);
    $('#scanModal').addClass('show');
  });

  // 5) Close modal on ✕ or outside click
  $('.modal .close').on('click', function(){
    $('#scanModal').removeClass('show');
  });
  $('#scanModal').on('click', function(e){
    if (e.target.id === 'scanModal') {
      $(this).removeClass('show');
    }
  });
});  /* <-- make sure this is the only closing for $(function()) */
</script>

</script>

</body>
</html>

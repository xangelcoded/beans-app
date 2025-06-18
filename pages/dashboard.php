<?php
// pages/dashboard.php
require __DIR__ . '/../init.php';
include __DIR__ . '/../header.php';

// Fetch totals
$total      = (int)$db->query("SELECT COUNT(*) FROM scans")->fetchColumn();
$goodCount  = (int)$db->query("SELECT COUNT(*) FROM scans WHERE label='Good'")->fetchColumn();
$ripeCount  = (int)$db->query("SELECT COUNT(*) FROM scans WHERE label='Ripe'")->fetchColumn();
$underCount = (int)$db->query("SELECT COUNT(*) FROM scans WHERE label='Underripe'")->fetchColumn();
$defCount   = (int)$db->query("SELECT COUNT(*) FROM scans WHERE label='Defective'")->fetchColumn();

// Build 7-day trend
$trendLabels = [];
$trendData   = [];
for ($i = 6; $i >= 0; $i--) {
    $day = date('Y-m-d', strtotime("-{$i} days"));
    $trendLabels[] = $day;
    $stmt = $db->prepare("SELECT COUNT(*) FROM scans WHERE DATE(scanned_at)=?");
    $stmt->execute([$day]);
    $trendData[] = (int)$stmt->fetchColumn();
}

// Distribution arrays
$distLabels = ['Good','Ripe','Underripe','Defective'];
$distData   = [$goodCount, $ripeCount, $underCount, $defCount];
?>

<div class="content pixel-ui">
  <div class="dashboard">
    <div class="info-grid">
      <div class="info-box">
        <p>Total Scans</p>
        <h3><?= $total ?></h3>
      </div>
      <div class="info-box">
        <p>Good</p>
        <h3><?= $goodCount ?></h3>
      </div>
      <div class="info-box">
        <p>Ripe</p>
        <h3><?= $ripeCount ?></h3>
      </div>
      <div class="info-box">
        <p>Underripe</p>
        <h3><?= $underCount ?></h3>
      </div>
      <div class="info-box">
        <p>Defective</p>
        <h3><?= $defCount ?></h3>
      </div>
    </div>

    <div class="charts">
      <div class="chart-card">
        <p>Scans in Last 7 Days</p>
        <canvas id="trendChart"></canvas>
      </div>
      <div class="chart-card">
        <p>Bean Class Distribution</p>
        <canvas id="distChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // 7-day trend line
  new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
      labels: <?= json_encode($trendLabels) ?>,
      datasets: [{
        data: <?= json_encode($trendData) ?>,
        borderColor: '#6F4E37',
        backgroundColor: 'rgba(111,78,55,0.2)',
        tension: 0.4,
        pointBackgroundColor: '#6F4E37',
        pointRadius: 5
      }]
    },
    options: {
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 10 } } },
        y: { beginAtZero: true, ticks: { font: { size: 10 } } }
      },
      plugins: { legend: { display: false } }
    }
  });

  // Pie distribution
  new Chart(document.getElementById('distChart'), {
    type: 'pie',
    data: {
      labels: <?= json_encode($distLabels) ?>,
      datasets: [{
        data: <?= json_encode($distData) ?>,
        backgroundColor: ['#28a745','#ffc107','#ffd54f','#dc3545']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { boxWidth:12, font:{ size:10 } }
        }
      }
    }
  });
</script>

</body>
</html>
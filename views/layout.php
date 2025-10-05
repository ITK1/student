<?php
// Layout cơ bản Bootstrap từ CDN để giao diện dễ nhìn
// Thêm Bootstrap Icons + thanh menu có trạng thái active + footer đơn giản
$flash = flash_get();
$current = isset($_GET['r']) ? (string)$_GET['r'] : 'home/index';
$currentController = explode('/', $current)[0] ?? 'home';
?><!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; }
        .container { max-width: 1024px; }
        a { text-decoration: none; }
        footer { margin-top: 32px; padding: 16px 0; color: #6c757d; border-top: 1px solid #eee; }
    </style>
    </head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= h(base_url('index.php')) ?>"><i class="bi bi-building"></i> Ký túc xá</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link <?= $currentController==='students'?'active':'' ?>" href="<?= h(base_url('index.php?r=students/index')) ?>"><i class="bi bi-mortarboard"></i> Sinh viên</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentController==='rooms'?'active':'' ?>" href="<?= h(base_url('index.php?r=rooms/index')) ?>"><i class="bi bi-door-closed"></i> Phòng</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentController==='contracts'?'active':'' ?>" href="<?= h(base_url('index.php?r=contracts/index')) ?>"><i class="bi bi-file-text"></i> Hợp đồng</a></li>
      </ul>
    </div>
  </div>
  </nav>

<div class="container mt-3">
  <?php if ($flash): ?>
    <div class="alert alert-<?= h($flash['type']) ?>"><?= h($flash['message']) ?></div>
  <?php endif; ?>
  <?= $content ?? '' ?>
</div>

<div class="container">
  <footer>
    <div class="d-flex justify-content-between small">
      <span><?= h(APP_NAME) ?></span>
      <span>Xây dựng bằng PHP + PDO + Bootstrap</span>
    </div>
  </footer>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<div class="d-flex justify-content-between align-items-center mb-3">
  <h4><i class="bi bi-people"></i> Danh sách sinh viên</h4>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-secondary" href="<?= h(base_url('index.php?r=students/exportCsv&q=' . urlencode($q ?? ''))) ?>"><i class="bi bi-download"></i> CSV</a>
    <a class="btn btn-primary" href="<?= h(base_url('index.php?r=students/create')) ?>"><i class="bi bi-plus-lg"></i> Thêm</a>
  </div>
  
</div>

<form class="row g-2 mb-3" method="get" action="<?= h(base_url('index.php')) ?>">
  <input type="hidden" name="r" value="students/index">
  <div class="col-auto">
    <input class="form-control" type="text" name="q" value="<?= h($q ?? '') ?>" placeholder="Tìm mã, tên, email">
  </div>
  <div class="col-auto"><button class="btn btn-outline-secondary">Tìm</button></div>
</form>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Mã SV</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Điện thoại</th>
        <th>Giới tính</th>
        <th>Ngày sinh</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= h($s['id']) ?></td>
        <td><?= h($s['student_code']) ?></td>
        <td><?= h($s['full_name']) ?></td>
        <td><?= h($s['email']) ?></td>
        <td><?= h($s['phone']) ?></td>
        <td><?= h($s['gender']) ?></td>
        <td><?= h($s['dob']) ?></td>
        <td class="text-nowrap">
          <a class="btn btn-sm btn-info" href="<?= h(base_url('index.php?r=students/show&id=' . $s['id'])) ?>"><i class="bi bi-eye"></i></a>
          <a class="btn btn-sm btn-warning" href="<?= h(base_url('index.php?r=students/edit&id=' . $s['id'])) ?>"><i class="bi bi-pencil-square"></i></a>
          <a class="btn btn-sm btn-danger" href="<?= h(base_url('index.php?r=students/delete&id=' . $s['id'])) ?>" onclick="return confirm('Xóa?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php
// Phân trang đơn giản
$totalPages = (int)ceil(($total ?? 0) / ($perPage ?? 10));
if ($totalPages > 1): ?>
<nav aria-label="pagination">
  <ul class="pagination">
    <?php for ($i=1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= ($page===$i)?'active':'' ?>">
        <a class="page-link" href="<?= h(base_url('index.php?r=students/index&q=' . urlencode($q ?? '') . '&page=' . $i)) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>


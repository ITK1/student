<div class="d-flex justify-content-between align-items-center mb-3">
  <h4><i class="bi bi-file-text"></i> Hợp đồng xếp phòng</h4>
  <a class="btn btn-primary" href="<?= h(base_url('index.php?r=contracts/create')) ?>"><i class="bi bi-plus-lg"></i> Tạo hợp đồng</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Mã SV</th>
        <th>Tên SV</th>
        <th>Phòng</th>
        <th>Từ ngày</th>
        <th>Đến ngày</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($contracts as $c): ?>
      <tr>
        <td><?= h($c['id']) ?></td>
        <td><?= h($c['student_code']) ?></td>
        <td><?= h($c['student_name']) ?></td>
        <td><?= h($c['room_code']) ?></td>
        <td><?= h($c['start_date']) ?></td>
        <td><?= h($c['end_date']) ?></td>
        <td class="text-nowrap">
          <?php if (empty($c['end_date'])): ?>
            <a class="btn btn-sm btn-outline-secondary" href="<?= h(base_url('index.php?r=contracts/end&id=' . $c['id'])) ?>" onclick="return confirm('Kết thúc hợp đồng hôm nay?')"><i class="bi bi-stop-circle"></i></a>
          <?php endif; ?>
          <a class="btn btn-sm btn-danger" href="<?= h(base_url('index.php?r=contracts/delete&id=' . $c['id'])) ?>" onclick="return confirm('Xóa hợp đồng?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>


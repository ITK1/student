<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title"><i class="bi bi-person-badge"></i> Thông tin sinh viên</h5>
    <div class="row">
      <div class="col-md-6">
        <div><strong>Mã SV:</strong> <?= h($student['student_code']) ?></div>
        <div><strong>Họ tên:</strong> <?= h($student['full_name']) ?></div>
        <div><strong>Email:</strong> <?= h($student['email']) ?></div>
      </div>
      <div class="col-md-6">
        <div><strong>Điện thoại:</strong> <?= h($student['phone']) ?></div>
        <div><strong>Giới tính:</strong> <?= h($student['gender']) ?></div>
        <div><strong>Ngày sinh:</strong> <?= h($student['dob']) ?></div>
      </div>
    </div>
  </div>
</div>

<h5><i class="bi bi-clock-history"></i> Hợp đồng đã ký</h5>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th><th>Phòng</th><th>Từ ngày</th><th>Đến ngày</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($contracts as $c): ?>
      <tr>
        <td><?= h($c['id']) ?></td>
        <td><?= h($c['room_code']) ?></td>
        <td><?= h($c['start_date']) ?></td>
        <td><?= h($c['end_date']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<a class="btn btn-secondary" href="<?= h(base_url('index.php?r=students/index')) ?>">Quay lại</a>





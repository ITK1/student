<h4>Tạo hợp đồng xếp phòng</h4>
<form method="post" action="<?= h(base_url('index.php?r=contracts/store')) ?>" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Sinh viên</label>
    <select class="form-select" name="student_id">
      <option value="">-- Chọn sinh viên --</option>
      <?php foreach ($students as $s): ?>
      <option value="<?= h($s['id']) ?>"><?= h($s['student_code'] . ' - ' . $s['full_name']) ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['student_id'])): ?><div class="text-danger small"><?= h($errors['student_id']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Phòng</label>
    <select class="form-select" name="room_id">
      <option value="">-- Chọn phòng --</option>
      <?php foreach ($rooms as $r): ?>
      <option value="<?= h($r['id']) ?>"><?= h($r['room_code']) ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['room_id'])): ?><div class="text-danger small"><?= h($errors['room_id']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-4">
    <label class="form-label">Từ ngày</label>
    <input type="date" class="form-control" name="start_date">
    <?php if (!empty($errors['start_date'])): ?><div class="text-danger small"><?= h($errors['start_date']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-4">
    <label class="form-label">Đến ngày (có thể để trống)</label>
    <input type="date" class="form-control" name="end_date">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Tạo</button>
    <a class="btn btn-secondary" href="<?= h(base_url('index.php?r=contracts/index')) ?>">Hủy</a>
  </div>
</form>





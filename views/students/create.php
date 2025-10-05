<h4>Thêm sinh viên</h4>
<form method="post" action="<?= h(base_url('index.php?r=students/store')) ?>" class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Mã sinh viên</label>
    <input class="form-control" name="student_code" value="<?= h($old['student_code'] ?? '') ?>">
    <?php if (!empty($errors['student_code'])): ?><div class="text-danger small"><?= h($errors['student_code']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-8">
    <label class="form-label">Họ và tên</label>
    <input class="form-control" name="full_name" value="<?= h($old['full_name'] ?? '') ?>">
    <?php if (!empty($errors['full_name'])): ?><div class="text-danger small"><?= h($errors['full_name']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input class="form-control" name="email" value="<?= h($old['email'] ?? '') ?>">
    <?php if (!empty($errors['email'])): ?><div class="text-danger small"><?= h($errors['email']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Điện thoại</label>
    <input class="form-control" name="phone" value="<?= h($old['phone'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Giới tính</label>
    <select class="form-select" name="gender">
      <option value="">-- Chọn --</option>
      <option value="male">Nam</option>
      <option value="female">Nữ</option>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Ngày sinh</label>
    <input type="date" class="form-control" name="dob" value="<?= h($old['dob'] ?? '') ?>">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Lưu</button>
    <a class="btn btn-secondary" href="<?= h(base_url('index.php?r=students/index')) ?>">Hủy</a>
  </div>
</form>





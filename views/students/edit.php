<h4>Sửa sinh viên</h4>
<form method="post" action="<?= h(base_url('index.php?r=students/update')) ?>" class="row g-3">
  <input type="hidden" name="id" value="<?= h($student['id']) ?>">
  <div class="col-md-4">
    <label class="form-label">Mã sinh viên</label>
    <input class="form-control" name="student_code" value="<?= h($student['student_code']) ?>">
    <?php if (!empty($errors['student_code'])): ?><div class="text-danger small"><?= h($errors['student_code']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-8">
    <label class="form-label">Họ và tên</label>
    <input class="form-control" name="full_name" value="<?= h($student['full_name']) ?>">
    <?php if (!empty($errors['full_name'])): ?><div class="text-danger small"><?= h($errors['full_name']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input class="form-control" name="email" value="<?= h($student['email']) ?>">
    <?php if (!empty($errors['email'])): ?><div class="text-danger small"><?= h($errors['email']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Điện thoại</label>
    <input class="form-control" name="phone" value="<?= h($student['phone']) ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Giới tính</label>
    <select class="form-select" name="gender">
      <option value="">-- Chọn --</option>
      <option value="male" <?= $student['gender']==='male'?'selected':'' ?>>Nam</option>
      <option value="female" <?= $student['gender']==='female'?'selected':'' ?>>Nữ</option>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Ngày sinh</label>
    <input type="date" class="form-control" name="dob" value="<?= h($student['dob']) ?>">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Cập nhật</button>
    <a class="btn btn-secondary" href="<?= h(base_url('index.php?r=students/index')) ?>">Hủy</a>
  </div>
</form>





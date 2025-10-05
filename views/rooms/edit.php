<h4>Sửa phòng</h4>
<form method="post" action="<?= h(base_url('index.php?r=rooms/update')) ?>" class="row g-3">
  <input type="hidden" name="id" value="<?= h($room['id']) ?>">
  <div class="col-md-4">
    <label class="form-label">Mã phòng</label>
    <input class="form-control" name="room_code" value="<?= h($room['room_code']) ?>">
    <?php if (!empty($errors['room_code'])): ?><div class="text-danger small"><?= h($errors['room_code']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-4">
    <label class="form-label">Sức chứa</label>
    <input class="form-control" name="capacity" type="number" min="1" value="<?= h($room['capacity']) ?>">
    <?php if (!empty($errors['capacity'])): ?><div class="text-danger small"><?= h($errors['capacity']) ?></div><?php endif; ?>
  </div>
  <div class="col-md-4">
    <label class="form-label">Giới tính</label>
    <select class="form-select" name="gender">
      <option value="" <?= $room['gender']===''?'selected':'' ?>>-- Bất kỳ --</option>
      <option value="male" <?= $room['gender']==='male'?'selected':'' ?>>Nam</option>
      <option value="female" <?= $room['gender']==='female'?'selected':'' ?>>Nữ</option>
    </select>
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Cập nhật</button>
    <a class="btn btn-secondary" href="<?= h(base_url('index.php?r=rooms/index')) ?>">Hủy</a>
  </div>
</form>





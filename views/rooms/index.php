<div class="d-flex justify-content-between align-items-center mb-3">
  <h4><i class="bi bi-door-closed"></i> Danh sách phòng</h4>
  <a class="btn btn-primary" href="<?= h(base_url('index.php?r=rooms/create')) ?>"><i class="bi bi-plus-lg"></i> Thêm</a>
</div>

<form class="row g-2 mb-3" method="get" action="<?= h(base_url('index.php')) ?>">
  <input type="hidden" name="r" value="rooms/index">
  <div class="col-auto">
    <select name="gender" class="form-select">
      <option value="" <?= ($gender??'')===''?'selected':'' ?>>Tất cả</option>
      <option value="male" <?= ($gender??'')==='male'?'selected':'' ?>>Nam</option>
      <option value="female" <?= ($gender??'')==='female'?'selected':'' ?>>Nữ</option>
    </select>
  </div>
  <div class="col-auto">
    <button class="btn btn-outline-secondary"><i class="bi bi-funnel"></i> Lọc</button>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Mã phòng</th>
        <th>Sức chứa</th>
        <th>Giới tính</th>
        <th>Đang ở / Sức chứa</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rooms as $r): ?>
      <tr>
        <td><?= h($r['id']) ?></td>
        <td><?= h($r['room_code']) ?></td>
        <td><?= h($r['capacity']) ?></td>
        <td><?= h($r['gender']) ?></td>
        <td><span class="badge bg-<?= ($r['occupancy']>=$r['capacity'])?'danger':'success' ?>"><?= h(($r['occupancy']??0) . ' / ' . $r['capacity']) ?></span></td>
        <td class="text-nowrap">
          <a class="btn btn-sm btn-warning" href="<?= h(base_url('index.php?r=rooms/edit&id=' . $r['id'])) ?>"><i class="bi bi-pencil-square"></i></a>
          <a class="btn btn-sm btn-danger" href="<?= h(base_url('index.php?r=rooms/delete&id=' . $r['id'])) ?>" onclick="return confirm('Xóa?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>


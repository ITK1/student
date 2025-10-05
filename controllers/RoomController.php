<?php

require_once __DIR__ . '/../models/Room.php';

class RoomController {
    public function __construct(private PDO $pdo) {}

    public function index(): string {
        // Lọc theo giới tính và kèm số lượng đang ở (occupancy)
        $gender = isset($_GET['gender']) ? (string)$_GET['gender'] : '';
        $rooms = Room::withOccupancy($this->pdo, $gender);
        $content = render_view('rooms/index', ['rooms' => $rooms, 'gender' => $gender]);
        return render_view('layout', [
            'title' => 'Phòng',
            'content' => $content,
        ]);
    }

    public function create(): string {
        $content = render_view('rooms/create', ['errors' => [], 'old' => []]);
        return render_view('layout', [
            'title' => 'Thêm phòng',
            'content' => $content,
        ]);
    }

    public function store(): void {
        $data = [
            'room_code' => $_POST['room_code'] ?? '',
            'capacity' => $_POST['capacity'] ?? '',
            'gender' => $_POST['gender'] ?? '',
        ];
        $errors = validate($data, [
            'room_code' => 'required|max:20',
            'capacity' => 'required',
        ]);
        if ($errors) {
            $content = render_view('rooms/create', ['errors' => $errors, 'old' => $data]);
            echo render_view('layout', ['title' => 'Thêm phòng', 'content' => $content]);
            return;
        }
        try {
            Room::create($this->pdo, $data);
            flash_set('success', 'Thêm phòng thành công');
            redirect('index.php?r=rooms/index');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
            redirect('index.php?r=rooms/create');
        }
    }

    public function edit(): string {
        $id = (int)($_GET['id'] ?? 0);
        $room = Room::find($this->pdo, $id);
        if (!$room) {
            flash_set('danger', 'Không tìm thấy phòng');
            redirect('index.php?r=rooms/index');
        }
        $content = render_view('rooms/edit', ['errors' => [], 'room' => $room]);
        return render_view('layout', [
            'title' => 'Sửa phòng',
            'content' => $content,
        ]);
    }

    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'room_code' => $_POST['room_code'] ?? '',
            'capacity' => $_POST['capacity'] ?? '',
            'gender' => $_POST['gender'] ?? '',
        ];
        $errors = validate($data, [
            'room_code' => 'required|max:20',
            'capacity' => 'required',
        ]);
        if ($errors) {
            $room = array_merge(['id' => $id], $data);
            $content = render_view('rooms/edit', ['errors' => $errors, 'room' => $room]);
            echo render_view('layout', ['title' => 'Sửa phòng', 'content' => $content]);
            return;
        }
        try {
            Room::update($this->pdo, $id, $data);
            flash_set('success', 'Cập nhật phòng thành công');
            redirect('index.php?r=rooms/index');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
            redirect('index.php?r=rooms/edit&id=' . $id);
        }
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            Room::delete($this->pdo, $id);
            flash_set('success', 'Xóa phòng thành công');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
        }
        redirect('index.php?r=rooms/index');
    }
}



<?php

require_once __DIR__ . '/../models/Contract.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Room.php';

class ContractController {
    public function __construct(private PDO $pdo) {}

    public function index(): string {
        $contracts = Contract::allWithJoins($this->pdo);
        $content = render_view('contracts/index', ['contracts' => $contracts]);
        return render_view('layout', [
            'title' => 'Hợp đồng xếp phòng',
            'content' => $content,
        ]);
    }

    public function create(): string {
        $students = Student::all($this->pdo);
        $rooms = Room::all($this->pdo);
        $content = render_view('contracts/create', ['errors' => [], 'old' => [], 'students' => $students, 'rooms' => $rooms]);
        return render_view('layout', [
            'title' => 'Tạo hợp đồng',
            'content' => $content,
        ]);
    }

    public function store(): void {
        $data = [
            'student_id' => (int)($_POST['student_id'] ?? 0),
            'room_id' => (int)($_POST['room_id'] ?? 0),
            'start_date' => $_POST['start_date'] ?? '',
            'end_date' => $_POST['end_date'] ?? '',
        ];
        // Validate cơ bản + giới tính phù hợp phòng + trùng thời gian
        $errors = validate($data, [
            'student_id' => 'required',
            'room_id' => 'required',
            'start_date' => 'required',
        ]);
        if (!$errors) {
            $student = Student::find($this->pdo, $data['student_id']);
            $room = Room::find($this->pdo, $data['room_id']);
            if (!$student || !$room) {
                $errors['student_id'] = 'Dữ liệu không hợp lệ';
            } else {
                if ($room['gender'] !== '' && $student['gender'] !== '' && $room['gender'] !== $student['gender']) {
                    $errors['room_id'] = 'Phòng không phù hợp giới tính';
                }
                // Kiểm tra sinh viên đã có hợp đồng trùng thời gian (end_date NULL hoặc >= start)
                $overlap = Contract::studentOverlap($this->pdo, $data['student_id'], $data['start_date']);
                if ($overlap) {
                    $errors['student_id'] = 'Sinh viên đã có hợp đồng hiệu lực trong thời gian này';
                }
            }
        }
        if ($errors) {
            $students = Student::all($this->pdo);
            $rooms = Room::all($this->pdo);
            $content = render_view('contracts/create', ['errors' => $errors, 'old' => $data, 'students' => $students, 'rooms' => $rooms]);
            echo render_view('layout', ['title' => 'Tạo hợp đồng', 'content' => $content]);
            return;
        }
        try {
            Contract::create($this->pdo, $data);
            flash_set('success', 'Tạo hợp đồng thành công');
            redirect('index.php?r=contracts/index');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
            redirect('index.php?r=contracts/create');
        }
    }

    public function end(): void {
        // Kết thúc hợp đồng: set end_date = hôm nay
        $id = (int)($_GET['id'] ?? 0);
        try {
            Contract::end($this->pdo, $id);
            flash_set('success', 'Đã kết thúc hợp đồng');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
        }
        redirect('index.php?r=contracts/index');
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            Contract::delete($this->pdo, $id);
            flash_set('success', 'Xóa hợp đồng thành công');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
        }
        redirect('index.php?r=contracts/index');
    }
}



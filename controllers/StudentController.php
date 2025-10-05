<?php

require_once __DIR__ . '/../models/Student.php';

class StudentController {
    public function __construct(private PDO $pdo) {}

    public function index(): string {
        // Trang danh sách có tìm kiếm + phân trang đơn giản
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        [$students, $total] = Student::searchPaginated($this->pdo, $q, $page, $perPage);
        $content = render_view('students/index', [
            'students' => $students,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
        ]);
        return render_view('layout', [
            'title' => 'Sinh viên',
            'content' => $content,
        ]);
    }

    public function create(): string {
        $content = render_view('students/create', ['errors' => [], 'old' => []]);
        return render_view('layout', [
            'title' => 'Thêm sinh viên',
            'content' => $content,
        ]);
    }

    public function store(): void {
        $data = [
            'student_code' => $_POST['student_code'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'dob' => $_POST['dob'] ?? '',
        ];
        $errors = validate($data, [
            'student_code' => 'required|max:20',
            'full_name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'max:20',
        ]);
        if ($errors) {
            $content = render_view('students/create', ['errors' => $errors, 'old' => $data]);
            echo render_view('layout', ['title' => 'Thêm sinh viên', 'content' => $content]);
            return;
        }
        try {
            Student::create($this->pdo, $data);
            flash_set('success', 'Thêm sinh viên thành công');
            redirect('index.php?r=students/index');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
            redirect('index.php?r=students/create');
        }
    }

    public function edit(): string {
        $id = (int)($_GET['id'] ?? 0);
        $student = Student::find($this->pdo, $id);
        if (!$student) {
            flash_set('danger', 'Không tìm thấy sinh viên');
            redirect('index.php?r=students/index');
        }
        $content = render_view('students/edit', ['errors' => [], 'student' => $student]);
        return render_view('layout', [
            'title' => 'Sửa sinh viên',
            'content' => $content,
        ]);
    }

    public function show(): string {
        // Trang chi tiết sinh viên: thông tin + hợp đồng liên quan
        $id = (int)($_GET['id'] ?? 0);
        $student = Student::find($this->pdo, $id);
        if (!$student) {
            flash_set('danger', 'Không tìm thấy sinh viên');
            redirect('index.php?r=students/index');
        }
        $contracts = Student::contracts($this->pdo, $id);
        $content = render_view('students/show', ['student' => $student, 'contracts' => $contracts]);
        return render_view('layout', [
            'title' => 'Chi tiết sinh viên',
            'content' => $content,
        ]);
    }

    public function exportCsv(): void {
        // Xuất CSV danh sách sinh viên theo từ khóa hiện tại
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
        $rows = Student::search($this->pdo, $q);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="students.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Mã SV', 'Họ tên', 'Email', 'Điện thoại', 'Giới tính', 'Ngày sinh']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['id'], $r['student_code'], $r['full_name'], $r['email'], $r['phone'], $r['gender'], $r['dob']]);
        }
        fclose($out);
        exit;
    }

    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'student_code' => $_POST['student_code'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'dob' => $_POST['dob'] ?? '',
        ];
        $errors = validate($data, [
            'student_code' => 'required|max:20',
            'full_name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'max:20',
        ]);
        if ($errors) {
            $student = array_merge(['id' => $id], $data);
            $content = render_view('students/edit', ['errors' => $errors, 'student' => $student]);
            echo render_view('layout', ['title' => 'Sửa sinh viên', 'content' => $content]);
            return;
        }
        try {
            Student::update($this->pdo, $id, $data);
            flash_set('success', 'Cập nhật sinh viên thành công');
            redirect('index.php?r=students/index');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
            redirect('index.php?r=students/edit&id=' . $id);
        }
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            Student::delete($this->pdo, $id);
            flash_set('success', 'Xóa sinh viên thành công');
        } catch (Throwable $e) {
            flash_set('danger', 'Lỗi: ' . $e->getMessage());
        }
        redirect('index.php?r=students/index');
    }
}



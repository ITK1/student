<?php

class Student {
    public static function all(PDO $pdo): array {
        $stmt = $pdo->query('SELECT * FROM students ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public static function search(PDO $pdo, string $q): array {
        if ($q === '') { return self::all($pdo); }
        $stmt = $pdo->prepare('SELECT * FROM students WHERE student_code LIKE :q OR full_name LIKE :q OR email LIKE :q ORDER BY id DESC');
        $stmt->execute([':q' => "%$q%"]);
        return $stmt->fetchAll();
    }

    public static function searchPaginated(PDO $pdo, string $q, int $page, int $perPage): array {
        // Trả về [rows, total]
        $offset = ($page - 1) * $perPage;
        if ($q === '') {
            $total = (int)$pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
            $stmt = $pdo->prepare('SELECT * FROM students ORDER BY id DESC LIMIT :limit OFFSET :offset');
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return [$stmt->fetchAll(), $total];
        }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM students WHERE student_code LIKE :q OR full_name LIKE :q OR email LIKE :q');
        $stmt->execute([':q' => "%$q%"]);
        $total = (int)$stmt->fetchColumn();
        $stmt = $pdo->prepare('SELECT * FROM students WHERE student_code LIKE :q OR full_name LIKE :q OR email LIKE :q ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return [$stmt->fetchAll(), $total];
    }

    public static function find(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(PDO $pdo, array $data): void {
        $stmt = $pdo->prepare('INSERT INTO students (student_code, full_name, email, phone, gender, dob, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['student_code'], $data['full_name'], $data['email'], $data['phone'], $data['gender'], $data['dob'] ?: null,
        ]);
    }

    public static function update(PDO $pdo, int $id, array $data): void {
        $stmt = $pdo->prepare('UPDATE students SET student_code=?, full_name=?, email=?, phone=?, gender=?, dob=? WHERE id=?');
        $stmt->execute([
            $data['student_code'], $data['full_name'], $data['email'], $data['phone'], $data['gender'], $data['dob'] ?: null, $id,
        ]);
    }

    public static function delete(PDO $pdo, int $id): void {
        $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function contracts(PDO $pdo, int $studentId): array {
        $sql = 'SELECT c.*, r.room_code FROM contracts c JOIN rooms r ON r.id = c.room_id WHERE c.student_id = ? ORDER BY c.start_date DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }
}



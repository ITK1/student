<?php

class Contract {
    public static function allWithJoins(PDO $pdo): array {
        $sql = 'SELECT c.*, s.full_name AS student_name, s.student_code, r.room_code
                FROM contracts c
                JOIN students s ON s.id = c.student_id
                JOIN rooms r ON r.id = c.room_id
                ORDER BY c.id DESC';
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function create(PDO $pdo, array $data): void {
        // Kiểm tra sức chứa phòng: số hợp đồng active trong khoảng thời gian giao với [start, end]
        // Đơn giản: chỉ đếm những hợp đồng có end_date IS NULL hoặc end_date >= start_date
        $checkSql = 'SELECT COUNT(*) AS cnt, r.capacity
                     FROM contracts c
                     JOIN rooms r ON r.id = c.room_id
                     WHERE c.room_id = :room_id AND (c.end_date IS NULL OR c.end_date >= :start_date)';
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([':room_id' => $data['room_id'], ':start_date' => $data['start_date']]);
        $row = $stmt->fetch();
        $count = (int)($row['cnt'] ?? 0);
        $capacity = (int)($row['capacity'] ?? 0);
        if ($count >= $capacity) {
            throw new RuntimeException('Phòng đã đủ chỗ.');
        }

        $sql = 'INSERT INTO contracts (student_id, room_id, start_date, end_date, created_at)
                VALUES (?, ?, ?, ?, NOW())';
        $stmt = $pdo->prepare($sql);
        $end = $data['end_date'] ?: null;
        $stmt->execute([$data['student_id'], $data['room_id'], $data['start_date'], $end]);
    }

    public static function delete(PDO $pdo, int $id): void {
        $stmt = $pdo->prepare('DELETE FROM contracts WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function end(PDO $pdo, int $id): void {
        $stmt = $pdo->prepare('UPDATE contracts SET end_date = CURDATE() WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function studentOverlap(PDO $pdo, int $studentId, string $startDate): bool {
        // Trùng thời gian: có hợp đồng chưa kết thúc tại thời điểm startDate
        $sql = 'SELECT COUNT(*) FROM contracts WHERE student_id = ? AND (end_date IS NULL OR end_date >= ?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $startDate]);
        return (int)$stmt->fetchColumn() > 0;
    }
}



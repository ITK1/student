<?php

class Room {
    public static function all(PDO $pdo): array {
        $stmt = $pdo->query('SELECT * FROM rooms ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public static function withOccupancy(PDO $pdo, string $genderFilter = ''): array {
        // Đếm số hợp đồng còn hiệu lực: end_date IS NULL hoặc end_date >= CURDATE()
        $sql = 'SELECT r.*, 
                       (
                         SELECT COUNT(*) FROM contracts c 
                         WHERE c.room_id = r.id AND (c.end_date IS NULL OR c.end_date >= CURDATE())
                       ) AS occupancy
                FROM rooms r';
        $params = [];
        if ($genderFilter !== '') {
            $sql .= ' WHERE r.gender = :g';
            $params[':g'] = $genderFilter;
        }
        $sql .= ' ORDER BY r.id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(PDO $pdo, array $data): void {
        $stmt = $pdo->prepare('INSERT INTO rooms (room_code, capacity, gender, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([
            $data['room_code'], (int)$data['capacity'], $data['gender'],
        ]);
    }

    public static function update(PDO $pdo, int $id, array $data): void {
        $stmt = $pdo->prepare('UPDATE rooms SET room_code=?, capacity=?, gender=? WHERE id=?');
        $stmt->execute([
            $data['room_code'], (int)$data['capacity'], $data['gender'], $id,
        ]);
    }

    public static function delete(PDO $pdo, int $id): void {
        $stmt = $pdo->prepare('DELETE FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
    }
}



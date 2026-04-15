<?php
require_once __DIR__ . '/../config/db.php';

class Rating
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::connect();
    }

    public function upsert(int $businessId, array $data): array
    {
        
        $stmt = $this->db->prepare(
            "SELECT id FROM ratings
             WHERE business_id = :bid
               AND (email = :email OR phone = :phone)
             LIMIT 1"
        );
        $stmt->execute([
            ':bid'   => $businessId,
            ':email' => $data['email'],
            ':phone' => $data['phone'],
        ]);
        $existing = $stmt->fetch();

        if ($existing) {
            $upd = $this->db->prepare(
                "UPDATE ratings
                 SET name = :name, email = :email,
                     phone = :phone, rating = :rating
                 WHERE id = :id"
            );
            $upd->execute([
                ':name'   => $data['name'],
                ':email'  => $data['email'],
                ':phone'  => $data['phone'],
                ':rating' => $data['rating'],
                ':id'     => $existing['id'],
            ]);
            $action = 'updated';
        } else {
            $ins = $this->db->prepare(
                "INSERT INTO ratings (business_id, name, email, phone, rating)
                 VALUES (:bid, :name, :email, :phone, :rating)"
            );
            $ins->execute([
                ':bid'    => $businessId,
                ':name'   => $data['name'],
                ':email'  => $data['email'],
                ':phone'  => $data['phone'],
                ':rating' => $data['rating'],
            ]);
            $action = 'inserted';
        }

        return [
            'action'     => $action,
            'avg_rating' => $this->getAvg($businessId),
        ];
    }

    public function getAvg(int $businessId): float
    {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(ROUND(AVG(rating), 1), 0) AS avg
             FROM ratings WHERE business_id = :bid"
        );
        $stmt->execute([':bid' => $businessId]);
        return (float) $stmt->fetchColumn();
    }
}
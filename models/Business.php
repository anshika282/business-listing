<?php
require_once __DIR__ . '/../config/db.php';

class Business {
    private $table = "businesses";
    private PDO $db;

    public function __construct() {
        $this->db = DB::connect();
    }

    public function getAll() {
         $sql = "SELECT b.*,
                       COALESCE(ROUND(AVG(r.rating), 1), 0) AS avg_rating,
                       COUNT(r.id) AS total_ratings
                FROM $this->table b
                LEFT JOIN ratings r ON r.business_id = b.id
                GROUP BY b.id
                ORDER BY b.id DESC";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO $this->table (name, address, phone, email) 
                  VALUES (:name, :address, :phone, :email)";
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':email' => $data['email']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM businesses WHERE id = :id LIMIT 1"
        );

        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE $this->table 
                  SET name = :name, address = :address, phone = :phone, email = :email
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':email' => $data['email']
        ]);
    }

    public function delete(int $id) {
        $stmt = $this->db->prepare(
            "DELETE FROM $this->table WHERE id = :id"
            );
        return $stmt->execute([':id' => $id]);
    }


    public function getAvgRating(int $businessId)
    {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(ROUND(AVG(rating), 1), 0) AS avg_rating
             FROM ratings WHERE business_id = :bid"
        );
        $stmt->execute([':bid' => $businessId]);
        return (float) $stmt->fetchColumn();
    }
}
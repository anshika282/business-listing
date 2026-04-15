<?php
require_once __DIR__ . '/../models/Business.php';

class BusinessController {
    private Business $business;

    public function __construct() {
        $this->business = new Business();
    }


    //validation and helper methods
    private function json(bool $success, string $message, array $data = []): void
    {
        header('Content-Type: application/json');
        echo json_encode(array_merge(
            ['success' => $success, 'message' => $message],
            $data
        ));
        exit;
    }
 
    private function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
 
    private function collectFields(): array
    {
        return [
            'name'    => $this->sanitize($_POST['name']    ?? ''),
            'address' => $this->sanitize($_POST['address'] ?? ''),
            'phone'   => $this->sanitize($_POST['phone']   ?? ''),
            'email'   => $this->sanitize($_POST['email']   ?? ''),
        ];
    }
 
    private function validate(array $fields): ?string
    {
        foreach (['name', 'address', 'phone', 'email'] as $key) {
            if ($fields[$key] === '') {
                return ucfirst($key) . ' is required.';
            }
        }
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email address.';
        }
        if (!preg_match('/^[0-9+\-\s]{7,15}$/', $fields['phone'])) {
            return 'Invalid phone number.';
        }
        return null;
    }

    //apis

    public function addBusiness(): void
    {
        $fields = $this->collectFields();
        $error  = $this->validate($fields);
 
        if ($error) {
            $this->json(false, $error);
        }
 
        $newId    = $this->business->create($fields);
        $business = $this->business->getById($newId);
 
        $this->json(true, 'Business added successfully.', [
            'business'   => $business,
            'avg_rating' => 0,
        ]);
    }

    public function updateBusiness(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->json(false, 'Invalid business ID.');
        }
 
        $fields = $this->collectFields();
        $error  = $this->validate($fields);
 
        if ($error) {
            $this->json(false, $error);
        }
 
        $this->business->update($id, $fields);
        $business = $this->business->getById($id);
 
        $this->json(true, 'Business updated successfully.', [
            'business'   => $business,
            'avg_rating' => $this->business->getAvgRating($id),
        ]);
    }

    public function deleteBusiness(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->json(false, 'Invalid business ID.');
        }
 
        $this->business->delete($id);
        $this->json(true, 'Business deleted successfully.', ['id' => $id]);
    }
 
    public function getAllBusiness(): void
    {
        $businesses = $this->business->getAll();
        $this->json(true, '', ['businesses' => $businesses]);
    }


  
}
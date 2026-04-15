<?php
require_once __DIR__ . '/../models/Rating.php';

class RatingController
{
    private Rating $model;

    public function __construct()
    {
        $this->model = new Rating();
    }

    //helpers
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


    // apis
    public function submit(): void
    {
        $businessId = (int) ($_POST['business_id'] ?? 0);
        if ($businessId <= 0) {
            $this->json(false, 'Invalid business.');
        }

        $data = [
            'name'   => $this->sanitize($_POST['name']   ?? ''),
            'email'  => $this->sanitize($_POST['email']  ?? ''),
            'phone'  => $this->sanitize($_POST['phone']  ?? ''),
            'rating' => (float) ($_POST['rating']        ?? 0),
        ];

        foreach (['name', 'email', 'phone'] as $key) {
            if ($data[$key] === '') {
                $this->json(false, ucfirst($key) . ' is required.');
            }
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->json(false, 'Invalid email address.');
        }
        if (!preg_match('/^[0-9+\-\s]{7,15}$/', $data['phone'])) {
            $this->json(false, 'Invalid phone number.');
        }
        if ($data['rating'] < 0.5 || $data['rating'] > 5) {
            $this->json(false, 'Rating must be between 0.5 and 5.');
        }
        // Force .0 or .5 increments
        $data['rating'] = round($data['rating'] * 2) / 2;

        $result = $this->model->upsert($businessId, $data);

        $this->json(true, 'Rating submitted successfully.', [
            'action'      => $result['action'],
            'avg_rating'  => $result['avg_rating'],
            'business_id' => $businessId,
        ]);
    }
}
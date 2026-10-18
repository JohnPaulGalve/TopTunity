<?php
require_once __DIR__ . '/../includes/data.php';

$user = tt_current_user();
$payment_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$payment_id || !$user || $user['role'] !== 'client') {
    http_response_code(404);
    exit('Receipt not found.');
}

$stmt = db()->prepare("SELECT pay.id, pay.type, pay.amount, pay.service_fee, pay.status, pay.created_at, p.title
                       FROM payments pay
                       JOIN projects p ON p.id = pay.project_id
                       WHERE pay.id = ? AND p.client_id = ?");
$stmt->execute([(int) $payment_id, (int) $user['id']]);
$payment = $stmt->fetch();
if (!$payment) {
    http_response_code(404);
    exit('Receipt not found.');
}

$labels = ['escrow' => 'Deposit', 'release' => 'Payment release', 'refund' => 'Refund', 'hourly_billing' => 'Hourly billing'];
$safe = static function ($value) {
    return trim(str_replace(["\r", "\n"], ' ', strip_tags((string) $value)));
};
$receipt = [
    'TopTunity payment receipt',
    'Receipt ID: TT-' . (int) $payment['id'],
    'Date: ' . date('M d, Y H:i', strtotime($payment['created_at'])),
    'Client: ' . $safe($user['name']),
    'Project: ' . $safe($payment['title']),
    'Transaction: ' . ($labels[$payment['type']] ?? 'Payment'),
    'Status: ' . ucfirst($payment['status']),
    'Amount: PHP ' . number_format((int) $payment['amount']),
    'Service fee: PHP ' . number_format((int) $payment['service_fee']),
];
if ($payment['type'] === 'release') {
    $receipt[] = 'Net released: PHP ' . number_format((int) $payment['amount'] - (int) $payment['service_fee']);
}

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="toptunity-receipt-' . (int) $payment['id'] . '.txt"');
echo implode("\n", $receipt) . "\n";

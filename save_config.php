<?php
/**
 * CanDO Nursery - Configuration Save Endpoint
 * Saves configuration data to config.json
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit();
}

// Get the JSON data from the request body
$input = file_get_contents('php://input');
$config = json_decode($input, true);

// Validate that we received valid JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    exit();
}

// Validate required fields
$requiredFields = [
    'currentStudents', 'totalCapacity', 'currentActiveClasses', 'totalClassrooms',
    'currentStaff', 'currentTuitionRate', 'futureTuitionRate', 'currentMonthlyExpenses',
    'investmentAmount', 'egpRate', 'taxRate', 'year0TuitionRate', 'year0MonthlyExpenses',
    'year1Students', 'year1TuitionRate', 'year1MonthlyExpenses',
    'year2Students', 'year2TuitionRate', 'year2MonthlyExpenses',
    'year3Students', 'year3TuitionRate', 'year3MonthlyExpenses'
];

foreach ($requiredFields as $field) {
    if (!isset($config[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required field: ' . $field]);
        exit();
    }
}

// Path to config.json file
$configFile = __DIR__ . '/config.json';

// Create a backup of the current config (if it exists)
if (file_exists($configFile)) {
    $backupFile = __DIR__ . '/config.backup.json';
    copy($configFile, $backupFile);
}

// Write the new configuration to config.json
$jsonOutput = json_encode($config, JSON_PRETTY_PRINT);
$result = file_put_contents($configFile, $jsonOutput);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to write config file. Check file permissions.']);
    exit();
}

// Success response
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Configuration saved successfully',
    'timestamp' => date('Y-m-d H:i:s')
]);
?>

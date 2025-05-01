<?php

session_start();
if (!isset($_SESSION['adminid'])) {
    http_response_code(403);
    exit('Unauthorized');
}

$code = $_POST['code'] ?? '';
if (trim($code) === '143') {
    file_put_contents(__DIR__ . '/143.key', '143');
    echo 'activated';
} else {
    echo 'invalid';
}

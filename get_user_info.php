<?php

set_content_type('application/json');

$serialized = $_SESSION['user_info'] ?? null;

if ($serialized === null) {
    echo 'null';
    die;
}

$user_info = unserialize($serialized);

echo json_encode($user_info);
die;

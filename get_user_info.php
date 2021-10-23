<?php

set_content_type('application/json');

$serialized = $_SESSION['user'] ?? null;

if ($serialized === null) {
    echo 'null';
    die;
}

$userInfo = unserialize($serialized);

echo json_encode($userInfo);
die;

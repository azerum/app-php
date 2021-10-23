<?php

set_content_type('application/json');

$userAuthorizedApp = $_SESSION['app_is_authorized'] ?? false;
$serialized = $_SESSION['token'] ?? null;

if (!$userAuthorizedApp || $serialized === null) {
    echo 'null';
    die;
}

$token = unserialize($serialized);

echo json_encode($token);
die;

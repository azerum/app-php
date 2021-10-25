<?php

set_content_type('text/plain');

$client = make_google_client_with_client_id_secret_and_redirect_uri();

$client->setAccessType('online');
$client->setApprovalPrompt('auto');

$client->setScopes([
    'openid', 
    'email', 
    Google\Service\Classroom::CLASSROOM_COURSES_READONLY,
    Google\Service\Classroom::CLASSROOM_COURSEWORK_ME_READONLY
]);

$state = generate_state();
Session::setOAuthState($state);

$client->setState($state);

echo $client->createAuthUrl();
die;


function generate_state(): string {
    return bin2hex(random_bytes(16));
}

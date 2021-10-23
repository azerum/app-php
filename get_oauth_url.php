<?php

set_content_type('text/plain');

$state = bin2hex(random_bytes(16));
$_SESSION['state'] = $state;

$params = [
    'response_type' => 'code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'scope' => SCOPE,
    'state' => generate_state()
];

$url = AUTHORIZATION_URL.'?'.http_build_query($params);

echo $url;
die;

function generate_state(): string {
    $state = bin2hex(random_bytes(16));
    $_SESSION['state'] = $state;

    return $state;
}

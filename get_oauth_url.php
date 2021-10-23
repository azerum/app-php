<?php

set_content_type('text/plain');

$client = make_google_client();

$client->setAccessType('online');

$client->setScopes(OAUTH_SCOPES);
$client->setRedirectUri(OAUTH_REDIRECT_URI);

$state = generate_state();
$client->setState($state);

echo $client->createAuthUrl();
die;


function generate_state(): string {
    $state = bin2hex(random_bytes(16));
    $_SESSION['state'] = $state;

    return $state;
}

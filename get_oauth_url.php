<?php

set_content_type('text/plain');

$client = make_google_client_with_client_id_secret_and_redirect_uri();

$client->setAccessType('online');
$client->setScopes(OAUTH_SCOPES);

$state = generate_state();
Session::setOAuthState($state);

$client->setState($state);

echo $client->createAuthUrl();
die;


function generate_state(): string {
    return bin2hex(random_bytes(16));
}

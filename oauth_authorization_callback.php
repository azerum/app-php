<?php

$code = $_GET['code'] ?? die('OAuth authorization code not set');
verify_state_param_or_die();

$client = make_google_client();
$accessToken = $client->fetchAccessTokenWithAuthCode($code);

$_SESSION['access_token'] = $accessToken;
$_SESSION['app_is_authorized'] = true;

redirect_to(SPA_URL);
die;


function verify_state_param_or_die() {
    $passedState = $_GET['state'] ?? null;
    $sessionState = $_SESSION['state'] ?? null;

    if (
        $passedState === null || $sessionState === null ||
        $passedState !== $sessionState
    ) {
        die("Missing or incorrect 'state' parameter. Are you a hacker?");
    }
}

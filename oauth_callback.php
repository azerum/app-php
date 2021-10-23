<?php

$code = $_GET['code'] ?? die('OAuth authorization code not set');
verify_state_param_or_die();

$client = make_google_client();

$response = $client->fetchAccessTokenWithAuthCode($code);

if (isset($response['error'])) {
    var_dump($response);
    die;
}

$_SESSION['access_token'] = $response['access_token'];

$oauth2 = new Google\Service\Oauth2($client);
$userInfo = $oauth2->userinfo_v2_me->get();

$_SESSION['user_info'] = serialize($userInfo);

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

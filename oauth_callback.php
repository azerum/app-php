<?php

$code = $_GET['code'] ?? die('OAuth authorization code not set');
verify_state_param_or_die();

$client = make_google_client_with_client_id_secret_and_redirect_uri();

$response = $client->fetchAccessTokenWithAuthCode($code);

Session::setAccessToken($response['access_token']);

$oauth2 = new Google\Service\Oauth2($client);
$userInfo = $oauth2->userinfo_v2_me->get();

Session::setUserInfo($userInfo);

redirect_to(SPA_URL);
die;


function verify_state_param_or_die() {
    $passedState = $_GET['state'] ?? null;
    $sessionState = Session::oauthState();

    if (
        $passedState === null || $sessionState === null ||
        $passedState !== $sessionState
    ) {
        die("Missing or incorrect 'state' parameter. Are you a hacker?");
    }
}

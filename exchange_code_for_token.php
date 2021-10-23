<?php

$code = $_GET['code'] ?? die('OAuth authorization code not set');
verify_state_param_or_die();

$response = exchange_code($code);

$userInfo = parse_id_token($response['id_token']);

$_SESSION['user'] = serialize($userInfo);
$_SESSION['access_token'] = $response['access_token'];

header('Location: '.SPA_URL);
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

function exchange_code(string $code): array {
    $ch = curl_init(TOKEN_EXCHANGE_URL);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'authorization_code',
        'code' => $code,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI
    ]));

    return json_decode(curl_exec($ch), true);
}

function parse_id_token(string $idToken): array {
    // Split the JWT string into three parts
    $jwt = explode('.', $idToken);

    // Extract the middle part, base64 decode, then json_decode it
    $userInfo = json_decode(base64_decode($jwt[1]), true);

    return $userInfo;
}

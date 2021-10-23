<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort(405);
}

verify_csrf_token_or_die();

$client = make_google_client();

$idToken = get_verified_id_token_or_die($client);
$_SESSION['token'] = serialize($idToken);

redirect_to( get_oauth_authorization_url($client, $idToken) );
die;


function verify_csrf_token_or_die() {
    $fromCookie = $_COOKIE['g_csrf_token'] ?? abort(400, 'CSRF token cookie not set');
    $fromBody = $_POST['g_csrf_token'] ?? abort(400, 'CSRF token not set in POST body');

    if ($fromCookie !== $fromBody) {
        abort(400, 'Failed to verify CSRF token');
    }
}

function get_verified_id_token_or_die(Google\Client $client): array {
    $encodedIdToken = $_POST['credential'];

    try {
        $tokenOrFalse = $client->verifyIdToken($encodedIdToken);

        if ($tokenOrFalse !== false) {
            return $tokenOrFalse;
        }
    }
    catch (UnexpectedValueException) {
        //Token is not even a valid JWT token
    }

    abort(400, 'Failed to verify response');
}

function get_oauth_authorization_url(Google\Client $client, array $idToken): string {
    $client->setAccessType('online');
    $client->setLoginHint($idToken['sub']);

    $client->setScopes(OAUTH_SCOPES);
    $client->setRedirectUri(OAUTH_REDIRECT_URI);

    $state = generate_oauth_state();
    $client->setState($state);

    return $client->createAuthUrl();
}

function generate_oauth_state(): string {
    $state = bin2hex(random_bytes(16));
    $_SESSION['state'] = $state;

    return $state;
}

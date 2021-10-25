<?php

require_once(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__.'/Session.php');

const SPA_URL = 'http://localhost:5500';
const OAUTH_REDIRECT_URI = 'http://localhost:8000?action=oauth_callback';

$action = $_GET['action'] ?? null;

configure_session_cookie();
session_start();

switch ($action) {
    case 'get_coursework':
    case 'list_courses':
        abort_if_user_unauthenticated();
    /* fallthrough */

    case 'get_user_info':
    case 'get_oauth_url':
        handle_cors();
    /* fallthrough */

    case 'oauth_callback':
        require_once(__DIR__.'/'.$action.'.php');
    break;
}

die;

function configure_session_cookie() {
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = true;
    $cookieParams['secure'] = true;
    $cookieParams['samesite'] = 'Lax';

    session_set_cookie_params($cookieParams);
}

function handle_cors() {
    header('Access-Control-Allow-Origin: '.SPA_URL);
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Credentials: true');
}

function abort_if_user_unauthenticated() {
    if (!Session::isUserInfoSet()) {
        abort(401);
    }
}

function abort(int $responseCode, ?string $message = null)  {
    http_response_code($responseCode);

    if ($message !== null) {
        set_content_type('text/plain');
        echo $message;
    }

    die;
}

function set_content_type(string $contentType) {
    header('Content-Type: '.$contentType);
}

function redirect_to(string $url) {
    header('Location: '.$url);
    die;
}

function make_google_client_with_client_id_secret_and_redirect_uri(): Google\Client {
    $client = new Google\Client();
    $client->setAuthConfig(__DIR__.'/../google-client-secret.json');
    $client->setRedirectUri(OAUTH_REDIRECT_URI);

    return $client;
}

<?php

require_once(__DIR__.'/vendor/autoload.php');

const SPA_URL = 'http://localhost:5500';

const OAUTH_REDIRECT_URI = 'http://localhost:8000?action=oauth_callback';
const OAUTH_SCOPES = 'email profile https://www.googleapis.com/auth/classroom.coursework.me.readonly';

$action = $_GET['action'] ?? null;

configure_session_cookie();
session_start();

switch ($action) {
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

function set_content_type(string $contentType) {
    header('Content-Type: '.$contentType);
}

function redirect_to(string $url) {
    header('Location: '.$url);
    die;
}

function make_google_client(): Google\Client {
    $client = new Google\Client();
    $client->setAuthConfig(__DIR__.'/google-client-secret.json');

    return $client;
}

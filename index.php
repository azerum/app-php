<?php

const SPA_URL = 'http://localhost:5500';
const REDIRECT_URI = 'http://localhost:8000/?action=exchange_code_for_token';

const AUTHORIZATION_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
const TOKEN_EXCHANGE_URL = 'https://oauth2.googleapis.com/token';

const CLIENT_ID = '895562400824-eqfrnrj8php452e1lkfvok61gdu2mhai.apps.googleusercontent.com';
const CLIENT_SECRET = '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';

const SCOPE = 'openid email profile';

$action = $_GET['action'] ?? null;

session_start();

switch ($action) {
    case 'get_user_info':
        handle_cors();
        require_once(__DIR__.'/get_user_info.php');
    break;

    case 'get_oauth_url':
        handle_cors();
        require_once(__DIR__.'/get_oauth_url.php');
    break;

    case 'exchange_code_for_token':
        require_once(__DIR__.'/exchange_code_for_token.php');
    break;
}

die;

function set_content_type(string $contentType) {
    header('Content-Type: '.$contentType);
}

function handle_cors() {
    header('Access-Control-Allow-Origin: '.SPA_URL);
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Credentials: true');
}

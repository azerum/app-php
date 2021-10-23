<?php

set_content_type('application/json');

$client = make_google_client();

$buttonInfo = [
    'client_id' => $client->getClientId(),
    'login_uri' => SIGN_IN_BUTTON_LOGIN_URI,
];

echo json_encode($buttonInfo);
die;

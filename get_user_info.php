<?php

set_content_type('application/json');

$userInfo = Session::userInfo();

echo json_encode($userInfo);
die;

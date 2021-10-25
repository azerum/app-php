<?php

//set_content_type('application/json');

$courseId = $_GET['course_id'] ?? abort(400, 'course_id is required query parameter');

$client = new Google\Client();
$client->setAccessToken(Session::accessToken());

$classroom = new Google\Service\Classroom($client);

$result = $classroom->courses_courseWork->listCoursesCourseWork($courseId);
var_dump($result);

die;

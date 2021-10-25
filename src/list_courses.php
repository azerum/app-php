<?php

use Google\Service\Classroom\Course;

set_content_type('application/json');

$client = new Google\Client();
$client->setAccessToken(Session::accessToken());

$classroom = new Google\Service\Classroom($client);

$coursesFields = [
    'descriptionHeading'
];

$options = [
    'courseStates' => ['ACTIVE', 'ARCHIVED'],
    'fields' => 'courses(' . implode(',', $coursesFields) . ')',
];

$courses = $classroom->courses->listCourses($options)->getCourses();

$result = array_map(
    function (Course $course) use ($coursesFields) {
        $result = [];

        foreach ($coursesFields as $field) {
            $result[$field] = $course->{$field};
        }

        return $result;
    },

    $courses
);

echo json_encode($result);
die;

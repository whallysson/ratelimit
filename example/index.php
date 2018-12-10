<?php

require __DIR__ . '/../vendor/autoload.php';


use CodeBlog\RateLimit\RateLimit;


$key = 'user-id-999';
$limit = new RateLimit('cache-folder/', $key, 15, 60);


var_dump($limit);
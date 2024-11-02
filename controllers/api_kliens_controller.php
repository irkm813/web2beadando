<?php
// /../controllers/home_controller.php


$title = "No Sidebar";

$config = require __DIR__ . '/../config.php';
$username = $config['user_name'];
$password = $config['user_pass'];

require __DIR__ . '/../views/api-kliens.php';
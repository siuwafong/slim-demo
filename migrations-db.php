<?php

use Doctrine\DBAL\DriverManager;

return DriverManager::getConnection([
    'dbname' => "slimapi",
    'user' => "root",
    'password' => "MyNewPass5!",
    'host' => "localhost",
    'driver' => "pdo_mysql",
]);

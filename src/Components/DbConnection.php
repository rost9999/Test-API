<?php

namespace Components;

use PDO;

class DbConnection
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new PDO('mysql:host=localhost;dbname=test-api', 'root', '');
        }
        return self::$instance;
    }
}
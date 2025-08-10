<?php

namespace Controller;

use Core\View;

use PDO;
use PDOStatement;
use PDOException;

class Home
{
    public function index()
    {
        View::show('home/index', ['title' => 'Homepage']);
    }
}

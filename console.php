<?php

use app\models\Helper;


require_once 'app/db/SafeMySQL.php';
require_once 'app/models/Helper.php';
$config = require __DIR__.'/app/config/config.php';
$helper = new Helper();
$helper->showTree($config['incoming']);









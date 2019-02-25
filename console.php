<?php

use app\models\Helper;


require_once 'app/db/SafeMySQL.php';
require_once 'app/models/Helper.php';

$helper = new Helper();
$helper->showTree('./incoming');









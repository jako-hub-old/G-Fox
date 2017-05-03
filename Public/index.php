<?php

require realpath(__DIR__ . "/../Config/bootstrap.php");
require KERNEL_DIR . DS . "System.php";
\GF\System::createApp()->start();

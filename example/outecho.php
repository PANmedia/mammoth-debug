<?php
require_once __DIR__ . '/example.php';

// Buffer some output
ob_start();
echo 'Foo';

// Same as out but uses echo instead of var_dump
outecho('Bar');

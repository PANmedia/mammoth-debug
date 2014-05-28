<?php
require_once __DIR__ . '/example.php';

// Buffer some output
ob_start();
echo 'Foo';

// Calling out clears the buffer then flushes the debug output
out('Bar');
out($data);

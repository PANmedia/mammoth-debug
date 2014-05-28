<?php
require_once __DIR__ . '/example.php';
$foo = function() {
    $bar = function() {
        stacktrace(debug_backtrace());
    };
    $bar();
};
$foo();

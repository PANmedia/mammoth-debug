<?php
require_once __DIR__ . '/example.php';

// Example function so we get a stack trace
function triggerError($arg) {
    Test\Test::method();
}

triggerError('Foo bar');

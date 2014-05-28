<?php
require_once __DIR__ . '/example.php';

// Example function so we get a stack trace
function triggerError($arg) {
    trigger_error('This is an example error.', E_USER_ERROR);
}

triggerError('Foo bar');

<?php
require_once __DIR__ . '/example.php';

// Example function so we get a stack trace
function throwException($arg) {
    throw new RuntimeException('This is an example exception.');
}

throwException('Foo bar');

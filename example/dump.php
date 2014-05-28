<?php
require_once __DIR__ . '/example.php';

dump(42, 'Foo bar', [
    'Foo',
    'Foo' => 'Bar',
    new stdClass(),
]);

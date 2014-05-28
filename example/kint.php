<?php
require_once __DIR__ . '/example.php';

Mammoth\Debug\Dump::setHTMLObjectRenderer(['Mammoth\Debug\Render\HTML\Kint', 'object']);

dump(42, 'Foo bar', [
    'Foo',
    'Foo' => 'Bar',
    new stdClass(),
]);

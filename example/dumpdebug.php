<?php
require_once __DIR__ . '/example.php';

dumpdebug($data);

for ($i = 1; $i < 100; $i++) {
    if ($i === 42) {
        debug();
    }
    dumpdebug($i, $data);
}

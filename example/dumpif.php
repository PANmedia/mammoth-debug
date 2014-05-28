<?php
require_once __DIR__ . '/example.php';

for ($i = 1; $i < 100; $i++) {
    dumpif($i >= 42, $i, $data);
}

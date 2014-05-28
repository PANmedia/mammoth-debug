ERROR:
<?= $this->getErrorLevel($number); ?>: <?= trim($message) ? nl2br($message) : '*No Message*'; ?>


File:
(<?= $line; ?>) <?= $file; ?>


<?php
    $stacktrace = debug_backtrace();
    include __DIR__ . '/trace.php';
?>
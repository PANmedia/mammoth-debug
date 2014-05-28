<?= $message; ?>

<h2>
    Debug Stack Trace
    <label><input type="checkbox" checked="checked" autocomplete="off" class="mammoth-debug-autoscroll" /> Autoscroll</label>
</h2>
<?php
    $stacktrace = debug_backtrace();
    include __DIR__ . '/trace.php';
?>

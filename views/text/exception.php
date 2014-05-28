<?php if (!isset($previous) || !$previous): ?>
An uncaught exception has occurred in your application.
<?php else: ?>
Previous Exception
<?php endif; ?>

Exception: <?= $exception->getCode(); ?>

<?= $exception->getMessage() ?: '*No Message*'; ?>


File: (<?= $exception->getLine(); ?>) <?= $exception->getFile(); ?>

<?php if (is_callable(array($exception, 'getSQL'))): ?>
SQL:
<?= Mammoth\Debug\Dump::code($exception->getSQL(), 'sql'); ?>
<?php endif; ?>

<?php
    $stacktrace = $exception->getTrace();
    include __DIR__ . '/trace.php';
?>

<?php
    if ($exception->getPrevious()) {
        // Create new scope
        call_user_func(function($exception) {
            $previous = true;
            $exception = $exception->getPrevious();
            include __FILE__;
        }, $exception);
    }
?>

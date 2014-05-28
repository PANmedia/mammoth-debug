<?php if (!isset($previous) || !$previous): ?>
    <h1>
        <img src="data:image/png;base64,<?= base64_encode(file_get_contents(Mammoth\Debug\ROOT . '/public/images/warning32.png')); ?>" />
        An uncaught exception has occurred in your application.
    </h1>
<?php else: ?>
    <h1>
        <img src="data:image/png;base64,<?= base64_encode(file_get_contents(Mammoth\Debug\ROOT . '/public/images/warning32.png')); ?>" />
        Previous Exception
    </h1>
<?php endif; ?>
<div class="mammoth-debug-alert mammoth-debug-alert-exception">
    <span class="mammoth-debug-label mammoth-debug-label-exception"><?= get_class($exception) ?> <?= $exception->getCode(); ?></span>
    <big><b><?= trim(htmlspecialchars($exception->getMessage())) ? nl2br(htmlspecialchars($exception->getMessage())) : '*No Message*'; ?></b></big>
    <hr/>
    <big>
        <b>File:</b>
        <i>(<?= $exception->getLine(); ?>)</i>
        <?= $exception->getFile(); ?>
    </big>
</div>
<?php if (method_exists($exception, 'getContext')): ?>
    <h2>
        Exception Context
        <label><input type="checkbox" checked="checked" autocomplete="off" class="mammoth-debug-autoscroll" /> Autoscroll</label>
    </h2>
    <pre class="mammoth-debug-wrapper mammoth-debug-limit-height mammoth-debug-table mammoth-debug-table-bordered"><?= $this->renderContext($exception->getContext()); ?></pre>
<?php endif; ?>

<?php if (method_exists($exception, 'getSQL')): ?>
    <h2>SQL:</h2>
    <pre class="mammoth-debug-wrapper mammoth-debug-limit-height mammoth-debug-table mammoth-debug-table-bordered"><?= Mammoth\Debug\Dump::code($exception->getSQL(), 'sql'); ?></pre>
<?php endif; ?>

<h2>
    Exception Stack Trace
    <label><input type="checkbox" checked="checked" autocomplete="off" class="mammoth-debug-autoscroll" /> Autoscroll</label>
</h2>
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

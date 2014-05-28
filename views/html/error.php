<h1>
    <img src="data:image/png;base64,<?= base64_encode(file_get_contents(Mammoth\Debug\ROOT . '/public/images/error32.png')); ?>" />
    An unhandled error has occurred in your application.
</h1>
<div class="mammoth-debug-alert mammoth-debug-alert-<?= strtolower(str_replace('_', '-', $this->getErrorLevel($number))); ?>">
    <span class="mammoth-debug-label mammoth-debug-label-<?= strtolower(str_replace('_', '-', $this->getErrorLevel($number))); ?>"><?= $this->getErrorLevel($number); ?></span>
    <big><b><?= trim($message) ? nl2br($message) : '*No Message*'; ?></b></big>
    <hr/>
    <b>File:</b>
    <i>(<?= $line; ?>)</i>
    <?= $file; ?>
</div>

<h2>
    Debug Stack Trace
    <label><input type="checkbox" checked="checked" autocomplete="off" class="mammoth-debug-autoscroll" /> Autoscroll</label>
</h2>
<?php
    $stacktrace = debug_backtrace();
    include __DIR__.'/trace.php';
?>

<?php if (isset($context) && $context): ?>
<h2>
    Context
    <label><input type="checkbox" checked="checked" autocomplete="off" class="mammoth-debug-autoscroll" /> Autoscroll</label>
</h2>
<pre class="mammoth-debug-wrapper mammoth-debug-limit-height mammoth-debug-table mammoth-debug-table-bordered"><?= $this->renderContext($context); ?></pre>
<?php endif; ?>

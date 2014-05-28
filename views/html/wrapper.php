<?php
    namespace Mammoth\Debug\Error;
    use Mammoth;
    $textMessage = 'No text message.';
    if (isset($text) && is_file($text)) {
        ob_start();
        include $text;
        $textMessage = ob_get_clean();
    }
?>
<!--
<?= $textMessage; ?>
-->
<!DOCTYPE html>
<html class="mammoth-debug">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>An error has occurred.</title>
        <style type="text/css"><?php include Mammoth\Debug\ROOT . '/public/css/debug.min.css'; ?></style>
        <link rel="icon" type="image/x-icon" href="data:image/png;base64,<?= base64_encode(file_get_contents(Mammoth\Debug\ROOT . '/public/images/warning16.png')); ?>" />
    </head>

    <body class="mammoth-debug-body">
        <div class="mammoth-debug-container">
            <?php include $view; ?>
            <?= Mammoth\Debug\Dump::renderLog() ?>
            <?php include __DIR__.'/debug.php'; ?>
        </div>
        <script type="text/javascript"><?php include Mammoth\Debug\ROOT  . '/public/js/debug.min.js'; ?></script>
    </body>
</html>

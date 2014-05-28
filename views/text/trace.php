Stack Trace:
<?php
    $padMethod = 0;
    $i = 0;
    foreach ($stacktrace as $i => $trace) {
        $padMethod = max($padMethod, strlen(
            (isset($trace['class']) ? $trace['class'] : '') .
            (isset($trace['type']) ? $trace['type'] : '') .
            (isset($trace['function']) ? $trace['function'] : '')
        ));
    }
    $padIndex = strlen($i) + 2;
    foreach ($stacktrace as $i => $trace) {
        echo str_pad('#' . $i, $padIndex, ' ', STR_PAD_RIGHT);
        echo str_pad(
            (isset($trace['class']) ? $trace['class'] : '') .
            (isset($trace['type']) ? $trace['type'] : '') .
            (isset($trace['function']) ? $trace['function'] : '')
        , $padMethod, ' ', STR_PAD_RIGHT);
        echo " called at [";
        echo isset($trace['file']) ? $trace['file'] : '';
        echo ':';
        echo isset($trace['line']) ? $trace['line'] : '';
        echo ']';
        echo PHP_EOL;
    }
?>

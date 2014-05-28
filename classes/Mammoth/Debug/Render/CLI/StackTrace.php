<?php
/**
 * Mammoth\Debug\Render\CLI\StackTrace
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\CLI;
use Mammoth;

class StackTrace {

    public static function render(array $stacktrace = null) {
        if ($stacktrace) {
            ob_start();
            include Mammoth\Debug\ROOT . '/views/text/trace.php';
            return ob_get_clean();
        }
        ob_start();
        $stacktrace = debug_backtrace();
        include Mammoth\Debug\ROOT . '/views/text/trace.php';
        return ob_get_clean();
    }

}

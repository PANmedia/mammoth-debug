<?php
/**
 * Mammoth\Debug\Render\HTML\StackTrace
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use Mammoth;

class StackTrace {

    public static function render(array $stacktrace = null) {
        if ($stacktrace) {
            ob_start();
            $view = Mammoth\Debug\ROOT . '/views/html/trace.php';
            include Mammoth\Debug\ROOT . '/views/html/wrapper.php';
            return ob_get_clean();
        } elseif (function_exists('xdebug_print_function_stack')) {
            ob_start();
            xdebug_print_function_stack();
            return ob_get_clean();
        }
        ob_start();
        debug_print_backtrace();
        return '<pre>' . htmlspecialchars(ob_get_clean()) . '</pre>';
    }

}

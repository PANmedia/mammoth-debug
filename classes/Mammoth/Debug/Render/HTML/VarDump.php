<?php
/**
 * Mammoth\Debug\Render\HTML\VarDump
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;

class VarDump {

    public static function object($object) {
        ob_start();
        if (function_exists('xdebug_var_dump')) {
            xdebug_var_dump($object);
            return ob_get_clean();
        } else {
            var_dump($object);
            return '<pre>' . htmlspecialchars(ob_get_clean()) . '</pre>';
        }
    }

}

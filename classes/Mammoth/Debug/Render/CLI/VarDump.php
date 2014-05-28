<?php
/**
 * Mammoth\Debug\Render\CLI\VarDump
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\CLI;

class VarDump {

    public static function object($object) {
        ob_start();
        if (function_exists('xdebug_var_dump')) {
            xdebug_var_dump($object);
        } else {
            var_dump($object);
        }
        return trim(ob_get_clean());
    }

}

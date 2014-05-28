<?php
/**
 * Mammoth\Debug\Render\HTML\DBug
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use Ospinto;

class DBug {

    public static function object($object) {
        if (!class_exists('Ospinto\Dbug')) {
            return VarDump::object($object);
        }
        ob_start();
        new Ospinto\Dbug($object);
        return ob_get_clean();
    }

}

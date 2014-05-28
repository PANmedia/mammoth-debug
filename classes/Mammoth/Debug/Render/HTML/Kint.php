<?php
/**
 * Mammoth\Debug\Render\HTML\Kint
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;

class Kint {

    public static function object($object) {
        ob_start();
        \Kint::dump($object);
        return ob_get_clean();
    }

}

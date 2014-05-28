<?php
/**
 * Mammoth\Debug\Render\HTML\Log
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use Mammoth;

class Log {

    public static function render() {
        include Mammoth\Debug\ROOT . '/views/log.php';
    }

}

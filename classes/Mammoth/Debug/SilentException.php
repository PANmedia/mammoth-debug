<?php
/**
 * Mammoth\Debug\SilentException
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug;
use Exception;

class SilentException extends Exception {

    public function __construct($previous) {
        parent::__construct('An exception has been silenced.', 0, $previous);
    }

    public function isSilent() {
        return true;
    }

}


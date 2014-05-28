<?php
/**
 * Mammoth\Debug\Render\CLI\Object
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\CLI;
use Exception;
use ReflectionClass;
use ReflectionObject;

class Object {

    public $object;

    public function __construct($object) {
        $this->object = $object;
    }

    public function render() {
        $robject = new ReflectionObject($this->object);
        return (string) $robject;
    }

    public function __toString() {
        try {
            return $this->render();
        } catch (Exception $exception) {
            trigger_error($exception->getMessage(), E_USER_WARNING);
        }
        return '';
    }

}

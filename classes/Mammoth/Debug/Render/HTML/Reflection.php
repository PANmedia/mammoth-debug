<?php
/**
 * Mammoth\Debug\Render\HTML\Reflection
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use ReflectionClass;

class Reflection {

    public static function renderObject($object) {
        if (!is_object($object)) {
            return;
        }
        $result = '<pre>';
        $reflection = new ReflectionObject($object);
        $result .= $reflection;
        $result .= '</pre>';
        return $result;
    }

    public static function renderClass($class) {
        if (is_object($class)) {
            $class = get_class($class);
        } elseif (!is_string($class) || !class_exists($class)) {
            return;
        }
        $result = '<pre>';
        $reflection = new ReflectionClass($class);
        $result .= $reflection;
        $result .= '</pre>';
        return $result;
    }

}

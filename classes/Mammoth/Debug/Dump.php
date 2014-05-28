<?php
/**
 * Mammoth\Debug\Dump
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug;
use Mammoth;
use Mammoth\Debug\Render\HTML;
use Mammoth\Debug\Render\CLI;

class Dump {

    public static $cliObjectRenderer = ['Mammoth\Debug\Render\CLI\VarDump', 'object'];
    public static $cliClassRenderer = ['Mammoth\Debug\Render\CLI\Reflection', 'renderClass'];
    public static $cliStackTraceRenderer = ['Mammoth\Debug\Render\CLI\StackTrace', 'render'];
    public static $htmlObjectRenderer = ['Mammoth\Debug\Render\HTML\VarDump', 'object'];
    public static $htmlClassRenderer = ['Mammoth\Debug\Render\HTML\Reflection', 'renderClass'];
    public static $htmlStackTraceRenderer = ['Mammoth\Debug\Render\HTML\StackTrace', 'render'];
    public static $debugging = false;

    public static function debug() {
        static::$debugging = true;
        static::out('Debugging enabled...');
        forward_static_call_array('static::out', func_get_args());
    }

    public static function dumpDebug() {
        if (static::$debugging) {
            return forward_static_call_array('static::dump', func_get_args());
        }
    }

    /**
     * Clears the PHP output buffer.
     */
    public static function clear() {
        while (ob_get_level() > 0) {
            $level = ob_get_level();
            ob_end_clean();
            if (ob_get_level() == $level) {
                break;
            }
        }
    }

    /**
     * Tries to force flushing of data to the browser. This function will:
     *  - Disable output buffering
     *  - Disable output compression
     *  - Enable implicit flushing
     *  - Clear the output buffer
     *  - Attempt to tell Apache not to compress or vray
     *  - Outputs 1025 bytes of whitespace (enabled browsers to start rendering)
     *  - Flush the buffer
     */
    public static function flush() {
        // Turn off output buffering
        ini_set('output_buffering', 'off');
        // Turn off PHP output compression
        if (!headers_sent()) {
            ini_set('zlib.output_compression', false);
        }
        // Implicitly flush the buffer(s)
        ini_set('implicit_flush', true);
        ob_implicit_flush(true);
        // Clear, and turn off output buffering
        static::clear();
        // Disable apache output buffering/compression
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', '1');
            apache_setenv('dont-vary', '1');
        }

        if (PHP_SAPI !== 'cli') {
            // Output at least 1KB of white space to prevent browser output buffering
            echo str_repeat(' ', 1024).PHP_EOL;
            flush();
        } else {
            echo PHP_EOL;
        }
    }

    /**
     * Kills the script execution and outputs that it was this class that caused it.
     */
    public static function kill($stack = true) {
        if ($stack) {
            static::stackTrace();
            static::renderLog();
        }
        exit('Execution killed by '.__CLASS__);
    }

    public static function exception($exception) {
        static::dump($exception);
    }

    /**
     * Renders a stack trace using the default renderer.
     */
    public static function stackTrace(array $stacktrace = null) {
        static::clear();
        $renderer = static::getStackTraceRenderer();
        echo $renderer($stacktrace);
        static::flush();
    }


    /**
     * Renders a stack trace using the default renderer, then kills execution.
     */
    public static function dumpStack() {
        static::stackTrace();
        static::kill();
    }

    public static function dumpHex() {
        static::clear();
        foreach (func_get_args() as $object) {
            echo HTML\Hex::render($object);
        }
        static::kill();
    }

    public static function outTable() {
        static::clear();
        foreach (func_get_args() as $object) {
            echo HTML\Table::render($object);
        }
    }

    public static function dumpTable() {
        static::clear();
        foreach (func_get_args() as $object) {
            echo HTML\Table::render($object);
        }
        static::kill();
    }

    public static function code($code, $type) {
        if (PHP_SAPI !== 'cli') {
            switch ($type) {
                case 'sql': {
                    return HTML\Code\SQL::render($code);
                }
                case 'html': {
                    return HTML\Code\HTML::render($code);
                }
            }
        }
    }

    /**
     *
     * @param mixed $object... Object/variable to output
     */
    public static function out() {
        static::clear();
        $renderer = static::getObjectRenderer();
        foreach (func_get_args() as $arg) {
            echo call_user_func($renderer, $arg);
            static::flush();
        }
    }

    public static function outLog() {
        if (class_exists('Mammoth\Log')) {
            foreach (func_get_args() as $arg) {
                Mammoth\Log::debug(get_called_class(), $arg);
            }
        }
    }

    public static function outEcho() {
        static::clear();
        foreach (func_get_args() as $arg) {
            echo $arg;
            static::flush();
        }
    }

    /**
     *
     * @param mixed $object... Object/variable to dump
     */
    public static function dumpHTML() {
        foreach (func_get_args() as $arg) {
            static::out(htmlspecialchars($arg));
        }
        static::kill();
    }

    public static function dumpClass() {
        $renderer = static::getClassRenderer();
        foreach (func_get_args() as $arg) {
            static::out($arg);
            echo call_user_func($renderer, $arg);
            static::flush();
        }
        static::kill();
    }

    /**
     *
     * @param mixed $object... Object/variable to dump
     */
    public static function dump() {
        foreach (func_get_args() as $arg) {
            static::out($arg);
        }
        static::kill();
    }

    /**
     *
     * @param mixed $object... Object/variable to dump
     */
    public static function dumpns() {
        foreach (func_get_args() as $arg) {
            static::out($arg);
        }
        static::kill(false);
    }

    /**
     *
     * @staticvar int $current Current count
     * @param int $count Maximum count
     * @param mixed $object... Object/variable to dump
     */
    public static function dumpCount($count) {
        static $current;
        if (!isset($current)) {
            $current = 0;
        }
        $args = func_get_args();
        array_shift($args);
        if (++$current == $count) {
            call_user_func_array('static::dump', $args);
        }
    }

    /**
     *
     * @param type $condition
     * @param mixed $object... Object/variable to dump
     */
    public static function dumpIf($condition, $object = null) {
        if (func_num_args() === 1) {
            $args = array($condition);
        } else {
            $args = func_get_args();
            array_shift($args);
        }
        if ($condition) {
            call_user_func_array('static::dump', $args);
        }
    }

    public static function renderLog() {
        if (class_exists('Mammoth\Log', false)) {
            $records = Mammoth\Log::$testHandler->getRecords();
            if (PHP_SAPI === 'cli') {
                include ROOT . '/views/text/log.php';
            } else {
                include ROOT . '/views/html/log.php';
            }
        }
    }

    public static function reverseFile($file) {
        $file = explode(DIRECTORY_SEPARATOR, $file);
        return implode(' -> ', array_reverse($file));
    }

    public static function implodeArguments($arguments, $implodeLimit = 5) {
        if ($implodeLimit-- <= 0) {
            return '*RECURSION*';
        }
        $result = array();
        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $result[] = 'array(' . static::implodeArguments($argument, $implodeLimit) . ')';
            } elseif (is_object($argument)) {
                $result[] = get_class($argument);
            } elseif ($argument === null) {
                $result[] = 'NULL';
            } elseif ($argument === true) {
                $result[] = 'TRUE';
            } elseif ($argument === false) {
                $result[] = 'FALSE';
            } elseif (is_string($argument)) {
                $result[] = htmlspecialchars($argument);
            } else {
                $result[] = $argument;
            }
        }
        return implode(', ', $result);
    }

    public static function getObjectRenderer() {
        if (PHP_SAPI === 'cli') {
            return static::$cliObjectRenderer;
        }
        return static::$htmlObjectRenderer;
    }

    public static function getClassRenderer() {
        if (PHP_SAPI === 'cli') {
            return static::$cliClassRenderer;
        }
        return static::$htmlClassRenderer;
    }

    public static function getStackTraceRenderer() {
        if (PHP_SAPI === 'cli') {
            return static::$cliStackTraceRenderer;
        }
        return static::$htmlStackTraceRenderer;
    }

    // <editor-fold defaultstate="collapsed" desc="Getters and setters">
    public static function getCLIObjectRenderer() {
        return static::$cliObjectRenderer;
    }

    public static function setCLIObjectRenderer($cliObjectRenderer) {
        static::$cliObjectRenderer = $cliObjectRenderer;
    }

    public static function getCLIClassRenderer() {
        return static::$cliClassRenderer;
    }

    public static function setCLIClassRenderer($cliClassRenderer) {
        static::$cliClassRenderer = $cliClassRenderer;
    }

    public static function getCLIStackTraceRenderer() {
        return static::$cliStackTraceRenderer;
    }

    public static function setCLIStackTraceRenderer($cliStackTraceRenderer) {
        static::$cliStackTraceRenderer = $cliStackTraceRenderer;
    }

    public static function getHTMLObjectRenderer() {
        return static::$htmlObjectRenderer;
    }

    public static function setHTMLObjectRenderer($htmlObjectRenderer) {
        static::$htmlObjectRenderer = $htmlObjectRenderer;
    }

    public static function getHTMLClassRenderer() {
        return static::$htmlClassRenderer;
    }

    public static function setHTMLClassRenderer($htmlClassRenderer) {
        static::$htmlClassRenderer = $htmlClassRenderer;
    }

    public static function getHTMLStackTraceRenderer() {
        return static::$htmlStackTraceRenderer;
    }

    public static function setHTMLStackTraceRenderer($htmlStackTraceRenderer) {
        static::$htmlStackTraceRenderer = $htmlStackTraceRenderer;
    }
    // </editor-fold>

}

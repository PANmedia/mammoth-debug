<?php
/**
 * Mammoth\Debug\Error\Handler\Debug
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Error\Handler;
use Mammoth;

class Debug {

    public $implodeLimit = null;
    public $errors = [
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
    ];

    public function handleException($exception) {
        if (method_exists($exception, 'isSilent') && $exception->isSilent()) {
            return;
        }
        Mammoth\Debug\Dump::clear();
        if (!headers_sent()) {
            header_remove();
            header('HTTP/1.1 500 Internal Server Error');
        }
        $this->renderException($exception);
    }

    public function renderException($exception) {
        if (PHP_SAPI === 'cli') {
            $view = Mammoth\Debug\ROOT . '/views/text/exception.php';
            $text = Mammoth\Debug\ROOT . '/views/text/exception.php';
            require Mammoth\Debug\ROOT . '/views/text/wrapper.php';
        } else {
            $view = Mammoth\Debug\ROOT . '/views/html/exception.php';
            $text = Mammoth\Debug\ROOT . '/views/text/exception.php';
            require Mammoth\Debug\ROOT . '/views/html/wrapper.php';
        }
    }

    public function handleError($number, $message, $file, $line, $context) {
        Mammoth\Debug\Dump::clear();
        if (!headers_sent()) {
            header_remove();
            header('HTTP/1.1 500 Internal Server Error');
        }
        $this->renderError($number, $message, $file, $line, $context);
    }

    public function renderError($number, $message, $file, $line, $context) {
        if (PHP_SAPI === 'cli') {
            $view = Mammoth\Debug\ROOT . '/views/text/error.php';
            require Mammoth\Debug\ROOT . '/views/text/wrapper.php';
        } else {
            $view = Mammoth\Debug\ROOT . '/views/html/error.php';
            $text = Mammoth\Debug\ROOT . '/views/text/error.php';
            require Mammoth\Debug\ROOT . '/views/html/wrapper.php';
        }
    }

    public function handleFatalError($error) {
        Mammoth\Debug\Dump::clear();
        if (!headers_sent()) {
            header_remove();
            header('HTTP/1.1 500 Internal Server Error');
        }
        $this->renderFatalError($error);
    }

    public function renderFatalError($error) {
        $this->renderError($error['type'], $error['message'], $error['file'], $error['line'], null);
    }

    public function handleMessage($message) {
        $this->renderMessage($message);
    }

    public function renderMessage($message) {
        if (PHP_SAPI === 'cli') {
            $view = Mammoth\Debug\ROOT . '/views/text/message.php';
            require Mammoth\Debug\ROOT . '/views/text/wrapper.php';
        } else {
            $view = Mammoth\Debug\ROOT . '/views/html/message.php';
            require Mammoth\Debug\ROOT . '/views/html/wrapper.php';
        }
    }

    public function getErrorLevel($code) {
        if (isset($this->errors[$code])) {
            return $this->errors[$code];
        }
        return 'Unknown PHP error';
    }

    public function renderContext($context) {
        $result = '';
        $this->renderContextType($result, $context);
        return $result;
    }

    public function renderContextType(&$result, $context, $indent = 0, &$depth = 4, &$length = 500, array &$recursion = []) {
        if ($indent >= $depth) {
            $result .= '**Depth limit**';
            return false;
        } elseif ($length-- <= 0) {
            $result .= '**Length limit**';
            return false;
        }
        $result .= gettype($context);
        if (is_string($context)) {
            $result .= " '" . htmlentities($context) . "' (length=" . strlen($context) . ')';
        } elseif (is_object($context)) {
            foreach ($recursion as &$value) {
                if (is_object($value) && $value === $context) {
                    $result .= '(' . get_class($context) . ') **Object recursion**';
                    return true;
                }
            }
            $recursion[] = $context;
            $result .= '(' . get_class($context) . ')';
            $this->renderContextObject($result, $context, $indent + 1, $depth, $length, $recursion);
        } elseif (is_array($context)) {
            foreach ($recursion as &$value) {
                if (is_array($value) && $this->arrayMatch($value, $context)) {
                    $result .= '(' . count($context) . ') **Array recursion**';
                    return true;
                }
            }
            $result .= '(' . count($context) . ')';
            $this->renderContextArray($result, $context, $indent + 1, $depth, $length, $recursion);
        } elseif (is_int($context) || is_float($context)) {
            $result .= ' ' . $context;
        }
        return true;
    }

    public function renderContextArray(&$result, $context, $indent, &$depth, &$length, array &$recursion = []) {
        foreach ($context as $key => $value) {
            $result .= PHP_EOL;
            $result .= str_repeat('    ', $indent);
            if (is_string($key)) {
                $result .= "'$key'";
            } else {
                $result .= $key;
            }
            $result .= ' =&gt; ';
            if ($this->renderContextType($result, $value, $indent, $depth, $length, $recursion) === false) {
                return false;
            }
        }
        return true;
    }

    public function renderContextObject(&$result, $context, $indent, &$depth, &$length, array &$recursion = []) {
        foreach (get_object_vars($context) as $key => $value) {
            $result .= PHP_EOL;
            $result .= str_repeat('    ', $indent);
            if (is_string($key)) {
                $result .= "'$key'";
            } else {
                $result .= $key;
            }
            $result .= ' =&gt; ';
            if ($this->renderContextType($result, $value, $indent, $depth, $length, $recursion) === false) {
                return false;
            }
        }
        return true;
    }

    public function renderTrace($stacktrace = null) {
        if ($stacktrace === null) {
            $stacktrace = debug_backtrace();
        }
        include Mammoth\Debug\ROOT . '/views/html/trace.php';
    }

    /**
     * http://stackoverflow.com/a/4263181/268074
     *
     * @param  array   $a
     * @param  array   $b
     * @return boolean
     */
    public function arrayMatch(array &$a, array &$b) {
        $tempA = $a;
        $tempB = $b;

        $key = uniqid('ref');
        $b = $key;

        if ($a === $key) {
            $return = true;
        } else {
            $return = false;
        }

        $a = $tempA;
        $b = $tempB;

        return $return;
    }

}

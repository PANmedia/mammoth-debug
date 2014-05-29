<?php
/**
 * Mammoth\Debug\Error\Handler
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Error;
use Exception;

class Handler {

    public $exceptionHandlers = [];
    public $errorHandlers = [];
    public $fatalErrorHandlers = [];
    public $reservedMemory;

    /**
     * Handles an exception.
     *
     * @param Exception $exception
     */
    public function handleException($exception) {
        $this->reservedMemory = null;
        foreach ($this->exceptionHandlers as $handler) {
            call_user_func($handler, $exception);
        }
        exit;
    }

    /**
     * Handles an error.
     *
     * @param int    $number
     * @param string $message
     * @param string $file
     * @param string $line
     * @param array  $context
     */
    public function handleError($number, $message, $file, $line, $context) {
        $this->reservedMemory = null;
        // Check if the error level is ignored or supressed
        if (!(error_reporting() & $number)) {
            return;
        }

        foreach ($this->errorHandlers as $handler) {
            call_user_func($handler, $number, $message, $file, $line, $context);
        }
        exit;
    }

    /**
     * Handles a fatal error.
     *
     * @param Exception $exception
     */
    public function handleFatalError() {
        $this->reservedMemory = null;
        $error = error_get_last();
        if ($error) {
            foreach ($this->fatalErrorHandlers as $handler) {
                call_user_func($handler, $error);
            }
        }
        exit;
    }

    /**
     * Adds an error handler to the stack.
     *
     * @param callable $handler
     */
    public function addErrorHandler($handler) {
        $this->errorHandlers[] = $handler;
    }

    /**
     * Adds an exception handler to the stack.
     *
     * @param callable $handler
     */
    public function addExceptionHandler($handler) {
        $this->exceptionHandlers[] = $handler;
    }

    /**
     * Adds an exception handler to the stack.
     *
     * @param callable $handler
     */
    public function addFatalErrorHandler($handler) {
        $this->fatalErrorHandlers[] = $handler;
    }

    /**
     * Binds error handlers to PHP internal functions.
     *
     * @param int $reservedMemorySize Allocates an amount of memory, which is freed before handling a fatal error.
     */
    public function register($reservedMemorySize = 40) {
        $this->reservedMemory = str_repeat(' ', 1024 * $reservedMemorySize);

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleFatalError']);
    }

}

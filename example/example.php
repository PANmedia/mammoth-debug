<?php
    define('ENVIRONMENT', 'example');
    define('DEBUG', true);

    if (is_file(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
    } elseif (is_file(__DIR__ . '/../../../autoload.php')) {
        require_once __DIR__ . '/../../../autoload.php';
    }

    // Some dummy data for dumping
    $data = [
        'Foo',
        'Foo' => 'Bar',
        new stdClass(),
    ];
    $tableData = [
        ['1', 'Keefe H. Wade', 'Cras.vehicula@ultriciesadipiscingenim.ca', 'Vicksburg', 'Ontario', 'Belarus', '1-798-600-2141', '03/01/1967', 'In'],
        ['2', 'Stephen J. Gentry', 'Donec.non.justo@duinecurna.com', 'Peru', 'NB', 'Albania', '1-337-214-1263', '31/01/1987', 'volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh.'],
        ['3', 'Heather T. Howe', 'risus.at.fringilla@velarcu.org', 'Saint Cloud', 'NH', 'Azerbaijan', '1-892-274-2164', '13/02/1993', 'gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum'],
        ['4', 'Bethany K. Patel', 'a.purus@Maecenas.edu', 'Lafayette', 'Gelderland', 'Djibouti', '1-940-971-6147', '01/01/1965', 'felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras'],
        ['5', 'Lunea B. Spencer', 'faucibus@dictumeu.com', 'West Haven', 'Saskatchewan', 'Armenia', '1-640-159-8750', '10/09/1982', 'nascetur ridiculus'],
    ];

    // Hide errors if we are not in debug mode
    ini_set('display_errors', DEBUG);
    error_reporting(DEBUG ? E_ALL : 0);

    // Load the error handling layer
    $errorHandler = new Mammoth\Debug\Error\Handler();

    if (DEBUG) {
        $debugHandler = new Mammoth\Debug\Error\Handler\Debug();
        $errorHandler->addErrorHandler([$debugHandler, 'handleError']);
        $errorHandler->addFatalErrorHandler([$debugHandler, 'handleFatalError']);
        $errorHandler->addExceptionHandler([$debugHandler, 'handleException']);
    }

    if (PHP_SAPI !== 'cli' && class_exists('Mammoth\Email')) {
        $environmentName = '';
        if (defined('ENVIRONMENT') && is_string(ENVIRONMENT)) {
            $environmentName = '[' . ENVIRONMENT . ']';
        }
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $emailSubject = "Mammoth Error $environmentName on $url";
        } else {
            $url = realpath(__DIR__ . '/../../../..');
            $emailSubject = "Mammoth Error $environmentName from $url";
        }

        if (defined('PREFERED_DOMAIN')) {
            $emailFrom = 'errors@' . preg_replace('/:\d+$/', '', PREFERED_DOMAIN);
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $emailFrom = 'errors@' . preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST']);
        } else {
            $emailFrom  = 'errors@example.com';
        }

        $emailHanlder = new Mammoth\Debug\Error\Handler\Email();
        $emailHanlder->addEmailTo('you@example.co.nz');
        $emailHanlder->setEmailFrom($emailFrom);
        $emailHanlder->setEmailSubject($emailSubject);
        $errorHandler->addErrorHandler([$emailHanlder, 'handleError']);
        $errorHandler->addFatalErrorHandler([$emailHanlder, 'handleFatalError']);
        $errorHandler->addExceptionHandler([$emailHanlder, 'handleException']);
    }

    $errorHandler->register();
?>
<a href="dump.php">Standard dump `dump`</a><br/>
<a href="dumpt.php">Dump text `dumpt`</a><br/>
<a href="dumpclass.php">Dump class info `dumpclass`</a><br/>
<a href="dumpcount.php">Dump after X calls `dumpcount`</a><br/>
<a href="dumpdebug.php">Dump after debug is called `dumpdebug`</a><br/>
<a href="dumphex.php">Hex dump string data `dumphex`</a><br/>
<a href="dumphtml.php">Dump HTML entities `dumphtml`</a><br/>
<a href="dumpif.php">Dump if a condition is met `dumpif`</a><br/>
<a href="dumpns.php">Dump without a stack trace `dumpns`</a><br/>
<a href="dumpstack.php">Dump a stack trace `dumpstack`</a><br/>
<a href="dumptable.php">Dump tablular data `dumptable`</a><br/>
<a href="out.php">Output debug data `out`</a><br/>
<a href="outecho.php">Echo debug data `outecho`</a><br/>
<a href="outlog.php">Output logs `outlog`</a><br/>
<a href="outtable.php">Output tabular data `outtable`</a><br/>
<a href="stacktrace.php">Output a stack trace `stacktrace`</a>

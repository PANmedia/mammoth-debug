<?php
/**
 * Mammoth\Debug
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug;

define('Mammoth\Debug\ROOT', __DIR__);

require_once __DIR__.'/functions/local.php';

if ((!defined('EXPOSE_GLOBAL_FUNCTIONS') && !defined('Mammoth\Debug\EXPOSE_GLOBAL_FUNCTIONS')) || EXPOSE_GLOBAL_FUNCTIONS) {
    require_once __DIR__ . '/functions/global.php';
}

require_once __DIR__ . '/classes/Mammoth/Debug/Dump.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Error/Handler.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Error/Handler/Debug.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Error/Handler/Email.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/CLI/Object.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/CLI/StackTrace.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/CLI/VarDump.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Code/HTML.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Code/SQL.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Code/TGeSHi.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Code/XML.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/DBug.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Hex.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Kint.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Log.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Reflection.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/StackTrace.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/Table.php';
require_once __DIR__ . '/classes/Mammoth/Debug/Render/HTML/VarDump.php';
require_once __DIR__ . '/classes/Mammoth/Debug/SilentException.php';

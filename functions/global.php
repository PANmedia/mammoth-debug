<?php
function debug()      { call_user_func_array('Mammoth\Debug\Dump::debug',      func_get_args()); }
function dump()       { call_user_func_array('Mammoth\Debug\Dump::dump',       func_get_args()); }
function dumpclass()  { call_user_func_array('Mammoth\Debug\Dump::dumpclass',  func_get_args()); }
function dumpcount()  { call_user_func_array('Mammoth\Debug\Dump::dumpcount',  func_get_args()); }
function dumpdebug()  { call_user_func_array('Mammoth\Debug\Dump::dumpdebug',  func_get_args()); }
function dumphex()    { call_user_func_array('Mammoth\Debug\Dump::dumphex',    func_get_args()); }
function dumphtml()   { call_user_func_array('Mammoth\Debug\Dump::dumphtml',   func_get_args()); }
function dumpif()     { call_user_func_array('Mammoth\Debug\Dump::dumpif',     func_get_args()); }
function dumpns()     { call_user_func_array('Mammoth\Debug\Dump::dumpns',     func_get_args()); }
function dumpstack()  { call_user_func_array('Mammoth\Debug\Dump::dumpstack',  func_get_args()); }
function dumptable()  { call_user_func_array('Mammoth\Debug\Dump::dumptable',  func_get_args()); }
function out()        { call_user_func_array('Mammoth\Debug\Dump::out',        func_get_args()); }
function outecho()    { call_user_func_array('Mammoth\Debug\Dump::outecho',    func_get_args()); }
function outlog()     { call_user_func_array('Mammoth\Debug\Dump::outlog',     func_get_args()); }
function outtable()   { call_user_func_array('Mammoth\Debug\Dump::outtable',   func_get_args()); }
function stacktrace() { call_user_func_array('Mammoth\Debug\Dump::stacktrace', func_get_args()); }

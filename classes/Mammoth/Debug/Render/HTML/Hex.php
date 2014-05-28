<?php
/**
 * Mammoth\Debug\Render\HTML\Table
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use Mammoth\Debug\Render\HTML;

class Hex {

    public static function render($data) {
        $hex = strtoupper(bin2hex($data));
        $length = strlen($hex) / 2;
        $output = "Hex dump (length=$length)";
        $output .= PHP_EOL . "Offset    00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F";
        $length = strlen($hex);
        for ($offset = 0; $offset < $length; $offset += 2) {
            if ($offset % 32 === 0) {
                $offsetString = str_pad(strtoupper(base_convert($offset / 2, 10, 16)), 8, '0', STR_PAD_LEFT);
                $offsetString = substr($offsetString, 0, 4) . ':' . substr($offsetString, 4);
                $output .= PHP_EOL . $offsetString . ' ';
            }
            $output .= "{$hex[$offset]}{$hex[$offset + 1]} ";
            if (($offset + 2) % 32 === 0) {
                $ascii = substr($data, ($offset + 2) / 2 - 16, ($offset + 2) / 2);
                for ($i = 0; $i < 16; $i++) {
                    $char = $ascii[$i];
                    if (ord($char) >= 32 && ord($char) <= 127) {
                        $output .= $char;
                    } else {
                        $output .= '.';
                    }
                }
            }
        }
        if ($offset % 32 !== 0) {
            $output .= str_repeat('   ', (16 - ($offset / 2 % 16)));
            $ascii = substr($data, -($offset / 2 % 16));
            $length = strlen($ascii);
            for ($i = 0; $i < $length; $i++) {
                $char = $ascii[$i];
                if (ord($char) >= 32 && ord($char) <= 127) {
                    $output .= $char;
                } else {
                    $output .= '.';
                }
            }
        }
        return HTML\VarDump::object($output);
    }

}

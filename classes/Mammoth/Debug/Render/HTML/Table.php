<?php
/**
 * Mammoth\Debug\Render\HTML\Table
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML;
use Mammoth;

class Table {

    public static function render($object) {
        $array = $object;
        if (is_object($object)) {
            $array = get_object_vars($object);
        }
        if (!is_array($array)) {
            Mammoth\Debug\Dump::out($object);
            return;
        }
        $result = '<style type="text/css">';
        $result .= file_get_contents(Mammoth\Debug\ROOT . '/public/css/debug.min.css');
        $result .= '</style>';
        $result .= '<table class="mammoth-debug-table mammoth-debug-table-condensed mammoth-debug-table-bordered mammoth-debug-table-striped">';
        $result .= '<thead>';
        foreach ($array as $row) {
            $result .= '<tr>';
            foreach ($row as $key => $value) {
                $result .= '<th>' . $key . '</th>';
            }
            $result .= '</tr>';
            break;
        }
        $result .= '</thead>';
        $result .= '<tbody>';
        foreach ($array as $row) {
            $result .= '<tr>';
            foreach ($row as $key => $value) {
                $result .= '<td>' . $value . '</td>';
            }
            $result .= '</tr>';
        }
        $result .= '</tbody>';
        $result .= '</table>';
        return $result;
    }

}

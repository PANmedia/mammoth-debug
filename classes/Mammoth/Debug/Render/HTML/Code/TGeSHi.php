<?php
/**
 * Mammoth\Debug\Render\HTML\Code\TGeshi
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML\Code;
use Mammoth\Debug;
use GeSHi\GeSHi;

trait TGeSHi {

    public static function geshi($code, $language, $line = 1) {
        if (class_exists('GeSHi\GeSHi')) {
            $geshi = new GeSHi($code, $language);
            $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
            $geshi->start_line_numbers_at($line);
            $geshi->set_header_type(GESHI_HEADER_PRE);
            $geshi->set_tab_width(4);
            $geshi->set_overall_class('mammoth-debug-geshi');
            return $geshi->parse_code();
        }
        return false;
    }

}

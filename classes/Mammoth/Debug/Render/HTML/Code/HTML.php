<?php
/**
 * Mammoth\Debug\Render\HTML\Code\HTML
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML\Code;

class HTML {
    use TGeSHi;

    public static function render($html) {
        $html = static::format($html);
        if ($geshi = static::geshi($html, 'xml')) {
            return $geshi;
        }
        $html = htmlentities($html);
        $html = "<pre>$html</pre>";
        return $html;
    }

    public static function getIndent($level) {
        $result = '';
        $i = $level * 4;
        if ($level < 0) {
            throw "Level is below 0";
        }
        while ($i--) {
            $result .= ' ';
        }
        return $result;
    }

    public static function format($html) {
        $html = trim($html);
        $result = '';
        $indentLevel = 0;
        $tokens = explode('<', $html);
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            $parts = explode('>', $tokens[$i]);
            if (count($parts) === 2) {
                if ($tokens[$i][0] === '/') {
                    $indentLevel--;
                }
                $result .= static::getIndent($indentLevel);
                if ($tokens[$i][0] !== '/') {
                    $indentLevel++;
                }

                if ($i > 0) {
                    $result .= '<';
                }

                $result .= trim($parts[0]) . '>' . PHP_EOL;
                if (trim($parts[1]) !== '') {
                    $result .= static::getIndent($indentLevel) . preg_replace('/\s+/', ' ', trim($parts[1])) . PHP_EOL;
                }

                if (preg_match('/^(img|hr|br)/', $parts[0])) {
                    $indentLevel--;
                }
            }
        }
        return $result;
    }

}

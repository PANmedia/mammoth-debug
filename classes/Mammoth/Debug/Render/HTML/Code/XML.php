<?php
/**
 * Mammoth\Debug\Render\HTML\Code\XML
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Render\HTML\Code;
use DOMDocument;

class XML {
    use TGeSHi;

    public static function render($xml) {
        $xml = static::format($xml);
        if ($geshi = static::geshi($xml, 'xml')) {
            return $geshi;
        }
        $xml = htmlentities($xml);
        $xml = "<pre>$xml</pre>";
        return $xml;
    }

    public static function format($xml) {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();
    }

}

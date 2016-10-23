<?php
namespace Concrete\Package\Amp\Amp;

use Concrete\Block\Content\Controller as ContentBlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Package\Amp\Html\Object\AmpImg;
use File;
use Sunra\PhpSimple\HtmlDomParser;

class Converter
{
    public static function content(ContentBlockController $controller)
    {
        $content = $controller->getSearchableContent();

        $dom = new HtmlDomParser();
        $r = $dom->str_get_html($content, true, true, DEFAULT_TARGET_CHARSET, false);
        if (is_object($r)) {
            foreach ($r->find('concrete-picture') as $picture) {
                $fID = $picture->fid;
                $fo = File::getByID($fID);
                if (is_object($fo)) {
                    $tag = new AmpImg($fo);
                    $tag->alt($picture->alt);
                    $picture->outertext = (string) $tag;
                }
            }
            $content = (string) $r->restore_noise($r);
        }

        return LinkAbstractor::translateFrom($content);
    }
}

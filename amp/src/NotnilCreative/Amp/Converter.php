<?php
namespace NotnilCreative\Amp;

use Sunra\PhpSimple\HtmlDomParser;
use Concrete\Core\Url\Url;

class Converter
{
    private $arrowedBlocks = array(
        'content' => 'view',
        'video' => 'templates/amp',
    );
    
    public function handle($event)
    {
        $contents = $event->getArgument('contents');
        $contents = self::run($contents);
        $event->setArgument('contents', $contents);
    }
    
    public static function run($content)
    {
        $dom = HtmlDomParser::str_get_html($content);
        
        foreach ($dom->find('img') as $img) {
            $img->outertext = sprintf('<amp-img src="%s" alt="%s" height="%s" width="%s" />', $img->src, $img->alt, $img->height, $img->width);
        }
        /*
        foreach ($dom->find('object') as $object) {
            $object->outertext = '';
        }
        */
        foreach ($dom->find('source') as $source) {
            $url = Url::createFromUrl($source->src);
            $url->setScheme(null);
            $source->src = $url;
        }
        /*
        foreach ($dom->find('video') as $video) {
            $video->outertext = sprintf('<amp-video poster="%s">%s</amp-video>', $video->poster, $video->innertext);
        }
        */
        
        return (string) $dom;
    }
    
    public function getAmpSafeBlockArray($blockArray)
    {
        $returnBlockArray = array();
        foreach ($blockArray as $b) {
            $bHandle = $b->getBlockTypeHandle();
            if (array_key_exists($bHandle, $this->arrowedBlocks)) {
                //$b->getInstance()->render('amp');
                $returnBlockArray[] = $b;
            }
        }
        return $returnBlockArray;
    }
}
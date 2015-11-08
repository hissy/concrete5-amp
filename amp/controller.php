<?php 
namespace Concrete\Package\Amp;

use PageTheme;
use Core;
use Events;
use Sunra\PhpSimple\HtmlDomParser;

class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle = 'amp';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.1';
    protected $pkgAutoloaderMapCoreExtensions = true;
    
    public function getPackageName()
    {
        return t('Accelerated Mobile Pages (AMP)');
    }
    
    public function getPackageDescription()
    {
        return t('Make your site ready for Accelerated Mobile Pages (AMP).');
    }
    
    public function install()
    {
        $pkg = parent::install();
        PageTheme::add('amp', $pkg);
    }
    
    public function on_start()
    {
        Core::bind('\PageController', 'Concrete\Package\Amp\Page\Controller\PageController');
        
        Events::addListener('on_page_output', function($event) {
            $contents = $event->getArgument('contents');
            
            $dom = HtmlDomParser::str_get_html($contents);
            
            foreach ($dom->find('img') as $img) {
                $img->outertext = sprintf('<amp-img src="%s" alt="%s" height="%s" width="%s" />', $img->src, $img->alt, $img->height, $img->width);
            }
            
            $event->setArgument('contents', (string) $dom);
        });
    }
}

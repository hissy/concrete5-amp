<?php 
namespace Concrete\Package\Amp;

use PageTheme;
use Core;
use Events;
use Request;
use Page;
use Concrete\Core\Url\Components\Path;

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
        /*
        Events::addListener('on_before_dispatch', function() {
            $request = Request::getInstance();
            $page = Page::getByPath($request->getPath());
            if ($page->isError()) {
                $path = new Path($request->getPath());
                if (count($path) > 0 && $path[0] == 'amp') {
                    $path->remove('amp');
                    $page = Page::getByPath($path->getUriComponent());
                    //dd($page);
                    if (!$page->isError) {
                        $new_request = Request::createFromGlobals();
                        $request->setCurrentPage($page);
                        \Request::setInstance($prefixed_request);
                        dd($request);
                        $response = Core::dispatch($request);
                        $response->send();
                        Core::shutdown();
                    }
                }
            }
        });
        */
    }
}

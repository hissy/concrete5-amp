<?php
namespace Concrete\Package\Amp;

use PageTheme;
use Core;

class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle = 'amp';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.1';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src/NotnilCreative' => 'NotnilCreative',
    );

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
    }
}

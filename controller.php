<?php
namespace Concrete\Package\Amp;

use Concrete\Core\Backup\ContentImporter;
use PageTheme;
use Core;

class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle = 'amp';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.1';
    protected $pkgAutoloaderMapCoreExtensions = true;

    /**
     * Returns the translated package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return t('Accelerated Mobile Pages (AMP)');
    }

    /**
     * Returns the translated package description.
     *
     * @return string
     */
    public function getPackageDescription()
    {
        return t('Make your site ready for Accelerated Mobile Pages (AMP).');
    }

    /**
     * Install process of the package.
     */
    public function install()
    {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }

    /**
     * Startup process of the package.
     */
    public function on_start()
    {
        Core::bind('\PageController', 'Concrete\Package\Amp\Page\Controller\PageController');
    }
}

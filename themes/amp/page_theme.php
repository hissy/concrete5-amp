<?php
namespace Concrete\Package\Amp\Theme\Amp;

use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme
{
    public function registerAssets()
    {
        $this->providesAsset('css', '*');
        $this->providesAsset('javascript', '*');
    }

    public function getThemeName()
    {
        return t('Amp');
    }

    public function getThemeDescription()
    {
        return t('A theme for Accelerated Mobile Pages (AMP).');
    }
}
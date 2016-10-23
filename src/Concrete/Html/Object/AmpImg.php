<?php
namespace Concrete\Package\Amp\Html\Object;

use Concrete\Core\File\File;
use HtmlObject\Traits\Tag;
use Page;

class AmpImg extends Tag
{
    protected $element = 'amp-img';
    protected $theme;
    protected $isResponsive = false;

    protected function loadPictureSettingsFromTheme()
    {
        $c = Page::getCurrentPage();
        if (is_object($c)) {
            $th = $c->getCollectionThemeObject();
            if (is_object($th)) {
                $this->theme = $th;
                $this->isResponsive = count($th->getThemeResponsiveImageMap()) > 0;
            }
        }
    }

    public function __construct(File $file)
    {
        $this->loadPictureSettingsFromTheme();

        if ($this->isResponsive) {
            $sources = array();
            foreach ($this->theme->getThemeResponsiveImageMap() as $thumbnail => $width) {
                $type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle($thumbnail);
                if ($type !== null) {
                    $src = $file->getThumbnailURL($type->getBaseVersion());
                    if ($width) {
                        $sources[] = $src . ' ' . str_replace('px', '', $width) . 'w';
                    }
                }
            }
            $this->srcset(implode(', ', $sources));
            $this->layout('responsive');
        }

        $path = $file->getRelativePath();
        if (!$path) {
            $path = $file->getURL();
        }
        $this->src($path);
        $this->width($file->getAttribute('width'));
        $this->height($file->getAttribute('height'));
    }
}

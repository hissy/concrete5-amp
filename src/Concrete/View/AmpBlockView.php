<?php
namespace Concrete\Package\Amp\View;

use Concrete\Core\Block\View\BlockView;
use Concrete\Core\Block\View\BlockViewTemplate;

class AmpBlockView extends BlockView
{
    protected function useBlockCache()
    {
        return false; // Always do not use block cache
    }

    public function finishRender($contents)
    {
        return parent::finishRender($contents); // Avoid Stores Block Output Cache
    }

    public function setupRender()
    {
        parent::setupRender();

        if ($this->block) {
            $obj = $this->block;
        } else {
            $obj = $this->blocktype;
        }

        $bvt = new BlockViewTemplate($obj);
        $bvt->setBlockCustomTemplate('amp.php');
        $this->setViewTemplate($bvt->getTemplate());

        if ($obj->getBlockTypeHandle() == 'youtube') {
            $this->addHeaderAsset('<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>');
        }
    }

    public function renderViewContents($scopeItems)
    {
        extract($scopeItems);
        if (!$this->outputContent) {
            ob_start();
            include $this->template;
            $this->outputContent = ob_get_contents();
            ob_end_clean();
        }

        $this->onBeforeGetContents();

        return $this->outputContent;
        $this->onAfterGetContents();
    }
}

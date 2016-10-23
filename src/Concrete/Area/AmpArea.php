<?php
namespace Concrete\Package\Amp\Area;

use Concrete\Core\Area\Area;
use Concrete\Core\Block\Block;
use Concrete\Package\Amp\View\AmpBlockView;
use Page;
use Permissions;
use View;

class AmpArea extends Area
{
    private $ampSafeBlockTypes = array('image','content','video','youtube');

    public function display($c = false, $alternateBlockArray = null)
    {
        if (!$c) {
            $c = Page::getCurrentPage();
        }
        $v = View::getRequestInstance();

        if (!is_object($c) || $c->isError()) {
            return false;
        }

        $this->load($c);
        $ap = new Permissions($this);
        if (!$ap->canViewArea()) {
            return false;
        }

        $blocksToDisplay = ($alternateBlockArray) ? $alternateBlockArray : $this->getAreaBlocksArray();

        /** @var Block $b */
        foreach ($blocksToDisplay as $b) {
            if (in_array($b->getBlockTypeHandle(), $this->ampSafeBlockTypes)) {
                $bv = new AmpBlockView($b);
                $bv->setAreaObject($this);
                $p = new Permissions($b);
                if ($p->canViewBlock()) {
                    echo $bv->render('view');
                }
            }
        }
    }
}

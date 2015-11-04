<?php
namespace Concrete\Package\Amp\Page\Controller;

use Concrete\Core\Html\Object\HeadLink;

class PageController extends \Concrete\Core\Page\Controller\PageController
{
    public function view()
    {
        $c = $this->getPageObject();
        if (!$c->isError()) {
            $link = $c->getCollectionLink(true) . '/amp';
            $this->addHeaderItem(new HeadLink($link, 'amphtml'));
        }
        //parent::view();
    }
    
    public function amp()
    {
        $this->setTheme('amp');
        $c = $this->getPageObject();
        if (!$c->isError()) {
            $link = $c->getCollectionLink(true);
            $this->addHeaderItem(new HeadLink($link, 'canonical'));
        }
    }
}
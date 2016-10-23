<?php
namespace Concrete\Package\Amp\Page\Controller;

use Concrete\Core\Html\Object\HeadLink;
use NotnilCreative\Amp\Converter as AmpConverter;
use Events;

class PageController extends \Concrete\Core\Page\Controller\PageController
{
    public function view()
    {
        $c = $this->getPageObject();
        if (!$c->isError()) {
            $link = $c->getCollectionLink(true) . '/amp';
            $this->addHeaderItem(new HeadLink($link, 'amphtml'));
        }
    }
    
    public function amp()
    {
        $this->setTheme('amp');
        
        //Events::addListener('on_page_output', array(new AmpConverter(), 'handle'));
    }
}
<?php
namespace Concrete\Package\Amp\Page\Controller;

use Concrete\Core\Html\Object\HeadLink;
use Concrete\Core\Page\Page;
use Package;

class PageController extends \Concrete\Core\Page\Controller\PageController
{
    public function view()
    {
        /** @var \Concrete\Core\Package\Package $pkg */
        $pkg = Package::getByHandle('amp');
        $types = $pkg->getFileConfig()->get('types');
        $types = (is_array($types)) ? $types : array();

        /** @var Page $c */
        $c = $this->getPageObject();
        if (!$c->isError() && in_array($c->getPageTypeID(), $types)) {
            $link = $c->getCollectionLink(true) . '/amp';
            $this->addHeaderItem(new HeadLink($link, 'amphtml'));
        }
    }

    /**
     * @see https://developers.google.com/analytics/devguides/collection/amp-analytics/
     */
    public function amp()
    {
        $this->setTheme('amp');

        /** @var \Concrete\Core\Package\Package $pkg */
        $pkg = Package::getByHandle('amp');
        $googleAnalyticsAccount = $pkg->getFileConfig()->get('analytics.googleanalytics.account');
        if ($googleAnalyticsAccount) {
            $this->addHeaderItem('<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>');
            $this->addFooterItem('<amp-analytics type="googleanalytics" id="analytics1">
                <script type="application/json">
                {
                    "vars": {
                      "account": "'.$googleAnalyticsAccount.'"
                    },
                    "triggers": {
                        "trackPageview": {
                            "on": "visible",
                            "request": "pageview"
                        }
                    }
                }
                </script>
                </amp-analytics>');
        }
    }
}

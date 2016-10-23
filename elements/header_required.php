<?php
defined('C5_EXECUTE') or die("Access Denied.");

/** @var \Concrete\Core\Page\Page $c */
$c = Page::getCurrentPage();
if (is_object($c)) {
    $cp = new Permissions($c);
}

/**
 * Handle page title
 */

if (is_object($c)) {
    // We can set a title 3 ways:
    // 1. It comes through programmatically as $pageTitle. If this is the case then we pass it through, no questions asked
    // 2. It comes from meta title
    // 3. It comes from getCollectionName()
    // In the case of 3, we also pass it through page title format.

    if (!isset($pageTitle) || !$pageTitle) {
        // we aren't getting it dynamically.
        $pageTitle = $c->getCollectionAttributeValue('meta_title');
        if (!$pageTitle) {
            $pageTitle = $c->getCollectionName();
            if($c->isSystemPage()) {
                $pageTitle = t($pageTitle);
            }
            $seo = Core::make('helper/seo');
            if (!$seo->hasCustomTitle()) {
                $seo->addTitleSegmentBefore($pageTitle);
            }
            $seo->setSiteName(Config::get('concrete.site'));
            $seo->setTitleFormat(Config::get('concrete.seo.title_format'));
            $seo->setTitleSegmentSeparator(Config::get('concrete.seo.title_segment_separator'));
            $pageTitle = $seo->getTitle();
        }
    }

    if (!isset($pageDescription) || !$pageDescription) {
        // we aren't getting it dynamically.
        $pageDescription = $c->getCollectionAttributeValue('meta_description');
        if (!$pageDescription) {
            $pageDescription = $c->getCollectionDescription();
        }
    }

    $cID = $c->getCollectionID();

    if (!isset($image)) {
        $thumbnail = $c->getAttribute('thumbnail');
        if ($thumbnail instanceof File && !$thumbnail->isError()) {
            $image = $thumbnail->getURL();
        }
    }

} else {
    $cID = 1;
    if (!isset($pageTitle)) {
        $pageTitle = null;
    }
}
?>
<meta charset="utf-8">
<title><?=h($pageTitle)?></title>
<?php
$canonical_link = $c->getCollectionLink(true);
echo new \Concrete\Core\Html\Object\HeadLink($canonical_link, 'canonical');
?>
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<script type="application/ld+json">
<?php
    /** @var \Concrete\Core\Localization\Service\Date $date */
    $date = Core::make('helper/date');

    $jsonLD = array(
        "@context" => "http://schema.org",
        "@type" => "NewsArticle",
        "mainEntityOfPage" => $canonical_link,
        "headline" => $pageDescription,
        "datePublished" => $date->formatCustom('c', $c->getCollectionDatePublic()),
        "dateModified" => $date->formatCustom('c', $c->getCollectionDateLastModified()),
    );

    if (isset($image)) {
        $jsonLD['image'] = array($image);
    }

    if (is_array($headers)) {
        $jsonLD = $headers + $jsonLD;
    }
    echo json_encode($jsonLD);
?>
</script>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<?php
$v = View::getInstance();
$v->markHeaderAssetPosition();

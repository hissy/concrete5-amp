<?php
defined('C5_EXECUTE') or die("Access Denied.");

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

} else {
    $cID = 1;
    if (!isset($pageTitle)) {
        $pageTitle = null;
    }
}
?>
<meta charset="utf-8">
<title><?=h($pageTitle)?></title>
<meta name="description" content="<?=h($pageDescription)?>" />
<?php
$akk = $c->getCollectionAttributeValue('meta_keywords');
if ($akk) { ?>
<meta name="keywords" content="<?=h($akk)?>" />
<?php }

if($c->getCollectionAttributeValue('exclude_search_index')) {
    echo '<meta name="robots" content="noindex" />';
}

if (Config::get('concrete.misc.app_version_display_in_header')) {
    echo '<meta name="generator" content="concrete5 - ' . APP_VERSION . '" />';
} else {
    echo '<meta name="generator" content="concrete5" />';
}

$canonical_link = $c->getCollectionLink(true);
echo new \Concrete\Core\Html\Object\HeadLink($canonical_link, 'canonical');

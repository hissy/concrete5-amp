<?php
defined('C5_EXECUTE') or die("Access Denied.");

/** @var \Concrete\Core\Page\Page $c */
$c = Page::getCurrentPage();

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
            /** @var \Concrete\Core\Html\Service\Seo $seo */
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
} else {
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
if (is_object($c)) {
    /** @var \Concrete\Core\Localization\Service\Date $date */
    $date = Core::make('helper/date');
    /** @var \Concrete\Core\Utility\Service\Text $text */
    $text = Core::make('helper/text');
    /** @var \Concrete\Core\Page\Theme\Theme $theme */
    $theme = \Concrete\Core\Page\Theme\Theme::getByHandle('amp');
    $theme_url = Core::getApplicationURL() . $theme->getThemeURL();
    $theme_path = DIR_BASE . $theme->getThemeURL();

    // We can set a headline 3 ways:
    // 1. It comes through programmatically as $pageDescription.
    // 2. It comes from meta description
    // 3. It comes from getCollectionDescription()
    if (!isset($pageDescription) || !$pageDescription) {
        // we aren't getting it dynamically.
        $pageDescription = $c->getCollectionAttributeValue('meta_description');
        if (!$pageDescription) {
            $pageDescription = $c->getCollectionDescription();
        }
    }

    /** @var \Concrete\Core\User\UserInfo $author */
    $author = Core::make('Concrete\Core\User\UserInfoFactory')->getByID($c->getCollectionUserID());

    /** @see https://developers.google.com/search/docs/data-types/articles */
    $jsonLD = array(
        '@context' => 'http://schema.org',
        '@type' => 'NewsArticle',
        'mainEntityOfPage' => $canonical_link,
        'headline' => $text->shortenTextWord($pageDescription, 110, false),
        'datePublished' => $date->formatCustom('c', $c->getCollectionDatePublic()),
        'dateModified' => $date->formatCustom('c', $c->getCollectionDateLastModified()),
        'author' => array(
            '@type' => 'Person',
            'name' => $author->getUserDisplayName(),
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => Config::get('concrete.site'), // @TODO: Compatible up to ver8 SiteKey system
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => $theme_url . '/images/publisher.png',
                'width' => 600,
                'height' => 60,
            ),
        ),
    );

    // We can set a thumbnail image 3 ways:
    // 1. It comes through programmatically as $thumbnail.
    // 2. It comes from thumbnail attribute
    // 3. It comes from default png file bundled in amp package (because thumbnail image is required property)
    if (!isset($thumbnail)) {
        $thumbnail = $c->getAttribute('thumbnail');
    }
    if ($thumbnail instanceof File && !$thumbnail->isError()) {
        $thumbnail_width = $thumbnail->getAttribute('width');
        /**
         * Images should be at least 696 pixels wide.
         * @see https://developers.google.com/search/docs/data-types/articles#amp-sd
         */
        if ($thumbnail_width > 696) {
            $image = array(
                '@type' => 'ImageObject',
                'url' => $thumbnail->getURL(),
                'width' => $thumbnail->getAttribute('width'),
                'height' => $thumbnail->getAttribute('height'),
            );
        }
    }
    if (!isset($image)) {
        $size = getimagesize($theme_path . '/images/thumbnail.png');
        $image = array(
            '@type' => 'ImageObject',
            'url' => $theme_url . '/images/thumbnail.png',
            'width' => $size[0],
            'height' => $size[1],
        );
    }
    $jsonLD['image'] = $image;

    if (is_array($headers)) {
        $jsonLD = $headers + $jsonLD;
    }
    echo json_encode($jsonLD);
}
?>
</script>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<?php
$v = View::getInstance();
$v->markHeaderAssetPosition();

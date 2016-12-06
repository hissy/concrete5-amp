<?php
/**
 * Basic template for AMP html.
 *
 * How to debug
 * * Add #development=1 to the URL
 * * Open the Chrome DevTools console and check for validation errors.
 */
defined('C5_EXECUTE') or die("Access Denied."); ?>
<!doctype html>
<html ⚡ lang="<?=Localization::activeLanguage()?>">
<head>
    <?php
    /**
     * You can override some properties of structured data.
     * NOTICE: 'author' and 'publisher' are required properties and should be overridden.
     * NOTICE: You must follow the AMP logo guideline.
     * @see https://developers.google.com/search/docs/data-types/articles
     */
    /*
    $headers[] = array(
        'author' => array(
            '@type' => 'Person',
            'name' => 'John Doe',
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'Google',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => 'http://cdn.ampproject.org/logo.jpg',
                'width' => 600,
                'height' => 60,
            ),
        ),
    );
    */
    $thumbnail = $c->getAttribute('thumbnail');
    View::element('header_required', array(
        'headers'         => isset($headers) ? $headers : array(),
        'pageTitle'       => isset($pageTitle) ? $pageTitle : '',
        'pageDescription' => isset($pageDescription) ? $pageDescription : '',
        'thumbnail'       => $thumbnail,
    ), 'amp');
    ?>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <style amp-custom>
        body {
            background-color: white;
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
            padding: 1em;
        }
        main {
            border-top: 1px solid gray;
            margin-top: 1em;
        }
        amp-img {
            background-color: grey;
        }
        .brand-logo {
            font-weight: bold;
        }
        .header-time {
            font-size: small;
            color: grey;
        }
        .feature-image {
            margin: 20px 0;
            text-align: center;
        }
        .copyright {
            color: lightgrey;
        }
        .article-body {
            margin: 1em 0;
        }
        .social-share {
            margin: 2em 0;
        }
    </style>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>
    <div class="<?php echo $c->getPageWrapperClass(); ?>">
        <header>
            <div class="brand-logo">
                <?php echo h(Config::get('concrete.site')); ?>
            </div>
        </header>
        <main role="main">
            <article>
                <header>
                <?php if ($thumbnail instanceof File && !$thumbnail->isError()) { ?>
                    <figure class="feature-image">
                        <amp-img
                                src="<?=$thumbnail->getURL()?>"
                                width="<?=$thumbnail->getAttribute('width')?>"
                                height="<?=$thumbnail->getAttribute('height')?>"
                                layout="responsive"></amp-img>
                    </figure>
                <?php } ?>
                    <h1 itemprop="headline"><?php echo h($c->getCollectionName()); ?></h1>
                    <time class="header-time"
                          itemprop="datePublished"
                          datetime="<?php echo $c->getCollectionDatePublicObject()->format(DATE_ATOM); ?>"><?php
                        echo Core::make('helper/date')->formatDate($c->getCollectionDatePublic(), true); ?></time>
                </header>
                <div class="article-body" itemprop="articleBody">
                    <?php
                    $a = new \Concrete\Package\Amp\Area\AmpArea('Main');
                    $a->display($c);
                    ?>
                </div>
            </article>
        </main>
        <footer>
            <div class="copyright">
                <small>&copy; <?php echo h(Config::get('concrete.site')); ?></small>
            </div>
            <div class="social-share">
                <amp-social-share type="twitter"></amp-social-share>
                <!-- <amp-social-share type="facebook" data-param-app_id=""></amp-social-share> -->
                <amp-social-share type="linkedin"></amp-social-share>
                <amp-social-share type="gplus"></amp-social-share>
                <amp-social-share type="email"></amp-social-share>
            </div>
        </footer>
    </div>
    <?php View::getInstance()->markFooterAssetPosition(); ?>
</body>
</html>
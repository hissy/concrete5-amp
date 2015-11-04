<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<!doctype html>
<html ⚡ lang="<?=Localization::activeLanguage()?>">
<head>
    <?php Loader::element('header_required', array('pageTitle' => isset($pageTitle) ? $pageTitle : ''));?>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom>
    body {
        margin: 0;
        font-family: Serif;
    }
    amp-img {
        background-color: #f4f4f4;
    }
    </style>
    <style>body {opacity: 0}</style><noscript><style>body {opacity: 1}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>
    <div class="<?=$c->getPageWrapperClass()?>">
        <header>
            <div class="brand-logo">
                PublisherLogo
            </div>
        </header>
        <main role="main">
            <article>
                <header>
                    <h1 itemprop="headline">Lorem Ipsum</h1>
                        <time class="header-time" itemprop="datePublished"
                  datetime="2015-09-14 13:00">September 14, 2015</time>
                </header>
                <div class="article-body" itemprop="articleBody">
                    <?php
                    $a = new Area('Main');
                    $a->display($c);
                    ?>
                </div>
            </article>
        </main>
        <footer>
            <div class="brand-logo">PublisherLogo</div>
        </footer>
    </div>
    <?php Loader::element('footer_required'); ?>
</body>
</html>
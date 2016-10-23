<?php defined('C5_EXECUTE') or die("Access Denied.");

if (is_object($f)) {
    $tag = new \Concrete\Package\Amp\Html\Object\AmpImg($f);
    if ($altText) {
        $tag->alt(h($altText));
    } else {
        $tag->alt('');
    }
    if ($title) {
        $tag->title(h($title));
    }
    if ($linkURL) {
        print '<a href="' . $linkURL . '">';
    }

    print $tag;

    if ($linkURL) {
        print '</a>';
    }
}
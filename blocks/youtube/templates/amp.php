<?php defined('C5_EXECUTE') or die("Access Denied.");
$tag = \HtmlObject\Element::create('amp-youtube');
$tag->setAttribute('data-videoid', h($videoID));
$tag->setAttribute('layout', 'responsive');
$width = ($vWidth) ? $vWidth : '480';
$height = ($vHeight) ? $vHeight : '270';
$tag->setAttribute('width', h($width));
$tag->setAttribute('height', h($height));
echo $tag;

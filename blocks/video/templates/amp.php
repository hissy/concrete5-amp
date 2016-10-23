<?php
defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
$vWidth=intval($controller->width);
$vHeight=intval($controller->height);
if (!$webmURL && !$oggURL && !$mp4URL) { ?>
    <p><?=t('No Video Files Selected.')?></p>
<?php } else if ($webmURL || $oggURL || $mp4URL) { ?>
    <amp-video width="<?=$controller->width?>" height="<?=$controller->height?>" src="<?=$mp4URL?>"
    <?php echo $posterURL ? 'poster="'.$posterURL.'"' : '' ?>>
        <?php if($webmURL) { ?>
        <source src="<?php echo $webmURL ?>" type="video/webm" />
        <?php }
        if ($oggURL) { ?>
        <source src="<?php echo $oggURL ?>" type="video/ogg" />
        <?php }
        if ($mp4URL) { ?>
            <source src="<?php echo $mp4URL ?>" type="video/mp4" />
        <?php } ?>
    </amp-video>
<? } ?>
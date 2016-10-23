<?php defined('C5_EXECUTE') or die("Access Denied.");?>

<form action="<?php echo $this->action('update_settings')?>" method="post">
    <?php echo $this->controller->token->output('update_settings')?>
    <fieldset>
        <legend><?php echo t('Basic'); ?></legend>
        <div class="form-group">
            <?php echo $form->label('types', t('Which Page Types should serve AMP Page?')); ?>
            <div style="width: 100%">
                <?php echo $form->selectMultiple('types', $pagetypes, $types, array('style' => 'width: 100%')); ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend><?php echo t('Google Analytics'); ?></legend>
        <div class="form-group">
            <?php echo $form->label('account', t('Property ID')); ?>
            <?php echo $form->text('account', $account, array('placeholder' => 'UA-XXXXX-Y')); ?>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-success" type="submit" ><?php echo t('Save')?></button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function() {
        $('#types').removeClass('form-control').select2();
    });
</script>
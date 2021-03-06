<?php defined('C5_EXECUTE') or die('Access Denied.');

$included = $permissionAccess->getAccessListItems();
$excluded = $permissionAccess->getAccessListItems(PermissionKey::ACCESS_TYPE_EXCLUDE);
$attribs = UserAttributeKey::getList();
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$form = $app->make('helper/form');
?>

<?php if (count($included) > 0 || count($excluded) > 0) { ?>
    <?php if (count($included) > 0) { ?>
        <h4><?php echo t('Who can view what?')?></h4>
        <?php foreach ($included as $assignment) {
            $entity = $assignment->getAccessEntityObject();
        ?>
            <div class="clearfix">
            	<label class="control-label"><?php echo $entity->getAccessEntityLabel()?></label>
            	<div class="input">
                	<?php echo $form->select('viewAttributesIncluded[' . $entity->getAccessEntityID() . ']', array('A' => t('All Attributes'), 'C' => t('Custom')), $assignment->getAttributesAllowedPermission())?>
                    <br>
                	<ul class="inputs-list" <?php if ($assignment->getAttributesAllowedPermission() != 'C') { ?>style="display: none"<?php } ?>>
                		<?php foreach ($attribs as $ak) { ?>
                			<li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="akIDInclude[<?php echo $entity->getAccessEntityID()?>][]" value="<?php echo $ak->getAttributeKeyID()?>" <?php
                                        if (in_array($ak->getAttributeKeyID(), $assignment->getAttributesAllowedArray())) { ?> checked="checked" <?php } ?>>
                                        <span><?php echo $ak->getAttributeKeyDisplayName()?></span>
                                    </label>
                                </div>
                            </li>
                		<?php
                        }
                        ?>
                	</ul>
            	</div>
            </div>
        <?php
        }
    }
    ?>

    <?php if (count($excluded) > 0) { ?>
        <h3><?php echo t('Who can\'t view what?')?></h3>
        <?php foreach ($excluded as $assignment) {
            $entity = $assignment->getAccessEntityObject();
        ?>
            <div class="clearfix">
            	<label class="control-label"><?php echo $entity->getAccessEntityLabel()?></label>
            	<div class="input">
            	<?php echo $form->select('viewAttributesExcluded[' . $entity->getAccessEntityID() . ']', array('N' => t('No Attributes'), 'C' => t('Custom')), $assignment->getAttributesAllowedPermission())?>
                <br>
                	<ul class="inputs-list" <?php if ($assignment->getAttributesAllowedPermission() != 'C') { ?>style="display: none"<?php } ?>>
                		<?php foreach ($attribs as $ak) { ?>
                			<li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="akIDExclude[<?php echo $entity->getAccessEntityID()?>][]" value="<?php echo $ak->getAttributeKeyID()?>" <?php
                                        if (in_array($ak->getAttributeKeyID(), $assignment->getAttributesAllowedArray())) { ?> checked="checked" <?php } ?>>
                                        <span><?php echo $ak->getAttributeKeyDisplayName()?></span>
                                    </label>
                                </div>
                            </li>
                		<?php
                        }
                        ?>
                	</ul>
            	</div>
            </div>
        <?php
        }
    }
    ?>

<?php
} else { ?>
	<p><?php echo t('No users or groups selected.')?></p>
<?php
}
?>

<script>
$(function() {
	$("#ccm-tab-content-custom-options select").change(function() {
		if ($(this).val() == 'C') {
			$(this).parent().find('ul.inputs-list').show();
		} else {
			$(this).parent().find('ul.inputs-list').hide();
		}
	});
});
</script>

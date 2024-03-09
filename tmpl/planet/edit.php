<?php
/**
 * @package     Kanev.Donations
 * @subpackage  com_lms
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var \TechFry\Component\Stars\Administrator\View\Planet\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('core')
    ->useScript('jquery')
    ->useScript('form.validate')
    ->useScript('keepalive');

$wa->registerAndUseScript('jquery.ui.core', Uri::root().'components/com_stars/assets/js/jquery.ui.core.min.js', [], ['defer' => true], []);
$wa->registerAndUseScript('jquery.ui.widget', Uri::root().'components/com_stars/assets/js/jquery.ui.widget.min.js', [], ['defer' => true], []);
$wa->registerAndUseScript('jquery.ui.draggable', Uri::root().'components/com_stars/assets/js/jquery.ui.draggable.min.js', [], ['defer' => true], []);

$wa->registerAndUseScript('jquery.fileupload', Uri::root().'components/com_stars/assets/js/jquery.fileupload.min.js', [], ['defer' => true], []);
$wa->registerAndUseScript('jquery.fileupload-process', Uri::root().'components/com_stars/assets/js/jquery.fileupload-process.min.js', [], ['defer' => true], []);
$wa->registerAndUseScript('jquery.fileupload-validate', Uri::root().'components/com_stars/assets/js/jquery.fileupload-validate.min.js', [], ['defer' => true], []);
$wa->registerAndUseScript('jquery.Jcrop', Uri::root().'components/com_stars/assets/js/jquery.Jcrop.min.js', [], ['defer' => true], []);

$wa->registerAndUseStyle('jquery.fileupload.style', Uri::root().'components/com_stars/assets/styles/jquery.fileupload.min.css');
$wa->registerAndUseStyle('jquery.Jcrop.style', Uri::root().'components/com_stars/assets/styles/jquery.Jcrop.min.css');

?>

<form action="<?php echo Route::_('index.php?option=com_stars&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="category-form" aria-label="<?php echo Text::_('COM_BANNERS_BANNER_FORM_' . ((int) $this->item->id === 0 ? 'NEW' : 'EDIT'), true); ?>" class="form-validate">
	<input type="hidden" name="jform[language_translation_changed]" id="language_translation_changed" value="0" />
	<?php // echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="main-card">
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'details', 'recall' => true, 'breakpoint' => 768]); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_STARS_ITEM_DETAILS')); ?>
		<div class="row">
			<div class="col-lg-9">
        <?php echo $this->form->renderField('title'); ?>
				<?php
				echo $this->form->renderField('description');
				?>
			</div>
			<div class="col-lg-3">
				<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row">
			<div class="col-md-6">
				<fieldset id="fieldset-publishingdata" class="options-form">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></legend>
					<div>
						<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
	</div>

	<input type="hidden" name="task" value="">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.titles-flag-wrap .titles-flag').click(function(e){
		var flagID = jQuery(this).attr('id');
		jQuery('.titles-content').css({'display':'none'});
		jQuery('.btnLabelWrap').css({'display':'none'});
		jQuery(this).siblings().removeClass('btn-success');
		jQuery(this).addClass('btn-success');
		jQuery('.titles-content-wrap').find('[data-language="'+flagID+'"]').css({'display':'block'});
		jQuery('.button-text').find('[data-language="'+flagID+'"]').css({'display':'block'});
	});
	jQuery('.input_translated_title').change(function(e){
		jQuery('#language_translation_changed').val(1);
	}); 
})
</script>
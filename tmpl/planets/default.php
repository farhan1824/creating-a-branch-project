<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
?>
<form action="<?php echo Route::_('index.php?option=com_stars&view=planets'); ?>" 
 method="post" name="adminForm" id="adminForm">
 <?php if (empty($this->items)) : ?>
    <!-- <div class="alert alert-info">
        <span class="icon-info-circle" aria-hidden="true"></span> 
        <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
    </div> -->
<?php

$displayData = [
	'textPrefix' => 'COM_STARS_PLANET',
	'formURL'    => 'index.php?option=com_stars&view=planets',
	'helpURL'    => '',
	'icon'       => 'icon-bookmark',
];

$user = Factory::getApplication()->getIdentity();

if ($user->authorise('core.create', 'com_stars') )
{
	$displayData['createURL'] = 'index.php?option=com_stars&task=planet.add';
}

echo LayoutHelper::render('joomla.content.emptystate', $displayData);
?>
    
<?php else : ?>
    <!-- ai filter take table er upor dite hobe qs holo aita empty diplay te show korbe na  -->
    <?php echo LayoutHelper::render('joomla.searchtools.default', ['view' => $this]); ?>
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th><?php echo HTMLHelper::_('grid.checkall'); ?></th>
            <!-- <th>Status</th>
            <th>Title</th>
            <th>ID</th> -->
            <th><?php echo HTMLHelper::_('grid.checkall'); ?></th>
<th>
 <?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.published', $this->listDirn, $this->listOrder); ?>
</th>
<th>
 <?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $this->listDirn, $this->listOrder); ?>
</th>
<th>
 <?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $this->listDirn, $this->listOrder); ?>
</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($this->items as $i => $item) : ?>
        <tr>
            <td><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
            <td><?php echo $item->published; ?></td>
            <td>
                <a href="/<?php echo Route::_('index.php?option=com_stars&task=planet.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?>"> 
                    <?php echo $this->escape($item->title); ?>
                </a>
            </td>
            <td><?php echo $item->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<input type="hidden" name="task" value="">
    <input type="hidden" name="boxchecked" value="0">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
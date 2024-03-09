<?php
/**
 * @package     Kanev.Donations
 * @subpackage  com_kdonations
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;

$displayData = [
	'textPrefix' => 'COM_STARS_CATEGORY',
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

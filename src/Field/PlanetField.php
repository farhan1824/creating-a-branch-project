<?php
/**
 * @package     Kanev.LMS
 * @subpackage  com_lms
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace TechFry\Component\Stars\Administrator\Field;

\defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ListField;
// use TechFry\Component\Stars\Administrator\Helper\LmsHelper;

/**
 * Category field.
 *
 * @since  1.6
 */
class PlanetField extends ListField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Planet';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.6
	 */
	// public function getOptions()
	// {
	// 	return array_merge(parent::getOptions(), LmsHelper::getCategoryOptions());
	// }
}

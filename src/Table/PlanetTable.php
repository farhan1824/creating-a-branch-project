<?php
/**
 * @package     Kanev.Donations
 * @subpackage  com_kdonations
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace TechFry\Component\Stars\Administrator\Table;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * Category table
 *
 * @since  1.5
 */
class PlanetTable extends Table 
{
	/**
	 * Indicates that columns fully support the NULL value in the database
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $_supportNullValue = true;

	/**
	 * Constructor
	 *
	 * @param   DatabaseDriver  $db  Database connector object
	 *
	 * @since   1.5
	 */
	public function __construct(DatabaseDriver $db)
	{
		$this->typeAlias = 'com_stars.planet';

		parent::__construct('#__Planets', 'id', $db);

		$this->created = Factory::getDate()->toSql();
		$this->setColumnAlias('published', 'state');
	}

	/**
	 * Overloaded check function
	 *
	 * @return  boolean
	 *
	 * @see     Table::check
	 * @since   1.5
	 */
	public function check()
	{
		try
		{
			parent::check();
		}
		catch (\Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Set name
		$this->name = htmlspecialchars_decode($this->name, ENT_QUOTES);

		// Set alias
		if (trim($this->alias) == '')
		{
			$this->alias = $this->name;
		}

		//$this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
		$this->alias = ApplicationHelper::stringURLSafe($this->alias);

		if (trim(str_replace('-', '', $this->alias)) == '')
		{
			$this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
		}

		// Set created date if not set.
		if (!(int) $this->created)
		{
			$this->created = Factory::getDate()->toSql();
		}

		// Set ordering
		if ($this->state < 0)
		{
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		}
		elseif (empty($this->ordering))
		{
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder($this->_db->quoteName('state') . ' >= 0');
		}

		// Set modified to created if not set
		if (!$this->modified)
		{
			$this->modified = $this->created;
		}

		// Set modified_by to created_by if not set
		if (empty($this->modified_by))
		{
			$this->modified_by = $this->created_by;
		}

		return true;
	}

	/**
	 * Overloaded bind function
	 *
	 * @param   mixed  $array   An associative array or object to bind to the \JTable instance.
	 * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.5
	 */
	public function bind($array, $ignore = array())
	{
		return parent::bind($array, $ignore);
	}

	/**
	 * Method to store a row
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success, false on failure.
	 */
	public function store($updateNulls = true)
	{
		$db = $this->getDbo();

		if (empty($this->id))
		{
			// Store the row
			parent::store($updateNulls);
		}
		else
		{
			// Get the old row
			/** @var PlanetTable $oldrow */
			$oldrow = Table::getInstance('PlanetTable', __NAMESPACE__ . '\\', array('dbo' => $db));

			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}

			// Verify that the alias is unique
			/** @var PlanetTable $table */
			$table = Table::getInstance('PlanetTable', __NAMESPACE__ . '\\', array('dbo' => $db));

			if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0))
			{
				$this->setError(Text::_('COM_BANNERS_ERROR_UNIQUE_ALIAS'));

				return false;
			}

			// Store the new row
			parent::store($updateNulls);

			// Need to reorder ?
			if ($oldrow->state >= 0 && ($this->state < 0))
			{
				// Reorder the oldrow
				$this->reorder($this->_db->quoteName('state') . ' >= 0');
			}
		}

		return count($this->getErrors()) == 0;
	}
}

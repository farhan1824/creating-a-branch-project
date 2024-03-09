<?php
namespace TechFry\Component\Stars\Administrator\View\Planets;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\ContentHelper;
class HtmlView extends BaseHtmlView 
{
    public function display($tpl = null) 
    {
		/** @var BannersModel $model */
		$model               = $this->getModel();
		$this->items         = $model->getItems();
		$this->pagination    = $model->getPagination();
		$this->state         = $model->getState();
		$this->filterForm    = $model->getFilterForm();
		$this->activeFilters = $model->getActiveFilters();

		if (!\count($this->items) && $this->isEmptyState = $this->get('IsEmptyState'))
		{
			$this->setLayout('emptystate');
		}

		// Check for errors.
		if (\count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		parent::display($tpl);
    }
	protected function addToolbar(): void
	{
		$canDo = ContentHelper::getActions('com_stars');
		$user  = Factory::getApplication()->getIdentity();

		// Get the toolbar object instance
		$toolbar = Toolbar::getInstance('toolbar');

		ToolbarHelper::title(Text::_('COM_STARS_MANAGER_CATEGORIES'), 'bookmark');

		if ($canDo->get('core.create') )
		{
			$toolbar->addNew('planet.add');
		}
        $this->state = $this->get('State');

        $this->listOrder = $this->escape($this->state->get('list.ordering'));
        $this->listDirn = $this->escape($this->state->get('list.direction'));

		if (!$this->_defaultModel && ($canDo->get('core.edit.state') || ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))))
		{
			$dropdown = $toolbar->dropdownButton('status-group')
				->text('JTOOLBAR_CHANGE_STATUS')
				->toggleSplit(false)
				->icon('icon-ellipsis-h')
				->buttonClass('btn btn-action')
				->listCheck(true);

			$childBar = $dropdown->getChildToolbar();

			if ($canDo->get('core.edit.state'))
			{
				if ($this->state->get('filter.published') != 2)
				{
					$childBar->publish('planets.publish')->listCheck(true);

					$childBar->unpublish('planets.unpublish')->listCheck(true);
				}

				if ($this->state->get('filter.published') != -1)
				{
					if ($this->state->get('filter.published') != 2)
					{
						$childBar->archive('planets.archive')->listCheck(true);
					}
					elseif ($this->state->get('filter.published') == 2)
					{
						$childBar->publish('publish')->task('planets.publish')->listCheck(true);
					}
				}

				$childBar->checkin('planets.checkin')->listCheck(true);

				if ($this->state->get('filter.published') != -2)
				{
					$childBar->trash('planets.trash')->listCheck(true);
				}
			}

			if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
			{
				$toolbar->delete('planets.delete')
					->text('JTOOLBAR_EMPTY_TRASH')
					->message('JGLOBAL_CONFIRM_DELETE')
					->listCheck(true);
			}
		}

		if ($user->authorise('core.admin', 'com_stars') || $user->authorise('core.options', 'com_stars'))
		{
			$toolbar->preferences('com_stars');
		}
	}
}
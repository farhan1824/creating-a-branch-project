<?php
namespace TechFry\Component\Stars\Administrator\View\Planet;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;
class HtmlView extends BaseHtmlView
{
    protected $form;
    protected $item;
    
    public function display($tpl = null) 
    {
        $this->form = $this->get('Form');
        $this->item  = $this->get('Item');
        $this->addToolbar();
        parent::display($tpl);
    }
    protected function addToolbar()
{
    Factory::getApplication()->getInput()->set('hidemainmenu', true);
    ToolbarHelper::title('Planet: Add');
     
    ToolbarHelper::apply('planet.apply');
    ToolbarHelper::save('planet.save');
    ToolbarHelper::cancel('planet.cancel', 'JTOOLBAR_CLOSE');
}
}
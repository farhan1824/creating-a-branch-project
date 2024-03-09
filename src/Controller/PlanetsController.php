<?php
namespace TechFry\Component\Stars\Administrator\Controller;
use Joomla\CMS\MVC\Controller\AdminController;

class PlanetsController extends AdminController
{
    public function getModel($name = 'Planet', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
}
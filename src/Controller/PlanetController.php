<?php
namespace TechFry\Component\Stars\Administrator\Controller;
use Joomla\CMS\MVC\Controller\FormController;

class PlanetController extends FormController
{
    /**
    * Method override to check if you can add a new record.
    *
    * @param   array  $data  An array of input data.
    *
    * @return  boolean
    *
    * @since   1.6
    */
   protected function allowAdd($data = array())
   {
       // In the absence of better information, revert to the component permissions.
       return parent::allowAdd($data);
   }
   
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId   = (int) isset($data[$key]) ? $data[$key] : 0;

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

}
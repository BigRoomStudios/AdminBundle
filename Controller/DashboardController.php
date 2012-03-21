<?php

namespace BRS\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BRS\CoreBundle\Core\Widget\PanelWidget;
use BRS\CoreBundle\Core\Utility;

/**
 * Member controller.
 *
 * @Route("")
 */
class DashboardController extends AdminController
{
	protected function setup()
	{
		parent::setup();
			
		$dashboard = new PanelWidget();
		
		$this->addWidget($dashboard, 'dashboard');
		
		$this->addView('index', $dashboard);
	}
	
}
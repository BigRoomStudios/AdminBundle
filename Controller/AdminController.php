<?php

namespace BRS\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;

use BRS\CoreBundle\Core\WidgetController;
use BRS\CoreBundle\Core\Navigator;

/**
 * AdminController defines a few preset routes and default entity management
 * @Route("_")
 */
class AdminController extends WidgetController
{
	protected $navigator;
	protected $route;
	
	protected function getNav(){
		
		return $this->nav;
	}
	
	protected function setNav($nav){
		
		$this->nav = $nav;
	}
	
	protected function getViewValues(){
		
		$this->route = $this->getRequest()->get('_route');
		
		$nav = $this->container->getParameter('admin.nav');
		
		$this->navigator = new Navigator($nav);
		
		$this->navigator->setSelected($this->route);
		
		return array(
			'route' => $this->route,
			'nav' => $this->navigator->getNav(),
		);
	}
	
	
	
	
	//-- ACTIONS --//
	
	/**
	 * Default view for this admin module
	 *
	 * @Route("/")
	 * @Template("BRSAdminBundle:Admin:default.html.twig")
	 */
	public function indexAction()
	{
		$view = $this->getView('index');
		
		$view->handleRequest();
		
		$values = array(
		
			'view' => $view->render(),
		);
		
		if($this->isAjax()){
			
			return $this->jsonResponse($values);
		}
		
		$values = array_merge( $this->getViewValues(), $values );
		
		return $values;
	}


	/**
	 * Displays a form to create a new entity for this admin module
	 *
	 * @Route("/new")
	 * @Template("BRSAdminBundle:Admin:default.html.twig")
	 */
	public function newAction()
	{
		//print($request);	
			
		$view = $this->getView('new');
		
		$id = $view->handleRequest();
		
		if($id){
			
			return $this->redirect($this->generateUrl($this->getRouteName() . '_edit', array('id' => $id)));
		}
		
		$values = array(
		
			'view' => $view->render(),
		);
		
		if($this->isAjax()){
			
			return $this->jsonResponse($values);
		}
		
		$values = array_merge( $this->getViewValues(), $values );
		
		return $values;
	}

	/**
	 * Displays a form to edit an existing entity for this admin module
	 *
	 * @Route("/{id}/edit")
	 * @Template("BRSAdminBundle:Admin:default.html.twig")
	 */
	public function editAction($id)
	{
		//die('test');	
			
		$view = $this->getView('edit');
		
		$view->getById($id);
		
		$view->handleRequest();
		
		$values = array(
		
			'view' => $view->render(),
		);
		
		if($this->isAjax()){
			
			return $this->jsonResponse($values);
		}
		
		$values = array_merge( $this->getViewValues(), $values );
		
		return $values;
	}
		
	//-- END ACTIONS --//

}
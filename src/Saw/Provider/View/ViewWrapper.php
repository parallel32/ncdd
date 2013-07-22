<?php
namespace Saw\Provider\View;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use QueryPath\QueryPath;
use Saw\Model;

class ViewWrapper
{
	
	private $layoutPath   = '';
	private $viewPath 	  = '';
	private $elementPath  = '';
	public  $app          = null;
	private $vars		  = array();
	
	public function __construct($layoutPath, $viewPath, $elementPath, Application $app)
	{
		$this->layoutPath   = $layoutPath;
		$this->viewPath 	= $viewPath;
		$this->elementPath  = $elementPath;
		$this->app         	= $app;

	}
	
	public function render($view, $layout = null, $vars=array()){
		
		$this->vars = $vars;
		$layout = (!empty($layout)) ? $layout : 'default' ;
		
		ob_start();
		include($this->layoutPath.$layout.'.php');
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	public function content($view){
		
		ob_start();
		include($this->viewPath.$view.'.php');
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
		
	}

	public function element($element,$params=array()){
		
		ob_start();
		if(!empty($params)){
			extract($params);
		}
		include($this->elementPath.$element.'.php');
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
		
	}
	
	public function pp($arr){
	    $retStr = '<ul>';
	    if (is_array($arr)){
	        foreach ($arr as $key=>$val){
	            if (is_array($val)){
	                $retStr .= '<li>' . $key . ' => ' . $this->pp($val) . '</li>';
	            }else{
	                $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
	            }
	        }
	    }
	    $retStr .= '</ul>';
	    return $retStr;
	}

}

?>

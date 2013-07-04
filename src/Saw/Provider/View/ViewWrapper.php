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
	
	public function renderPageTypeByRoute($route, $siteKey,$vars=array()){
		$content = '';
		$collection = 'domain';
		$file_name = '';
		$query = array('siteKey'=>$siteKey,'pageTypes.route'=>$route);
		$fields = array('pageTypes.fileName'=>true,'pageTypes.route'=>true);
		$result = $this->app['mongo']->findOne($collection, $query, $fields, $slaveOkay=true);

		if(!empty($result)):
			foreach($result['pageTypes'] as $pageType):
				if($pageType['route'] == $route){
					$file_name = $pageType['fileName'];
				}
			endforeach;
			$include_str = 'http://'.SAW_ADMIN_WEBSITE.'/cfs/'.$siteKey.$file_name;
//error_log('include string:::::'.$include_str);
			ob_start();
			include($include_str);
			$content = ob_get_contents();
			ob_end_clean();
			
		endif;
		return $content;
	
	}





	public function replaceTags($startPoint, $endPoint, $newText, $source) {
	    return preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$newText.'$3', $source);
	}

	

	public function renderPageByRoute(Request $request, $route, $siteKey,$vars=array()){
		$content = '';
		$query = array('siteKey'=>$siteKey,'route'=>$route);
		$fields = array('pageType'=>true,'sections'=>true,'statusCode'=>true,'_id'=>true);
		$result = $this->app['mongo']->findOne('link', $query, $fields, $slaveOkay=true);
//error_log('renderPageByRoute:::result:'.print_r($result,true));
		if(!empty($result)):
			$content = $this->renderPageTypeByRoute($result['pageType'], $siteKey,$vars);
			// use query path to find the content sections and inject the data based on $result['sections']
			// and add the page id via $result['_id']
			// contenteditable="true" data-section="AA" data-pageid=""
			$qpObj = htmlqp($content);
			foreach($qpObj->find('[data-pageid]') as $item){
			    if($item->hasAttr('data-pageid')){
			        $item->attr('data-pageid',$result['_id']);
			    }
			}
			if(array_key_exists('sections',$result)):
				foreach($qpObj->find('[data-section]') as $item){
				    if($item->hasAttr('data-section')){
				        $section = $item->attr('data-section');
				        foreach($result['sections'] as $sections){
				        	if($sections['label'] == $section){
				        		if(!empty($sections['value'])){
				        			$item->html($sections['value']);
				        		}
				        	}
				        }
				    }
				}
			endif;
			// if this is the alias domain i.e. domain.com.local.sawstud.io: 
			// then append the content editing javascript and update contenteditable="true" .. by default it's set to false via the template (hardcoded that way)
			if(strpos($request->getHost(), SAW_ADMIN_WEBSITE) !== false){
				
				foreach($qpObj->find('[contenteditable]') as $item){
				    if($item->hasAttr('contenteditable')){
				        $item->attr('contenteditable','true');
				    }
				}

				// include some styling for the contenteditable
				// seems to get added properly without querypath converting the <style> tags into htmlentities
				$qpObj->find('head')->append(SAW_CONTENT_EDITOR_STYLES);
				
				// cannot do it this way because querypath will convert the <script> tags into htmlentities
				//$qpObj->find('body')->textBefore(SAW_CONTENT_EDITOR_JAVASCRIPT);
			}

			ob_start();
			$qpObj->writeHTML();
			$content = ob_get_contents();
			$content = $content.SAW_CONTENT_EDITOR_JAVASCRIPT;
			ob_end_clean();	

		endif;
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
			extract($param);
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

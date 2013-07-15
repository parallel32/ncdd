<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Saw\Model;
use dflydev\markdown\MarkdownParser;

// Logic for validating model fields
$app['validateModel'] = $app->protect(function ($app,$model,$groups=array()) {
	if(!empty($groups))
		$violations = $app['validator']->validate($model,$groups);
	else
		$violations = $app['validator']->validate($model);
	if(is_object($violations) && count($violations)>0):
		foreach ($violations as $violation):
			$fields[] = array('name'=>$violation->getPropertyPath(),
							  'message'=>$violation->getMessage(),
							  'invalid_value'=>$violation->getInvalidValue());
		endforeach;
		throw new Saw\Model\Exceptions\DomainException($model::$invalidFieldsMessage, $fields);
	endif;	
});
return $app;
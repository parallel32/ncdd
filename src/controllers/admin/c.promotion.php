<?php
////////////////////////
// FOURMS CONTROLLERS //
////////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$promotion = $app['controllers_factory'];
$promotion->before($mustbeADMIN);

////////////
//  HOME  //
////////////
$promotion->get('/', function (Request $request) use ($app) {
	
	$promotion = new Model\Promotion(array(),$app);
	$promotions = $promotion->find();
	
	// count how many sign ups per promotion there have been.
	for ($i=0; $i < count($promotions) ; $i++) { 

		switch ($promotions[$i]['currentStatus']) {
			case Model\Promotion::$status['NEWMEMBER']:
				$obj = new Model\Apply(array(),$app);
				$promotions[$i]['count'] = $obj->count(array('promotion.code'=>$promotions[$i]['code']));
				break;
			case Model\Promotion::$status['RENEWAL']:
				
				break;
			case Model\Promotion::$status['STORE']:
				
				break;
		}
	}
	
	$crumbs = array(array('name'=>'Promotion','href'=>'/promotion'));
	$view_vars = array(
						 'active'=>'Promotion'
						,'page-plugin'=>'datatables'
						,'headline'=>'Promotion'
						,'description'=>""
						,'crumbs'=>$crumbs
						,'promotions'=>$promotions
						
						);
	return $app['view']->render('promotion/index', 'default', $view_vars);
});


// add / edit a promotion
$promotion->get('/edit/{promotionId}', function ($promotionId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'Promotion','href'=>'/promotion')
					,array('name'=>'Manage Promotions','href'=>'/promotion/index')
	);
	$view_vars = array(
						 'active'=>'Promotion'
						,'page-plugin'=>''
						,'headline'=>(empty($promotionId)) ? 'Add a new promotion' : 'Edit your promotion' 
						,'description'=>(empty($promotionId)) ? "Add a new promotion here" : "Edit your promotion here"
						,'crumbs'=>$crumbs
						);
	
	if(!empty($promotionId)){	
		$promotion = new Model\Promotion(array('_id'=>$promotionId),$app);
		$promotion = $promotion->findById();

		$view_vars['crumbs'][] = array('name'=>$promotion['code'],'href'=>'/promotion/edit/'.$promotionId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/promotion/edit/'.$promotionId);

		$view_vars['promotion'] = $promotion;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($promotion['image'])) ? $app['getImageURL']($promotion['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/promotion/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('promotion/edit', 'default', $view_vars);
})
->value('promotionId','');

// add / save promotion 
$promotion->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
	$promotion = new Model\Promotion($document, $app);
    // validate the model
   	$app['validateModel']($app,$promotion);
    $promotion->saveEdit();
    
    return new Response(json_encode(array('promotionId'=>$promotion->_id->__toString(), 'message' => 'Promotion details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});


// remove a promotion completely
$promotion->get('/{promotionId}/remove', function ($promotionId, Request $request) use ($app) {
	
	$promotion = new Model\Promotion(array('_id'=>$promotionId), $app);
    $promotion->findById();
	$promotion->delete();
	return new Response(json_encode(array('message' => 'Promotion details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	
});
///////////////////
// PHOTO EDITING //
///////////////////
$promotion->get('/edit/{promotionId}/edit-photo', function ($promotionId, Request $request) use ($app) {

	$promotion = new Model\Promotion($doc=array('_id'=>new MongoId($promotionId)), $app);
	$promotion = $promotion->findById();
	
	$crumbs = array(array('name'=>'Promotion','href'=>'/promotion')
					,array('name'=>'Manage Promotions','href'=>'/promotion/index')
					,array('name'=>$promotion['code'],'href'=>'/promotion/edit/'.$promotionId)
					,array('name'=>'edit','href'=>'/promotion/edit/'.$promotionId)
					,array('name'=>'photo','href'=>'/promotion/edit/'.$promotionId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Promotion'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Promotion'
						,'description'=>"Edit promotion photo"
						,'crumbs'=>$crumbs
						,'promotion'=>$promotion
						,'image'=>(!empty($promotion['image'])) ? $app['getImageURL']($promotion['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($promotion['image'])) ? '/image/delete/'.$promotion['image']['context'].'/'.$promotion['image']['belongsTo'] : '');
	return $app['view']->render('promotion/edit-photo', 'default', $view_vars);
})
->value('promotionId','');

$promotion->get('/edit/{promotionId}/edit-photo-crop', function ($promotionId, Request $request) use ($app) {

	$promotion = new Model\Promotion($doc=array('_id'=>new MongoId($promotionId)), $app);
	$promotion = $promotion->findById();
	
	$crumbs = array(array('name'=>'Promotion','href'=>'/promotion')
					,array('name'=>'Manage Promotions','href'=>'/promotion/index')
					,array('name'=>$promotion['code'],'href'=>'/promotion/edit/'.$promotionId)
					,array('name'=>'edit','href'=>'/promotion/edit/'.$promotionId)
					,array('name'=>'photo','href'=>'/promotion/edit/'.$promotionId.'/edit-photo')
					,array('name'=>'crop','href'=>'/promotion/edit/'.$promotionId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Promotion'
						,'page-plugin'=>'crop'
						,'headline'=>'Promotion'
						,'description'=>"Crop promotion photo"
						,'crumbs'=>$crumbs
						,'promotion'=>$promotion
						,'image'=>(!empty($promotion['image'])) ? $app['getImageURL']($promotion['image'],'large') : '/placeholder'
						);
	return $app['view']->render('promotion/edit-photo-crop', 'default', $view_vars);
})
->value('promotionId','');

return $promotion;
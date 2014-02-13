<?php
///////////////////////
// MEMBER MANAGEMENT //
///////////////////////
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Saw\Model;

$product= $app['controllers_factory'];
$product->before($mustbeADMIN);

$product->get('/', function (Request $request) use ($app) {
	
	$order = new Model\Order(array(),$app);
	$new_orders = $order->fetchByStatus('NEW');
	$new_orders_cnt = (is_array($new_orders) && !empty($new_orders)) ? count($new_orders): 0;
	$fulfilled_orders = $order->fetchByStatus('SHIPPED');
	$fulfilled_orders_cnt = (is_array($fulfilled_orders) && !empty($fulfilled_orders)) ? count($fulfilled_orders): 0;

	$product= new Model\Product(array(),$app);
	$products = $product->fetchByStatus();
	$products_cnt = (is_array($products) && !empty($products)) ? count($products): 0;

	$crumbs = array(array('name'=>'NCDD Store','href'=>'/product'));
	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'datatables'
						,'headline'=>'NCDD Store'
						,'description'=>"Manage products and fulfill orders here."
						,'crumbs'=>$crumbs
						,'products'=>$products
						,'productsCnt'=>$products_cnt
						,'fulfilledCnt'=>$fulfilled_orders_cnt
						,'newOrdersCnt'=>$new_orders_cnt
						,'newOrders'=>$new_orders
						,'fulfilledOrders'=>$fulfilled_orders
						);
	return $app['view']->render('product/index', 'default', $view_vars);
});


// member add / edit a post
$product->get('/edit/{productId}', function ($productId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'NCDD Store','href'=>'/product'));
	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'editor'
						,'headline'=>(empty($productId)) ? 'Add a new product' : 'Edit your product' 
						,'description'=>"Edit your post and submit it for review when finished."
						,'crumbs'=>$crumbs
						,'availableCategories'=>Model\Product::getAvailableCategories($app)
						);
	
	if(!empty($productId)){	
		$product= new Model\Product(array('_id'=>$productId),$app);
		$product= $product->findById();
		$view_vars['crumbs'][] = array('name'=>$product['name'],'href'=>'/product/edit/'.$productId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/product/edit/'.$productId);

		$view_vars['product'] = $product;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($product['image'])) ? $app['getImageURL']($product['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/product/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('product/edit', 'default', $view_vars);
})->value('productId','');

// add / save productpost
$product->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $product= new Model\Product($document, $app);
    // validate the model
   	$app['validateModel']($app,$product);
    $product->saveEdit();
    
    return new Response(json_encode(array('productId'=>$product->_id->__toString(), 'message' => 'Product details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);


///////////////////
// PHOTO EDITING //
///////////////////
$product->get('/edit/{productId}/edit-photo', function ($productId, Request $request) use ($app) {

	$product = new Model\Product($doc=array('_id'=>new MongoId($productId)), $app);
	$product = $product->findById();
	
	
	$crumbs = array(array('name'=>'NCDD Store','href'=>'/product')
					,array('name'=>$product['name'],'href'=>'/product/edit/'.$productId)
					,array('name'=>'edit','href'=>'/product/edit/'.$productId)
					,array('name'=>'photo','href'=>'/product/edit/'.$productId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Product'
						,'description'=>"Edit product photo"
						,'crumbs'=>$crumbs
						,'product'=>$product
						,'image'=>(!empty($product['image'])) ? $app['getImageURL']($product['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($product['image'])) ? '/image/delete/'.$product['image']['context'].'/'.$product['image']['belongsTo'] : '');
	return $app['view']->render('product/edit-photo', 'default', $view_vars);
})
->value('productId','');

$product->get('/edit/{productId}/edit-photo-crop', function ($productId, Request $request) use ($app) {

	$product = new Model\Product($doc=array('_id'=>new MongoId($productId)), $app);
	$product = $product->findById();
	
	$crumbs = array(array('name'=>'NCDD Store','href'=>'/product')
					,array('name'=>$product['name'],'href'=>'/product/edit/'.$productId)
					,array('name'=>'edit','href'=>'/product/edit/'.$productId)
					,array('name'=>'photo','href'=>'/product/edit/'.$productId.'/edit-photo')
					,array('name'=>'crop','href'=>'/product/edit/'.$productId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'crop'
						,'headline'=>'Product'
						,'description'=>"Crop product photo"
						,'crumbs'=>$crumbs
						,'product'=>$product
						,'image'=>(!empty($product['image'])) ? $app['getImageURL']($product['image'],'large') : '/placeholder'
						);
	return $app['view']->render('product/edit-photo-crop', 'default', $view_vars);
})
->value('productId','');




// slugify
$product->post('/slugify', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $slug = Model\Product::slugify($doc['name']);
    
    return new Response(json_encode(array('slug'=>$slug, 'message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));
});

// remove a product completely
$product->get('/{productId}/remove', function ($productId, Request $request) use ($app) {
	$product = new Model\Product(array('_id'=>$productId), $app);
    $product->findById();
	$product->remove();
	return new Response(json_encode(array('message' => 'Product has been removed successfully.')), 200,array('Content-Type' => 'application/json'));
	
});


///////////////////
// ORDER EDITING //
///////////////////
$product->get('/order/edit/{orderId}', function ($orderId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'NCDD Store','href'=>'/product'));
	$view_vars = array(
						 'active'=>'Store'
						,'page-plugin'=>'editor'
						,'headline'=>'Order Edit' 
						,'description'=>"Fulfill or view the order."
						,'crumbs'=>$crumbs
						,'availableCategories'=>Model\Product::getAvailableCategories($app)
						);
	
	$order= new Model\Order(array('_id'=>$orderId),$app);
	$order= $order->findById();
	$view_vars['crumbs'][] = array('name'=>$order['payment']['name'],'href'=>'/product/order-edit/'.$orderId);
	$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/product/order-edit/'.$orderId);

	$view_vars['order'] = $order;
	$view_vars['add'] = 'no';

	if(!empty($order['payment']['memberId'])){
		$member = new Model\Member(array('_id'=>$order['payment']['memberId']),$app);
		$user = $member->findById();
	}else{
		$user = array();
	}		

	$view_vars['order'] = $order;
	$view_vars['user'] = $user;

	return $app['view']->render('product/order-edit', 'default', $view_vars);
})->value('orderId','');

// save order
$product->post('/order/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    $order= new Model\Order($document, $app);
    $order->saveSafe();
    
    return new Response(json_encode(array('orderId'=>$order->_id->__toString(), 'message' => 'Product details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
})->before($mustbeMEMBER);

// remove a order completely
$product->get('/{orderId}/remove/order', function ($orderId, Request $request) use ($app) {
	$order = new Model\Order(array('_id'=>$orderId), $app);
    $order->findById();
	$order->remove();
	return new Response(json_encode(array('message' => 'Product has been removed successfully.')), 200,array('Content-Type' => 'application/json'));
	
});

return $product;
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

$category = $app['controllers_factory'];
$category->before($mustbeADMIN);

////////////
//  HOME  //
////////////
$category->get('/', function (Request $request) use ($app) {
	
	$category = new Model\Category(array('currentType'=>Model\Category::$type['STORE']),$app);
	$categories = $category->fetchByType();
	$category = new Model\Category(array('currentType'=>Model\Category::$type['BLOG']),$app);
	$tags = $category->fetchByType();
	
	
	$crumbs = array(array('name'=>'Category','href'=>'/category'));
	$view_vars = array(
						 'active'=>'Category'
						,'page-plugin'=>'datatables'
						,'headline'=>'Category & Tag Management'
						,'description'=>"Here you can define the tags to be available for blog posts and categories available for products in the NCDD Store."
						,'crumbs'=>$crumbs
						,'categories'=>$categories
						,'tags'=>$tags
						);
	return $app['view']->render('category/index', 'default', $view_vars);
});


// add / edit a category
$category->get('/edit/{categoryId}', function ($categoryId, Request $request) use ($app) {
	
	$crumbs = array(array('name'=>'Category','href'=>'/category')
					,array('name'=>'Manage Categories and Tags','href'=>'/category/index')
	);
	$view_vars = array(
						 'active'=>'Category'
						,'page-plugin'=>''
						,'headline'=>(empty($categoryId)) ? 'Add a new category' : 'Edit your category' 
						,'description'=>(empty($categoryId)) ? "Add a new category here" : "Edit your category here"
						,'crumbs'=>$crumbs
						);
	
	if(!empty($categoryId)){	
		$category = new Model\Category(array('_id'=>$categoryId),$app);
		$category = $category->findById();

		$view_vars['crumbs'][] = array('name'=>$category['name'],'href'=>'/category/edit/'.$categoryId);
		$view_vars['crumbs'][] = array('name'=>'edit','href'=>'/category/edit/'.$categoryId);

		$view_vars['category'] = $category;
		$view_vars['add'] = 'no';
		$view_vars['image'] = (!empty($category['image'])) ? $app['getImageURL']($category['image'],'large') : '/placeholder';
	}else{
		$view_vars['crumbs'][] = array('name'=>'add','href'=>'/category/edit');
		$view_vars['add'] = 'yes';
		$view_vars['image'] = '/placeholder';
	}

	
	return $app['view']->render('category/edit', 'default', $view_vars);
})
->value('categoryId','');

// add / save category 
$category->post('/edit', function (Request $request) use ($app) {
	// retrieve document from request
    $document = $request->get('doc');
    
	$category = new Model\Category($document, $app);
    // validate the model
   	$app['validateModel']($app,$category);
    $category->saveEdit();
    
    return new Response(json_encode(array('categoryId'=>$category->_id->__toString(), 'message' => 'Category details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
});


// remove a category completely
$category->get('/{categoryId}/remove', function ($categoryId, Request $request) use ($app) {
	
	$category = new Model\Category(array('_id'=>$categoryId), $app);
    $category->findById();
	$category->delete();
	return new Response(json_encode(array('message' => 'Category details have saved successfully.')), 200,array('Content-Type' => 'application/json'));
	
});
///////////////////
// PHOTO EDITING //
///////////////////
$category->get('/edit/{categoryId}/edit-photo', function ($categoryId, Request $request) use ($app) {

	$category = new Model\Category($doc=array('_id'=>new MongoId($categoryId)), $app);
	$category = $category->findById();
	
	$crumbs = array(array('name'=>'Category','href'=>'/category')
					,array('name'=>'Manage Categories and Tags','href'=>'/category/index')
					,array('name'=>$category['name'],'href'=>'/category/edit/'.$categoryId)
					,array('name'=>'edit','href'=>'/category/edit/'.$categoryId)
					,array('name'=>'photo','href'=>'/category/edit/'.$categoryId.'/edit-photo')
	);

	$view_vars = array(
						 'active'=>'Category'
						,'page-plugin'=>'fileupload'
						,'headline'=>'Category'
						,'description'=>"Edit category photo"
						,'crumbs'=>$crumbs
						,'category'=>$category
						,'image'=>(!empty($category['image'])) ? $app['getImageURL']($category['image'],'large') : '/placeholder'
						,'imageDelete'=>(!empty($category['image'])) ? '/image/delete/'.$category['image']['context'].'/'.$category['image']['belongsTo'] : '');
	return $app['view']->render('category/edit-photo', 'default', $view_vars);
})
->value('categoryId','');

$category->get('/edit/{categoryId}/edit-photo-crop', function ($categoryId, Request $request) use ($app) {

	$category = new Model\Category($doc=array('_id'=>new MongoId($categoryId)), $app);
	$category = $category->findById();
	
	$crumbs = array(array('name'=>'Category','href'=>'/category')
					,array('name'=>'Manage Categories and Tags','href'=>'/category/index')
					,array('name'=>$category['name'],'href'=>'/category/edit/'.$categoryId)
					,array('name'=>'edit','href'=>'/category/edit/'.$categoryId)
					,array('name'=>'photo','href'=>'/category/edit/'.$categoryId.'/edit-photo')
					,array('name'=>'crop','href'=>'/category/edit/'.$categoryId.'/edit-photo-crop')
	);
	
	$view_vars = array(
						 'active'=>'Category'
						,'page-plugin'=>'crop'
						,'headline'=>'Category'
						,'description'=>"Crop category photo"
						,'crumbs'=>$crumbs
						,'category'=>$category
						,'image'=>(!empty($category['image'])) ? $app['getImageURL']($category['image'],'large') : '/placeholder'
						);
	return $app['view']->render('category/edit-photo-crop', 'default', $view_vars);
})
->value('categoryId','');

// slugify
$category->post('/slugify', function (Request $request) use ($app) {
	// retrieve document from request
    $doc = $request->get('doc');
    $slug = Model\Category::slugify($doc['name']);
    
    return new Response(json_encode(array('slug'=>$slug, 'message' => 'successful operation.')), 200,array('Content-Type' => 'application/json'));
});



return $category;
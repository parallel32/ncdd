<?php

namespace Saw\Component\Connect;

class GetUserResponse extends \Saw\Component\Communication\Response {
	
	/**
	 * array to validate against
	 * setting to true means incoming array must contain that element. If it does not ResponseDomainException will be thrown.
	 * setting to false means incoming array can optionally contain it. If it does not no Exceptions thrown.
	 * @var array
	 */
	protected $_template = array(	'id'=>true,
									'name'=>true,
									'profileImageUrl'=>true,
									'firstName'=>false,
									'lastName'=>false,
									'gender'=>false,
									'dob'=>false,
									'email'=>false,
									'about'=>false,
									'locale'=>false,
									/*'profileImageUrlHttps'=>false,
									'profileSidebarBorderColor'=>false,
									'profileSidebarFillColor'=>false,
									'profileBackgroundImageUrl'=>false,
									'profileBackgroundImageUrlHttps'=>false,
									'profileBackgroundTile'=>false,
									'profileBackgroundColor'=>false,
									'profileUseBackgroundImage'=>false,
									'profileTextColor'=>false,
									'profileLinkColor'=>false,*/
									'location'=>array('name'=>false,
													  'lat'=>false,
													  'lon'=>false)
								);

	public function __construct($validate){
		parent::__construct($validate);
	}
	
}
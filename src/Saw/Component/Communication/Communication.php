<?php

namespace Saw\Component\Communication;

class Communication {
	
	
	public function __construct(){
		
	}
	/**
	 * if the arrays match an empty array is returned otherwise an array of the differences 
	 * is returned
	 * @param array $arr1 the array which $arr2 is matched against
	 * @param array $arr2 the array to check
	 * @return array either an empty array or one with only the elements in arr1 not contained in arr2
	 */
	public function recursiveValidate($arr1, $arr2){
		$return_arr = array();
		foreach ($arr1 as $key => $val):
			if (array_key_exists($key, $arr2)):
				if (is_array($val)):
					$recurse_arr = $this->recursiveValidate($val, $arr2[$key]);
					if (!empty($recurse_arr)): 
						$return_arr[$key] = $recurse_arr; 
					endif;
				endif;
			else:
				if($val) // means that if the value set in template is true then it will return an array which will cause an exception
					$return_arr[$key] = $val;
			endif;
		endforeach;

		return $return_arr;

	}
	
}
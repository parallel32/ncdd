<?php
namespace Saw\Component\Payment\Services;

class StripePayment extends \Saw\Component\Payment\Payment {
	
	
	
	
	
	
	////////////////////////////
	////  UPDATE CUSTOMER //////
	////////////////////////////
	public function updateCustomer($request){
		
		
		try{
			$request = $this->updateCustomerRequest($request)->__toArray();
			\Stripe::setApiKey($this->keys['skey']);
			$cu = \Stripe_Customer::retrieve($request['vaultId']);
			$cu->email = $request['email'];
			$cu->description = $request['description'];
			$cu->card = $request['token']; // token obtained with Stripe.js
			$response = $cu->save();
			
			$responseObj = $this->updateCustomerResponse($response);
			if($responseObj instanceof \Saw\Component\Communication\Response):
				return $responseObj->__toArray();
			else:
				return false;
			endif;
			
		}catch (\Stripe_CardError $e){

			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentException("Invalid Credit Card.");
			
		}catch (\Stripe_ApiError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway API Error.");
			
		}catch (\Stripe_InvalidRequestError $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Exception($e->getMessage());
			
		}catch (\Stripe_AuthenticationError $e){

			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\AuthenticationException("Failed to Authenticate with the Payment Gateway");			

		} catch (\Saw\Component\Communication\Exceptions\RequestDomainException $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
			
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
			
		}catch(\Exception $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway exception.");
			
		}
		
	}
	
	public function updateCustomerRequest($request){
		
		$requestObj = new \Saw\Component\Payment\UpdateCustomerRequest($request);
		$requestObj->validate();
		
		return $requestObj;
		
	}
	public function updateCustomerResponse($response){
		
		$arr_response = array();
		$formatted_response = array();
		
		$arr_response = json_decode($response);
		if(!empty($arr_response)):
			
			$formatted_response['vaultId'] 				= $arr_response->id;
			$formatted_response['expMonth'] 			= $arr_response->active_card->exp_month;
			$formatted_response['expYear'] 				= $arr_response->active_card->exp_year;
			$formatted_response['cardType'] 			= $arr_response->active_card->type;
			$formatted_response['number'] 				= $arr_response->active_card->last4;
			$formatted_response['addressLine1'] 		= (isset($arr_response->active_card->address_line1)) ? $arr_response->active_card->address_line1 : '';
			$formatted_response['addressLine2'] 		= (isset($arr_response->active_card->address_line2)) ? $arr_response->active_card->address_line2 : '';
			$formatted_response['stateProvinceRegion'] 	= (isset($arr_response->active_card->address_state)) ? $arr_response->active_card->address_state : '';
			$formatted_response['zipPostalCode'] 		= (isset($arr_response->active_card->address_zip)) ? $arr_response->active_card->address_zip : '';
			$formatted_response['country'] 				= (isset($arr_response->active_card->address_country)) ? $arr_response->active_card->address_country : '';
			$formatted_response['email']				= $arr_response->email;
			// clear out elements we no longer need
			$formatted_response['token']				= 'empty';
			$formatted_response['cvc']					= 'empty';
		
			$responsObj = new \Saw\Component\Payment\UpdateCustomerResponse($formatted_response);
			$responsObj->validate();
			
			return $responsObj;
			
		endif;
		
		return false;
		//*/	
	}
	
	
	
	
	/////////////////////////
	////  NEW CUSTOMER //////
	/////////////////////////
	public function newCustomer($request){
		
		try{
			$request = $this->newCustomerRequest($request);
			$response = \Stripe_Customer::create($request, $this->keys['skey']);
			$responseObj = $this->newCustomerResponse($response);
			if($responseObj instanceof \Saw\Component\Communication\Response):
				return $responseObj->__toArray();
			else:
				return false;
			endif;
			
		}catch (\Stripe_CardError $e){

			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentException("Invalid Credit Card.");
			
		}catch (\Stripe_ApiError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway API Error.");
			
		}catch (\Stripe_InvalidRequestError $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Exception($e->getMessage());
			
		}catch (\Stripe_AuthenticationError $e){

			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\AuthenticationException("Failed to Authenticate with the Payment Gateway");			

		} catch (\Saw\Component\Communication\Exceptions\RequestDomainException $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
			
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
			
		}catch(\Exception $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway exception.");
			
		}
		
	}
	
	public function newCustomerRequest($request){
		// how stripe.com expects it and can add default values here if desired
		$formatted_request = array(	'email'=>true,
			'description'=>true,
			'card'=>array(
				'number'=>true,
				'exp_month'=>true,
				'exp_year'=>true,
				'cvc'=>true,
				'name'=>true,
				'address_line1'=>true,
				'address_line2'=>true,
				'address_zip'=>true,
				'address_state'=>true,
				'address_country'=>true
			)
		);
		
		$requestObj = new \Saw\Component\Payment\NewCustomerRequest($request);
		$requestObj->validate();
		
		$validated_request_arr = $requestObj->__toArray();
		
		if(!empty($validated_request_arr['token'])){
			$formatted_request['card'] 						= $validated_request_arr['token'];
			$formatted_request['email'] 					= $validated_request_arr['email'];
			$formatted_request['description'] 				= $validated_request_arr['description'];
		}else{
			$formatted_request['description'] 				= $validated_request_arr['description'];
			$formatted_request['email'] 					= $validated_request_arr['email'];
			$formatted_request['card']['number'] 			= $validated_request_arr['number'];
			$formatted_request['card']['exp_month'] 		= $validated_request_arr['expMonth'];
			$formatted_request['card']['exp_year'] 			= $validated_request_arr['expYear'];
			$formatted_request['card']['cvc'] 				= $validated_request_arr['cvc'];
			$formatted_request['card']['name'] 				= $validated_request_arr['name'];
			$formatted_request['card']['address_line1'] 	= $validated_request_arr['addressLine1'];
			$formatted_request['card']['address_line2'] 	= $validated_request_arr['addressLine2'];
			$formatted_request['card']['address_zip'] 		= $validated_request_arr['stateProvinceRegion'];
			$formatted_request['card']['address_state'] 	= $validated_request_arr['zipPostalCode'];
			$formatted_request['card']['address_country'] 	= $validated_request_arr['country'];
		}
		
		return $formatted_request;
		
	}
	public function newCustomerResponse($response){
		
		$arr_response = array();
		$formatted_response = array();
		
		$arr_response = json_decode($response);
		if(!empty($arr_response)):
			
			$formatted_response['vaultId'] 				= $arr_response->id;
			$formatted_response['expMonth'] 			= $arr_response->active_card->exp_month;
			$formatted_response['expYear'] 				= $arr_response->active_card->exp_year;
			$formatted_response['cardType'] 			= $arr_response->active_card->type;
			$formatted_response['number'] 				= $arr_response->active_card->last4;
			$formatted_response['addressLine1'] 		= (isset($arr_response->active_card->address_line1)) ? $arr_response->active_card->address_line1 : '';
			$formatted_response['addressLine2'] 		= (isset($arr_response->active_card->address_line2)) ? $arr_response->active_card->address_line2 : '';
			$formatted_response['stateProvinceRegion'] 	= (isset($arr_response->active_card->address_state)) ? $arr_response->active_card->address_state : '';
			$formatted_response['zipPostalCode'] 		= (isset($arr_response->active_card->address_zip)) ? $arr_response->active_card->address_zip : '';
			$formatted_response['country'] 				= (isset($arr_response->active_card->address_country)) ? $arr_response->active_card->address_country : '';
			$formatted_response['email']				= $arr_response->email;
			// clear out elements we no longer need
			$formatted_response['token']				= 'empty';
			$formatted_response['cvc']					= 'empty';
		
			$responsObj = new \Saw\Component\Payment\NewCustomerResponse($formatted_response);
			$responsObj->validate();
			
			return $responsObj;
			
		endif;
		
		return false;
		//*/	
	}
	
	
	/////////////////////////
	////  GET CUSTOMER //////
	/////////////////////////
	public function getCustomer($request){
		
		try{
			$request = $this->getCustomerRequest($request);
			
			\Stripe::setApiKey($this->keys['skey']);
			$request_arr = $request->__toArray();
			$response = \Stripe_Customer::retrieve($request_arr['id']);
			$responseObj = $this->getCustomerResponse($response);
			if($responseObj instanceof \Saw\Component\Communication\Response):
				return $responseObj->__toArray();
			else:
				return false;
			endif;
			
		}catch (\Stripe_ApiError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway API Error.");
		}catch (\Stripe_InvalidRequestError $e){
			// means customer number was not found
			// so don't want to abort the request with an exception
			// just return false so a new customer can be made 
			// on the payment gateway
			return false;
		}catch (\Stripe_AuthenticationError $e){
		
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\AuthenticationException("Failed to Authenticate with the Payment Gateway");
		
		}catch (\Saw\Component\Communication\Exceptions\RequestDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		
		}catch(\Exception $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway exception.");
		}
		
	}
	
	public function getCustomerRequest($request){
		
		$requestObj = new \Saw\Component\Payment\GetCustomerRequest($request);
		$requestObj->validate();
		
		return $requestObj;
		
	}
	
	public function getCustomerResponse($response){
		
		$arr_response = array();
		$formatted_response = array();
		$responseObj = new \stdClass();
		
		$arr_response = json_decode($response);
		if(!empty($arr_response)):
			
			$formatted_response['vaultId'] 				= $arr_response->id;
			$formatted_response['expMonth'] 			= $arr_response->active_card->exp_month;
			$formatted_response['expYear'] 				= $arr_response->active_card->exp_year;
			$formatted_response['cardType'] 			= $arr_response->active_card->type;
			$formatted_response['number'] 				= $arr_response->active_card->last4;
			$formatted_response['addressLine1'] 		= (isset($arr_response->active_card->address_line1)) ? $arr_response->active_card->address_line1 : '';
			$formatted_response['addressLine2'] 		= (isset($arr_response->active_card->address_line2)) ? $arr_response->active_card->address_line2 : '';
			$formatted_response['stateProvinceRegion'] 	= (isset($arr_response->active_card->address_state)) ? $arr_response->active_card->address_state : '';
			$formatted_response['zipPostalCode'] 		= (isset($arr_response->active_card->address_zip)) ? $arr_response->active_card->address_zip : '';
			$formatted_response['country'] 				= (isset($arr_response->active_card->address_country)) ? $arr_response->active_card->address_country : '';
			$formatted_response['email']				= $arr_response->email;
		
			$responsObj = new \Saw\Component\Payment\GetCustomerResponse($formatted_response);
			$responsObj->validate();
			
			return $responsObj;
			
		endif;
		
		return false;
		//*/
			
	}
	
	
	public function charge($request){
		try{
			$request = $this->chargeRequest($request);
			$response = \Stripe_Charge::create($request, $this->keys['skey']);
			$responseObj = $this->chargeResponse($response);
			if($responseObj instanceof \Saw\Component\Communication\Response):
				return $responseObj->__toArray();
			else:
				return false;
			endif;
			
		}catch (\Stripe_ApiError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway API Error.");
		}catch (\Stripe_InvalidRequestError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException($e->getMessage());
		}catch (\Stripe_AuthenticationError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\AuthenticationException("Failed to Authenticate with the Payment Gateway");
		}catch (\Saw\Component\Communication\Exceptions\RequestDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		}catch(\Exception $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway exception.");
		}
		
	}
	
	protected function chargeRequest($request){
		
		// how stripe.com expects it and can add default values here if desired
		$formatted_request = array(	'amount'=>true,
			'currency'=>'usd',
			'customer'=>true,
			'description'=>true,
			'card'=>array(
				'number'=>true,
				'exp_month'=>true,
				'exp_year'=>true,
				'cvc'=>true,
				'name'=>true,
				'address_line1'=>true,
				'address_line2'=>true,
				'address_zip'=>true,
				'address_state'=>true,
				'address_country'=>true
			)
		);
		
		$requestObj = new \Saw\Component\Payment\ChargeRequest($request);
		$requestObj->validate();
		
		$validated_request_arr = $requestObj->__toArray();
		
		if(!empty($validated_request_arr['vaultId'])){
			$formatted_request['customer'] 					= $validated_request_arr['vaultId'];
			$formatted_request['amount'] 					= $validated_request_arr['amount'];
			$formatted_request['description'] 				= $validated_request_arr['description'];
			$formatted_request['card']		 				= '';//unset card since customer is there
			$formatted_request = array_filter($formatted_request);// now remove the ['card'] from the array or stripe.com will throw an exception
		}else{
			$formatted_request['amount'] 					= $validated_request_arr['amount'];
			$formatted_request['description'] 				= $validated_request_arr['description'];
			$formatted_request['card']['number'] 			= $validated_request_arr['number'];
			$formatted_request['card']['exp_month'] 		= $validated_request_arr['expMonth'];
			$formatted_request['card']['exp_year'] 			= $validated_request_arr['expYear'];
			$formatted_request['card']['cvc'] 				= $validated_request_arr['cvc'];
			$formatted_request['card']['name'] 				= $validated_request_arr['name'];
			$formatted_request['card']['address_line1'] 	= $validated_request_arr['addressLine1'];
			$formatted_request['card']['address_line2'] 	= $validated_request_arr['addressLine2'];
			$formatted_request['card']['address_zip'] 		= $validated_request_arr['stateProvinceRegion'];
			$formatted_request['card']['address_state'] 	= $validated_request_arr['zipPostalCode'];
			$formatted_request['card']['address_country'] 	= $validated_request_arr['country'];
		}
		$formatted_request['amount'] = $validated_request_arr['amount']*100; // stripe.com expects the amount to be in cents
		return $formatted_request;
		
	}

	protected function chargeResponse($response){
		$arr_response = array();
		$formatted_response = array();
		$responseObj = new \stdClass();
		
		$arr_response = json_decode($response);
		if(!empty($arr_response)):
			
			$formatted_response['transactionId'] 		= $arr_response->id;
			$formatted_response['date']		 			= $arr_response->created;
			$formatted_response['amount'] 				= $arr_response->amount;
			$formatted_response['transactionFee'] 		= $arr_response->fee;
			$formatted_response['failureMessage'] 		= (strpos($response,'failure_message')!==false) ? $arr_response->failure_message : 'charge:no failure' ;
			$formatted_response['status'] 				= ($arr_response->paid) ? 'succeeded' : 'declined';
			$formatted_response['lastFourNumbers'] 		= $arr_response->card->last4;
			$formatted_response['expDate'] 				= $arr_response->card->exp_month.'/'.$arr_response->card->exp_year;
			$formatted_response['nameOnAccount']		= $arr_response->card->name;
			$formatted_response['type'] 				= PAYMENT_TYPE_CC;
			$formatted_response['amount']  = $formatted_response['amount'] / 100; // stripe sends it back in cents: so convert to dollars
			$formatted_response['date']    = new \MongoDate(intval($formatted_response['date'])); // set it
			$responsObj = new \Saw\Component\Payment\ChargeResponse($formatted_response);
			$responsObj->validate();
			
			return $responsObj;
			
		endif;
		
		return false;
		//*/
	}
	
	public function refund($request){
		try{
			$request_arr = $this->refundRequest($request);
			$ch = \Stripe_Charge::retrieve($request_arr['id'], $this->keys['skey']);
			if(empty($request_arr['amount'])){ // if not amount specified full refund
				$response = $ch->refund();
			}else{
				$response = $ch->refund(array("amount"=>$request_arr['amount']));
			}
			return $this->refundResponse($response);
						
		}catch (\Stripe_ApiError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway API Error.");
		}catch (\Stripe_InvalidRequestError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException($e->getMessage());
		}catch (\Stripe_AuthenticationError $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\AuthenticationException("Failed to Authenticate with the Payment Gateway");
		}catch (\Saw\Component\Communication\Exceptions\RequestDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			// log it and throw a general exception which will abort the request gracefully
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			error_log(__METHOD__.'::'.get_class($e).'::ErrorArr::'.print_r($e->getErrorArr(),true));
			throw new \Exception($e->getMessage());
		}catch(\Exception $e){
			error_log(__METHOD__.'::'.get_class($e).'::message::'.print_r($e->getMessage(),true));
			throw new \Saw\Exceptions\PaymentGatewayException("Payment Gateway exception.");
		}
	}
	
	
	// not yet refactored
	protected function refundRequest($request){
		
		$requestObj = new \Saw\Component\Payment\RefundRequest($request);
		$requestObj->validate();
		
		$validated_request_arr = $requestObj->__toArray();
		$validated_request_arr['amount'] = $validated_request_arr['amount']*100; // stripe.com expects the amount to be in cents
		return $validated_request_arr;
	}
	
	protected function refundResponse($response){
		$arr_response = array();
		$formatted_response = array();
		$responseObj = new \stdClass();
		
		$arr_response = json_decode($response);
		if(!empty($arr_response)):
			
			$formatted_response['transactionId'] 		= $arr_response->id;
			$formatted_response['date']		 			= $arr_response->created;
			$formatted_response['amount'] 				= $arr_response->amount;
			$formatted_response['amountRefunded']		= $arr_response->amount_refunded;
			$formatted_response['transactionFee'] 		= $arr_response->fee;
			$formatted_response['failureMessage'] 		= (strpos($response,'failure_message')!==false) ? $arr_response->failure_message : 'refund:no failure' ;
			$formatted_response['status'] 				= ($arr_response->paid) ? 'succeeded' : 'declined';
			$formatted_response['lastFourNumbers'] 		= $arr_response->card->last4;
			$formatted_response['expDate'] 				= $arr_response->card->exp_month.'/'.$arr_response->card->exp_year;
			$formatted_response['nameOnAccount']		= $arr_response->card->name;
			$formatted_response['type'] 				= PAYMENT_TYPE_CC;

			$formatted_response['amount']  			= $formatted_response['amount'] / 100; // stripe sends it back in cents: so convert to dollars
			$formatted_response['amountRefunded']  = $formatted_response['amountRefunded'] / 100; // stripe sends it back in cents: so convert to dollars
			$formatted_response['date']    			= new \MongoDate(intval($formatted_response['date'])); // set it
			$responsObj = new \Saw\Component\Payment\RefundResponse($formatted_response);
			$responsObj->validate();
			
			return $responsObj->__toArray();
			
		endif;
		
		return false;
		//*/
	}
	
	public function deleteCustomer($request){}
	
	protected function deleteCustomerRequest($request){}
	
	protected function deleteCustomerResponse($response){}
	
}
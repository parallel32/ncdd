<?php
namespace Saw\Component\Payment\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;

class PaymentServiceProvider implements ServiceProviderInterface
{
	
	public function register(Application $app)
    {
		
        $app['payment'] = $app->share(function () use ($app) { 	
			$payment = new StripePayment($app, 
										array(	'pkey'=>$app['payment.stripe.pkey'], 
												'skey'=>$app['payment.stripe.skey']
										));
			return $payment;
		});
		
		// register autoloader for the Strip classes
		if(isset($app['payment.stripe.class_path'])){
			$app['autoloader']->registerPrefix('Stripe',$app['payment.stripe.class_path']);
		}
    }
	public function boot(Application $app)
	{
		
	}
}
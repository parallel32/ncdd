<script type="text/javascript">
(function( Login, $, undefined ) {
    
	function attemptLogin (){
		io.saw.FormPost.activate({postUrl:'/login'
			,formName:'.login-form'
			,serializeSelector:':input'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/';
			}
		});		
	}
	Login.init = function(){
		$('.login-form input').keypress(function (e) {
            if (e.which == 13) {
            	console.log('here');
            	e.preventDefault();
				attemptLogin();
                return false;
            }
        });
        $('.login-form :submit').click(function(e){
        	e.preventDefault();
        	attemptLogin();
        });

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
            	console.log('hereerererer');
            	e.preventDefault();
                attemptLogin();
	            return false;
            }
        });

        $('#forget-password').click(function () {
            $('.login-form').hide();
            $('.forget-form').show();
        });

        $('#back-btn').click(function () {
            $('.login-form').show();
            $('.forget-form').hide();
        });
        $('#register-btn').click(function () {
            $('.login-form').hide();
            $('.register-form').show();
        });

        $('#register-back-btn').click(function () {
            $('.login-form').show();
            $('.register-form').hide();
        });	

        $.backstretch([
	        "assets/img/bg/2.jpg",
	        "assets/img/bg/1.jpg",
	        "assets/img/bg/3.jpg"
	        ], {
	          fade: 1000,
	          duration: 8000
	      });	
	};
    
}( io.saw.Login = io.saw.Login || {}, io.saw.jQuery || jQuery ));
</script>
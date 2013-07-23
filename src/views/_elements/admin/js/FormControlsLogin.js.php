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
    function forgotPassword (){
		io.saw.FormPost.activate({postUrl:'/member/forgotpassword'
			,formName:'#forgotpass-form'
			,serializeSelector:':input'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
                $('#forgotpass-form .control-group').hide();
                $('#forgotpass-form p').hide();
				$('#forgotpass-form .submit').hide();
                $('#forgotpass-form h3').after('<p id="forgotmessage">'+responseObj.message+'</p>');
			}
		});		
	}
	Login.init = function(){
		$('.login-form input').keypress(function (e) {
            if (e.which == 13) {
            	e.preventDefault();
				attemptLogin();
                return false;
            }
        });
        $('#login-form .submit').click(function(e){
        	e.preventDefault();
        	attemptLogin();
        });

        $('#forget-password').click(function () {
            $('.login-form').hide();
            $('.forget-form').show();
        });

        $('#back-btn').click(function () {
            $('.login-form').show();
            $('.forget-form').hide();
            $('#forgotmessage').remove();
            $('#forgotpass-form .control-group').show();
            $('#forgotpass-form p').show();
            $('#forgotpass-form .submit').show();
            $('#forgotpass-form input').val('');
            
        });
        $('#register-btn').click(function () {
            document.location.href="/application/new-member";
        });

        $('#register-back-btn').click(function () {
            $('.login-form').show();
            $('.register-form').hide();
        });	

        $('#forgotpass-form .submit').click(function (e){
            e.preventDefault();
            forgotPassword();
        })
        $('#forgotpass-form input').keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                forgotPassword();
            }
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
<script type="text/javascript">
(function( Seminar, $, undefined ) {
	function add (){
		io.saw.FormPost.activate({postUrl:'/seminar/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		      $('#save-success .continue').attr('data-insertid',responseObj.id.$id);
		   }
		});      
	};
	function edit (){
		io.saw.FormPost.activate({postUrl:'/seminar/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	};
	Seminar.indexInit = function (){
		// prepare the edit seminar and edit agenda buttons
		$('.edit-seminar').click(function(e){
			e.preventDefault();
			document.location.href='/seminar/edit/'+$(this).attr('data-id');
		});
		$('.edit-agenda').click(function(e){
			e.preventDefault();
			document.location.href='/agenda/'+$(this).attr('data-id')+'/manage';
		});
		$('.remove-seminar').click(function(e){
			e.preventDefault();
			$('#save-success .modal-body p').html($(this).attr('data-name'));
			$('#save-success .green').attr('data-id',$(this).attr('data-id'));
		    $('#save-success').modal({keyboard: false});
		});
		// modal buttons
		$('#save-success .green').click(function(e){
			Seminar.delete($(this).attr('data-id'));
		});
		$('#save-success .cancel').click(function(e){
			$('#save-success').modal('hide');
		});
		
	};
	Seminar.init = function(saveMode){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  $('#description').val($('.description').html());
		      if(saveMode == 'edit'){
		         edit();
		      }else if(saveMode == 'add'){
		         add();
		      }
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			$('#description').val($('.description').html());
			if(saveMode == 'edit'){
				edit();
			}else if(saveMode == 'add'){
				add();
			}
		});
		$('#saw-form .cancel').click(function(e){
			document.location.href="/seminar/view/<?=(array_key_exists('seminar',$this->vars)) ? $this->vars['seminar']['_id']: '';?>";	
		});
		$('#saw-form .manage').click(function(e){
			document.location.href="/agenda/<?=(array_key_exists('seminar',$this->vars)) ? $this->vars['seminar']['_id']: '';?>/manage";	
		});
		// modal buttons
		$('#save-success .finished').click(function(e){
			document.location.href='/seminar/';
		});
		$('#save-success .blue.continue').click(function(e){
			if(saveMode == 'add'){
				document.location.href='/agenda/'+$('#save-success .continue').attr('data-insertid')+'/manage';
			}else if(saveMode == 'edit'){
				document.location.href="/seminar/edit/<?=(array_key_exists('seminar',$this->vars)) ? $this->vars['seminar']['_id']: '';?>";	
			}			
		});
		if(saveMode == 'add'){
			$('#save-success .yellow.continue').click(function(e){
				document.location.href='/seminar/edit/'+$(this).attr('data-insertid');
			});
		}
	};
	Seminar.delete = function(id){
		io.saw.FormGet.activate({postUrl:'/seminar/delete/'+id
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/seminar/';
			}
		});
	};
	Seminar.sluggifyTimeoutId = undefined;
	Seminar.sluggify = function(inputEl,targetEl){
		$('.'+inputEl).bind("paste keyup", function(e) {
			if (e.which != 13) { // don't let it slugify when the enter key is hit because it interferes with the form post
				$('#slug-str').val($(this).val());
				window.clearTimeout(this.sluggifyTimeoutId);//cancel previous timer so they don't queue up when you're typing
				this.sluggifyTimeoutId = window.setTimeout(function(){ // delay the post so it's not in every key-up stroke
					io.saw.FormPost.activate({postUrl:'/seminar/slugify'
			    		,formName:'#saw-slug'
						,postOnComplete:function(responseObj,responseStatus){}
						,postOnSuccess:function(responseObj){
							if (!/\//i.test(responseObj.slug)){
								responseObj.slug = '/seminar/'+responseObj.slug;
							}
							if($('#'+targetEl+'-slug').is('input')){
								$('#'+targetEl+'-slug').val(responseObj.slug);
							}else{
								$('#'+targetEl+'-slug').html(responseObj.slug);
							}
							
						}
						,blockUI:'no'
						,validate:'no'
					});	
				},1000);
		    	
			}
		});

	};
}( io.saw.Seminar = io.saw.Seminar || {}, io.saw.jQuery || jQuery ));
</script>
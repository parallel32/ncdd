<script type="text/javascript">
(function( Dashboard, $, undefined ) {
	
	function init(){
		
	};
	Dashboard.adminInit = function(){
		init();
		$('#applications .btn.view').click(function(e){
			e.preventDefault();
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});
		$('#application .btn.view').click(function(e){
			e.preventDefault();
			document.location.href='/applications';
		});
		
	};
	Dashboard.memberInit = function(saveMode){
		init();
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
			document.location.href="/application/view/<?=(array_key_exists('application',$this->vars)) ? $this->vars['application']['_id']: '';?>";	
		});
		
		$('#approved-applications .pay').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/pay';	
		});

		$('.btn.edit-profile').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit';	
		});

	};
	Dashboard.editorInit = function(saveMode){
		init();
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
			document.location.href="/application/view/<?=(array_key_exists('application',$this->vars)) ? $this->vars['application']['_id']: '';?>";	
		});
		
	};

}( io.saw.Dashboard = io.saw.Dashboard || {}, io.saw.jQuery || jQuery ));
</script>
<script type="text/javascript">
(function( Dashboard, $, undefined ) {
	
	Dashboard.adminInit = function(){
		$('#applications .btn.view').click(function(e){
			e.preventDefault();
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});
		$('#application .btn.view').click(function(e){
			e.preventDefault();
			document.location.href='/application/';
		});
		
	};
	Dashboard.memberInit = function(saveMode){
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
	Dashboard.editorInit = function(saveMode){
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
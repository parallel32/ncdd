<script type="text/javascript">
(function( Dashboard, $, undefined ) {
	
	function init(){
		$('#page-view-all').click(function(e){
			e.preventDefault();
			document.location.href='/page/all';	
		});
		$('#pages .btn.blue.mini.view').click(function(e){
			e.preventDefault();
			document.location.href='/page/view/'+$(this).attr('data-id');	
		});
				
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
		$('#blog .btn.view').click(function(e){
			e.preventDefault();
			document.location.href='/blog/all-posts';
		});
		$('#blogs .btn.view-post').click(function(e){
			e.preventDefault();
			document.location.href='/blog/'+$(this).attr('data-member-id')+'/edit/'+$(this).attr('data-blog-id');
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
		
		$('#applications .pay').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/pay';	
		});
		
		$('#blogs .view').click(function(e){
			document.location.href='/blog/'+$(this).attr('data-id')+'/view';	
		});
		$('#blog .draft-post').click(function(e){
			e.preventDefault();
			document.location.href='/blog/'+$(this).attr('data-id')+'/edit';	
		});

		$('.btn.edit-profile').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit';	
		});
		$('.btn.renewal').click(function(e){
			document.location.href='/application/'+$(this).attr('data-apptype');	
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
			<div class="container-fluid">
				<form id="saw-form" class="horizontal-form portlet">
                    <input id="add" type="hidden" name="doc[add]" value="yes">
                    <input id="_id" type="hidden" name="doc[_id]" value="">
                    <input id="_id" type="hidden" name="doc[belongsTo]" value="<?=$this->vars['belongsTo']?>">
                 
				<div class="row-fluid pull-left">
					<p>Add a new file or delete the selected file.</p>
	            	<div class="form-actions text-center">
                        <button type='button' class='btn green add'><i class='icon-plus'></i> Upload a File.</button>
                        <button type='button' class='btn red delete'><i class='icon-trash'></i> Delete Selected.</button>
                	</div>
	               <!--/span-->
	            </div>
		        </form>
				<!-- BEGIN PAGE HEADER-->
	            <div class="row-fluid">
	               <div class="span12">
	                  <?//$this->element('page-title-and-bread-crumb');?>
	               </div>
	            </div>
	            <!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<style>
				.tile.double-down i {margin-top: 19px;}
				.tile.double-down {height: 180px !important;}
				</style>
				<div class="tiles">
					<? if(!empty($this->vars['files'])): ?>
					<? foreach($this->vars['files'] as $file): 
						if(!empty($file['file'])):
							//echo"<pre>";print_r($file);echo "</pre>";
					?>
					<div id="<?=$file['_id']?>" class="tile bg-blue double-down">
						<div class="corner"></div>
						<div class="check"></div>
						<div class="tile-body">
							<i class="icon-file"></i>
						</div>
						<div class="tile-object double double-down">
							<div class="name">
								<a id="file-<?=$file['_id']?>" href="<?=$file['file']?>"><?=$file['originalFileName']?></a>
							</div>
							<div class="number">
							</div>
						</div>
					</div>

					<? endif; ?>
					<? endforeach; ?>

					<? else: ?>
					<p>No files to show.</p>
					<? endif; ?>
				</div>
				<!-- END PAGE CONTENT-->

			</div>

			
			<script>
			var selected_file = ''; 
			jQuery(document).ready(function() {   
				
				// add file
				$('.btn.add').click(function(e){
					var postSuccess = postSuccess || function(responseObj){
				   		$('#_id').val(responseObj.driveId);
				   		$('#add').val('no');
				   	  	$('#save-modal').modal({keyboard: false});   		
				   	  	document.location.href='/drive/edit/'+responseObj.driveId+'/edit-file';	
					};
					// handle the adding of the drive record for the file
					io.saw.FormPost.activate({postUrl:'/drive/edit'
					   ,serializeSelector:':input'
					   ,postOnComplete:function(responseObj,responseStatus){
						   	if(responseStatus == 'success'){
						   	}else{
						   		var responseObj = $.parseJSON(responseObj.responseText);
						   	}
					   }
					   ,postOnSuccess:postSuccess
					});
						
				});
				// handle the file selected highlight
				$('.tile').click(function(e){
					$('.tile').removeClass('selected');
					$(this).toggleClass('selected');
					selected_file = $(this).attr('id');
				});

				// delete the selected file
				$('.red.delete').click(function(e){
		          io.saw.FormGet.activate({postUrl:"/file/delete/drivefile/"+selected_file
		            ,postOnComplete:function(responseObj,responseStatus){}
		            ,postOnSuccess:function(responseObj){
		              $('#'+selected_file).remove();
		            }
		          });
		        }); 
		        

			});
			</script>
			<? if(!empty($this->vars['files'])){
echo <<<EOD
<script>
jQuery(document).ready(function() {   
	$('.tile').first().trigger('click');
});	
</script>
EOD;
					} ?>
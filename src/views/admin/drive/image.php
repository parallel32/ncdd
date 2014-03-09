			<div class="container-fluid">
				<form id="saw-form" class="horizontal-form portlet">
                    <input id="add" type="hidden" name="doc[add]" value="yes">
                    <input id="_id" type="hidden" name="doc[_id]" value="">
                    <input id="_id" type="hidden" name="doc[belongsTo]" value="<?=$this->vars['belongsTo']?>">
                 
				<div class="row-fluid pull-left">
					<p>Add a new picture or delete the selected picture.</p>
	            	<div class="form-actions text-center">
                        <button type='button' class='btn green add'><i class='icon-plus'></i> Upload a Picture.</button>
                        <button type='button' class='btn red delete'><i class='icon-trash'></i> Delete Selected.</button>
                        <button type='button' class='btn yellow crop'> Crop Selected.</button>
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
				<style>.tile.double {width: 220px !important;}</style>
				<div class="tiles">
					<? if(!empty($this->vars['images'])): ?>
					<? foreach($this->vars['images'] as $image): 
						if(!empty($image['image'])):
					?>
					<div id="<?=$image['_id']?>" class="tile image double">
						<div class="tile-body">
							<img id="image-<?=$image['_id']?>" src="<?=$image['image']?>" alt="">
						</div>
						<!--
						<div class="tile-object">
							<div class="name">
								Uploaded
							</div>
							<div class="number">
								24 Jan 2013
							</div>
						</div>
						-->
  						<div class="corner"></div>
						<div class="check"></div>
					</div>
					<? endif; ?>
					<? endforeach; ?>
					<? else: ?>
					<p>No pictures to show.</p>
					<? endif; ?>
				</div>
				<!-- END PAGE CONTENT-->

			</div>

			
			<script>
			var selected_image = ''; 
			jQuery(document).ready(function() {   
				
				// add photo
				$('.btn.add').click(function(e){
					var postSuccess = postSuccess || function(responseObj){
				   		$('#_id').val(responseObj.driveId);
				   		$('#add').val('no');
				   	  	$('#save-modal').modal({keyboard: false});   		
				   	  	document.location.href='/drive/edit/'+responseObj.driveId+'/edit-photo';	
					};
					// handle the adding of the drive record for the photo 
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
				// handle the image selected highlight
				$('.tile').click(function(e){
					$('.tile').removeClass('selected');
					$(this).toggleClass('selected');
					selected_image = $(this).attr('id');
				});

				// delete the selected image
				$('.red.delete').click(function(e){
		          io.saw.FormGet.activate({postUrl:"/image/delete/drive/"+selected_image
		            ,postOnComplete:function(responseObj,responseStatus){}
		            ,postOnSuccess:function(responseObj){
		              $('#'+selected_image).remove();
		            }
		          });
		        }); 
		        // crop the selected image
		        $('.yellow.crop').click(function(e){
		          document.location.href='/drive/edit/'+selected_image+'/edit-photo-crop'
		        }); 
		        

			});
			</script>
			<? if(!empty($this->vars['images'])){
echo <<<EOD
<script>
jQuery(document).ready(function() {   
	$('.tile').first().trigger('click');
});	
</script>
EOD;
					} ?>
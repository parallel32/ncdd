<? $category = $this->vars['category']; ?>
<!-- BEGIN PAGE -->
      <div class="page-content">
         
         <!-- BEGIN PAGE CONTAINER-->        
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <?=$this->element('page-title-and-bread-crumb');?>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            
            <? if(true): ?>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid uploadView">
               <div class="span12">
                  
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-picture"></i>Crop Topic Image</div>
                       <div class="actions">
                          <a class="btn yellow image"> Crop Image</a>
                          <a class="btn back image "> Save & Go Back</a>
                       </div>
                     </div>

                     <div class="portlet-body form">
                      <div class="well">
                          <h3>How to crop</h3>
                          <ul>
                             <li>Move your cursor over the image.  The pointer will become a plus sign.</li>
                             <li>Start by left clicking and holding the button and drag the plus sign from the top left of the image towards the bottom right.</li>
                             <li>NOTE: the box that is drawn will remain a square size.  This is by design to maintain the proper aspect ration.  We do this to avoid creating a skewed image.</li>
                             <li>When you're satisfied with the initial box that's drawn, let go of the left mouse button.</li>
                             <li>Now you can resize the image from the corners, the sides, and move it around.</li>
                             <li>When you're satisfied with the box size click "Crop Image".</li>
                             <li>Then click "Save & Go Back".</li>
                          </ul>
                       </div>
                       <br>
                       <blockquote>
                          <img id="image" src="<?=$this->vars['image']?>">
                       </blockquote>
                       <br>

                       <form id="saw-form" class="horizontal-form">
                          <input type="hidden" name="doc[belongsTo]" value="<?=$category['_id']?>">
                          <input type="hidden" name="doc[context]" value="category">
                          <input type="hidden" name="doc[size]" value="large">
                          <input type="hidden" name="doc[imageId]" value="<?=$category['image']['sizes']['large']['id']?>">
                          
                          <div class="row-fluid coords">
                             <div class="span6 ">
                                <div class="control-group">
                                   <label class="control-label" >X</label>
                                   <div class="controls">
                                      <input type="text" name="doc[x]" class="m-wrap span12 x" id="x">
                                   </div>
                                </div>
                             </div>
                             <div class="span6 ">
                                <div class="control-group">
                                   <label class="control-label" >Y</label>
                                   <div class="controls">
                                      <input type="text" name="doc[y]" class="m-wrap span12 y" id="y">
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="row-fluid coords">
                             <div class="span6 ">
                                <div class="control-group">
                                   <label class="control-label" >W</label>
                                   <div class="controls">
                                      <input type="text" name="doc[w]" class="m-wrap span12 w" id="w">
                                   </div>
                                </div>
                             </div>
                             <div class="span6 ">
                                <div class="control-group">
                                   <label class="control-label" >H</label>
                                   <div class="controls">
                                      <input type="text" name="doc[h]" class="m-wrap span12 h" id="h">
                                   </div>
                                </div>
                             </div>
                          </div>
                       </form>
                       
                    </div>
                 </div>
                 
              </div>
            </div>
            <!-- END PAGE CONTENT-->
            <? endif; ?>
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
      <script>
      jQuery(document).ready(function() {   
        function showCoords(c)
        {
          $('#x').val(c.x);
          $('#y').val(c.y);
          $('#x2').val(c.x2);
          $('#y2').val(c.y2);
          $('#w').val(c.w);
          $('#h').val(c.h);
        };
        var jcrop_api;
        $('#image').Jcrop({
          onChange: showCoords,
          onSelect: showCoords,
          aspectRatio: 4/3
          ,minSize:[50,50]
          ,maxSize:[800,900]
        },function(){
          jcrop_api = this;
        });
        
        $('.back.image').click(function(e){
          document.location.href='/category/edit/<?=$category['_id']?>';
        }); 
        $('.yellow.image').click(function(e){
          io.saw.FormPost.activate({postUrl:'/image/crop'
             ,serializeSelector:':input'
             ,formName:'#saw-form'
             ,postOnComplete:function(responseObj,responseStatus){}
             ,postOnSuccess:function(responseObj){
              jcrop_api.destroy();
                $('.coords').hide();
                $('#image').after('<img src="'+responseObj.imageUrl+'">');
                $('#image').remove();
             }
          });
        }); 
                

      });
      </script>

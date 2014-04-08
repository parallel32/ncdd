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
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12 blog-page">
                  <div class="row-fluid">
                     <div class="span9 article-block">
                        <? if(!empty($this->vars['seminars'])): ?>
                        <? foreach ($this->vars['seminars'] as $seminar): ?>
                        <div class="row-fluid">
                           <div class="span12 blog-article">
                              <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app);
                                  if($accessLevel >= EDITOR){
                               ?>
                              <a class="btn green manage-registration" data-id="<?=$seminar['_id']?>">
                                Registrations <i class="icon-money"></i>
                              </a>
                              <a class="btn yellow edit-seminar" data-id="<?=$seminar['_id']?>">
                                Edit Seminar <i class="icon-pencil"></i>
                              </a>
                              <a class="btn yellow edit-agenda" data-id="<?=$seminar['_id']?>">
                                Edit Agendas <i class="icon-pencil"></i>
                              </a>
                              <a class="btn red remove-seminar" data-name="<?=$seminar['headline']?>" data-id="<?=$seminar['_id']?>">
                                Remove Seminar <i class="icon-pencil"></i>
                              </a>
                              <? } ?>


                              <h2><a href="/seminar/view/<?=$seminar['_id']?>"><?=$seminar['headline']?></a></h2>
                              <h4><a href="/seminar/view/<?=$seminar['_id']?>"><?=$seminar['startDate']['monthDay']?> - <?=$seminar['endDate']['monthDay']?>, <?=$seminar['startDate']['year']?></a></h4>
                              <h5><a href="/seminar/view/<?=$seminar['_id']?>"><?=(array_key_exists('location',$seminar)) ? $seminar['location']: '';?></a></h5>
                              <? if(!empty($seminar['agendas'])): ?>
                              <? foreach($seminar['agendas'] as $agenda): ?>
                                 <a class="btn blue" href="/agenda/<?=$seminar['_id']?>/<?=$agenda['_id']?>">
                                 <?=$agenda['name'] ?>
                                 <i class="m-icon-swapright m-icon-white"></i>
                                 </a>
                              <? endforeach; ?>
                              <? endif; ?>
                              <? $slug = (array_key_exists('slug',$seminar)) ? '/'.$seminar['slug'] : ''; ?>
                              <?if(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register']) && $seminar['register']['currentStatus'] < \Saw\Model\SeminarRegister::$status['OFF']): ?>
                              <a class="btn green register-seminar" data-name="<?=$slug?>" data-id="<?=$seminar['_id']?>">
                                Register <i class="icon-plus"></i>
                              </a>
                              <? else: ?>
                              <a class="btn grey disabled" data-name="<?=$slug?>" data-id="<?=$seminar['_id']?>">
                                Registration will be available soon.
                              </a>
                              <? endif; ?>

                              <? if(!empty($seminar['image'])){?>
                              <img src="<?=$this->app['getImageURL']($seminar['image'],'small')?>" alt="" style="padding-top:15px">
                              <? } ?>
                           
                              <p><?=$seminar['description']?></p>
                              
                              
                           </div>
                           
                           
                        </div>
                        <hr>
                        <? endforeach; ?>
                        <? else: ?>
                        <p>Currently, there are no Seminars in the system.</p>
                        <? endif; ?>
                     </div>
                     <!--end span9--
                     <div class="span3 blog-sidebar">
                        <h2>By Month</h2>
                        <div class="top-news">
                           <a href="#" class="btn blue">
                           <span>July (1)</span>
                           </a>
                           <a href="#" class="btn blue">
                           <span>September (2)</span>
                           </a>
                           <a href="#" class="btn blue">
                           <span>November (1)</span>
                           </a>
                        </div>
                        
                     </div>
                     <!--end span3-->
                     <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="save-success-label">Delete This Seminar?</h3>
                           </div>
                           <div class="modal-body">
                              <p></p>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn red" data-id="">Confirm Delete</button>
                              <button type="button" class="btn cancel">Cancel</button>
                           </div>
                        </div>
                  </div>
                  
               </div>
            </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/Seminar.js');?>
      <script>
      jQuery(document).ready(function() {    
         io.saw.Seminar.indexInit();
      });      
      </script>
   <link href="/assets/css/pages/blog.css" rel="stylesheet" type="text/css"/>

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
                  <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>
                  <h1> <? if($accessLevel == MEMBER): ?><small>Participate in this Forum.  <br>Draft a topic and submit it for publishing. </small><a class="btn green" href="/topic/edit/null/<?=$this->vars['forum']['_id']?>">Add a Topic <i class="icon-plus"></i></a><? endif; ?></h1> 
                  <div class="row-fluid">
                     <div class="span9 article-block">
                        <h1><?=$this->vars['forum']['name'] ?></h1>
                        <? 
                        if(is_array($this->vars['topics']) && !empty($this->vars['topics'])):
                        foreach($this->vars['topics'] as $topic): 
                           if(!empty($topic['image'])):
                        ?>
                        <!-- IMAGE -->
                        <hr>
                        <div class="row-fluid">
                           <div class="span4 blog-img blog-tag-data">
                              <img src="<?=$this->app['getImageURL']($topic['image'],'large') ?>" alt="">
                              <ul class="unstyled inline">
                                 <li><i class="icon-calendar"></i> <a href="#"><?=$topic['publishDate']['fullMonth']?></a></li>
                                 <li><i class="icon-comments"></i> <a href="#"><?=$topic['commentCount']?> Comments</a></li>
                                 <? if(array_key_exists('displayName',$topic['author'])){ ?>
                                 <li><i class="icon-pencil"></i> <a href="#"> by <?=$topic['author']['displayName']?></a></li>
                                 <? } ?>
                                 
                              </ul>
                              
                           </div>
                           <div class="span8 blog-article">
                              <h2><a href="/topic/<?=$topic['_id']?>/view"><?=$topic['headline']?></a></h2>
                              <p><?if(strlen($topic['body']) >499){ echo substr($topic['body'],0,500).'...'; } else { echo $topic['body'] }?></p>
                              <a class="btn blue pull-right" href="/topic/<?=$topic['_id']?>/view">
                              Read more 
                              <i class="m-icon-swapright m-icon-white"></i>
                              </a>
                           </div>
                        </div>
                        <!--/ IMAGE -->
                        <? else: ?>
                        <!-- NO IMAGE -->
                        <hr>
                        <div class="row-fluid">
                           <div class="span12 blog-article blog-tag-data">
                              <h2><a href="/topic/<?=$topic['_id']?>/view"><?=$topic['headline']?></a></h2>
                              <p><?if(strlen($topic['body']) >499){ echo substr($topic['body'],0,500).'...'; } else { echo $topic['body'] }?></p>
                              
                              <ul class="unstyled inline">
                                 <li><i class="icon-calendar"></i> <a href="#"><?=$topic['publishDate']['fullMonth']?></a></li>
                                 <li><i class="icon-comments"></i> <a href="#"><?=$topic['commentCount']?> Comments</a></li>
                                 <? if(array_key_exists('displayName',$topic['author'])){ ?>
                                 <li><i class="icon-pencil"></i> <a href="#"> by <?=$topic['author']['displayName']?></a></li>
                                 <? } ?>

                              </ul>
                              <br>
                              <br>
                              <a class="btn blue pull-right" href="/topic/<?=$topic['_id']?>/view">
                              Read more 
                              <i class="m-icon-swapright m-icon-white"></i>
                              </a>
                           </div>
                        </div>
                        <!--/ NO IMAGE -->
                        <? endif ?>
                        <? endforeach; ?>
                        <? else: ?>
                        <hr>
                        <div class="row-fluid">
                           <div class="span12 blog-article blog-tag-data">
                              <h2>There are no topics available.</h2>
                           </div>
                        </div>
                        <? endif; /* endif if !empty this->vars['topics'] */ ?>
                        


                     </div>
                     <!--end span9-->
                     
                  </div>
                  
                  <!-- PAGINATION
                  <div class="pagination pagination-right">
                     <ul>
                        <li><a href="#">Prev</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li class="active"><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">Next</a></li>
                     </ul>
                  </div>
                   / PAGINATION -->

               </div>
            </div>
            <!-- END PAGE CONTENT-->


         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
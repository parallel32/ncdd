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
                  <h1> <? if($accessLevel == MEMBER): ?><small>Participate in the NCDD.com DUI Blog.  <br>Draft a blog post and submit it for publishing. </small><a class="btn green" href="/blog/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>/edit">Add a Blog Post <i class="icon-plus"></i></a><? endif; ?></h1> 
                  <div class="row-fluid">
                     <div class="span9 article-block">
                        <h1>
                        <?
                        if(array_key_exists('month',$this->vars)){
                           echo 'Archives for '.$this->vars['month'].', '.$this->vars['year'];
                        }else if(array_key_exists('tag',$this->vars)){
                           echo 'Tag: '.$this->vars['tag'];
                        } else {
                           echo 'Recent Posts';
                        }
                        ?></h1>
                        <? 
                        if(is_array($this->vars['posts']) && !empty($this->vars['posts'])):
                        foreach($this->vars['posts'] as $post): 
                           if(!empty($post['image'])):
                        ?>
                        <!-- IMAGE -->
                        <hr>
                        <div class="row-fluid">
                           <div class="span4 blog-img blog-tag-data">
                              <img src="<?=$this->app['getImageURL']($post['image'],'large') ?>" alt="">
                              <ul class="unstyled inline">
                                 <li><i class="icon-calendar"></i> <a href="#"><?=$post['publishDate']['fullMonth']?></a></li>
                                 <li><i class="icon-comments"></i> <a href="#"><?=$post['commentCount']?> Comments</a></li>
                              </ul>
                              <ul class="unstyled inline blog-tags">
                                 <li>
                                    <i class="icon-tags"></i> 
                                    <? if(!empty($post['tags'])):
                                          foreach($post['tags'] as $tag):
                                    ?>
                                    <a href="/blog/tag<?=$tag['slug']?>"><?=$tag['name']?></a> 
                                    <?    endforeach;
                                       endif;
                                    ?>
                                 </li>
                              </ul>
                           </div>
                           <div class="span8 blog-article">
                              <h2><a href="/blog/<?=$post['_id']?>/view"><?=$post['headline']?></a></h2>
                              <p><?=substr($post['body'],0,500)?>...</p>
                              <a class="btn blue pull-right" href="/blog/<?=$post['_id']?>/view">
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
                              <h2><a href="/blog/<?=$post['_id']?>/view"><?=$post['headline']?></a></h2>
                              <p><?=substr($post['body'],0,500)?>...</p>
                              
                              <ul class="unstyled inline">
                                 <li><i class="icon-calendar"></i> <a href="#"><?=$post['publishDate']['fullMonth']?></a></li>
                                 <li><i class="icon-comments"></i> <a href="#"><?=$post['commentCount']?> Comments</a></li>
                              </ul>
                              <br>
                              <ul class="unstyled inline blog-tags">
                                 <li>
                                    <i class="icon-tags"></i> 
                                    <? if(!empty($post['tags'])):
                                          foreach($post['tags'] as $tag):
                                    ?>
                                    <a href="/blog/tag<?=$tag['slug']?>"><?=$tag['name']?></a> 
                                    <?    endforeach;
                                       endif;
                                    ?>
                                 </li>
                              </ul>
                              <br>
                              <a class="btn blue pull-right" href="/blog/<?=$post['_id']?>/view">
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
                              <h2>There are no posts available.</h2>
                           </div>
                        </div>
                        <? endif; /* endif if !empty this->vars['posts'] */ ?>
                        


                     </div>
                     <!--end span9-->
                     <div class="span3 blog-sidebar">
                        <h2>Blog Tags</h2>
                        <ul class="unstyled inline sidebar-tags">
                           <?
                              foreach($this->vars['tags'] as $tag):
                           ?>
                              <li><a href="/blog/tag<?=$tag['slug']?>"><i class="icon-tags"></i> <?=$tag['name']?></a></li>
                           <? endforeach;?>
                        </ul>
                        <div class="space20"></div>
                        <h2>Archives</h2>
                        <div class="top-news">
                           
                           <a href="/blog/archives/August/2013" class="btn blue">
                           <span>August 2013</span>
                           <em>12 posts<em>
                           <i class="icon-archive top-news-icon"></i>
                           </a>

                        </div>
                        
                     </div>
                     <!--end span3-->
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
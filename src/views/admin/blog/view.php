   <link href="/assets/css/pages/blog.css" rel="stylesheet" type="text/css"/>
   <? $post = $this->vars['post']; ?>

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
                        <h1><?=$post['headline']?></h1>
                        <div class="blog-tag-data">
                           <? if(!empty($post['image'])): ?>
                           <img src="<?=$this->app['getImageURL']($post['image'],'large') ?>" alt="">
                           <? endif;?>
                           <div class="row-fluid">
                              <div class="span6">
                                 <ul class="unstyled inline blog-tags">
                                    <li>
                                       <i class="icon-tags"></i> 
                                       <? if(!empty($post['tags'])):
                                          $tags = explode(',',$post['tags']);
                                          foreach($tags as $tag):
                                    ?>
                                    <a href="/blog/tag/<?=$tag?>"><?=$tag?></a> 
                                    <?    endforeach;
                                       endif;
                                    ?>
                                    </li>
                                 </ul>
                              </div>
                              <div class="span6 blog-tag-data-inner">
                                 <ul class="unstyled inline">
                                    <li><i class="icon-calendar"></i> <a href="#"><?=$post['publishDate']['fullMonth']?></a></li>
                                    <li><i class="icon-comments"></i> <a href="#"><?=$post['commentCount']?> Comments</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <!--end news-tag-data-->
                        <div>
                           <? if (!empty($post['video'])){ ?>
                              <?=$post['video']?>
                              <br><br>
                           <? } ?>
                           <? if (!empty($post['link'])){ ?>
                              <h2><a href="<?=$post['link']?>"><?=$post['link']?></a></h2>
                              <br><br>
                           <? } ?>
                           <p><?=$post['body']?></p>
                        </div>
                        <hr>


                        <!-- COMMENTS -->
                        <? if(false): ?>
                        <div class="media">
                           <h3>Comments</h3>
                           <a href="#" class="pull-left">
                           <img alt="" src="assets/img/blog/9.jpg" class="media-object">
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading">Media heading <span>5 hours ago / <a href="#">Reply</a></span></h4>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <hr>
                              <!-- Nested media object -->
                              <div class="media">
                                 <a href="#" class="pull-left">
                                 <img alt="" src="assets/img/blog/5.jpg" class="media-object">
                                 </a>
                                 <div class="media-body">
                                    <h4 class="media-heading">Media heading <span>17 hours ago / <a href="#">Reply</a></span></h4>
                                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                 </div>
                              </div>
                              <!--end media-->
                              <hr>
                              <div class="media">
                                 <a href="#" class="pull-left">
                                 <img alt="" src="assets/img/blog/7.jpg" class="media-object">
                                 </a>
                                 <div class="media-body">
                                    <h4 class="media-heading">Media heading <span>2 days ago / <a href="#">Reply</a></span></h4>
                                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                 </div>
                              </div>
                              <!--end media-->
                           </div>
                        </div>
                        <!--end media-->
                        <div class="media">
                           <a href="#" class="pull-left">
                           <img alt="" src="assets/img/blog/6.jpg" class="media-object">
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading">Media heading <span>July 5,2013 / <a href="#">Reply</a></span></h4>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                           </div>
                        </div>
                        <!--end media-->
                        <hr>
                        <div class="post-comment">
                           <h3>Leave a Comment</h3>
                           <form>
                              <label>Name</label>
                              <input type="text" class="span7 m-wrap">
                              <label>Email <span class="color-red">*</span></label>
                              <input type="text" class="span7 m-wrap">
                              <label>Message</label>
                              <textarea class="span10 m-wrap" rows="8"></textarea>
                              <p><button class="btn blue" type="submit">Post a Comment</button></p>
                           </form>
                        </div>
                        <? endif; ?>
                        <!--/ COMMENTS -->
                     </div>
                     <!--end span9-->
                     <div class="span3 blog-sidebar">
                        <h2>Blog Tags</h2>
                        <ul class="unstyled inline sidebar-tags">
                           <? 
                              foreach($this->vars['tags'] as $tag):
                           ?>
                              <li><a href="/blog/tag/<?=$tag?>"><i class="icon-tags"></i> <?=$tag?></a></li>
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
               </div>
            </div>
            <!-- END PAGE CONTENT-->



         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
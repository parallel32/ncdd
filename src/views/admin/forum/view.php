   <link href="/assets/css/pages/blog.css" rel="stylesheet" type="text/css"/>
   <? $post = $this->vars['topic']; ?>

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
                           <div class="row-fluid">
                              <div class="span12 blog-tag-data-inner">
                                 <ul class="unstyled inline">
                                    <? if(array_key_exists('displayName',$post['author'])){ ?>
                                    <li><i class="icon-pencil"></i> <a href="#"> by <?=$post['author']['displayName']?></a></li>
                                    <? } ?>
                                    <? if(array_key_exists('fullMonth',$post['publishDate'])){ ?>
                                    <li><i class="icon-calendar"></i> <a href="#"><?=$post['publishDate']['fullMonth']?></a></li>
                                    <? } ?>
                                    <li><i class="icon-comments"></i> <a href="#"><?=$post['commentCount']?> Comments</a></li>
                                 </ul>
                              </div>
                           </div>
                           <? if(!empty($post['image'])): ?>
                           <img src="<?=$this->app['getImageURL']($post['image'],'large') ?>" alt="">
                           <? endif;?>
                           
                        </div>
                        <!--end news-tag-data-->
                        <div>
                           <p><?=$post['body']?></p>
                        </div>
                        <!-- COMMENTS -->
                        <? if(true): ?>
                        <a name="comments"></a>
                        <div class="media">
                           <h2>Comments</h2>
                           <hr>
                           <? if(!empty($this->vars['comments'])): ?>
                           <? foreach($this->vars['comments'] as $comment): ?>
                           <a href="#" class="pull-left">
                           <? if(!empty($comment['author'])){ ?>
                           <img alt="" src="<?=$this->app['getImageURL']($comment['author']['image'],'small')?>" class="media-object">
                           <? } ?>
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading"><?=(!empty($comment['author'])) ? $comment['author']['displayName']: ''?> <span><?=$comment['timeAgo']?> </span></h4>
                              <p><?=$comment['comment']?></p>
                              <hr>
                           </div>
                           <? endforeach; ?>
                           <? else: ?>
                           No comments.
                           <? endif; ?>
                        </div>
                        <!--end media-->
                        <hr>
                        <div class="post-comment">
                           <h3>Leave a Comment</h3>
                           <form id="saw-form">
                              <input type="hidden" name="doc[belongsTo]" value="<?=$this->vars['topic']['_id']?>">
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                       <label class="control-label">Type your comment here:</label>
                                       <div class="controls">
                                          <textarea id="comment-message" class="span12 comment" name="doc[comment]"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <!--/span-->
                              </div>

                              <p><a class="btn blue save">Post a Comment</a></p>
                           </form>
                        </div>
                        <? endif; ?>
                        <!--/ COMMENTS -->
                     </div>
                     <!--end span9-->

                     <? if(array_key_exists('files', $post)): ?>
                     <div class="span3 blog-sidebar">
                        <h2>Files</h2>
                        <? foreach($post['files'] as $file): ?>
                        <div class="top-news">
                           
                           <a target="_blank" href="<?=$file['embedUrl']?>" class="btn blue">
                           <span><?=$file['name']?></span>
                           <em>click to view<em>
                           <i class="icon-file-text top-news-icon"></i>
                           </a>

                        </div>
                        <? endforeach; ?>
                     </div>
                     <!--end span3-->
                     <? endif; ?>
                  </div>
               </div>
            </div>
            <!-- END PAGE CONTENT-->



         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->


      <?=$this->element('js/Comment.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Comment.init('/topic/<?=$this->vars['topic']['_id']?>/view?v=<?=rand()?>');
         });
            
         </script>
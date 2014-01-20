<link href="/assets/css/pages/news.css" rel="stylesheet" type="text/css"/>
<style>
/*green blue red yellow purple black .. or no color will make it light grey*/
.news-blocks img.news-block-imgg {
margin: 5px 10px 0 0;
}
.top-news em, .top-news span {
text-align: center;
}
</style>

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
               <div class="span12 news-page">


                  <!-- TOPICS -->                  
                  <h1>Recent Topics</h1>
                  <div class="row-fluid">
                     <div class="span4">
                        <? $i=0; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn green">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        <? $i=1; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn yellow">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        
                     </div>
                     <!--end span4-->
                     <div class="span5">
                        <? $i=2; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn blue">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        
                        <? $i=3; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn black">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        
                     </div>
                     <!--end span5-->
                     <div class="span3">
                        <? $i=4; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn red">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        
                        <? $i=5; ?>
                        <div class="news-blocks">
                           <div class="top-news">
                              <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="btn purple">
                                 <span><?=$this->vars['topics'][$i]['forum']['name']?></span>
                                 <? if (!empty($this->vars['topics'][$i]['forum']['owner'])): ?>
                                 <em>
                                    <i class="icon-pencil"></i>
                                    by <?=$this->vars['topics'][$i]['forum']['owner']['displayName']?> 
                                 </em>
                                 <? endif; ?>
                                 <i class="top-news-icon"></i>
                              </a>
                           </div>
                           <h3><a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view"><?=$this->vars['topics'][$i]['headline']?></a></h3>
                           <div class="news-block-tags">
                              <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($this->vars['topics'][$i]['publishDate']['fullDateTime']), 'America/New_York'); ?>
                              <em>by <?=$this->vars['topics'][$i]['author']['displayName']?>, <?=$human->diffForHumans()?></em>
                           </div>
                           <p>
                              <?=substr($this->vars['topics'][$i]['body'],0,250)?>...
                           </p>
                           
                           <a href="/topic/<?=$this->vars['topics'][$i]['_id']?>/view" class="news-block-btn">
                              Read more
                              <i class="m-icon-swapright m-icon-black"></i>                              
                           </a> 
                                                    
                        </div>
                        
                     </div>
                     <!--end span3-->
                  </div>
                  <!--/ TOPICS -->                  
                  <div class="space20"></div>


                  <!-- FORUMS -->                  
                  <h2>All Forums </h2>
                     <div class="row-fluid">
                     <? $i=1; foreach($this->vars['forums'] as $forum): ?>
                        <div class="span3">
                           <div class="news-blocks">
                              <div class="top-news">
                                 <a href="/forum/view/<?=$forum['_id']?>" class="btn blue">
                                    <span><?=$forum['name']?></span>
                                    <? if(!empty($forum['owner'])): ?>
                                    <em>
                                       <i class="icon-pencil"></i>
                                       by <?=$forum['owner']['displayName']?> 
                                    </em>
                                    <? endif; ?>
                                    <i class="top-news-icon"></i>
                                 </a>
                              </div>
                              <h3>
                                 <ul class="pricing-content unstyled">
                                    <li><i class="icon-file"></i><?=$forum['topicCount']?> topics</li>
                                    <li><i class="icon-comments"></i><?=$forum['commentCount']?> comments</li>
                                 </ul>
                              </h3>
                              <!--
                              <div class="news-block-tags">
                                 <em>last comment: 2 hours ago</em>
                              </div>-->
                              <? if(!empty($forum['image'])): ?>
                              <p>
                                 <img class="news-block-imgg" src="<?=$forum['image']?>" alt="">
                              </p>
                              <? endif; ?>
                              <!--
                              <a href="page_news_item.html" class="news-block-btn">
                                 Read more
                                 <i class="m-icon-swapright m-icon-black"></i>                              
                              </a> 
                              -->                         
                           </div>
                        </div>
                        <!--end span3-->
                     <? if (($i % 4) == 0){ ?>
                        </div><div class="row-fluid">
                     <? } ?>
                     <? $i++; endforeach; ?>
                  </div>
                  <div class="space20"></div>
                  <!--/ FORUMS -->                  
                  
               </div>
            </div>
            <!-- END PAGE CONTENT-->





         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        <div class="blogContent">
                            
                            <p class="blogDescr"><?=$this->vars['page']['body']?></p>
                            <div class="row-fluid">
                                <div class="span8 pull-left">
                                    <? $post = $this->vars['post'];?>
                                    <?
                                        switch (\Saw\Model\Blog::$typeReversed[$post['currentType']]) {
                                            case 'EDITORIAL':
                                                $class = 'quote';
                                                break;
                                            case 'PICTURE':
                                                $class = 'photo';
                                                break;
                                            case 'LINK':
                                                $class = 'link';
                                                break;
                                            case 'VIDEO':
                                                $class = 'video';
                                                break;
                                        }
                                        if((\Saw\Model\Blog::$typeReversed[$post['currentType']] < \Saw\Model\Blog::$type['PICTURE']) && !empty($post['image'])){
                                            $class = 'photo';
                                            $type = ' PICTURE';
                                        }
                                    ?>

                                    <div class="postBody">
                                        <ul class="postHeader">
                                            <li class="mediaBlock <?=$class?>"><a href="/blog/<?=$post['_id']?>/<?=$post['slug']?>"></a></li>
                                            <li class="dateBlock"><a href="/blog/<?=$post['_id']?>/<?=$post['slug']?>"><?=$post['publishDate']['fullMonth']?></a></li>
                                        </ul>
                                        <div class="postContent">
                                            <div class="postMainImg">
                                                <? if(!empty($post['image'])){ ?>
                                                <img src="<?=$post['image']['urls']['large']['CDN'] ?>" alt="" class="bigPostMainImg">
                                                <? } ?>
                                                <? if(!empty($post['video'])){ ?>
                                                <br>
                                                <?=$post['video']?>
                                                <br>
                                                <? } ?>
                                            </div>
                                            <h3 class="postTitle"><?=$post['headline']?></h3>
                                            <? if(!empty($post['link'])){ ?>
                                            <br>
                                            <a href="<?=$post['link']?>" class="bigLink"><?=$post['link']?></a>
                                            <br>
                                            <? } ?>


                                            <p class="postDescr"><?=$post['body']?></p>
                                            <div class="postInfo"><span class="postAuthor">Posted by <a href="/member/<?=$post['author']['_id']?>/<?=$post['author']['slug']?>"><?=$post['author']['firstName'].' '.$post['author']['lastName']?> </a></span></div>
                                        </div>
                                        <div class="postFooter">
                                            <ul class="postTags pull-left">
                                                <li><h5>TAGS:</h5></li>
                                                
                                                <? if(!empty($post['tags'])):
                                                      $tags = explode(',',$post['tags']);
                                                      foreach($tags as $tag):
                                                ?>
                                                <li><a href="/blog/tag/<?=$tag?>">#<?=$tag?></a> </li>
                                                <?    endforeach;
                                                   endif;
                                                ?>
                                                
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="text-center">
                                        <ul class="pager">
                                            <li><a href="#">Older</a></li>
                                            <li class="sep"></li>
                                            <li><a href="#">Newer</a></li>
                                        </ul>
                                    </div>
                                    -->
                                </div>
                                <div class="span4 pull-right">
                                    <aside>
                                        <div class="asideItem tagClouds">
                                            <h4 class="asideTitle">Tags</h4>
                                            <ul class="tagList inline">
                                                <? foreach($this->vars['tags'] as $tag): ?>
                                                <li class="tagListItem"><a href="/blog/tag/<?=$tag?>" class="tagListLink"><?=$tag?></a></li>
                                                <? endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="asideItem archive">
                                            <h4 class="asideTitle">Archive</h4>
                                            <ul class="archiveAccordion accordion" id="archiveAccordion">
                                                <li class="archiveItem accordion-group">
                                                    <div class="accordion-heading">
                                                        <a class="archiveLink accordion-toggle collapsed" data-toggle="collapse" data-parent="#archiveAccordion" href="#year2013">2013 (5)</a>
                                                    </div>
                                                    <div id="year2013" class="accordion-body collapse">
                                                        <div class="accordion-inner">
                                                            <ul class="collapseLink">
                                                                <li><a href="/blog/archives/August/2013">August (5)</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                    </aside>
                                </div>
                            </div>
                            <!-- -->
                        </div>
                    </div>
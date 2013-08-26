                    <div class="row-fluid">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        <div class="text-center">
                            <br>
                            <?=$this->vars['page']['body']?>
                            <br>
                            <a href="http://twitter.com/NCDDNews" class="btn">@NCDDNews</a> <br><br><a href="https://twitter.com/NCDDNews" class="twitter-follow-button" data-show-count="false" data-size="large" data-dnt="true">Follow @NCDDNews</a>
                            

                            <!-- RECENT DUI NEWS -->
                    <div class="row-fluid bottomPadding recentNews">
                        <div id="dui-tweets-hidden" class="hide"></div>
                        <ul id="dui-tweets" class="thumbnails">
                            
                        </ul>
                        <div class="text-center">
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </div>
                    </div>
                    <script>
                     jQuery(document).ready(function(){
                        cTweet = function(obj){
                        $('#dui-tweets-hidden').html(obj.body);
                        
                        $.each($('#dui-tweets-hidden .tweet.h-entry'),function(index, value){
                           //if(index == 5){
                           //   return false;
                           //}
                           var posted_time = $(value).find('time').attr('aria-label');
                           var post_link = $(value).find('.u-url.permalink').attr('href');
                           var profile_img = $(value).find('.header .profile img').attr('data-src-2x');
                           var name = $(value).find('.header .profile .p-name').html();
                           var handle = $(value).find('.header .profile .p-nickname').html();
                           var tweet = $(value).find('.e-entry-content').html();
                           
                           var new_tweet = ''+
                           '<li class="span12">'+
                           '     <div class="thumbnail">'+
                           '         <a href="'+post_link+'"><img src="'+profile_img+'" alt="" class="pull-left"></a>'+
                           '         <div class="caption pull-left">'+
                           '             <h4 class="pull-left">'+name+' - '+handle+'</h4>'+
                           '             <span class="date pull-right">'+posted_time+'</span>'+
                           '             <p class="descr">'+tweet+'</p>'+
                           '             <ul class="links">'+
                           '                 <li class="linksItem"><a href="'+post_link+'"><b>&middot; &middot; &middot;</b>View</a></li>'+
                           '             </ul>'+
                           '         </div>'+
                           '     </div>'+
                           ' </li>';
                           $('#dui-tweets').append(new_tweet);
                           
                        });
                     };
                     e = '366950396167606272';
                     c = document.createElement("script");
                     c.type = "text/javascript";
                     c.src = "//cdn.syndication.twimg.com/widgets/timelines/" + e + "?&lang=en&callback=cTweet&suppress_response_codes=false&rnd=" + Math.random();
                     document.getElementsByTagName("head")[0].appendChild(c);
                     });
                  </script>
                    <!--/ RECENT DUI NEWS -->
                        </div>
                    </div>
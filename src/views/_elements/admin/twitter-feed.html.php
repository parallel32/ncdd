<!-- TWITTER FEED -->
               <link href="/assets/css/pages/search.css" rel="stylesheet" type="text/css"/>
               <div class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="twitter">
                              <div class="caption"><i class="icon-bullhorn"></i>Latest DUI News</div>
                              <div class="actions">
                                 <a href="https://twitter.com/NCDDNews" target="_blank" class="btn green view"><i class=" icon-twitter"></i> @NCDDNews</a>
                              </div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <div id="dui-news">

                              </div>
                              <div id="dui-news-hidden" class="hide"></div>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <script>
                     jQuery(document).ready(function(){
                        cTweet = function(obj){
                        $('#dui-news-hidden').html(obj.body);
                        
                        $.each($('#dui-news-hidden .tweet.h-entry'),function(index, value){
                           if(index == 5){
                              return false;
                           }
                           var posted_time = $(value).find('time').attr('aria-label');
                           var post_link = $(value).find('.u-url.permalink').attr('href');
                           var profile_img = $(value).find('.header .profile img').attr('data-src-2x');
                           var name = $(value).find('.header .profile .p-name').html();
                           var handle = $(value).find('.header .profile .p-nickname').html();
                           var tweet = $(value).find('.e-entry-content').html();
                           
                           var new_tweet = ''+
                           '                        <div class="row-fluid portfolio-block">'+
                           '                           <div class="span5 portfolio-text">'+
                           '                              <img src="'+profile_img+'" alt="">'+
                           '                              <div class="portfolio-text-info">'+
                           '                                 <h4>'+name+' - '+handle+'</h4>'+
                           '                                 '+tweet+
                           '                              </div>'+
                           '                           </div>'+
                           '                           <div class="span5">'+
                           '                              <div class="portfolio-info">'+
                           '                              </div>'+
                           '                              <div class="portfolio-info">'+
                           '                              </div>'+
                           '                              <div class="portfolio-info">'+
                           '                                 '+posted_time+
                           '                              </div>'+
                           '                           </div>'+
                           '                           <div class="span2 portfolio-btn">'+
                           '                              <a href="'+post_link+'" target="_blank" class="btn bigicn-only"><span>View</span></a>                        '+
                           '                           </div>'+
                           '                        </div>';
                           $('#dui-news').append(new_tweet);
                           
                        });
                     };
                     e = '366950396167606272';
                     c = document.createElement("script");
                     c.type = "text/javascript";
                     c.src = "//cdn.syndication.twimg.com/widgets/timelines/" + e + "?&lang=en&callback=cTweet&suppress_response_codes=false&rnd=" + Math.random();
                     document.getElementsByTagName("head")[0].appendChild(c);
                     });
                  </script>
                  <!-- tweet parsing reference
                  <li class="tweet h-entry with-expansion customisable-border" data-tweet-id="366105836285739009">

                  <a class="u-url permalink customisable-highlight" href="https://twitter.com/transferband/statuses/366105836285739009" data-datetime="2013-08-10T07:56:47+0000"><time pubdate="" class="dt-updated" datetime="2013-08-10T07:56:47+0000" title="Time posted: 10 Aug 2013, 07:56:47 (UTC)" aria-label="Posted 43 minutes ago">43<abbr title="minutes">m</abbr></time></a>

                    <div class="header h-card p-author with-verification">
                    <a class="u-url profile" href="https://twitter.com/transferband" aria-label="TRANSFER (screen name: transferband)">
                      <img class="u-photo avatar" alt="" src="https://si0.twimg.com/profile_images/3193986515/d9ed93bf25d16bd13760c42c3b8ebcf7_normal.jpeg" data-src-2x="https://si0.twimg.com/profile_images/3193986515/d9ed93bf25d16bd13760c42c3b8ebcf7_bigger.jpeg">
                      <span class="full-name">
                        
                        <span class="p-name customisable-highlight">TRANSFER</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="verified" title="Verified Account" aria-label="Verified Account"><b>✔</b></span>
                      </span>
                      <span class="p-nickname" dir="ltr">@<b>transferband</b></span>
                    </a>
                  </div>

                    <div class="e-entry-content">
                      <p class="e-entry-title">A little late night studio scrutiny...listening, watching, judging! <a href="https://twitter.com/search?q=%23bigfishstudios&amp;src=hash" data-query-source="hashtag_click" class="hashtag customisable" dir="ltr" rel="tag">#<b>bigfishstudios</b></a> <a href="https://twitter.com/search?q=%23api&amp;src=hash" data-query-source="hashtag_click" class="hashtag customisable" dir="ltr" rel="tag">#<b>api</b></a> <a href="https://twitter.com/search?q=%23recording&amp;src=hash" data-query-source="hashtag_click" class="hashtag customisable" dir="ltr" rel="tag">#<b>recording</b></a> <a href="https://twitter.com/search?q=%23newmusic&amp;src=hash" data-query-source="hashtag_click" class="hashtag customisable" dir="ltr" rel="tag">#<b>newmusic</b></a>... <a href="http://t.co/76nixUsykO" rel="nofollow" dir="ltr" data-expanded-url="http://fb.me/6kwwsP3sV" class="link customisable" target="_blank" title="http://fb.me/6kwwsP3sV"><span class="tco-hidden">http://</span><span class="tco-display">fb.me/6kwwsP3sV</span><span class="tco-hidden"></span><span class="tco-ellipsis"><span class="tco-hidden">&nbsp;</span></span></a></p>



                    </div>

                    <div class="footer customisable-border">
                      <span class="stats-narrow"><span class="stats">
                    <span class="stats-favorites">
                      <strong>1</strong> favorite
                    </span>
                  </span>
                  </span>
                      
                      <a class="expand customisable-highlight" href="https://twitter.com/transferband/statuses/366105836285739009" data-toggled-text="Collapse"><b>Expand</b></a>

                      <ul class="tweet-actions">
                    <li><a href="https://twitter.com/intent/tweet?in_reply_to=366105836285739009" class="reply-action web-intent" title="Reply"><i class="ic-reply ic-mask"></i><b>Reply</b></a></li>
                    <li><a href="https://twitter.com/intent/retweet?tweet_id=366105836285739009" class="retweet-action web-intent" title="Retweet"><i class="ic-retweet ic-mask"></i><b>Retweet</b></a></li>
                    <li><a href="https://twitter.com/intent/favorite?tweet_id=366105836285739009" class="favorite-action web-intent" title="Favorite"><i class="ic-fav ic-mask"></i><b>Favorite</b></a></li>
                  </ul>
                      <span class="stats-wide"><b>· </b><span class="stats">
                    <span class="stats-favorites">
                      <strong>1</strong> favorite
                    </span>
                  </span>
                  </span>
                    </div>
                  </li>
                  -->
               <div class="clearfix"></div>
               <!--/ TWITTER FEED -->
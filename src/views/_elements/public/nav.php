            <div class="hidden-phone">
                <div class="navbar-custom-inner">
                    <div class="container"> 
                        <div class="navbar">
                            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse-top">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                            <div class="nav-collapse collapse nav-collapse-top">
                                <ul class="pull-left nav">
                                    <li class="dropdown signIn">
                                        <a href="http://<?=SAW_ADMIN_WEBSITE ?>" class="" >Member <b>Sign in</b></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="memberDropDown">
                                            <li role="menuitem">
                                                <form action="get">
                                                    <input type="text" placeholder="username" class="username">
                                                    <input type="text" placeholder="password" class="password">
                                                    <div class="clearfix">
                                                        <label for="checkbox1" class="checkbox pull-left"><input type="checkbox" id="checkbox1" checked>Remember me</label>
                                                        <a href="#" class="pull-right">Forgot Password?</a>
                                                    </div>
                                                    <input type="submit" class="btn" value="Sign in">
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <li class="sep"></li>
                                    <li><a href="/deans-message">Dean’s Message</a></li>
                                    <li class="sep"></li>
                                    <li><a href="/dui-laws-in-your-state">DUI Laws in your State</a></li>
                                </ul>
                                 <ul class="pull-right nav navbar-form">
                                    <li><a href="/contact">Contact</a></li>
                                    <li class="sep"></li>
                                    <li class="cart"><a href="/coming-soon"><img src="/assets/img/cart.png" alt=""><!--<sup>3</sup>--></a></li>
                                    <li class="sep"></li>
                                    <li>
                                        <form action="/coming-soon"><input type="text" class="search span2" placeholder="search"><input type="submit" class="searchBtn" value=""></form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bgSep"></div>
                </div>
                <div class="mainMenu">
                    <div class="container">
                        <h1 class="logo"><a href="/">NCDD</a></h1>
                        <div class="text-center">
                            <div class="mainMenuBody">
                                <ul class="pull-left menu">
                                    <li class="dropdown">
                                        <a href="javascript:void(0)" class="text-center dropdown-toggle" id="discover">Discover <small>What You Can Do</small><div class="arrow"></div></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="javascript:void(0)" class="text-center dropdown-toggle" id="learn">LEARN <small>DUI Defense</small><div class="arrow"></div></a>
                                    </li>
                                </ul>
                                <ul class="pull-right menu">
                                    <li><a href="/find-an-attorney" class="text-center">ATTORNEYS <small>Find One Nearby</small></a></li>
                                    <li><a href="/become-a-member" class="text-center">BECOME <br> A MEMBER</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown-menu discover fullWidthDropDown" role="menu" aria-labelledby="discover">
                            <div class="container" role="menuitem">
                                <div class="close"></div>
                                <div class="tabbable tabs-left">
                                    <ul class="dropDownMenu nav nav-tabs" id="discoverTab">
                                        <?
                                        $i=0;
                                        foreach($this->vars['pages']['DISCOVER'] as $page):?>
                                        <li data-url="<?=$page['slug']?>" class="dropDownMenuItem <?=($i==0)?'active':'';?>"><a href="#<?=$page['slug']?>" class="dropDownMenuLink span2"><?=$page['headline']?></a></li>
                                        <?
                                        $i++;
                                        endforeach;?>
                                    </ul>
                                    <div class="tab-content">
                                        <? 
                                        $i=0;
                                        foreach($this->vars['pages']['DISCOVER'] as $page): ?>
                                        <div class="tab-pane text-center <?=($i==0)?'active':'';?>" id="<?=$page['slug']?>">
                                             
                                        </div>
                                        <? 
                                        $i++;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            jQuery(document).ready(function() {
                                function saw_get_preview(page_url){
                                    $.get('/preview/'+page_url)
                                    .done(function(response){
                                        if(page_url == 'board-certification'){
                                            $('#board-certification').addClass('active');
                                        }
                                        $('#'+page_url).html(response);
                                    })
                                    .fail(function(response){
                                    })
                                    .always(function(response){
                                        
                                    });
                                };
                                $('#discoverTab li').click(function(e){
                                    e.preventDefault();
                                    saw_get_preview($(this).attr('data-url'));
                                    
                                });
                                $('#discoverTab .active').trigger('click');                               


                                $('#learnTab li').click(function(e){
                                    e.preventDefault();
                                    $('#boardCertificationMenu li').removeClass('active');
                                    $('.boardCertificationDescr .board-cert-preview-only').removeClass('active');
                                    saw_get_preview($(this).attr('data-url'));
                                    
                                });
                                $('#learnTab .active').trigger('click');

                                $('#boardCertificationMenu li').click(function(e){
                                    e.preventDefault();
                                    saw_get_preview($(this).attr('data-url'));
                                    
                                });
                                $('#boardCertificationMenu .active').trigger('click');
                            });  
                        </script>
                        <div class="dropdown-menu learn fullWidthDropDown" role="menu" aria-labelledby="learn">
                            <div class="container" role="menuitem">
                                <div class="close"></div>
                                <div class="tabbable tabs-left">
                                    <ul class="dropDownMenu nav nav-tabs" id="learnTab">
                                        <?
                                        $i=0;
                                        foreach($this->vars['pages']['LEARN'] as $page):?>
                                        <li data-url="<?=$page['slug']?>" class="dropDownMenuItem <?=($i==0)?'active':'';?>"><a href="#<?=($page['slug']=='board-certification') ? 'boardCertification': $page['slug'] ?>" class="dropDownMenuLink span2"><?=$page['headline']?><?=($page['slug'] == 'board-certification') ? '<span class="arrow pull-right"></span>': ''?></a></li>
                                        <?
                                        $i++;
                                        endforeach;?>
                                    </ul>
                                    <div class="tab-content">
                                        
                                        <? 
                                        $i=0;
                                        foreach($this->vars['pages']['LEARN'] as $page): 
                                            
                                            if($page['slug'] == 'board-certification'):
                                        ?>
                                        
                                                <div class="tab-pane tabbable tabs-left row-fluid <?=($i==0)?'active':'';?>" id="boardCertification">
                                                    <ul class="span6 dropDownMenu nav nav-tabs pull-left" id="boardCertificationMenu">
                                                        <li class="arrow"></li>
                                                        <? foreach($this->vars['pages']['BOARD CERTIFICATION'] as $page):?>
                                                            <li data-url="<?=$page['slug']?>" class=" <?=($i==0)?'active':'';?>"><a href="#<?=$page['slug']?>" class=""><?=$page['headline']?></a></li>
                                                        <? endforeach;?>
                                                    </ul>
                                                    <div class="span6 boardCertificationDescr tab-content pull-right">
                                                        <div class="tab-pane active text-center" id="board-certification">
                                                            
                                                        </div>
                                                        <? foreach($this->vars['pages']['BOARD CERTIFICATION'] as $page):?>
                                                            <div class="tab-pane text-center board-cert-preview-only" id="<?=$page['slug'] ?>">
                                                                
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>

                                                </div>



                                            <? else: ?>


                                                <div class="tab-pane text-center <?=($i==0)?'active':'';?>" id="<?=$page['slug']?>">


                                                </div>


                                            <? endif; ?>

                                        <? 
                                        $i++;
                                        endforeach; ?>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






















            <script>
                jQuery(document).ready(function() {
                    $('#learnTab-phone li a').click(function(e){
                        e.preventDefault();
                        document.location.href='/'+$(this).attr('data-url')
                        
                    });
                    $('#discoverTab-phone li a').click(function(e){
                        e.preventDefault();
                        document.location.href='/'+$(this).attr('data-url')
                        
                    });
                });  
            </script>
            <div class="visible-phone">
                <div class="nav-collapse nav-collapse-top collapse">
                    <div class="mainMenu">
                        <div class="container">
                            <div class="text-center">
                                <div class="mainMenuBody">
                                    <ul class="pull-left menu">
                                        <li class="dropdown">
                                            <a href="javascript:void(0)" class="text-center dropdown-toggle" id="discover">Discover <small>What You Can Do</small><div class="arrow"></div></a>
                                            <div class="dropdown-menu discover fullWidthDropDown" role="menu" aria-labelledby="discover">
                                                <div class="container" role="menuitem">
                                                    <div class="close"></div>
                                                    <div class="tabbable tabs-left" id="discoverTab-phone">
                                                        <ul class="dropDownMenu nav nav-tabs" id="discoverTab">
                                                            <?
                                                            $i=0;
                                                            foreach($this->vars['pages']['DISCOVER'] as $page):?>
                                                            <li class="dropDownMenuItem"><a data-url="<?=$page['slug']?>" href="#<?=$page['slug']?>" class="dropDownMenuLink span2 <?=($i==0)?'active':'';?>"><?=$page['headline']?></a></li>
                                                            <?
                                                            $i++;
                                                            endforeach;?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown">
                                            <a href="javascript:void(0)" class="text-center dropdown-toggle" id="learn">LEARN <small>DUI Defense</small><div class="arrow"></div></a>
                                            <div class="dropdown-menu learn fullWidthDropDown" role="menu" aria-labelledby="learn">
                                                <div class="container" role="menuitem">
                                                    <div class="close"></div>
                                                    <div class="tabbable tabs-left" id="learnTab-phone">
                                                        <ul class="dropDownMenu nav nav-tabs" id="learnTab">
                                                            <?
                                                            $i=0;
                                                            foreach($this->vars['pages']['LEARN'] as $page):?>

                                                            <? if($page['slug'] == 'board-certification'): ?>
                                                                <li class="dropDownMenuItem">
                                                                <a href="#board-certification" class="dropDownMenuLink span2"><?=$page['headline']?> <span class="arrow pull-right"></span></a>
                                                                 <ul class="span6 dropDownMenu nav nav-tabs pull-left" id="boardCertificationMenu">
                                                                    <li class="arrow"></li>
                                                                    <? foreach($this->vars['pages']['BOARD CERTIFICATION'] as $page): ?>        
                                                                    
                                                                    <li><a data-url="<?=$page['slug']?>" href="#<?=$page['slug']?>"><?=$page['headline']?></a></li>
                                                                    
                                                                    <? endforeach; ?>
                                                                </ul>
                                                            </li>
                                                            
                                                            <? else: ?>

                                                            <li class="dropDownMenuItem"><a data-url="<?=$page['slug']?>"  href="#<?=$page['slug']?>" class="dropDownMenuLink span2 <?=($i==0)?'active':'';?>"><?=$page['headline']?></a></li>
                                                            
                                                            <? endif; ?>
                                                            <?
                                                            $i++;
                                                            endforeach;?>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="pull-right menu">
                                        <li><a href="/find-an-attorney" class="text-center">ATTORNEYS <small>Find One Nearby</small></a></li>
                                        <li><a href="/become-a-member" class="text-center">BECOME <br> A MEMBER</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="pull-left nav">
                        <li class="dropdown signIn">
                            <a href="http://<?=SAW_ADMIN_WEBSITE ?>" class="" >Member <b>Sign in</b></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="memberDropDown">
                                <li role="menuitem">
                                    <form action="get">
                                        <input type="text" placeholder="username" class="username">
                                        <input type="text" placeholder="password" class="password">
                                        <div class="clearfix">
                                            <label for="checkbox1" class="checkbox pull-left"><input type="checkbox" id="checkbox1" checked>Remember me</label>
                                            <a href="#" class="pull-right">Forgot Password?</a>
                                        </div>
                                        <input type="submit" class="btn" value="Sign in">
                                    </form>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sep"></li>
                        <li><a href="/deans-message">Dean’s Message</a></li>
                        <li class="sep"></li>
                        <li><a href="#">DUI Laws in your State</a></li>
                    </ul>
                    <ul class="pull-right nav navbar-form">
                        <li><a href="/contact">Contact</a></li>
                        <li class="sep"></li>
                        <li class="cart"><a href="/coming-soon"><img src="/assets/img/cart.png" alt=""><sup>3</sup></a></li>
                        <li class="sep"></li>
                        <li>
                            <form action="/coming-soon"><input type="text" class="search span2" placeholder="search"><input type="submit" class="searchBtn" value=""></form>
                        </li>
                    </ul>
                </div>
                <div class="navbar-custom-inner">
                    <div class="container"> 
                        <div class="navbar">
                            <button type="button" class="btn-navbar-phone btn-navbar btn">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                    <div class="bgSep"></div>
                </div>
                <div class="mainMenu">
                    <h1 class="logo"><a href="/">NCDD</a></h1>
                </div>
            </div> 
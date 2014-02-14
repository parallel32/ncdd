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
                                        <? $user = $this->app['session']->get('user');?>
                                        <? if(is_array($user) && array_key_exists('accessLevel', $user)){ ?>
                                        <a href="http://<?=SAW_ADMIN_WEBSITE ?>" class="dropdown-toggle" data-toggle="dropdown" id="memberDropDown">Welcome, <?=$user['displayName']?></a>
                                        <? } else { ?>
                                        <a href="http://<?=SAW_ADMIN_WEBSITE ?>" >Member <b>Sign in</b></a>
                                        <? } ?>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="memberDropDown">
                                            <li role="menuitem">
                                                <form>
                                                    <p>Welcome, <?=$user['displayName']?> </p>
                                                    <a class="btn" href="http://<?=SAW_ADMIN_WEBSITE ?>" class="pull-right">Go To Member Portal</a>
                                                    <a class="btn" href="http://<?=SAW_ADMIN_WEBSITE ?>/logout" class="pull-right">Log Out</a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <li class="sep"></li>
                                    <li><a href="/deans-message">Dean’s Message</a></li>
                                    <li class="sep"></li>
                                    <li><a href="/board-certification">Board Certification</a></li>
                                    <li class="sep"></li>
                                    <li><a href="/blog">Blog</a></li>
                                    <li class="sep"></li>
                                    <li><a href="https://<?=SAW_CONSUMER_WEBSITE?>/store">Store</a></li>
                                    <li class="sep"></li>
                                    <li><a href="/dui-laws-in-your-state">DUI Laws in your State</a></li>

                                </ul>
                                 <ul class="pull-right nav navbar-form">
                                    <li><a href="/contact">Contact</a></li>
                                    <li class="sep"></li>
                                    <li class="cart"><a href="https://<?=SAW_CONSUMER_WEBSITE?>/shopping-cart"><img src="/assets/img/cart.png" alt=""><sup id="sup-cart"><?=call_user_func(function($app){ $cart = $app['session']->get('shoppingcart'); return (is_array($cart) && !empty($cart) && count($cart) > 0) ? count($cart): '';},$this->app)?></sup></a></li>
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
                        <script>
                            jQuery(document).ready(function() {
                                $('#learnTab li a').click(function(e){
                                    e.preventDefault();
                                    document.location.href='/'+$(this).attr('data-url')
                                    
                                });
                                $('#discoverTab li a').click(function(e){
                                    e.preventDefault();
                                    document.location.href='/'+$(this).attr('data-url')
                                    
                                });
                            });  
                        </script>
                        
                        <!-- DISCOVER BUTTON -->
                        <div class="dropdown-menu discover fullWidthDropDown specialwidthsetting" role="menu" aria-labelledby="discover">
                            <div class="container" role="menuitem">
                                <!--<div class="close"></div>-->
                                <div class="tabbable tabs-left">
                                    <ul class="dropDownMenu nav nav-tabs" id="discoverTab">
                                        <?
                                        $i=0;
                                        foreach($this->vars['pages']['DISCOVER'] as $page):?>
                                        <li class="dropDownMenuItem "><a data-url="<?=$page['slug']?>" href="#<?=$page['slug']?>" class="dropDownMenuLink span2"><?=$page['headline']?></a></li>
                                        <?
                                        $i++;
                                        endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!--/ DISCOVER BUTTON -->

                        <!-- LEARN BUTTON -->
                        <div class="dropdown-menu learn fullWidthDropDown specialwidthsetting" role="menu" aria-labelledby="learn">
                            <div class="container" role="menuitem">
                                <!--<div class="close"></div>-->
                                <div class="tabbable tabs-left">
                                    <ul class="dropDownMenu nav nav-tabs" id="learnTab">
                                        <?
                                        $i=0;
                                        foreach($this->vars['pages']['LEARN'] as $page):?>
                                        <li class="dropDownMenuItem "><a data-url="<?=$page['slug']?>" href="#<?=$page['slug']?>" class="dropDownMenuLink span2"><?=$page['headline']?></a></li>
                                        <?
                                        $i++;
                                        endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--/ LEARN BUTTON -->
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
                                                            <li class="dropDownMenuItem"><a data-url="<?=$page['slug']?>"  href="#<?=$page['slug']?>" class="dropDownMenuLink span2 <?=($i==0)?'active':'';?>"><?=$page['headline']?></a></li>
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
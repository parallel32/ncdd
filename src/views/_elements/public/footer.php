<footer>
                <div class="footerLinks">
                    <div class="bgSep"></div>
                    <div class="container">
                        <div class="row-fluid">
                            <div class="span4">
                                <h4 class="menuTitle">Discover</h4>
                                <ul class="footerMenu">
                                    <? foreach($this->vars['pages']['DISCOVER'] as $page):?>
                                        <li class="footerMenuItem"><a href="/<?=$page['slug']?>" class="footerMenuLink"><?=$page['headline']?></a></li>    
                                    <? endforeach; ?>
                                </ul>
                            </div>
                            <div class="span4">
                                <h4 class="menuTitle">Learn</h4>
                                <ul class="footerMenu">
                                    <? foreach($this->vars['pages']['LEARN'] as $page):?>
                                        <li class="footerMenuItem"><a href="/<?=$page['slug']?>" class="footerMenuLink"><?=$page['headline']?></a></li>    
                                    <? endforeach; ?>
                                </ul>
                            </div>
                            <div class="span4">
                                <h4 class="menuTitle">Contact</h4>
                                <div class="addressList">
                                    <address><b>Rhea Kirk, </b><br>Executive Director</address>
                                    <address>445 S Decatur <br> St. Montgomery AL 36104</address>
                                    <address><b>Telephone:</b> 334-264-1950 </address>
                                    <address><b>Fax:</b> 334-264-1920</address>
                                    <address><b>E-mail:</b> <a href="mailto:rhea@ncdd.com">rhea@ncdd.com</a></address>
                                </div>
                                <div class="smaillLogo"><img src="/assets/img/smallLogo.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footerCopyright">
                    <div class="bgSep"></div>
                    <div class="container">
                        <span class="copyright pull-left">Copyright <?=date('Y')?>. All Rights Reserved by The NCDD.</span>
                        <ul class="pull-right socialNetwork">
                            <li class="socialNetworkItem"><span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=LGuEYlXQkUS4WD2iodHgQVfEd4QiaKligcqtG3KtcNTf1gWRNCDIIq"></script></span></li>
                            <li class="socialNetworkItem"><a href="http://www.twitter.com/NCDDNews" class="socialNetworkLinl twitter" target="_blank"></a></li>                            
                            <li class="socialNetworkItem"><a href="https://www.facebook.com/NationalCollegeforDUIDefense" class="socialNetworkLinl facebook" target="_blank"></a></li>                            
                        </ul>
                    </div>
                </div>
            </footer>
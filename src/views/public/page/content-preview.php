                        <div class="text">
                            <div class="title" style="padding-top:45px">
                                <h2><?=$this->vars['page']['headline']?></h2>
                            </div>
                                <?=substr($this->vars['page']['body'],0,1000)?>
                            
                        </div>    
                        <div class="text-center"><a href="/<?=$this->vars['page']['slug']?>" class="btn">Get More Details</a></div>        
                        
                        <script>
                            jQuery(document).ready(function() {  
                                //padding-top: 45px;                                  
                            });
                            
                        </script>
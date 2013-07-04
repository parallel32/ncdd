                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->        
                  <h3 class="page-title">
                     <?=$this->vars['headline']?>          <small><?=$this->vars['description']?></small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="/">Home</a> 
                        <i class="icon-angle-right"></i>
                     </li>
                     
                     <?
                        $i=1;
                        foreach($this->vars['crumbs'] as $crumb):
                     ?>
                           <li>
                              <a href="<?=$crumb['href']?>"><?=$crumb['name']?></a>
                              <? if($i <= count($this->vars['crumbs'])-1){ ?>
                                 <i class="icon-angle-right"></i>
                              <? } ?>
                           </li>
                     <?         
                           $i++;
                        endforeach;
                     ?>

                     
                     
                  </ul>
                  <!-- END PAGE TITLE & BREADCRUMB-->
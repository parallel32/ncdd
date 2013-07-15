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
            <? $agenda = $this->vars['agenda'];?>
			<h3 class="page-title">
               <?=$agenda['name']?> - <?=$agenda['date']['fullMonth']?><small></small>
            </h3>
            <div class="row-fluid">
               <div class="span12">
                  <ul class="timeline">
                     <? if(!empty($agenda['timeSlots'])): ?>
                     <? foreach($agenda['timeSlots'] as $timeSlot): ?>
                     <li class="timeline-<?=$timeSlot['color']?>">
                        <div class="timeline-time">
                           <span class="date"><?=$timeSlot['date']['monthDay']?></span>
                           <span class="time"><?=$timeSlot['date']['shortTimeSlim']?></span>
                        </div>
                        <div class="timeline-icon"><i class="icon-time"></i></div>
                        <div class="hide"><?=$timeSlot['title']?></div>
                        <div class="hide"><?=$timeSlot['color']?></div>
                        <div class="timeline-body">
                           <h2><?=$timeSlot['title']?></h2>
                           <div class="timeline-content">
                           	<?=$timeSlot['description']?>
                           </div>
                        </div>
                     </li>
                     <? endforeach; ?>              
                     <? endif; ?>       
                  </ul>
               </div>
            </div>

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?
$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); 
?>
   <!-- BEGIN SIDEBAR -->
      <div class="page-sidebar nav-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->         
         <ul class="page-sidebar-menu" style="">
            <li>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
               <div class="sidebar-toggler hidden-phone"></div>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
               <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
               <form id="qs-form" class="sidebar-search">
                  <div class="input-box">
                     <a class="remove"></a>
                     <input type="text" class="query" placeholder="Member Search.." />            
                     <input type="button" class="submit" value=" " />
                  </div>
               </form>
               <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="start <? echo ($this->vars['active'] == 'Dashboard') ? 'active':'';?>">
               <a href="/">
               <i class="icon-dashboard"></i> 
               <span class="title">Dashboard</span>
               <? echo ($this->vars['active'] == 'Dashboard') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
         <? if($accessLevel >= EDITOR):?>
            <li class="<? echo (strpos($this->vars['active'], 'Application') !== false) ? 'active open':'open';?>">
               <a href="javascript:;">
               <i class="icon-copy"></i> 
               <span class="title">Applications</span>
               <span class="selected"></span><span class="arrow open"></span>
               </a>
               <ul class="sub-menu" style="display: block;">
                  <li class="<? echo ($this->vars['active'] == 'Applications/New') ? 'active':'';?>">
                     <a href="/applications"><i class="icon-file"></i> New Applications</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Applications/Renewal') ? 'active':'';?>">
                     <a href="/renewals"><i class="icon-file-text"></i> Renewals</a>
                  </li>
               </ul>
            </li>
         <? endif; ?>
         <? if($accessLevel >= EDITOR):?>
         <li class="<? echo ($this->vars['active'] == 'Scholarship') ? 'active':'';?>">
            <a href="/scholarships">
            <i class="icon-star"></i> 
            <span class="title">Scholarships</span>
            <? echo ($this->vars['active'] == 'Scholarship') ? '<span class="selected"></span>':'';?>
            </a>
         </li>
         <? endif; ?>
         
         <? if($accessLevel >= MEMBER):?>
            <li class="<? echo (strpos($this->vars['active'], 'Members') !== false) ? 'active open':'';?>">
               <a href="javascript:;">
               <i class="icon-group"></i> 
               <span class="title">Members</span>
               <? echo (strpos($this->vars['active'], 'Members') !== false) ? '<span class="selected"></span><span class="arrow open"></span>':'<span class="arrow"></span>';?>
               </a>
               <ul class="sub-menu">
                  <? if($accessLevel == MEMBER):?>
                  <li class="<? echo ($this->vars['active'] == 'Members/edit') ? 'active':'';?>">
                     <a href="/member/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>/edit"><i class="icon-pencil"></i> Edit My Profile</a>
                  </li>
                  <? endif; ?>
                  <li class="<? echo ($this->vars['active'] == 'Members/search') ? 'active':'';?>">
                     <a href="/member/search"><i class="icon-search"></i> Search Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Founding Members"><i class="icon-user"></i> Founding Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Faculty"><i class="icon-user"></i> Faculty</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Regents and Fellows"><i class="icon-user"></i> Regents and Fellows</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Regents"><i class="icon-user"></i> Regents</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Fellows"><i class="icon-user"></i> Fellows</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Former Regents"><i class="icon-user"></i> Former Regents</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=State Delegates"><i class="icon-user"></i> State Delegates</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Board Certified"><i class="icon-user"></i> Board Certified</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Board Certified Sr"><i class="icon-user"></i> Board Certified Sr.</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Sustaining Members"><i class="icon-user"></i> Sustaining Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=General Members"><i class="icon-user"></i> General Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/src') ? 'active':'';?>">
                     <a href="/member/search?query=Public Defenders"><i class="icon-user"></i> Public Defenders</a>
                  </li>
               </ul>
            </li>
         <? endif; ?>
         <? if($accessLevel == ADMIN):?>
            <li class="<? echo ($this->vars['active'] == 'Delegate') ? 'active':'';?>">
               <a href="/delegate">
               <i class="icon-copy"></i> 
               <span class="title">State Delegate Pages</span>
               <? echo ($this->vars['active'] == 'Delegate') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
         <? endif; ?>
         <? if($accessLevel >= MEMBER):?>
            <li class="<? echo ($this->vars['active'] == 'Pages') ? 'active':'';?>">
               <a href="<?=($accessLevel == MEMBER) ? '/page/all' : '/page/';?>">
               <i class="icon-copy"></i> 
               <span class="title">Pages</span>
               <? echo ($this->vars['active'] == 'Pages') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo (strpos($this->vars['active'], 'Seminar') !== false) ? 'active open':'';?>">
               <a id="seminar" href="/seminar">
               <i class="icon-facetime-video"></i> 
               <span class="title">Sessions &amp; Seminars</span>
               <? echo ($this->vars['active'] == 'Seminar') ? '<span class="selected"></span>':'';?>
               </a>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Seminar/State') ? 'active':'';?>">
                     <a href="/stateseminar"><i class="icon-file"></i> State Approved</a>
                  </li>
               </ul>
            </li>
            <li class="<? echo (strpos($this->vars['active'], 'Blog') !== false) ? 'active open':'';?>">
               <a id="dui-blog" href="/blog">
               <i class="icon-edit"></i> 
               <span class="title">DUI Blog</span>
               <? 
                  if($accessLevel == MEMBER){
                     echo (strpos($this->vars['active'], 'Blog') !== false) ? '<span class="selected"></span><span class="arrow open"></span>':'<span class="arrow"></span>';
                  } else {
                     echo (strpos($this->vars['active'], 'Blog') !== false) ? '<span class="selected"></span>':'';
                  }
               ?>
               </a>
               <? if($accessLevel == MEMBER):?>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Blog/My') ? 'active':'';?>">
                     <a href="/blog/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>"><i class="icon-pencil"></i> My Blog Posts</a>
                  </li>
               </ul>
               <? endif; ?>
               <? if($accessLevel >= EDITOR):?>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Blog/All') ? 'active':'';?>">
                     <a href="/blog/all-posts"><i class="icon-pencil"></i> All Blog Posts</a>
                  </li>
               </ul>
               <? endif; ?>
            </li>
            

            <li class="<? echo (strpos($this->vars['active'], 'Forum') !== false) ? 'active open':'';?>">
               <a id="dui-forum" href="/forum">
               <i class="icon-comments"></i> 
               <span class="title">DUI Forum</span>
               <? 
                  if($accessLevel == MEMBER){
                     echo (strpos($this->vars['active'], 'Forum') !== false) ? '<span class="selected"></span><span class="arrow open"></span>':'<span class="arrow"></span>';
                  } else {
                     echo (strpos($this->vars['active'], 'Forum') !== false) ? '<span class="selected"></span>':'';
                  }
               ?>
               </a>
               <? if($accessLevel == MEMBER):?>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Forum/My') ? 'active':'';?>">
                     <a href="/forum/my-admin"><i class="icon-pencil"></i> Manage My Forums</a>
                  </li>
               </ul>
               <? endif; ?>
               <? if($accessLevel >= EDITOR):?>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Forum/Admin') ? 'active':'';?>">
                     <a href="/forum/admin"><i class="icon-pencil"></i> Manage Forum</a>
                  </li>
               </ul>
               <? endif; ?>
            </li>
            <? if($accessLevel >= EDITOR):?>
            <li class="<? echo ($this->vars['active'] == 'Category') ? 'active':'';?>">
               <a href="/category">
               <i class="icon-tags"></i> 
               <span class="title">Categories & Tags</span>
               <? echo ($this->vars['active'] == 'Category') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <? endif; ?>
            <li class="<? echo ($this->vars['active'] == 'VFL') ? 'active':'';?>">
               <a href="/vfl">
               <i class="icon-legal"></i> 
               <span class="title">Virtual Library</span>
               <? echo ($this->vars['active'] == 'VFL') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Store') ? 'active':'';?>">
               <? if($accessLevel >= EDITOR):?>
               <a href="/product">
               <? else: ?>
               <a href="https://<?=SAW_CONSUMER_WEBSITE?>/store">
               <? endif; ?>
               <i class="icon-shopping-cart"></i> 
               <span class="title">NCDD Store</span>
               <? echo ($this->vars['active'] == 'Store') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Payment') ? 'active':'';?>">
               <a href="/payment">
               <i class="icon-money"></i> 
               <span class="title">Payments</span>
               <? echo ($this->vars['active'] == 'Payment') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <? if($accessLevel == MEMBER):?>
            <li class="<? echo ($this->vars['active'] == 'Card') ? 'active':'';?>">
               <a href="/card">
               <i class="icon-credit-card"></i> 
               <span class="title">Credit Card on File</span>
               <? echo ($this->vars['active'] == 'Card') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <? endif; ?>
         <? endif; ?>
         <? if($accessLevel >= EDITOR):?>
            <li class="<? echo ($this->vars['active'] == 'EmailSent') ? 'active':'';?>">
               <a href="/emailsent">
               <i class="icon-envelope"></i> 
               <span class="title">Emails Sent</span>
               <? echo ($this->vars['active'] == 'EmailSent') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
         <? endif; ?>   
            <li class="">
               <a href="https://<?=SAW_CONSUMER_WEBSITE?>" target="_blank">
               <i class="icon-globe"></i> 
               <span class="title">ncdd.com</span>
               </a>
            </li>
            <li class="">
               <a href="/logout">
               <i class="icon-key"></i> 
               <span class="title">Log Out</span>
               </a>
            </li>
            
            
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>
   <!-- END SIDEBAR -->
   <script>
         jQuery(document).ready(function() {    
            $('#dui-blog').click(function(e){
               e.preventDefault();
               document.location.href="/blog";
            });
            $('#dui-forum').click(function(e){
               e.preventDefault();
               document.location.href="/forum";
            });
            $('#seminar').click(function(e){
               e.preventDefault();
               document.location.href="/seminar";
            });
         });
   </script>

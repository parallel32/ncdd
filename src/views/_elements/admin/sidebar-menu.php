   <!-- BEGIN SIDEBAR -->
      <div class="page-sidebar nav-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->         
         <ul class="page-sidebar-menu">
            <li>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
               <div class="sidebar-toggler hidden-phone"></div>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
               <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
               <form class="sidebar-search">
                  <div class="input-box">
                     <a href="javascript:;" class="remove"></a>
                     <input type="text" placeholder="Member Search.." />            
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
            <li class="<? echo ($this->vars['active'] == 'Clients') ? 'active':'';?>">
               <a href="/page">
               <i class="icon-copy"></i> 
               <span class="title">Website Pages</span>
               <? echo ($this->vars['active'] == 'Clients') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/store">
               <i class="icon-shopping-cart"></i> 
               <span class="title">NCDD Store</span>
               <? echo ($this->vars['active'] == 'Modules') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Application') ? 'active':'';?>">
               <a href="/applications">
               <i class="icon-copy"></i> 
               <span class="title">Applictions</span>
               <? echo ($this->vars['active'] == 'Application') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Payment') ? 'active':'';?>">
               <a href="/payment">
               <i class="icon-money"></i> 
               <span class="title">Payments</span>
               <? echo ($this->vars['active'] == 'Payment') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/blog">
               <i class="icon-edit"></i> 
               <span class="title">DUI Blog</span>
               <? echo ($this->vars['active'] == 'Modules') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/contact">
               <i class="icon-envelope"></i> 
               <span class="title">Web Contacts</span>
               <? echo ($this->vars['active'] == 'Modules') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Seminar') ? 'active':'';?>">
               <a href="/seminar">
               <i class="icon-facetime-video"></i> 
               <span class="title">Sessions &amp; Seminars</span>
               <? echo ($this->vars['active'] == 'Seminar') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo (strpos($this->vars['active'], 'Members') !== false) ? 'active open':'';?>">
               <a href="javascript:;">
               <i class="icon-group"></i> 
               <span class="title">Members</span>
               <? echo ($this->vars['active'] == 'Members') ? '<span class="selected"></span><span class="arrow open"></span>':'<span class="arrow"></span>';?>
               </a>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Members/edit') ? 'active':'';?>">
                     <a href="/member/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>/edit"><i class="icon-pencil"></i> Edit My Profile</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/phpinfo') ? 'active':'';?>">
                     <a href="/utilities/phpinfo"><i class="icon-search"></i> Search Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Founding Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Regents and Fellows</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Sate Delegates</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Members/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-briefcase"></i> Membership Forms</a>
                  </li>
               </ul>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/forum">
               <i class="icon-comments"></i> 
               <span class="title">DUI Forum</span>
               <? echo ($this->vars['active'] == 'Modules') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/vfl">
               <i class="icon-legal"></i> 
               <span class="title">Virtual Library</span>
               <? echo ($this->vars['active'] == 'Modules') ? '<span class="selected"></span>':'';?>
               </a>
            </li>
            
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>
   <!-- END SIDEBAR -->
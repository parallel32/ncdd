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
               <span class="selected"></span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Clients') ? 'active':'';?>">
               <a href="/page">
               <i class="icon-copy"></i> 
               <span class="title">Website Pages</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/store">
               <i class="icon-shopping-cart"></i> 
               <span class="title">NCDD Store</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/album">
               <i class="icon-picture"></i> 
               <span class="title">Photo Gallery</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/blog">
               <i class="icon-edit"></i> 
               <span class="title">DUI Blog</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/contact">
               <i class="icon-envelope"></i> 
               <span class="title">Web Contacts</span>
               </a>
            </li>
            <li class="<? echo (strpos($this->vars['active'], 'Utilities') !== false) ? 'active':'';?>">
               <a href="javascript:;">
               <i class="icon-group"></i> 
               <span class="title">Members</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/utilities/phpinfo"><i class="icon-search"></i> Search Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Founding Members</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Regents and Fellows</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-user"></i> Sate Delegates</a>
                  </li>
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/"><i class="icon-briefcase"></i> Membership Forms</a>
                  </li>
               </ul>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/forum">
               <i class="icon-comments"></i> 
               <span class="title">DUI Forum</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/vfl">
               <i class="icon-legal"></i> 
               <span class="title">Virtual Library</span>
               </a>
            </li>
            
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>
   <!-- END SIDEBAR -->
<!-- BEGIN SIDEBAR MENU -->         
         <ul>
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
                     <input type="text" placeholder="Find People.." />            
                     <input type="button" class="submit" value=" " />
                  </div>
               </form>
               <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="start <? echo ($this->vars['active'] == 'Dashboard') ? 'active':'';?>">
               <a href="/">
               <i class="icon-home"></i> 
               <span class="title">Dashboard</span>
               <span class="selected"></span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Clients') ? 'active':'';?>">
               <a href="/clients">
               <i class="icon-user"></i> 
               <span class="title">Clients</span>
               </a>
            </li>
            <li class="<? echo ($this->vars['active'] == 'Modules') ? 'active':'';?>">
               <a href="/modules/available">
               <i class="icon-th"></i> 
               <span class="title">Modules</span>
               </a>
            </li>
            <li class="<? echo (strpos($this->vars['active'], 'Utilities') !== false) ? 'active':'';?>">
               <a href="javascript:;">
               <i class="icon-cogs"></i> 
               <span class="title">Utiliies</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li class="<? echo ($this->vars['active'] == 'Utilities/phpinfo') ? 'active':'';?>">
                     <a href="/utilities/phpinfo">phpinfo</a>
                  </li>
                  <li class="">
                     <a href="/">General</a>
                  </li>
                  <li class="">
                     <a href="/">General</a>
                  </li>
               </ul>
            </li>
         </ul>
         <!-- END SIDEBAR MENU -->
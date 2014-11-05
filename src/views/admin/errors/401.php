   <div class="row-fluid">
      <div class="span12 page-404">
         <div class="number">
            401
         </div>
         <div class="details">
            <h3>Unauthorized due to no valid session or no valid permissions</h3>
               <p><?=$this->vars['error']->message?><br>
               resolve message: <?=$this->vars['error']->resolveMessage?><br>                           
               resolve action: <?=$this->vars['error']->resolveAction?><br />
               <a href="/">Return home</a> or try the search bar below.
            </p>
            <!--<form action="#">
               <div class="input-append">                      
                  <input class="m-wrap" size="16" type="text" placeholder="keyword..." />
                  <button class="btn blue">Search</button>
               </div>
            </form>-->
         </div>
      </div>
   </div>

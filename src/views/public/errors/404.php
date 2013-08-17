   <div class="row-fluid">
      <div class="span12 page-404">
         <div class="number">
            404
         </div>
         <div class="details">
            <h3><?=$this->vars['error']->message?></h3>
            <p><?=$this->vars['error']->resolveMessage?><br>                           
               <a href="/">Return home?</a>
            </p>
         </div>
      </div>
   </div>
			<div class="row-fluid">
               <div class="span12">
                  <div class="row-fluid page-404">
                     <div class="span5 number">
                        410
                     </div>
                     <div class="span7 details">
                        <h3>Gone - We have removed this page.</h3>
                        <p><?=$this->vars['error']->message?><br>
                        	resolve message: <?=$this->vars['error']->resolveMessage?><br>                           
                           resolve action: <?=$this->vars['error']->resolveAction?>
                        </p>
                        <form action="#">
                           <div class="input-append">                      
                              <input class="m-wrap" size="16" type="text" placeholder="keyword..." />
                              <button class="btn blue">Search</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

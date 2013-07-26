                    
                    <div class="row-fluid contact">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                                <h3 class="stroke"><?=$this->vars['page']['headline']?></h3>
                                <h3 class="insetShadow"><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        <div class="contactContent">
                            <p>Feel free to submit any inquiries directly through this form.</p>
                            <form id="saw-form" class="pull-left span6">
                                <div class="alert alert-error hide">
                                  
                                </div>   
                                <input type="text" name="doc[name]" placeholder="Your Name" class="span12">
                                <input type="text" name="doc[email]" placeholder="Your E-mail" class="span12">
                                <textarea  name="doc[message]" cols="30" rows="10" placeholder="Message" class="span12"></textarea>
                                <input type="button" class="btn pull-right" value="Send">
                            </form>
                            <div class="address pull-right span6">
                                <address><p><?=$this->vars['page']['body']?></p></address>
                                <ul class="socialNetwork inline">
                                    <li class="socialNetworkItem"><a href="http://www.twitter.com/NCDDNews" target="_blank" class="socialNetworkLink twitter"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                            $('#saw-form .btn').click(function(e){
                                $.post(
                                    '/contact'
                                    ,$('#saw-form :input').serialize()
                                    ,"json"
                                )
                                .done(function(response){
                                    $('.alert').removeClass('hide').removeClass('alert-error').addClass('alert-success').html(response.message);
                                })
                                .fail(function(response){
                                    $('.alert').removeClass('hide').html(response.responseJSON.message);
                                })
                                .always(function(response){
                                    
                                });
                            });
                            
                        }); 
                    </script>
                    
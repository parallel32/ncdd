                    <div class="row-fluid search" style="padding-top:30px;">
                        <div class="obliqueLineTitle text-center"><h2>Search Results</h2></div>
                        <form id="search-form" class="form-horizontal">
                        <div class="span10 pull-left">
                                 <input id="search-query-inline" type="text" class="m-wrap span10" value="<?=(!empty($this->vars) && array_key_exists('query', $this->vars) ) ? $this->vars['query']: '';?>">
                                 <input id="search-button-inline" type="button" class="checkoutBtn" value="Search Again">
                           
                        </div>
                        <!--/span-->
                        </form>
                        <h3 class="subtitle text-center"><strong><?=count($this->vars['results'])?><strong> <?=(count($this->vars['results']) == 1) ? 'match' : 'matches'?></h3>
                        <ul class="searchResultList">
                            <? foreach ($this->vars['results'] as $result): ?>
                            <?=$result['html']?>
                            <? endforeach; ?>                            
                        </ul>

                        <? if(false): ?>
                        <!--
                        <div class="pagination text-center">
                            <ul>
                                <li><a href="#">Previous</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="active"><a href="#">3</a></li>
                                <li><a href="#">Next</a></li>
                          </ul>
                        </div>
                        -->
                        <? endif; ?>

                    </div>
                    <script>
                    jQuery(document).ready(function() {    

                        $('#search-button-inline').click(function(e) {
                            e.preventDefault();
                            document.location.href='/search?q='+$('#search-query-inline').val();
                        });
                        $('#search-query-inline').keypress(function (e) {
                            if (e.which == 13) {
                                e.preventDefault();
                                document.location.href='/search?q='+$(this).val();     
                            }
                        });
                    });      
                    </script>

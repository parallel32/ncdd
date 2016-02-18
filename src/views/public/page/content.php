                    <div class="row-fluid becomeAmember">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=(is_array($this->vars['page']) && !empty($this->vars['page']) && array_key_exists('headline', $this->vars['page'])) ? $this->vars['page']['headline'] : ''?></h3>
                            </div>
                        </div>
                        <div class="becomeAmemberContent">
                            <?=$this->vars['page']['body']?>
                        </div>
                    </div>
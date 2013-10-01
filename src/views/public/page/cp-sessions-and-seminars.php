                                        <div class="text">
                                            <div class="title text-center" style="padding-top:45px">
                                                <h2>SESSIONS &amp; SEMINARS</h2>
                                            </div>
                                            <ul class="thumbnails row-fluid">
                                                <? foreach ($this->vars['seminars'] as $seminar): ?>
                                                <li class="span4">
                                                    <div class="thumbnail" style="background:#fff">
                                                        <? if(!empty($seminar['image'])){?>
                                                        <img src="<?=$seminar['image']['urls']['small']['CDN'] ?>" alt="">
                                                        <? } ?>
                                                        <div class="caption">
                                                            <h4 class="text-center"><a href="#"><?=$seminar['headline']?></a></h4>
                                                            <p class="data text-center"><?=$seminar['startDate']['monthDay']?> - <?=$seminar['endDate']['monthDay']?>, <?=$seminar['startDate']['year']?></p>
                                                            <p class="descr text-center"><?=$seminar['description']?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <? endforeach; ?>
                                            </ul>
                                            <div class="text-center">
                                                <!-- <a href="/seminars" class="btn">All Seminars</a> -->
                                            </div>
                                        </div>
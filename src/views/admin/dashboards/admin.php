      <!-- BEGIN PAGE -->
      <div class="page-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <?=$this->element('page-title-and-bread-crumb');?>
               </div>
            </div>
            <!-- END PAGE HEADER-->
                  <div id="dashboard">

               <!-- BEGIN DASHBOARD STATS -->
               <div class="row-fluid">
                  <div class="span6 responsive" data-tablet="span6" data-desktop="span6">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-barcode"></i>
                        </div>
                        <div class="details">
                           <div class="number"><?=$this->vars['newOrders']?></div>
                           <div class="desc">New Orders</div>
                        </div>
                        <a class="more" href="/product/">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span6 responsive" data-tablet="span6" data-desktop="span6">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-edit"></i>
                        </div>
                        <div class="details">
                           <div class="number"><?=$this->vars['blogs']?></div>
                           <div class="desc">Blogs to Approve</div>
                        </div>
                        <a class="more" href="/blog/all-posts">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
               </div>
               <!-- END DASHBOARD STATS -->
               <div class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN CHART PORTLET-->
                     <div class="portlet box blue">
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="icon-bar-chart font-green-haze"></i>
                              <span class="">New Members by Month</span>
                           </div>
                           <div class="tools">
                              Running total = <?=$this->vars['graph_total']?>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div id="chart_3" class="chart" style="height: 400px; overflow: hidden; text-align: left;"></div>
                        </div>
                     </div>
                     <!-- END CHART PORTLET-->
                  </div>
               </div>

               <h1>Members</h1>
               <!-- BEGIN DASHBOARD STATS -->
               <div class="row-fluid">
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['sm']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Sustaining Members</div>
                        </div>
                        <a class="more" href="/member/search?query=Sustaining%20Members">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['gm']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">General M's</div>
                        </div>
                        <a class="more" href="/member/search?query=Sustaining%20Members">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['fm']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Founding Members</div>
                        </div>
                        <a class="more" href="/member/search?query=Founding%20Members">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['pd']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Public Defenders</div>
                        </div>
                        <a class="more" href="/member/search?query=Public%20Defenders">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['r']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Regents</div>
                        </div>
                        <a class="more" href="/member/search?query=Regents">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['f']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Fellows</div>
                        </div>
                        <a class="more" href="/member/search?query=Fellows">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['sd']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">State Delegates</div>
                        </div>
                        <a class="more" href="/member/search?query=State%20Delegates">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['fa']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Faculty</div>
                        </div>
                        <a class="more" href="/member/search?query=Faculty">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['bc']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Board Certified</div>
                        </div>
                        <a class="more" href="/member/search?query=Board%20Certified">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['st']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Staff</div>
                        </div>
                        <a class="more" href="/member/search?query=Staff">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['fr']?></i>
                        </div>
                        <div class="details">
                           <div class="number"></div>
                           <div class="desc">Former Regents</div>
                        </div>
                        <a class="more" href="/member/search?query=Former%20Regents">
                        View <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  
               </div>
               <!-- END DASHBOARD STATS -->

               








            <h1>New Applications</h1>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['approved'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Unpaid</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications#unpaid"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="approve"></a>
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['paid'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Paid (90 days)</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications/all"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['ncdd2014promocode'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>NCDD2014 Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications#ncdd2014"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="approve"></a>
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['ncddtrialpromocode'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>TRIAL Promo</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications#trial"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>
            
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=$this->vars['newlypaid'];?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Paid w/o Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications#paidwopromo"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hide-me"><span class="number"><?=$this->vars['trial'];?></span></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Trial Mode</font></div>
                        <div class="desc"><font><font></font></font></div>
                     </div>
                     <a class="more" href="/applications#trial"><font><font>
                     Go </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>
               











               <!-- PRIVATE PAGES (RECENT) -->
               <div class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box blue">
                        <div class="portlet-title" id="page">
                           <div class="caption"><i class="icon-copy"></i>Private Pages (most recent)</div>
                           <div class="actions">
                              <a id="page-view-all" class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="pages" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class="">Headline</th>
                                    <th class="">Published</th>
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['pages'])): foreach($this->vars['pages'] as $page): ?>
                                 <tr class="gradeX odd">
                                    <td class=" "><?=$page['headline']?></td>
                                    <td class=" "><?=date('F j, Y',$page['_id']->getTimestamp())?></td>
                                    <td class=" "><a data-id="<?=$page['slug']?>" class="btn blue mini view"><i class=" "></i> View</a></td>
                                 </tr>
                                 <? endforeach;?>
                                 <? else: ?>
                                    <td colspan="5">No pages at the moment.</td>
                                 <? endif;?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <div class="clearfix"></div>
               <!--/ PRIVATE PAGES (RECENT) -->

               <?=$this->element('twitter-feed.html')?>


            </div>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Dashboard.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Dashboard.adminInit();
   AmCharts.makeChart("chart_3", {
            "type": "serial",
            "theme": "light",

            "fontFamily": 'Open Sans',            
            "color":    '#888888',
            
            "pathToImages": "/assets/plugins/amcharts/amcharts/images/",

            "dataProvider": [
            <? 
               $json = '';
               foreach ($this->vars['graph']['result'] as $member) {
                  $month = (strlen($member['_id']['month']) > 1) ? $member['_id']['month'] : '0'.$member['_id']['month'];
                  $json.= '{"date":"'.$member['_id']['year'].'-'.$month.'-01","signups":'.$member['count'].'},';
               }
               echo $json;
            ?>
            ],
            "balloon": {
                "cornerRadius": 6
            },
            "valueAxes": [{
               "axisAlpha": 0,
               "inside": true,
               "position": "left",
               "ignoreAxisWidth": true,
               "title":"New Members"
            }],
            "graphs": [{
                "bullet": "square",
                "bulletBorderAlpha": 1,
                "bulletBorderThickness": 1,
                "fillAlphas": 0.3,
                "fillColorsField": "lineColor",
                "legendValueText": "[[value]]",
                "lineColorField": "lineColor",
                "title": "signups",
                "valueField": "signups"
            }],
            "chartScrollbar": {},
            "chartCursor": {
                "categoryBalloonDateFormat": "YYYY MMM DD",
                "cursorAlpha": 0,
                "zoomable": false
            },
            "dataDateFormat": "YYYY-MM-DD",
            "categoryField": "date",
            "categoryAxis": {
        "minPeriod": "mm",
        "parseDates": true
    }
        });
});
</script>
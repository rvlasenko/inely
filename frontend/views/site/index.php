<div class="main-content">
<div class="topbar">

    <?php $this->beginContent('@app/views/templates/topbar.php'); $this->endContent(); ?>

</div>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content page-thin">
<div class="row">
    <div class="col-xlg-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
        <div class="panel">
            <div class="panel-content widget-info">
                <div class="row">
                    <div class="left">
                        <i class="fa fa-twitter bg-green"></i>
                    </div>
                    <div class="right">
                        <p class="number countup" data-from="0" data-to="52000">52,000</p>
                        <p class="text">New robots</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xlg-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
        <div class="panel">
            <div class="panel-content widget-info">
                <div class="row">
                    <div class="left">
                        <i class="fa fa-bug bg-blue"></i>
                    </div>
                    <div class="right">
                        <p class="number countup" data-from="0" data-to="575" data-suffix="k">575k</p>
                        <p class="text">Bugs Intruded</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xlg-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
        <div class="panel">
            <div class="panel-content widget-info">
                <div class="row">
                    <div class="left">
                        <i class="fa fa-fire-extinguisher bg-red"></i>
                    </div>
                    <div class="right">
                        <p class="number countup" data-from="0" data-to="463" data-suffix="k">463k</p>
                        <p class="text">Extinguishers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xlg-3 col-lg-3 col-md-3 col-sm-3 col-xs-6">
        <div class="panel">
            <div class="panel-content widget-info">
                <div class="row">
                    <div class="left">
                        <i class="icon-microphone bg-purple"></i>
                    </div>
                    <div class="right">
                        <p class="number countup" data-from="0" data-to="1210">1,210</p>
                        <p class="text">Left to exit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xlg-6 col-lg-5">
        <div class="panel widget-map">
            <div id="calendar"></div>
        </div>
    </div>
    <div class="col-xlg-4 col-sm-6 col-lg-4">
        <?php $this->beginContent('@app/views/templates/todo.php'); $this->endContent(); ?>
    </div>
    <div class="col-xlg-2 col-sm-6 col-lg-3 hidden-xs">
        <div class="row">
            <div class="col-md-12">
                <ul class="jquery-clock medium" data-jquery-clock="">
                    <li class="jquery-clock-pin"></li>
                    <li class="jquery-clock-sec"></li>
                    <li class="jquery-clock-noty">
                        <div class="tooltipp tooltip-west">
                            <span class="tooltip-item"></span>
                        </div>
                    </li>
                    <li class="jquery-clock-min"></li>
                    <li class="jquery-clock-hour"></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="widget-progress-bar">
                    <div class="clearfix">
                        <div class="title">Profil Complete</div>
                        <div class="number">82%</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary stat1" data-transitiongoal="82"></div>
                    </div>
                    <div class="clearfix">
                        <div class="title">Answer Emails</div>
                        <div class="number">43%</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary stat2" data-transitiongoal="43"></div>
                    </div>
                    <div class="clearfix">
                        <div class="title">Server availability</div>
                        <div class="number">93%</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary stat3" data-transitiongoal="93"></div>
                    </div>
                    <div class="clearfix">
                        <div class="title">CPU Usage</div>
                        <div class="number">76%</div>
                    </div>
                    <div class="progress m-b-0">
                        <div class="progress-bar progress-bar-primary stat4" data-transitiongoal="76"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xlg-6 col-lg-6 col-sm-6">
        <div class="panel widget-map">

        </div>
    </div>
    <div class="col-xlg-6 col-lg-6">
        <div class="panel panel-white">

        </div>
    </div>
</div>
<div class="row">
<div class="col-lg-4 col-sm-6 portlets ui-sortable">
    <div class="panel-content p-t-0 p-b-0 widget-news">
        <?php $this->beginContent('@app/views/templates/weather.php'); $this->endContent(); ?>
    </div>
</div>
    <div class="col-lg-4 col-sm-6 portlets ui-sortable">
        <div class="panel m-t-0" style="position: relative; opacity: 1; z-index: 0;">
            <div class="panel-header panel-controls">
                <h3>
                    <i class="icon-basket"></i>
                    <strong>News</strong> for you
                </h3>
            </div>
            <div class="panel-content p-t-0 p-b-0 widget-news">
                <div class="withScroll _mCS_23 _mCS_7 _mCS_21 mCustomScrollbar _mCS_31" data-height="400"
                     style="height: 400px;">
                    <div class="mCustomScrollBox mCS-light" id="mCSB_31"
                         style="position:relative; height:100%; overflow:hidden; max-width:100%;">
                        <div class="mCSB_container" style="position: relative; top: 0px;">
                            <a href="#" class="message-item media">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="pull-left p-r-10">
                                            <img src="http://www.nose2tail.co.uk/cat-matlock-derbyshire.jpg" style="width: 90px;">
                                        </div>
                                        <div>
                                            <small class="pull-right">28 Feb</small>
                                            <h4 class="c-dark">Reset your account password</h4>
                                            <p class="f-14 c-gray">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="message-item media">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="pull-left p-r-10"><img
                                                src="http://www.nose2tail.co.uk/cat-matlock-derbyshire.jpg"
                                                style="width: 90px;"></div>
                                        <div>
                                            <small class="pull-right">28 Feb</small>
                                            <h4 class="c-dark">Reset your account password</h4>

                                            <p class="f-14 c-gray">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                elit.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="message-item media">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="pull-left p-r-10"><img
                                                src="http://www.nose2tail.co.uk/cat-matlock-derbyshire.jpg"
                                                style="width: 90px;"></div>
                                        <div>
                                            <small class="pull-right">28 Feb</small>
                                            <h4 class="c-dark">Reset your account password</h4>

                                            <p class="f-14 c-gray">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                elit.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="message-item media">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="pull-left p-r-10"><img
                                                src="http://www.nose2tail.co.uk/cat-matlock-derbyshire.jpg"
                                                style="width: 90px;"></div>
                                        <div>
                                            <small class="pull-right">27 Feb</small>
                                            <h4 class="c-dark">Check Dropbox</h4>

                                            <p class="f-14 c-gray">Hello Steve, I have added new files in your Dropbox
                                                in order to show you how to...</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="message-item media">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="pull-left p-r-10"><img
                                                src="http://www.nose2tail.co.uk/cat-matlock-derbyshire.jpg"
                                                style="width: 90px;"></div>
                                        <div>
                                            <small class="pull-right">25 Feb</small>
                                            <h4 class="c-dark">Appointment at 8pm today</h4>

                                            <p class="f-14 c-gray">Hello Steve, I have added new files in your Dropbox
                                                in order to show you how to...</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="mCSB_scrollTools" style="position: absolute; display: block; opacity: 0;">
                            <div class="mCSB_draggerContainer">
                                <div class="mCSB_dragger" style="position: absolute; height: 368px; top: 0px;"
                                     oncontextmenu="return false;">
                                    <div class="mCSB_dragger_bar" style="position: relative; line-height: 368px;"></div>
                                </div>
                                <div class="mCSB_draggerRail"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 portlets">
        <div class="panel m-t-0">
            <div class="panel-header panel-controls">
                <h3>
                    <i class="icon-basket"></i>
                    <strong>Something</strong> is...
                </h3>
            </div>
            <div class="panel-content p-t-0 p-b-0">
                <div id="bar-chart"></div>
            </div>
        </div>
        <div class="panel m-t-0">
            <div class="panel-header panel-controls">
                <h3><i class="icon-basket"></i> <strong>Sales</strong> Volume Stats</h3>
            </div>
            <div class="panel-content p-t-0 p-b-0">
                <div id="bar-chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="copyright">
        <p class="pull-left sm-pull-reset">
            <span>Copyright <span class="copyright">©</span> 2015 </span>
            <span>THEMES LAB</span>.
            <span>All rights reserved. </span>
        </p>

        <p class="pull-right sm-pull-reset">
            <span>
                <a href="#" class="m-r-10">Support</a> |
                <a href="#" class="m-l-10 m-r-10">Terms of use</a> |
                <a href="#" class="m-l-10">Privacy Policy</a>
            </span>
        </p>
    </div>
</div>
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END MAIN CONTENT -->
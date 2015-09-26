<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

\backend\assets\DashboardAsset::register($this);

$main = "$('ul.panel-tabs li:nth-child(1)').addClass('active')";
$this->registerJs($main, $this::POS_END);

?>

<!-- Admin-panels -->
<div class="admin-panels fade-onload sb-l-o-full">

    <!-- full width widgets -->
    <div class="row">

        <!-- Three panes -->
        <div class="col-md-12 admin-grid">
            <div class="panel sort-disable" id="p0">
                <div class="panel-heading">
                    <span class="panel-title">Data Panel Widget</span>
                </div>
                <div class="panel-body mnw700 of-a">
                    <div class="row">

                        <!-- Chart Column -->
                        <div class="col-md-5 pln mvn15">
                            <h5 class="ml5 mbn mt20 ph10 pb5 br-b fw700">Your activity from last 7 days
                                <small class="pull-right fw600"><span class="text-primary">Quick view</span></small>
                            </h5>
                            <div class="ct-chart" style="width: 100%; height: 255px; margin: 0 auto;"></div>
                        </div>

                        <!-- Multi Text Column -->
                        <div class="col-md-4">
                            <h5 class="mt5 mbn ph10 pb5 br-b fw700">Your Status
                                <small class="pull-right fw700 text-primary">Good</small>
                            </h5>
                            <table class="table mbn tc-med-1 tc-bold-last tc-fs13-last">
                                <tbody>
                                <tr>
                                    <td><i class="fa fa-circle text-warning fs8 pr15"></i><span>Coins earned</span></td>
                                    <td>1,926</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-circle text-warning fs8 pr15"></i><span>Experience Points</span>
                                    </td>
                                    <td>1,254</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-circle text-warning fs8 pr15"></i><span>Tasks completed</span>
                                    </td>
                                    <td>783</td>
                                </tr>
                                </tbody>
                            </table>
                            <h5 class="mt15 mbn ph10 pb5 br-b fw700">Inely Status
                                <small class="pull-right fw700 text-primary">Good</small>
                            </h5>
                            <table class="table mbn tc-med-1 tc-bold-last tc-fs13-last">
                                <tbody>
                                <tr>
                                    <td><i class="fa fa-circle text-warning fs8 pr15"></i><span>Happiness</span></td>
                                    <td>50%</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-circle text-warning fs8 pr15"></i><span>Time with you</span>
                                    </td>
                                    <td>1 hour</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tag Column -->
                        <div class="col-md-3">
                            <h5 class="mt5 ph10 mbn pb5 br-b fw700">Most Used Tags</h5>
                            <ul class="list-group mbn">

                                <li class="list-group-item"><span class="badge badge-dark">9</span>Movies</li>
                                <li class="list-group-item"><span class="badge badge-dark">11</span>TV Shows</li>
                                <li class="list-group-item"><span class="badge badge-dark">22</span>Video Games</li>

                            </ul>
<!--                            <h5 class="mt5 ph10 mbn pb5 br-b fw700">Groups Cloud</h5>-->
<!--                            <ul class="list-group mbn">-->
<!---->
<!--                                <li class="list-group-item"><span class="badge badge-info">9</span>Movies</li>-->
<!--                                <li class="list-group-item"><span class="badge badge-info">11</span>TV Shows</li>-->
<!--                                <li class="list-group-item"><span class="badge badge-info">22</span>Video Games</li>-->
<!---->
<!--                            </ul>-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end: .col-md-12.admin-grid -->

        <div class="col-md-6">

            <!-- Calendar Widget -->
            <div class="panel panel-widget calendar-widget" id="43">
                <div class="panel-heading">
                    <span class="panel-icon"><i class="fa fa-pencil"></i></span>
                    <span class="panel-title"> Calendar Widget</span>
                </div>
                <div class="panel-body">
                    <div id="calendar-widget" class="fc fc-ltr fc-unthemed"></div>
                </div>
            </div>

            <!-- Weather -->
            <div class="panel" id="p11">
                <div class="panel-heading"><span class="panel-title">Pie Chart</span></div>
                <div class="panel-menu pn bg-white">
                    <ul class="nav nav-justified text-center fw600 chart-legend">
                        <li><a href="#" class="legend-item" data-chart-id="0">Yahoo</a></li>
                        <li class="br-l"><a href="#" class="legend-item" data-chart-id="1">CNN</a></li>
                        <li class="br-l"><a href="#" class="legend-item" data-chart-id="2">Yahoo</a></li>
                        <li class="br-l"><a href="#" class="legend-item" data-chart-id="3">CNN</a></li>
                    </ul>
                </div>
                <div class="panel-body pnb">
                    <div id="high-pie" style="width: 100%; height: 200px; margin: 0 auto;"></div>
                </div>
                <div class="panel-footer p15">
                    <p class="text-muted text-center mbn">A percent measure of tickets with
                        <b class="text-info">first</b> reply time</p>
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <!-- Task Widget -->
            <div class="panel panel-widget task-widget ui-sortable" id="41">
                <div class="panel-heading cursor">
                    <span class="panel-icon"><i class="fa fa-cog"></i></span>
                    <span class="panel-title">Task-List Widget</span>
                </div>
                <div class="panel-body pn">

                    <ul class="task-list task-current">
                        <li class="task-label">Current Tasks</li>
                        <li class="task-item low ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" id="task3">
                                    <label for="task3"></label>
                                </div>
                            </div>
                            <div class="task-desc">Finish building prototype for Sony</div>
                            <div class="task-menu"></div>
                        </li>
                        <li class="task-item high ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" id="task4">
                                    <label for="task4"></label>
                                </div>
                            </div>
                            <div class="task-desc">Order new building supplies for Microsoft</div>
                            <div class="task-menu"></div>
                        </li>
                        <li class="task-item low ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" id="task5">
                                    <label for="task5"></label>
                                </div>
                            </div>
                            <div class="task-desc">Add new servers to design board</div>
                            <div class="task-menu"></div>
                        </li>
                    </ul>

                    <ul class="task-list task-completed">
                        <li class="task-label">Completed Tasks</li>
                        <li class="task-item medium item-checked ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" checked="" id="task7">
                                    <label for="task7"></label>
                                </div>
                            </div>
                            <div class="task-desc">Finish building prototype for Sony</div>
                            <div class="task-menu"></div>
                        </li>
                        <li class="task-item low item-checked ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" checked="" id="task8">
                                    <label for="task8"></label>
                                </div>
                            </div>
                            <div class="task-desc">Order new building supplies for Microsoft</div>
                            <div class="task-menu"></div>
                        </li>
                        <li class="task-item high item-checked ui-sortable-handle">
                            <div class="task-handle">
                                <div class="checkbox-custom">
                                    <input type="checkbox" checked="" id="task10">
                                    <label for="task10"></label>
                                </div>
                            </div>
                            <div class="task-desc">Order new building supplies for Microsoft</div>
                            <div class="task-menu"></div>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Note editor -->
            <div class="panel panel-widget compose-widget">
                <div class="panel-heading">
                    <span class="panel-icon"><i class="fa fa-pencil"></i></span>
                    <span class="panel-title">Note editor</span>
                </div>
                <div class="panel-body">
                    <div class="summernote">Coming <b>Soon...</b></div>
                </div>
            </div>

        </div>

    </div>
    <!-- end: .row -->

</div>
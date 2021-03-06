<!-- new widget -->
<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false">

    <!-- widget options:
    usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

    data-widget-colorbutton="false"
    data-widget-editbutton="false"
    data-widget-togglebutton="false"
    data-widget-deletebutton="false"
    data-widget-fullscreenbutton="false"
    data-widget-custombutton="false"
    data-widget-collapsed="true"
    data-widget-sortable="false"

    -->

    <header>
        <span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
        <h2>Birds Eye</h2>
        <div class="widget-toolbar hidden-mobile">
            <span class="onoffswitch-title"><i class="fa fa-location-arrow"></i> Realtime</span>
            <span class="onoffswitch">
											<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" checked="checked" id="myonoffswitch">
											<label class="onoffswitch-label" for="myonoffswitch"> <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> <span class="onoffswitch-switch"></span> </label> </span>
        </div>
    </header>

    <!-- widget div-->
    <div>
        <!-- widget edit box -->
        <div class="jarviswidget-editbox">
            <div>
                <label>Title:</label>
                <input type="text" />
            </div>
        </div>
        <!-- end widget edit box -->

        <div class="widget-body no-padding">
            <!-- content goes here -->

            <div id="vector-map" class="vector-map"></div>
            <div id="heat-fill">
                <span class="fill-a">0</span>

                <span class="fill-b">5,000</span>
            </div>

            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Country</th>
                    <th>Visits</th>
                    <th class="text-align-center">User Activity</th>
                    <th class="text-align-center hidden-xs">Online</th>
                    <th class="text-align-center">Demographic</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="javascript:void(0);">USA</a></td>
                    <td>4,977</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            2700, 3631, 2471, 1300, 1877, 2500, 2577, 2700, 3631, 2471, 2000, 2100, 3000
                        </div></td>
                    <td class="text-align-center hidden-xs">143</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            17,83
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);">Australia</a></td>
                    <td>4,873</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            1000, 1100, 3030, 1300, -1877, -2500, -2577, -2700, 3631, 2471, 4700, 1631, 2471
                        </div></td>
                    <td class="text-align-center hidden-xs">247</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            22,88
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);">India</a></td>
                    <td>3,671</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            3631, 1471, 2400, 3631, 471, 1300, 1177, 2500, 2577, 3000, 4100, 3000, 7700
                        </div></td>
                    <td class="text-align-center hidden-xs">373</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            10,90
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);">Brazil</a></td>
                    <td>2,476</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            2700, 1877, 2500, 2577, 2000, 3631, 2471, -2700, -3631, 2471, 1300, 2100, 3000,
                        </div></td>
                    <td class="text-align-center hidden-xs ">741</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            34,66
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);">Turkey</a></td>
                    <td>1,476</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            1300, 1877, 2500, 2577, 2000, 2100, 3000, -2471, -2700, -3631, -2471, 2700, 3631
                        </div></td>
                    <td class="text-align-center hidden-xs">123</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            75,25
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0);">Canada</a></td>
                    <td>146</td>
                    <td class="text-align-center">
                        <div class="sparkline txt-color-orange text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
                            5, 34, 10, 1, 4, 6, -9, -1, 0, 0, 5, 6, 7
                        </div></td>
                    <td class="text-align-center hidden-xs">23</td>
                    <td class="text-align-center">
                        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
                            50,50
                        </div>
                        <div class="btn-group display-inline pull-right text-align-left hidden-tablet">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-xs pull-right">
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-file fa-lg fa-fw txt-color-greenLight"></i> <u>P</u>DF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><i class="fa fa-times fa-lg fa-fw txt-color-red"></i> <u>D</u>elete</a>
                                </li>
                                <li class="divider"></li>
                                <li class="text-align-center">
                                    <a href="javascript:void(0);">Cancel</a>
                                </li>
                            </ul>
                        </div></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan=5>
                        <ul class="pagination pagination-xs no-margin">
                            <li class="prev disabled">
                                <a href="javascript:void(0);">Previous</a>
                            </li>
                            <li class="active">
                                <a href="javascript:void(0);">1</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">2</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">3</a>
                            </li>
                            <li class="next">
                                <a href="javascript:void(0);">Next</a>
                            </li>
                        </ul></td>
                </tr>
                </tfoot>
            </table>

            <!-- end content -->

        </div>

    </div>
    <!-- end widget div -->
</div>
<!-- end widget -->
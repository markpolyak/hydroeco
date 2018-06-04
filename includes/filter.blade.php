<div id="page-wrapper" class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Данные по акваториям и станциям</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Фильтрация</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id="reportrange" class="form-control">
                                                <i class="fa fa-calendar"></i>
                                                <span></span> <b class="caret"></b>
                                            </div>

                                            <a href="#" id="allTime">За всё время</a>
                                            <a href="#" id="get-calendar-field" style="margin-left: 10px;"></a>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <select class="selectArea form-control" multiple="multiple">
                                            </select>

                                            <a href="#" id="selectAquatories">Выбрать все</a>&nbsp;&nbsp;&nbsp;
                                            <a href="#" id="clearAquatories">Очистить</a>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="selectStation form-control" multiple="multiple">
                                            </select>
                                            <a href="#" id="selectStations">Выбрать все</a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" id="clearStations">Очистить</a>
                                            <!-- <a href="#" id="mapStations" style="margin-left: 10px;">Отметить на карте</a> -->
                                            <a href="#" id="mapStations-ajax" style="margin-left: 10px;">Отметить на карте</a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox-content">
                                <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Поиск по результатам">

                                <table class="footable table table-stripped samples" data-page-size="25" data-filter=#filter>
                                    <thead>
                                    <tr>
                                        <th>Акватория</th>
                                        <th>Ссылка на пигмент</th>
                                        <th>Станция</th>
                                        <th>Дата пробы</th>
                                        <th data-hide="phone,tablet">Номер</th>
                                        <th data-hide="phone,tablet">Комментарий</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="map" style="width: 75%; height: 600px; display: none; margin: auto;"></div>
    <div id="map-diagram" style="width: 75%; height: 600px; display: none; margin: auto; margin-top: 45px;"></div>
    <div class="footer">
        <div>
            <strong>Copyright</strong> 2015
        </div>
    </div>


</div>
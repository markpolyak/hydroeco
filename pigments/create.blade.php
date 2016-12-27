@extends('app')
@section('content')

<?php
$cnn = pg_connect("host=pg.sweb.ru port=5432 dbname=mpolyakru_hbio user=mpolyakru_hbio password=test1234") or die("Connection Error");
?>


    <div id="page-wrapper" class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Добавление данных</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Новая проба</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label>Акватория</label>
                                                    <select class="selectArea form-control"></select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Станция</label>
                                                    <select class="selectStation form-control"></select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-normal">Дата отборы пробы</label>
                                                    <div class="input-group date date-sample">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" data-date-format="MM/DD/YYYY" class="form-control" value="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Порядковый номер</label>
                                                    <input type="text" placeholder="Порядковый номер" class="form-control comment-sample">
                                                </div>

                                                <div class="form-group">
                                                    <label>Комментарий</label>
                                                    <textarea style="resize: vertical;" placeholder="Комментарий" class="form-control serial-sample"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Добавление данных по пигментам</label>
                                                    <input id="pigmentInterface" type="checkbox">
                                                </div>

                                                <div>
                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs addsample" type="submit"><strong>Добавить</strong></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>



                                </div>


                            </div>

                            <div class="col-lg-5" id="pgInterface">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Данные о пигменте</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label >Тропическая характеризация воды</label>
                                                    <?php
                                                    $query = pg_query($cnn, "SELECT * FROM trophic_characterization_of_water");
                                                    ?>
                                                    <select class="IDTrophicCharacterization form-control">
                                                    
                                                    <?php
                                                    while($row = pg_fetch_array($query))
                                                    {
                                                    ?>
                                                        <option value="<?php echo $row['id_trophic_characterization']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label>Данные о горизонте</label>
                                                    <?php
                                                    $query = pg_query($cnn, "SELECT * FROM horizon_levels WHERE name IS NOT NULL");
                                                    ?>
                                                    <select class="IDHorizon form-control">
                                                    <?php
                                                    while($row = pg_fetch_array($query))
                                                    {
                                                    ?>
                                                        <option value="<?php echo $row['id_horizon']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label>Объём профильтрованной воды</label>
                                                    <input type="text" placeholder="VolumeOfFilteredWater" class="VolumeOfFilteredWater form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Концентрация хлорофилла A</label>
                                                    <input type="text" placeholder="ChlorophyllAConcentration" class=" ChlorophyllAConcentration form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Концентрация хлорофилла B</label>
                                                    <input type="text" placeholder="ChlorophyllBConcentration" class="ChlorophyllBConcentration form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Концентрация хлорофилла C</label>
                                                    <input type="text" placeholder="ChlorophyllCConcentration" class="ChlorophyllCConcentration form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Оптическая плотность</label>
                                                    <input type="text" placeholder="A(665K)" class="A form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Пигментный индекс</label>
                                                    <input type="text" placeholder="PigmentIndex" class="PigmentIndex form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Феопигменты</label>
                                                    <input type="text" placeholder="Pheopigments" class="Pheopigments form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Отношение хлорофила A / C</label>
                                                    <input type="text" placeholder="RatioOfChAToChC" class="RatioOfChAToChC form-control" />

                                                </div>

                                                <div class="form-group">

                                                    <label>Комментарий</label>
                                                    <textarea style="resize: vertical;" placeholder="Комментарий" class="PigmentComment form-control" /></textarea>

                                                </div>

                                                <div class="form-group">

                                                    <label>Порядковый номер пробы</label>
                                                    <input type="text" placeholder="Порядковый номер" class="PigmentNumber form-control" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> 2015
            </div>
        </div>

    </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <!-- FooTable -->
    <script src="js/plugins/footable/footable.all.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('#pgInterface').hide();
            var areas = ["","Невская губа","Восточная часть Финского залива (ВЧФЗ)","Курортная зона", "Район захоронения грунтов в Невской губе", "Район захоронения грунтов в ВЧФЗ", "Очистные сооружения на о. Белом", "Северные очистные сооружения"];

            var stations = [{"values":[
                {"key":1,"value":"5"},
                {"key":2,"value":"30"},
                {"key":3,"value":"25"},
                {"key":4,"value":"6"},
                {"key":5,"value":"7"},
                {"key":6,"value":"9"},
                {"key":7,"value":"10"},
                {"key":8,"value":"11"},
                {"key":9,"value":"11а"},
                {"key":10,"value":"14"},
                {"key":11,"value":"14а"},
                {"key":12,"value":"12"},
                {"key":13,"value":"13"},
                {"key":14,"value":"39"},
                {"key":15,"value":"42"},
                {"key":16,"value":"15"},
                {"key":17,"value":"16"},
                {"key":18,"value":"17"},
                {"key":19,"value":"17а"},
                {"key":20,"value":"1"},
                {"key":21,"value":"2"},
                {"key":22,"value":"12а"}]},
                {"values":[
                    {"key":30,"value":"19"},
                    {"key":31,"value":"20"},
                    {"key":32,"value":"21"},
                    {"key":33,"value":"22"},
                    {"key":34,"value":"24"},
                    {"key":35,"value":"26"},
                    {"key":36,"value":"21(K2"},
                    {"key":37,"value":"23"},
                    {"key":38,"value":"1"},
                    {"key":39,"value":"2"},
                    {"key":40,"value":"3"},
                    {"key":41,"value":"4"},
                    {"key":42,"value":"А"},
                    {"key":43,"value":"14"},
                    {"key":44,"value":"13"},
                    {"key":45,"value":"12"},
                    {"key":46,"value":"11"},
                    {"key":47,"value":"18л"},
                    {"key":48,"value":"6л"},
                    {"key":49,"value":"6к"},
                    {"key":50,"value":"3к"},
                    {"key":72,"value":"25"},
                    {"key":73,"value":"27"},
                    {"key":74,"value":"29"},
                    {"key":75,"value":"28"},    
                ]},
                {"values":[
                    {"key":82,"value":"19к"},
                    {"key":83,"value":"20к"},
                    {"key":84,"value":"К1"},
                    {"key":85,"value":"Г1"},
                    {"key":86,"value":"Г2"},
                ]},
                {"values":[
                    {"key":23,"value":"фоновая 1"},
                    {"key":24,"value":"фоновая 2"},
                    {"key":25,"value":"K5"},
                    {"key":26,"value":"K6"},
                    {"key":27,"value":"K7"},
                    {"key":28,"value":"K8"},
                    {"key":29,"value":"K9"},
                    {"key":57,"value":"ф1"},
                    {"key":58,"value":"Д1"},
                    {"key":59,"value":"Д2"},
                ]},
                {"values":[
                    {"key":51,"value":"К1"},
                    {"key":52,"value":"К2"},
                    {"key":53,"value":"К3"},
                    {"key":54,"value":"К4"},
                    {"key":55,"value":"21(К2)"},
                    {"key":56,"value":"К5"},
                    {"key":76,"value":"ф2"},
                    {"key":77,"value":"ф3"},
                    {"key":78,"value":"Д3"},
                    {"key":79,"value":"Д4"},
                    {"key":80,"value":"Д5"},
                    {"key":81,"value":"Д6"},
                ]},
                {"values":[
                    {"key":60,"value":"б2"},
                    {"key":61,"value":"Б1-I"},
                    {"key":62,"value":"Б1-II"},
                    {"key":63,"value":"Б1-III"},
                    {"key":64,"value":"Б3-II"},
                    {"key":65,"value":"Б3-III"},
                    {"key":87,"value":"Б1'"},
                    {"key":88,"value":"Б3''"},
                    {"key":89,"value":"Б3'''"},
                    ]},
                {"values":[
                    {"key":66,"value":"С1'"},
                    {"key":67,"value":"С2'"},
                    {"key":68,"value":"С3'"},
                    {"key":69,"value":"С1'''"},
                    {"key":70,"value":"С2'''"},
                    {"key":71,"value":"С3'''"},
                    {"key":90,"value":"С2''"},
                    ]},
            ];
            $('.footable').footable();
            $('.footable2').footable();

            $('#pigmentInterface').click(function () {
                if($('#pigmentInterface')[0].checked)
                {
                    $('#pgInterface').slideToggle()
                }
                else
                {
                    $('#pgInterface').slideToggle();
                }
            });


            $.each(areas, function(index, name) {
                $('.selectArea').append($("<option></option>").attr("value", index).text(name));
            });

            $('.selectArea').change(function(){
                var selectedIndex = $(".selectArea")[0].selectedIndex;
                if (selectedIndex <= 0)
                    return;

                $('.selectStation').empty();

                $.each(stations[selectedIndex-1].values, function(stationKey, station){
                    $('.selectStation')
                            .append($("<option></option>")
                                    .attr("value", station.key)
                                    .text(areas[selectedIndex] + ":" + station.value)); });

            });

			$('button.addsample').click(function()
            {
                var goodData = false;
                
                if($('#pigmentInterface')[0].checked)
                {
                    var data = {};
    				var selectedIndex = $('.selectStation').val();
    				data.id_station = selectedIndex;
    				var date = $(".date-sample").datepicker("getDate").toJSON();
    				data.date = date;
    				data.comment = $('.comment-sample').val();
    				data.serial_number = $('.serial-sample').val();
                    
                    data.pigment = $('#pigmentInterface')[0].checked;
                    data.id_trophic_characterization = $('.IDTrophicCharacterization').val();
                    data.id_horizon = $('.IDHorizon').val();
                    data.volume_of_filtered_water = $('.VolumeOfFilteredWater').val().replace(/,/, '.');
                    data.chlorophyll_a_concentration = $('.ChlorophyllAConcentration').val().replace(/,/, '.');
                    data.chlorophyll_b_concentration = $('.ChlorophyllBConcentration').val().replace(/,/, '.');
                    data.chlorophyll_c_concentration	 = $('.ChlorophyllCConcentration').val().replace(/,/, '.');
                    data.pigment_index = $('.PigmentIndex').val().replace(/,/, '.');
                    data.a = $('.A').val().replace(/,/, '.');
                    data.pheopigments = $('.Pheopigments').val().replace(/,/, '.');
                    data.ratio_of_cl_a_to_cl_c = $('.RatioOfChAToChC').val().replace(/,/, '.');
                    data.pigment_comment = $('.PigmentComment').val();
                    data.pigment_serial_number = $('.PigmentNumber').val();
                    
                    /*if(data.comment.length <= 128 && data.serial_number.length <= 32 && data.id_station > 0 && data.date &&  
                    ($.isNumeric(data.volume_of_filtered_water) && data.volume_of_filtered_water.length != 0) && 
                    ($.isNumeric(data.chlorophyll_a_concentration) && data.chlorophyll_a_concentration.length != 0) && 
                    ($.isNumeric(data.chlorophyll_c_concentration) && data.chlorophyll_c_concentration.length != 0) && 
                    ($.isNumeric(data.chlorophyll_c_concentration) && data.chlorophyll_c_concentration.length != 0) && 
                    ($.isNumeric(data.pigment_index) && data.pigment_index.length != 0) && 
                    ($.isNumeric(data.a) && data.a.length != 0) && 
                    ($.isNumeric(data.pheopigments) && data.pheopigments.length != 0) && 
                    ($.isNumeric(data.ratio_of_cl_a_to_cl_c) && data.ratio_of_cl_a_to_cl_c.length != 0) && 
                    ($.isNumeric(data.pigment_serial_number) && data.pigment_serial_number.length != 0) &&
                    data.pigment_comment.length <= 128)
                    {
                        goodData = true;
                    }*/

                    if(data.comment.length <= 128 && data.serial_number.length <= 32 && data.id_station > 0 && data.date &&  
                    ($.isNumeric(data.volume_of_filtered_water) || data.volume_of_filtered_water.length == 0) && 
                    ($.isNumeric(data.chlorophyll_a_concentration) || data.chlorophyll_a_concentration.length == 0) && 
                    ($.isNumeric(data.chlorophyll_c_concentration) || data.chlorophyll_c_concentration.length == 0) && 
                    ($.isNumeric(data.chlorophyll_c_concentration) || data.chlorophyll_c_concentration.length == 0) && 
                    ($.isNumeric(data.pigment_index) || data.pigment_index.length == 0) && 
                    ($.isNumeric(data.a) || data.a.length == 0) && 
                    ($.isNumeric(data.pheopigments) || data.pheopigments.length == 0) && 
                    ($.isNumeric(data.ratio_of_cl_a_to_cl_c) || data.ratio_of_cl_a_to_cl_c.length == 0) && 
                    ($.isNumeric(data.pigment_serial_number) || data.pigment_serial_number.length == 0) &&
                    data.pigment_comment.length <= 128)
                    {
                        goodData = true;
                    }
                                                         
    				var tmp = JSON.stringify(data);
                }
                else
                {
                    var data = {};
    				var selectedIndex = $('.selectStation').val();
    				data.id_station = selectedIndex;
    				var date = $(".date-sample").datepicker("getDate").toJSON();
    				data.date = date;
    				data.comment = $('.comment-sample').val();
    				data.serial_number = $('.serial-sample').val();
                    
                    if(data.comment.length <= 128 && data.serial_number.length <= 32 && data.id_station > 0 && data.date)
                    {
                        goodData = true;
                    }
                    
    				var tmp = JSON.stringify(data);	
                }
                
                if(!goodData)
                {
                    alert("There are some incorrect values");
                }
                else
                {
                    $.ajax({
    					type: "POST",
    					dataType: "json",
    					url: "create.php",
    					data: {'sample':tmp},
    					success: function()
                        {
    						alert('Done!');
    					},
                        error: function(e){
						  alert(e.responseText)
                        }
                    });
                }
				
			});

            $('.date-sample').datepicker({
                todayBtn: "linked",
                keyboardNavigation: true,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

        });



    </script>
@stop

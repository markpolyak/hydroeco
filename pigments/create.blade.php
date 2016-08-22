<?php

$cnn = mysqli_connect('localhost', 'root', '', 'pigments') or die("Connection Error");

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Stations & Samples - Index</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/plugins/select2/select2.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <!-- logo can be here -->
                </li>

                <li>
                    <a href="{{url('/')}}"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Данные по станциям</span></a>
                </li>

                <li>
                    <a href="{{url('/create')}}"><i class="fa fa-edit"></i> <span class="nav-label">Ввод данных</span></a>
                </li>

            </ul>

        </div>
    </nav>

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
                                                    $query = mysqli_query($cnn, "SELECT * FROM trophic_characterization_of_water");
                                                    ?>
                                                    <select class="IDTrophicCharacterization form-control">
                                                    <?php
                                                    while($row = mysqli_fetch_array($query))
                                                    {
                                                    ?>
                                                        <option><?php echo $row['id_trophic_characterization']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label>Данные о горизонте</label>
                                                    <?php
                                                    $query = mysqli_query($cnn, "SELECT * FROM horizon_levels");
                                                    ?>
                                                    <select class="IDHorizon form-control">
                                                    <?php
                                                    while($row = mysqli_fetch_array($query))
                                                    {
                                                    ?>
                                                        <option><?php echo $row['id_horizon']; ?></option>
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
            var areas = ["","Невская губа","Курортная зона","Восточная часть Финского залива (ВЧФЗ)"];

            var stations = [{"values":[
                {"key":1,"value":"5"},
                {"key":2,"value":"1"},
                {"key":3,"value":"2"},
                {"key":4,"value":"30"},
                {"key":5,"value":"25"},
                {"key":6,"value":"6"},
                {"key":7,"value":"7"},
                {"key":8,"value":"9"},
                {"key":9,"value":"10"},
                {"key":10,"value":"11"},
                {"key":13,"value":"12"},
                {"key":14,"value":"13"},
                {"key":15,"value":"39"},
                {"key":16,"value":"14"},
                {"key":18,"value":"42"},
                {"key":19,"value":"15"},
                {"key":20,"value":"16"},
                {"key":21,"value":"17"}]},
                {"values":[
                    {"key":11,"value":"11a"},
                    {"key":12,"value":"12a"},
                    {"key":17,"value":"14a"},
                    {"key":22,"value":"17a"},
                    {"key":23,"value":"19a"},
                    {"key":24,"value":"20a"}
                ]},
                {"values":[
                    {"key":25,"value":"19"},
                    {"key":26,"value":"20"},
                    {"key":27,"value":"21"},
                    {"key":28,"value":"26"},
                    {"key":29,"value":"22"},
                    {"key":30,"value":"24"},
                    {"key":31,"value":"1"},
                    {"key":32,"value":"2"},
                    {"key":33,"value":"3"},
                    {"key":34,"value":"4"},
                    {"key":35,"value":"A"},
                    {"key":36,"value":"3к"},
                    {"key":37,"value":"6к"},
                    {"key":38,"value":"6л"},
                    {"key":39,"value":"18л"}
                ]}
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
                    data.volume_of_filtered_water = $('.VolumeOfFilteredWater').val();
                    data.chlorophyll_a_concentration = $('.ChlorophyllAConcentration').val();
                    data.chlorophyll_b_concentration = $('.ChlorophyllBConcentration').val();
                    data.chlorophyll_c_concentration	 = $('.ChlorophyllCConcentration').val();
                    data.pigment_index = $('.PigmentIndex').val();
                    data.a = $('.A').val();
                    data.pheopigments = $('.Pheopigments').val();
                    data.ratio_of_cl_a_to_cl_c = $('.RatioOfChAToChC').val();
                    data.pigment_comment = $('.PigmentComment').val();
                    data.pigment_serial_number = $('.PigmentNumber').val();
                    
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
    				var tmp = JSON.stringify(data);	
                }
                
				$.ajax({
    					type: "POST",
    					dataType: "json",
    					url: "create.php",
    					data: {'sample':tmp},
    					success: function()
                        {
    						alert('Done!');
    					},
    					error: function()
                        {
    						alert('Some errors');
                        }
                    });
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
</body>
</html>
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

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
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
    </div>

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
        <div class="footer">
            <div>
                <strong>Copyright</strong> 2015
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

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>
    <script src="js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>

        $(document).ready(function()
        {
            var areas = ["Невская губа","Курортная зона","Восточная часть Финского залива (ВЧФЗ)"];

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

            $(".selectArea").select2({
                placeholder: "Акватории",
                allowClear: true
            });
            $(".selectStation").select2({
                placeholder: "Станции",
                allowClear: true
            });

            $('.selectArea').empty();
            var selectedAreas = [];
            var selectedStations = [];
            var startDate = '';
            var endDate = '';

            $.each(areas, function(index, name) {
                $('.selectArea').append($("<option></option>").attr("value", index).text(name));
            });

            $('.selectArea').change(function()
            {
                selectedAreas = [];
                $( ".selectArea option:selected" ).each(function() {
                    selectedAreas.push($( this ).attr('value'));
                });

                $('.selectStation').empty();

                $.each(selectedAreas, function(key, value) {
                    $.each(stations[value].values, function(stationKey, station){
                        $('.selectStation')
                                .append($("<option></option>")
                                        .attr("value", station.key)
                                        .text(areas[value] + ":" + station.value)); })
                });
            });


            $('#selectAquatories').click(function ()
            {
                selectedAreas = [];

                $('.selectArea option').each(function() {
                    selectedAreas.push($( this ).attr('value'));
                });
                $('.selectArea').val(selectedAreas).change();
            });

            $('#selectStations').click(function ()
            {
                selectedStations = [];

                $('.selectStation option').each(function() {
                    selectedStations.push($( this ).attr('value'));
                });
                $('.selectStation').val(selectedStations).change();
            });

            $('#clearAquatories').click(function ()
            {
                selectedAreas = [];
                selectedStations = [];
                $('.selectStation').val(selectedStations).change();
                $('.selectArea').val(selectedStations).change();
                $("table.samples tbody").empty();
            });

            $('#clearStations').click(function ()
            {
                selectedStations = [];
                $('.selectStation').val(selectedStations).change();
                $("table.samples tbody").empty();
            });

            $('#allTime').click(function ()
            {
                $('#reportrange span').html('Jan 01, 2012' + ' - ' + moment().format('MMMM D, YYYY'));
            });

            $('.selectStation').change(function(){
                selectedStations = [];
                $(".selectStation option:selected").each(function(){selectedStations.push($(this).attr("value"));});
                startDate = $('#reportrange').data('daterangepicker').startDate.format("YYYY-MM-DD");
                endDate = $('#reportrange').data('daterangepicker').endDate.format("YYYY-MM-DD");

                var result = selectedStations.join(",");
                if (result != ""){
                    $.ajax({
                        dataType: 'json',
                        url: 'data.php?stations=' + result + '&start='+startDate+'&end='+endDate,
                        success: function(data){
                            $("table.samples tbody").empty();
                            $(data).each(function(index, sample){

                                var areaIndex = -1;
                                var sampleInfo = {};
                                var link = "";
                                $.each(stations, function(i,s)
                                {
                                    $.each(s.values, function(ii, c)
                                    {
                                        if (sample.id_station == c.key)
                                        {
                                            areaIndex = index;
                                            sampleInfo = c;
                                        }
                                    });
                                });
                                
                                if(sample.id_sample != null)
                                {
                                    link = "<a href='pigment/" + sample.id_sample + '?date=' + sample.date + '&id_station=' + sampleInfo.value + "'>Посмотреть пробу</a>";
                                }
                                
                                $("table.samples tbody")
                                        .append($("<tr><td>"
                                                +areas[sample.id_water_area]+"</td><td>"
                                                +link+"</td><td>"
                                                +sampleInfo.value+"</td><td>"
                                                +sample.date+"</td><td>"
                                                +sample.serial_number+"</td><td>"
                                                +sample.comment+"</td></td>"
                                                ));
                            })
                        },
                        error: function(e){
                            alert(e.responseText);
                        }
                    });
                }
            });

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: '01/01/2012',
                endDate: moment().format('MM/DD/YYYY'),
                minDate: '01/01/2012',
                maxDate: moment().format('MM/DD/YYYY'),
                dateLimit: { days: 360 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 дней': [moment().subtract(6, 'days'), moment()],
                    '30 дней': [moment().subtract(29, 'days'), moment()],
                    'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Выбрать',
                    cancelLabel: 'Отмена',
                    fromLabel: 'От',
                    toLabel: 'До',
                    customRangeLabel: 'Выбрать:',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

        });

    </script>
</body>
</html>

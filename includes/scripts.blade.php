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



<!-- Map.js -->

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script>

    // Вместо JSON нужно обрабатывать просто то, что получим самими, через 
    // объекты, скорее всего

    // var phpDataObject = <?php echo $jsonString ?>;
    
</script>

<!-- Page-Level Scripts -->
<script>
    
    var selectedStations = [];
    var selectedAreas = [];
    var startDateCalendar = undefined;
    var endDatecalendar = undefined;
    var mapToggle = true;
    
    

    $(document).ready(function()
    {

        
        $(".selectArea").select2({
            placeholder: "Акватории",
            allowClear: true
        });
        $(".selectStation").select2({
            placeholder: "Станции",
            allowClear: true
        });

        $('.footable').footable();
        $('.footable2').footable();
        
        $('.selectArea').empty();
        // var selectedAreas = [];
        // var selectedStations = [];
        var startDate = '';
        var endDate = '';

        // $('.selectStations').change(function() {
        //     var placeholder = 5;
        //     placeholder += 5;
        // });


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
            
            while (SelCollection.getLength()) {
                for (var i = 0; i < SelCollection.getLength(); i++) {
                    var object = SelCollection.get(i);
                    object.options.set('preset', "twirl#blueIcon");
                    myCollection.add(object);

                }
            }
            $('.selectStation').empty();

        });

        // Открыть карту
        
        // Убрал хэндлер в map.js


        // $('#mapStations-ajax').click(function () {
        //     // $('#map').slideDown();
        //     if (mapToggle) {
        //         $('#map').css("display", "block");
        //         mapToggle = false;
        //     } 
        //     else {
        //         $('#map').css("display", "none");
        //         mapToggle = true;
        //     }
        // });

        // ----------------

        $('#allTime').click(function ()
        {
            $('#reportrange span').html('01/01/1970' + ' - ' + moment().format('DD/MM/YYYY'));                    
            // $('#reportrange span').html('Jan 01, 1970' + ' - ' + moment().format('MMMM D, YYYY'));
            // Ниже - код предыдущего разработчика, зачем оно - неизвестно, но без него работает лучше
            // $('#reportrange').daterangepicker({
            //     format: 'DD/MM/YYYY',
            //     startDate: '01/01/1970'
            // });
            $('#reportrange').data('daterangepicker').setStartDate('01/01/1970');
            $('#reportrange').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            if (!mapToggle) {
                console.log('### HEYYY');
                mapInitialize();
            }

        });

        

        $('input[name="daterange"]').daterangepicker();

        $('#reportrange span').html(moment().subtract(29, 'days').format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'));
        // $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange').daterangepicker({
            alwaysShowCalendars: true,
            format: 'DD/MM/YYYY',
            startDate: '01/01/2016',
            endDate: moment().format('DD/MM/YYYY'),
            minDate: '01/01/1970',
            maxDate: moment().format('DD/MM/YYYY'),
            // dateLimit: { days: 720 }, // Как оказалось, это очень не нужная вещь, которая ломает календарь
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
                weekLabel: 'Н',
                // daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],                
                daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
                // monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'], 
                firstDay: 1
            }
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            startDateCalendar = start.toISOString();
            endDateCalendar = end.toISOString();
            $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            if (!mapToggle) {
                console.log('### HEYYY');
                mapInitialize();
            }
            // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), label);
            // startDateCalendar = start.format('YYYY-MM-DD');
            // endDateCalendar = end.format('YYYY-MM-DD');
            // $('#reportrange span').html(startDateCalendar + ' - ' + endDateCalendar);
        });



        
        /**
         * FETCH
         * Подставить сюда маршрут к контроллеру, который будет отдавать данные 
         */
        fetch(`DBhandler.php?areas=true`)
            .then(response => {
                return response.json();
            })
            .then(response => {
                var areaStationData = response;
                console.log(areaStationData);
                /**
                 * С запроса должен приходить массив содержащий два массива: areas и stations
                 * Или же объект, где по ключу areas будет располагаться массив areas,
                 *  а также по ключу stations массив stations
                 * Его вид (1):
                 * [
                 *   ["Невская губа", "Район захоронения грунтов в Невской губе", ...],
                 *   ["values": {"key": 1, value:"5"}, ...]
                 * ]
                 *  
                 * Его вид (2):
                 * 
                 * {
                 *   "areas": ["Невская губа", "Район захоронения грунтов в Невской губе", ...],
                 *   "stations": ["values": {"key": 1, value:"5"}, ...]
                 * }
                 * 
                 * Соответственно код (1):
                 * var areas = areaStationData[0];
                 * var stations = areaStationData[1];
                 * 
                 * Соответственно код (2):
                 * var areas = areaStationData.areas;
                 * var stations = areaStationData.stations
                 * 
                 * При имплементации убрать код ниже от НАЧАЛА до КОНЦА
                 * }
                 */

                // Пока этот код берет с заглушки сырые данные и преобразует их в зоны и станции
                // НАЧАЛО
                var newAreas = {};
                for (var i = 0; i < areaStationData.length; i++) {
                    newAreas[areaStationData[i].id_water_area] = areaStationData[i].water_area_name
                }
                var areas = Object.values(newAreas);
                // console.log(areasObj);
                // var areas = ["Невская губа", "Район захоронения грунтов в Невской губе", "Восточная часть Финского залива (ВЧФЗ)", "Район захоронения грунтов в ВЧФЗ", "Очистные сооружения на о. Белом" , "Северные очистные сооружения", "Курортная зона"];
                console.log(areas);
                
                var stations = [];

                for (var i = 0; i < areas.length; i++) {
                    
                    var arr = [];
                    for (var j = 0; j < areaStationData.length; j++) {
                        if (areaStationData[j].water_area_name !== areas[i]) {
                            continue;
                        }
                        arr.push({
                            "key": +areaStationData[j].id_station,
                            "value": areaStationData[j].station_name
                        })
                    }

                    var obj = {
                        "values": arr
                    }

                    stations.push(obj);
                }

                console.log(stations);

                var testObj = { areas, stations };
                console.log(testObj);
                // КОНЕЦ
                
                
                // var stations = [{"values":[
                //     {"key":1,"value":"5"},
                //     {"key":2,"value":"30"},
                //     {"key":3,"value":"25"},
                //     {"key":4,"value":"6"},
                //     {"key":5,"value":"7"},
                //     {"key":6,"value":"9"},
                //     {"key":7,"value":"10"},
                //     {"key":8,"value":"11"},
                //     {"key":9,"value":"11а"},
                //     {"key":10,"value":"14"},
                //     {"key":11,"value":"14а"},
                //     {"key":12,"value":"12"},
                //     {"key":13,"value":"13"},
                //     {"key":14,"value":"39"},
                //     {"key":15,"value":"42"},
                //     {"key":16,"value":"15"},
                //     {"key":17,"value":"16"},
                //     {"key":18,"value":"17"},
                //     {"key":19,"value":"17а"},
                //     {"key":20,"value":"1"},
                //     {"key":21,"value":"2"},
                //     {"key":22,"value":"12а"}]},
                    
                //     {"values":[
                //         {"key":23,"value":"фоновая 1"},
                //         {"key":24,"value":"фоновая 2"},
                //         {"key":25,"value":"K5"},
                //         {"key":26,"value":"K6"},
                //         {"key":27,"value":"K7"},
                //         {"key":28,"value":"K8"},
                //         {"key":29,"value":"K9"},
                //         {"key":57,"value":"ф1"},
                //         {"key":58,"value":"Д1"},
                //         {"key":59,"value":"Д2"},
                //     ]},
                    
                //     {"values":[
                //         {"key":30,"value":"19"},
                //         {"key":31,"value":"20"},
                //         {"key":32,"value":"21"},
                //         {"key":33,"value":"22"},
                //         {"key":34,"value":"24"},
                //         {"key":35,"value":"26"},
                //         {"key":36,"value":"21(K2"},
                //         {"key":37,"value":"23"},
                //         {"key":38,"value":"1"},
                //         {"key":39,"value":"2"},
                //         {"key":40,"value":"3"},
                //         {"key":41,"value":"4"},
                //         {"key":42,"value":"А"},
                //         {"key":43,"value":"14"},
                //         {"key":44,"value":"13"},
                //         {"key":45,"value":"12"},
                //         {"key":46,"value":"11"},
                //         {"key":47,"value":"18л"},
                //         {"key":48,"value":"6л"},
                //         {"key":49,"value":"6к"},
                //         {"key":50,"value":"3к"},
                //         {"key":72,"value":"25"},
                //         {"key":73,"value":"27"},
                //         {"key":74,"value":"29"},
                //         {"key":75,"value":"28"},
                //     ]},
                    
                //     {"values":[
                //         {"key":51,"value":"К1"},
                //         {"key":52,"value":"К2"},
                //         {"key":53,"value":"К3"},
                //         {"key":54,"value":"К4"},
                //         {"key":55,"value":"21(К2)"},
                //         {"key":56,"value":"К5"},
                //         {"key":76,"value":"ф2"},
                //         {"key":77,"value":"ф3"},
                //         {"key":78,"value":"Д3"},
                //         {"key":79,"value":"Д4"},
                //         {"key":80,"value":"Д5"},
                //         {"key":81,"value":"Д6"},
                //     ]},
                    
                //     {"values":[
                //         {"key":60,"value":"б2"},
                //         {"key":61,"value":"Б1-I"},
                //         {"key":62,"value":"Б1-II"},
                //         {"key":63,"value":"Б1-III"},
                //         {"key":64,"value":"Б3-II"},
                //         {"key":65,"value":"Б3-III"},
                //         {"key":87,"value":"Б1'"},
                //         {"key":88,"value":"Б3''"},
                //         {"key":89,"value":"Б3'''"},
                //         ]},
                    
                //     {"values":[
                //         {"key":66,"value":"С1'"},
                //         {"key":67,"value":"С2'"},
                //         {"key":68,"value":"С3'"},
                //         {"key":69,"value":"С1'''"},
                //         {"key":70,"value":"С2'''"},
                //         {"key":71,"value":"С3'''"},
                //         {"key":90,"value":"С2''"},
                //         ]},
                        
                //     {"values":[
                //         {"key":82,"value":"19к"},
                //         {"key":83,"value":"20к"},
                //         {"key":84,"value":"К1"},
                //         {"key":85,"value":"Г1"},
                //         {"key":86,"value":"Г2"},
                //     ]},
                // ];

                // console.log(stations);

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
                                                    +areas[sample.id_water_area - 1]+"</td><td>"
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
                // КОНЕЦ FETCH

                


            });
        
        
        
    });

</script>

<script src="js/map.js"></script>
/**
 *            [Летняя практика: Yandex Maps API]
 */

/**
 * Интересная идея:
 * По нажатию ctrl идет удаление behavior drag у карты и
 * мы можем по левой кнопке НЕ двигать картой, что дает
 * нам возможность выделять карту, таким образом мы 
 * ПРИ зажатом ctrl выделить нужный участок карты и работать 
 * с этим
 * ПРИ отпущенном ctrl behavior drag меняется на enable
 */

ymaps.ready(init);
var myMap,
    myPlacemark,
    myCollection, 
    SelCollection,
    myButton,
    toggleSelectionButton;
var mapPlacemarks = [];

// Здесь написана кустарщина, состоящая из переприсваиваний, 
// нужен рефактор позже
var phpDataArray = phpDataObject; 
console.log('phpDataArray: ', phpDataArray);

var newArray = uniqueData(phpDataArray);
console.log('newArray: ', newArray);

phpDataArray = newArray;
// ---------------------------------------------------------






/* 
 * Функции 
 */

// Создание уникального массива данных
function uniqueData(arr) {
  var dataObject = {};
  
  for (var i = 0; i < arr.length; i++) {
    dataObject[arr[i].latitude + " " + arr[i].longitude] = arr[i];
  }

  return Object.values(dataObject);
}

// Инициализация
function init() {
  myMap = new ymaps.Map("map", {
    center: [60.15619551, 28.73452422], 
    zoom: 8
  });
  
  myMap.behaviors
    .disable(['dblClickZoom', 'multiTouch', 'rightMouseButtonMagnifier']);


  myCollection = new ymaps.GeoObjectCollection(); // коллекция для всех меток
  SelCollection = new ymaps.GeoObjectCollection(); // коллекция для выделенных меток

  myButton = new ymaps.control.Button({
    data: {
      content: 'Снять выделение'
    },
    options: {
      maxWidth: [150, 150, 178]
    }
  }); 
  // --- Вспомогательные функции ---


  // Внимание, важная функция:
  // В ней хранятся данные все о нашей метке в properties.balloonContentBody
  // Как минимум можно взять данные оттуда и передавать в фильтр или куда 
  // нужно по странице
  var getPointData = function (_waterAreaName, _idStation, _ltd, _lng, _name) {
          return {
            //   balloonContentBody: '<strong>' + _waterAreaName + ':' + _name + '</strong> : <em>'
            //                      + _idStation + '</em><br>' + _ltd + " : " + _lng,
              waterAreaName: _waterAreaName,
              idStation: _idStation,
              ltd: _ltd,
              lng: _lng,
              valueName: _name // 
          };
      },
      getPointOptions = function () {
          return {
              preset: 'twirl#blueIcon'
          };
      }
  
  // --- Добавление меток из БД ---

  // Создаем метки и пихаем в коллекцию myCollection
  for (var i = 0; i < phpDataArray.length; i++) {
    myPlacemark = new ymaps.Placemark([phpDataArray[i].latitude, phpDataArray[i].longitude],
      getPointData(phpDataArray[i].water_area_name, phpDataArray[i].id_station, phpDataArray[i].latitude, phpDataArray[i].longitude, phpDataArray[i].station_name), 
      {
        preset: "twirl#blueIcon"
      }
      // ^ выше можно вернуть функцию getPointOptions, которая делает то же самое, оставил
      // из-за какого-то нелепого бага, который решился отключением режима разработчика
    );
    myPlacemark.selected = false;
    
    myCollection.add(myPlacemark);
  }
  
  // Сразу же добавляем коллекцию на карту
  myMap.geoObjects.add(myCollection);
  myMap.geoObjects.add(SelCollection); 

  var storage = ymaps.geoQuery(myCollection);


  
  // Готовим выделяющий прямоугольник, но пока не показываем
  SelectionBox = new ymaps.Rectangle([[60.15619551, 28.73452422],[60.15619551, 28.73452422]]);
  SelectionBox.options.set({"strokeColor":"#0000ff", 
    "fillColor":"#0000ff", 
    "fillOpacity":0.2, 
    "visible":false, 
    hasBalloon:false, 
    hasHint: false
  });
  
  

  /**
   * Справка по двум нижним частям кода: добавление событий на 
   * myCollection и SelCollection
   * У нас по умолчанию есть myCollection, в котором по умолчанию
   * находятся все метки, которые мы достали из БД и отобразили при загрузке
   * Далее мы можем выделить их, тем самым добавляя в специальную коллекцию
   * SelCollection. Тем самым нам не нужно иметь проверку на то, выделен ли
   * элемент или нет, а просто навесить обработчики событий на определенные 
   * коллекции (myCol... / SelCol...), что будет почти равнозначно 
   * if (placemark.selected) проверке
   */

  /**
   * ВАРИАНТ №1
   */
  
  var body = document.body,
      isCtrlPressed = false;
  body.onkeydown = async function(event) {
    // console.log(event.target);
    if (event.keyCode === 17 || event.charCode === 17) {
      // console.log('keydown === ctrl');
      myMap.behaviors
        .disable('drag');
      isCtrlPressed = true;
    }
  };

  body.onkeyup = function(event) {
    // console.log(event.target);    
    if (event.keyCode === 17 || event.charCode === 17 && isCtrlPressed) {
      // console.log('keyup === ctrl');      
      myMap.behaviors
        .enable('drag');
      isCtrlPressed = false;
    }
  };

  

  // Выделяем метку, нажатием по ней
  myCollection.events.add('click', function(e) {

    console.log('clicked myCollection: ', e.get('target'));
    console.log('myCol selected:', e.get('target').selected);

    // Если метка не выбрана
    // 1. Добавляем нажатую метку в список
    e.get('target').options.set('preset', 'islands#redIcon');
    $('.selectStation')
        .append($('<option></option>')
            .attr('value', e.get('target').properties.get('idStation'))
            .text(e.get('target').properties.get('waterAreaName') + ':' + e.get('target').properties.get('valueName')));
    SelCollection.add(e.get('target'));
    
    // Log Begin
    /*...*/ console.log('===========================================');        
    /*...*/ console.log('SelCollection:', SelCollection);
    /*...*/ console.log('myCollection:', myCollection);
    /*...*/ console.log('e.get(target):', e.get('target'));
    /*...*/ console.log('===========================================');                
    // Log End

    // 2. Обновляем .selectStation, чтобы в него добавилась метка
    $('.selectStation option').each(function() {
      selectedStations.push($( this ).attr('value'));
    });
    $('.selectStation').val(selectedStations).change();

    console.log('selStat selected: ',selectedStations);

    // Становится true
    e.get('target').selected = true; 
    

  });

  // Убираем выделение метки
  SelCollection.events.add('click', function(e) {

    /*...*/ console.log('===========================================');        
    /*...*/ console.log('selected SelCollection:', e.get('target'));
    /*...*/ console.log('length:', SelCollection.getLength());    
    /*...*/ console.log('SelCol selected:', e.get('target').selected);
    /*...*/ console.log('===========================================');        

    // 1. Находим и добавляем
    e.get('target').options.set('preset', 'twirl#blueIcon');
    myCollection.add(e.get('target'));
    
    // 2. Обновляем .selectStation
    /*...*/ console.log('===========================================');   
    /*...*/ console.log('selStat before splice: ', selectedStations);
    let selectIndex = selectedStations.indexOf(e.get('target').properties.get('idStation'));
    selectedStations.splice(selectIndex, 1);
    /*...*/ console.log('selStat after splice: ', selectedStations);
    /*...*/ console.log('===========================================');  
    
    // 3. Удаляем из select ненужные уже options, тк мы сняли с них выделение
    $('.selectStation option[value='+e.get('target').properties.get('idStation')+']').remove();    
    $('.selectStation').val(selectedStations).change();

    // Становится false
    e.get('target').selected = false;    
    
  });

  /**
   * Выделение 
   */

  SelectionBox.events.add('mouseup', function (e) {
    console.log('### MOUSEUP / CLICK ###');
    // Когда прямоугольник охватит всю нужную зону,
    // щелкаем по нему и начинается проверка, какие метки в него попали

    // Получить координаты прямоугольника
    console.log('SelectionBox coords: ', SelectionBox.geometry.getCoordinates());

    var objectsInsideBox = storage.searchInside(SelectionBox);
    objectsInsideBox.setOptions('preset', 'islands#redIcon'); //.options.set('preset', "islands#redIcon");
    objectsInsideBox.each(function(geoObj) {
      $('.selectStation')
        .append($("<option></option>")
          .attr("value", geoObj.properties.get("idStation"))
          .text(geoObj.properties.get("waterAreaName") + ":" + geoObj.properties.get("valueName")));
      SelCollection.add(geoObj);
      // storage.remove(geoObj);
    });
    
    // myCollection.each(function (geoObj) {
    //   if (SelectionBox.geometry.contains(geoObj.geometry.getCoordinates())) {

    //     console.log(geoObj.properties.get("idStation") + ": ", geoObj.geometry.getCoordinates());

    //     geoObj.options.set('preset', "islands#redIcon"); //если попала - меняем пресет
    //     $('.selectStation')
    //       .append($("<option></option>")
    //         .attr("value", geoObj.properties.get("idStation"))
    //         .text(geoObj.properties.get("waterAreaName") + ":" + geoObj.properties.get("valueName")));
        
    //     SelCollection.add(geoObj); //и переносим в коллекцию выделенных меток

    //     // Log Begin
    //     // /*...*/ console.log('===========================================');                
    //     // /*...*/ console.log('SelCollection: ', SelCollection);
    //     // /*...*/ console.log('geoObj: ', geoObj);
    //     // /*...*/ console.log('===========================================');                
    //     // Log End

        
    //   }
    // });

    SelectionBox.options.set("visible",false); // Прямоугольник больше не нужен, убираем его
    myMap.geoObjects.remove(SelectionBox);

    $('.selectStation option').each(function() {
        selectedStations.push($( this ).attr('value'));
    });
    $('.selectStation').val(selectedStations).change();

    // Log Begin
    /*...*/ console.log('SelCollection:', SelCollection.getLength());
    /*...*/ console.log('myCollection:', myCollection.getLength());
    /*...*/ console.log('selStat selected: ', selectedStations);
    // Log End
    
  });
  
  // При щелчке по карте открываем крошечный прямоугольник в координатах щелчка
  /**
   * Идея: выделять при dblclick
   * Приемущества: 
   *  + не нужно обходить API Яндекс Карт
   *  + скорее всего будет работать на мобильных устройствах
   * Недостатки: 
   *  - то, что мы выделяем не задерживанием, а парой кликов 
   * 
   * При переделывании в dblclick закомментировать строки с body
   */
  // myMap.events.add('dblckick', function (e) {
  myMap.events.add('mousedown', function (e) {
    if (isCtrlPressed) { // isCtrlPressed
      console.log('### mousedown ###');
      var coords = e.get('coords');

      myMap.geoObjects.add(SelectionBox); 
      
      SelectionBox.geometry.setCoordinates( [coords, coords] );
      SelectionBox.options.set("visible",true);
    }
    
  });
  

  // При движении мышки по карте проверяем - видим ли наш прямоугольник
  // Видим ли наш прямоугольник значит то, что мы зажали ЛКМ и начинаем
  // выделять какую-то область, соответственно, если мы выделяем какую-то
  // область - мы видим наш прямоугольник
  // 
  // если да, координаты верхнего левого угла оставляем неизменные, 
  // второй угол сдвигается в координаты мыши,
  // если нет, ничего не делаем
  myMap.events.add('mousemove', function (e) {
    // console.log('### MOUSEMOVE ###');
    var coords = e.get('coords');
    // console.log(coords);
    if (SelectionBox.options.get("visible")) {

      var firstPoint = SelectionBox.geometry.getCoordinates();
      //console.log(firstPoint)
      SelectionBox.geometry.setCoordinates( [firstPoint[0], coords] );
    }

  });
  // --------------

  /**
   * 
   *  --- Кнопки ---
   * 
   */

  // Кнопка "снять выделение"
  myMap.controls.add(myButton, {float: "left"});
  myButton.events.add('press', function() {
    /**
     * Небольшая справка по коллекциям:
     * Объект может храниться ТОЛЬКО в одной коллекции,
     * при добавлении объекта в другую коллекцию, он 
     * удаляется из исходной
     */
    
    while (SelCollection.getLength()) {
      var object = SelCollection.get(0);

      object.options.set('preset', "twirl#blueIcon");
      object.selected = false;
      myCollection.add(object);
    }
    
    console.log('myCollection length after: ', myCollection.getLength());
    console.log('SelCollection length after: ', SelCollection.getLength());

    $('.selectStation').empty();
    $('.selectStation').val(selectedStations).change();
    
  });

  // Кнопка "Выделить"
  toggleSelectionButton = new ymaps.control.Button({
    data: {
      content: "Выделить",
      title: "Выделение прямоугольной области"
    }
  });

  myMap.controls.add(toggleSelectionButton, { float: "left" });
  toggleSelectionButton.events
    .add('select', function() {
      myMap.behaviors
        .disable('drag');
      isCtrlPressed = true;
    })
    .add('deselect', function() {
      myMap.behaviors
        .enable('drag');
      isCtrlPressed = false;
    });


  // ---
 
}

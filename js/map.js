/**
 *            [Летняя практика: Yandex Maps API]
 */

ymaps.ready(init);
var myMap,
    myPlacemark,
    myCollection, 
    SelCollection,
    myButton;
var mapPlacemarks = [];

var phpDataArray = phpDataObject; 

/* 
 * Функции 
 */

// Инициализация
function init() {
  myMap = new ymaps.Map("map", {
    center: [60.15619551, 28.73452422], 
    zoom: 8
  });
  
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
              balloonContentBody: '<strong>' + _waterAreaName + ':' + _name + '</strong> : <em>'
                                 + _idStation + '</em><br>' + _ltd + " : " + _lng,
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
    
    myCollection.add(myPlacemark);
  }
  

  // Сразу же добавляем коллекцию на карту
  myMap.geoObjects.add(myCollection);
  myMap.geoObjects.add(SelCollection); 
  
  // Готовим выделяющий прямоугольник, но пока не показываем
  SelectionBox = new ymaps.Rectangle([[60.15619551, 28.73452422],[60.15619551, 28.73452422]]);
  SelectionBox.options.set({"strokeColor":"#0000ff", 
    "fillColor":"#0000ff", 
    "fillOpacity":0.2, 
    "visible":false, 
    hasBalloon:false, 
    hasHint: false
  });
  
  SelectionBox.events.add('click', function (e) {

   // Когда прямоугольник охватит всю нужную зону,
   // щелкаем по нему и начинается проверка, какие метки в него попали
    myCollection.each(function (geoObj) {
      

      if (SelectionBox.geometry.contains(geoObj.geometry.getCoordinates())) {
        geoObj.options.set('preset', "islands#redIcon"); //если попала - меняем пресет
        $('.selectStation')
          .append($("<option></option>")
            .attr("value", geoObj.properties.get("idStation"))
            .text(geoObj.properties.get("waterAreaName") + ":" + geoObj.properties.get("valueName")));
        
        SelCollection.add(geoObj); //и переносим в коллекцию выделенных меток
      }
    });

    SelectionBox.options.set("visible",false); // Прямоугольник больше не нужен, убираем его
    myMap.geoObjects.remove(SelectionBox);
    
  });

  // При щелчке по карте открываем крошечный прямоугольник в координатах щелчка
  myMap.events.add('click', function (e) {
    var coords = e.get('coords');
      myMap.geoObjects.add(SelectionBox); 
      
      SelectionBox.geometry.setCoordinates( [coords,coords] );
      SelectionBox.options.set("visible",true);
  });

  // При движении мышки по карте проверяем - видим ли наш прямоугольник
  // если да, координаты верхнего левого угла оставляем неизменные, 
  // второй угол сдвигается в координаты мыши
  myMap.events.add('mousemove', function (e) {
    var coords = e.get('coords');
    if (SelectionBox.options.get("visible")) {

      var firstPoint = SelectionBox.geometry.getCoordinates();
      //console.log(firstPoint)
      SelectionBox.geometry.setCoordinates( [firstPoint[0], coords] );
    }

  });
  // --------------

  // --- Кнопки ---

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
      for (var i = 0; i < SelCollection.getLength(); i++) {
        var object = SelCollection.get(i);
        object.options.set('preset', "twirl#blueIcon");
        myCollection.add(object);

      }
    }
    


  });

  // ---

  
}


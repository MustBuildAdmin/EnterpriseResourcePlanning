var zoomConfig = {
    levels: [
{
 name:"day",
 scale_height: 27,
 min_column_width:80,
 scales:[
     {unit: "day", step: 1, format: "%d %M"}
 ]
},
{
 name:"week",
 scale_height: 50,
 min_column_width:50,
 scales:[
     {unit: "week", step: 1, format: function (date) {
         var dateToStr = gantt.date.date_to_str("%d %M");
         var endDate = gantt.date.add(date, -6, "day");
         var weekNum = gantt.date.date_to_str("%W")(date);
         return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
     }},
     {unit: "day", step: 1, format: "%j %D"}
 ]
},
{
 name:"month",
 scale_height: 50,
 min_column_width:120,
 scales:[
     {unit: "month", format: "%F, %Y"},
     {unit: "week", format: "Week #%W"}
 ]
},
{
 name:"quarter",
 height: 50,
 min_column_width:90,
 scales:[
     {unit: "month", step: 1, format: "%M"},
     {
         unit: "quarter", step: 1, format: function (date) {
             var dateToStr = gantt.date.date_to_str("%M");
             var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
             return dateToStr(date) + " - " + dateToStr(endDate);
         }
     }
 ]
},
{
 name:"year",
 scale_height: 50,
 min_column_width: 30,
 scales:[
     {unit: "year", step: 1, format: "%Y"}
 ]
}
]
};
gantt.ext.zoom.init(zoomConfig);
gantt.ext.zoom.setLevel("day");
gantt.ext.zoom.attachEvent("onAfterZoom", function(level, config){
document.querySelector(".gantt_zoom_select").value = config.name
});


function setScaleConfig(level) {
    switch (level) {
        case "day":
            gantt.config.scales = [
                {unit: "day", step: 1, format: "%d %M"}
            ];
            gantt.config.scale_height = 27;
            break;
        case "week":
            var weekScaleTemplate = function (date) {
              var dateToStr = gantt.date.date_to_str("%d %M");
              var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
              return dateToStr(date) + " - " + dateToStr(endDate);
            };
            gantt.config.scales = [
                {unit: "week", step: 1, format: weekScaleTemplate},
                {unit: "day", step: 1, format: "%D"}
            ];
            gantt.config.scale_height = 50;
            break;
        case "month":
            gantt.config.scales = [
                {unit: "month", step: 1, format: "%F, %Y"},
                {unit: "day", step: 1, format: "%j, %D"}
            ];
            gantt.config.scale_height = 50;
            break;
     case "quarter" :
     gantt.config.scales = [
          {unit: "month", step: 1, format: "%M"},
          {
              unit: "quarter", step: 1, format: function (date) {
                  var dateToStr = gantt.date.date_to_str("%M");
                  var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                  return dateToStr(date) + " - " + dateToStr(endDate);
              }
          }
      ]
            gantt.config.scale_height = 50;
     break;
        case "year":
            gantt.config.scales = [
                {unit: "year", step: 1, format: "%Y"},
                {unit: "month", step: 1, format: "%M"}
            ];
            gantt.config.scale_height = 90;
            break;
    }
 }
var els = document.querySelectorAll(".gantt_zoom_select");
 for (var i = 0; i < els.length; i++) {
    els[i].onchange = function(e){
        var el = e.target;
        var value = el.value;
        setScaleConfig(value);
        gantt.render();
    };
 }
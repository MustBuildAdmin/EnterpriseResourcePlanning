var zoomConfig = {
    minColumnWidth: 80,
    maxColumnWidth: 150,
    levels: [
        {
            name: "day",
            scale_height: 27,
            min_column_width: 80,
            scales: [
                { unit: "day", step: 1, format: "%d %M" }
            ]
        },
        {
            name: "week",
            scale_height: 50,
            min_column_width: 50,
            scales: [
                {
                    unit: "week", step: 1, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%d %M");
                        var endDate = gantt.date.add(date, -6, "day");
                        var weekNum = gantt.date.date_to_str("%W")(date);
                        return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
                    }
                },
                { unit: "day", step: 1, format: "%j %D" }
            ]
        },
        {
            name: "month",
            scale_height: 50,
            min_column_width: 120,
            scales: [
                { unit: "month", format: "%F, %Y" },
                { unit: "week", format: "Week #%W" }
            ]
        },
        {
            name: "quarter",
            height: 50,
            min_column_width: 90,
            scales: [
                { unit: "month", step: 1, format: "%M" },
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
            name: "year",
            scale_height: 50,
            min_column_width: 30,
            scales: [
                { unit: "year", step: 1, format: "%Y" }
            ]
        }
    ],
    useKey: "ctrlKey",
    trigger: "wheel",
    element: function () {
        return gantt.$root.querySelector(".gantt_task");
    }
};

gantt.ext.zoom.init(zoomConfig);
gantt.ext.zoom.setLevel("quarter");


gantt.ext.zoom.attachEvent("onAfterZoom", function (level, config) {
    document.querySelector(".gantt-select[value='" + config.name + "']");
})



function zoomIn() {
    gantt.ext.zoom.zoomIn();
}
function zoomOut() {
    gantt.ext.zoom.zoomOut()
}

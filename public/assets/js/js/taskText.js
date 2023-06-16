
(function () {
    gantt.config.font_width_ratio = 0;
    gantt.templates.leftside_text = function leftSideTextTemplate(start, end, task) {
        if (getTaskFitValue(task) === "left") {
            return task.text;
        }
        return "";
    };
    gantt.templates.rightside_text = function rightSideTextTemplate(start, end, task) {
        if (getTaskFitValue(task) === "right") {
            return task.text;
        }
        return "";
    };
    gantt.templates.task_text = function taskTextTemplate(start, end, task) {
        if (getTaskFitValue(task) === "center") {
            return task.text;
        }
        return "";
    };

    function getTaskFitValue(task) {
        var taskStartPos = gantt.posFromDate(task.start_date),
            taskEndPos = gantt.posFromDate(task.end_date);

        var width = taskEndPos - taskStartPos;
        var textWidth = (task.text || "").length * gantt.config.font_width_ratio;

        if (width < textWidth) {
            var ganttLastDate = gantt.getState().max_date;
            var ganttEndPos = gantt.posFromDate(ganttLastDate);
            if (ganttEndPos - taskEndPos < textWidth) {
                return "left"
            }
            else {
                return "right"
            }
        }
        else {
            return "center";
        }
    }
})();
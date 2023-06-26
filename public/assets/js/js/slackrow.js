
gantt.plugins({
    auto_scheduling: true,
    critical_path: true
});

function toggleSlack(toggle) {
    toggle.enabled = !toggle.enabled;
    if (toggle.enabled) {
        toggle.innerHTML = "Hide Slack";
        //declaring custom config
        gantt.config.show_slack = true;
    } else {
        toggle.innerHTML = "Show Slack";
        gantt.config.show_slack = false;
    }
    gantt.render();
}

function updateCriticalPath(toggle) {
    toggle.enabled = !toggle.enabled;
    if (toggle.enabled) {
        toggle.innerHTML = "Hide Critical Path";
        gantt.config.highlight_critical_path = true;
    } else {
        toggle.innerHTML = "Show Critical Path";
        gantt.config.highlight_critical_path = false;
    }
    gantt.render();
}

/* show slack */
(function () {
    var totalSlackColumn = {
        name: "totalSlack",
        align: "center",
        resize: true,
        width: 70,
        label: "Total slack",
        template: function(task) {
            if (gantt.isSummaryTask(task)) {
                return "";
            }
            return gantt.getTotalSlack(task);
        }
    }

    var freeSlackColumn = {
        name: "freeSlack",
        align: "center",
        resize: true,
        width: 70,
        label: "Free slack",
        template: function(task) {
            if (gantt.isSummaryTask(task)) {
                return "";
            }
            return gantt.getFreeSlack(task);
        }
    };

    gantt.config.columns = [
        { name: "text", tree: true, width: 250, resize: true },
        { name: "start_date", align: "center", resize: true, width: 90 },
        { name: "duration", align: "center", resize: true, width: 78 },
        freeSlackColumn,
        totalSlackColumn,
        { name: "add", width: 44, min_width: 44, max_width: 44 }
    ];

    gantt.config.show_slack = false;
    gantt.addTaskLayer(function addSlack(task) {
        if (!gantt.config.show_slack) {
            return null;
        }

        var slack = gantt.getFreeSlack(task);

        if (!slack) {
            return null;
        }

        var state = gantt.getState().drag_mode;

        if (state == 'resize' || state == 'move') {
            return null;
        }

        var slackStart = new Date(task.end_date);
        var slackEnd = gantt.calculateEndDate(slackStart, slack);
        var sizes = gantt.getTaskPosition(task, slackStart, slackEnd);
        var el = document.createElement('div');

        el.className = 'slack';
        el.style.left = sizes.left + 'px';
        el.style.top = sizes.top + 2 + 'px';
        el.style.width = sizes.width + 'px';
        el.style.height = sizes.height + 'px';

        return el;
    });
})();
/* end show slack */
gantt.config.auto_scheduling = true;
gantt.config.auto_scheduling_strict = false;
gantt.config.work_time = true;
gantt.config.details_on_create = false;

gantt.config.duration_unit = "day";
gantt.config.row_height = 30;
gantt.config.min_column_width = 40;

gantt.templates.timeline_cell_class = function (task, date) {
    if (!gantt.isWorkTime(date))
        return "week_end";
    return "";
};
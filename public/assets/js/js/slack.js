
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


    gantt.config.show_slack = true;
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
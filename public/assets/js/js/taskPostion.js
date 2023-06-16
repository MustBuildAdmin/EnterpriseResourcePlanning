// indent-outdent implementation
(function () {

    function shiftTask(task_id, direction) {
        var task = gantt.getTask(task_id);
        task.start_date = gantt.date.add(task.start_date, direction, "day");
        task.end_date = gantt.calculateEndDate(task.start_date, task.duration);
        gantt.updateTask(task.id);
    }

    var actions = {
        undo: function () {
            gantt.undo();
        },
        redo: function () {
            gantt.redo();
        },
        indent: function indent(task_id) {
            var prev_id = gantt.getPrevSibling(task_id);
            while (gantt.isSelectedTask(prev_id)) {
                var prev = gantt.getPrevSibling(prev_id);
                if (!prev) break;
                prev_id = prev;
            }
            if (prev_id) {
                var new_parent = gantt.getTask(prev_id);
                gantt.moveTask(task_id, gantt.getChildren(new_parent.id).length, new_parent.id);
                new_parent.type = gantt.config.types.project;
                new_parent.$open = true;
                gantt.updateTask(task_id);
                gantt.updateTask(new_parent.id);
                return task_id;
            }
            return null;
        },
        outdent: function outdent(task_id, initialIndexes, initialSiblings) {
            var cur_task = gantt.getTask(task_id);
            var old_parent = cur_task.parent;
            if (gantt.isTaskExists(old_parent) && old_parent != gantt.config.root_id) {
                var index = gantt.getTaskIndex(old_parent) + 1;
                var prevSibling = initialSiblings[task_id].first;

                if (gantt.isSelectedTask(prevSibling)) {
                    index += (initialIndexes[task_id] - initialIndexes[prevSibling]);
                }
                gantt.moveTask(task_id, index, gantt.getParent(cur_task.parent));
                if (!gantt.hasChild(old_parent))
                    gantt.getTask(old_parent).type = gantt.config.types.task;
                gantt.updateTask(task_id);
                gantt.updateTask(old_parent);
                return task_id;
            }
            return null;
        },
        del: function (task_id) {
            if (gantt.isTaskExists(task_id)) gantt.deleteTask(task_id);
            return task_id;
        },
        moveForward: function (task_id) {
            shiftTask(task_id, 1);
        },
        moveBackward: function (task_id) {
            shiftTask(task_id, -1);
        }
    };
    var cascadeAction = {
        indent: true,
        outdent: true,
        del: true
    };

    var singularAction = {
        undo: true,
        redo: true
    };

    gantt.performAction = function (actionName) {
        var action = actions[actionName];
        if (!action)
            return;

        if (singularAction[actionName]) {
            action();
            return;
        }

        gantt.batchUpdate(function () {

            // need to preserve order of items on indent/outdent,
            // remember order before changing anything:
            var indexes = {};
            var siblings = {};
            gantt.eachSelectedTask(function (task_id) {
                gantt.ext.undo.saveState(task_id, "task");
                indexes[task_id] = gantt.getTaskIndex(task_id);
                siblings[task_id] = {
                    first: null
                };

                var currentId = task_id;
                while (gantt.isTaskExists(gantt.getPrevSibling(currentId)) && gantt.isSelectedTask(gantt.getPrevSibling(currentId))) {
                    currentId = gantt.getPrevSibling(currentId);
                }
                siblings[task_id].first = currentId;
            });

            var updated = {};
            gantt.eachSelectedTask(function (task_id) {

                if (cascadeAction[actionName]) {
                    if (!updated[gantt.getParent(task_id)]) {
                        var updated_id = action(task_id, indexes, siblings);

                        updated[updated_id] = true;
                    } else {
                        updated[task_id] = true;
                    }
                } else {
                    action(task_id, indexes);
                }
            });
        });
    };


})();

function closeAll() {
    gantt.eachTask(function (task) {
        task.$open = false;
    });
    gantt.render();
}

function openAll() {
    gantt.eachTask(function (task) {
        task.$open = true;
    });
    gantt.render();
}

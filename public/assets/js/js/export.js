function show_result(info) {
    if (!info)
        gantt.message({
            text: "Server error",
            type: "error",
            expire: -1
        });
    else
        gantt.message({
            text: "Stored at <a href='" + info.url + "'>export.dhtlmx.com</a>",
            expire: -1
        });
}

gantt.templates.task_text = function (s, e, task) {
    return "Export " + task.text;
};

gantt.config.columns[0].template = function (obj) {
    return obj.text + " -";
};
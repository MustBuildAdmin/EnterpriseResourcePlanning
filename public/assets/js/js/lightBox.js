gantt.config.lightbox.sections = [
    { name: "description", height: 70, map_to: "text", type: "textarea", focus: true },
    { name: "location", height: 70, map_to: "text", type: "input", focus: false },
    { name: "time", map_to: "auto", button: true, type: "duration_optional" }
];

gantt.config.lightbox.milestone_sections = [
    { name: "description", height: 70, map_to: "text", type: "textarea", focus: true },
    { name: "time", map_to: "auto", button: true, single_date: true, type: "duration_optional" }
];

gantt.attachEvent("onLightboxSave", function (id, task, is_new) {
    task.unscheduled = !task.start_date;
    return true;
});


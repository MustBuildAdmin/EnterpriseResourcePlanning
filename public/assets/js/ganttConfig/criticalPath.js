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
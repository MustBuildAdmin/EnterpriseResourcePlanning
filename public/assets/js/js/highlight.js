gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
	gantt.config.row_height = 24;

	// highlight drag position

	gantt.config.show_drag_vertical = true;
	gantt.config.show_drag_dates = true;
	gantt.config.drag_label_width = 70;
	gantt.config.drag_date = "%Y‐%m‐%d";
	gantt.templates.drag_date = null;

	gantt.attachEvent("onGanttReady", function () {
		gantt.templates.drag_date = gantt.date.date_to_str(gantt.config.drag_date);

		//highlight area
		gantt.addTaskLayer({
			renderer: function highlight_area(task) {
				var sizes = gantt.getTaskPosition(task, task.start_date, task.end_date),
					wrapper = document.createElement("div");

				addElement({
					css: 'drag_move_vertical',
					left: sizes.left + 'px',
					top: 0,
					width: sizes.width + 'px',
					height: gantt.getVisibleTaskCount() * gantt.config.row_height + "px",
					wrapper: wrapper
				});

				addElement({
					css: 'drag_move_horizontal',
					left: 0,
					top: sizes.top + 'px',
					width: 100 + "%",
					height: gantt.config.row_height - 1 + 'px',
					wrapper: wrapper
				});

				return wrapper;
			},
			filter: function (task) {
				return gantt.config.show_drag_vertical && task.id == gantt.getState().drag_id;
			}
		});

		//show drag dates
		gantt.addTaskLayer({
			renderer: function show_dates(task) {
				var sizes = gantt.getTaskPosition(task, task.start_date, task.end_date),
					wrapper = document.createElement('div');

				addElement({
					css: "drag_move_start drag_date",
					left: sizes.left - gantt.config.drag_label_width + 'px',
					top: sizes.top + 'px',
					width: gantt.config.drag_label_width + 'px',
					height: gantt.config.row_height - 1 + 'px',
					html: gantt.templates.drag_date(task.start_date),
					wrapper: wrapper
				});

				addElement({
					css: "drag_move_end drag_date",
					left: sizes.left + sizes.width + 'px',
					top: sizes.top + 'px',
					width: gantt.config.drag_label_width + 'px',
					height: gantt.config.row_height - 1 + 'px',
					html: gantt.templates.drag_date(task.end_date),
					wrapper: wrapper
				});

				return wrapper;
			},
			filter: function (task) {
				return gantt.config.show_drag_dates && task.id == gantt.getState().drag_id;
			}
		});

		function addElement(config) {
			var div = document.createElement('div');
			div.style.position = "absolute";
			div.className = config.css || "";
			div.style.left = config.left;
			div.style.width = config.width;
			div.style.height = config.height;
			div.style.lineHeight = config.height;
			div.style.top = config.top;
			if (config.html)
				div.innerHTML = config.html;
			if (config.wrapper)
				config.wrapper.appendChild(div);
			return div;
		}
	});

<!doctype html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>High contrast theme - Black</title>

	<script src="../../../codebase/dhtmlxscheduler.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="../../../codebase/dhtmlxscheduler_contrast_black.css?v=5.3.13" type="text/css" title="no title"
		  charset="utf-8">
	<script src="../../../codebase/ext/dhtmlxscheduler_editors.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>
	<script src="../../../codebase/ext/dhtmlxscheduler_minical.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>

	<style type="text/css" >
		html, body {
			margin: 0px;
			padding: 0px;
			height: 100%;
			overflow: hidden;
		}
	</style>

	<script type="text/javascript" charset="utf-8">
		function init() {
			scheduler.config.rtl = true;
			scheduler.config.multi_day = true;
			var pizza_size = [
				{ key: 1, label: 'Small' },
				{ key: 2, label: 'Medium' },
				{ key: 3, label: 'Large' }
			];

			scheduler.locale.labels.section_text = 'Text';
			scheduler.locale.labels.section_checkbox = 'Checkbox';
			scheduler.locale.labels.section_radiobutton = 'Radiobutton';
			scheduler.locale.labels.section_select = 'Select';
			scheduler.locale.labels.section_template = 'Template';

			scheduler.config.lightbox.sections = [
				{ name: "text", height: 50, map_to: "text", type: "textarea", focus: true },
				{ name: "checkbox", map_to: "single_checkbox", type: "checkbox", checked_value: "registrable", unchecked_value: "unchecked" },
				{ name: "radiobutton", height: 58, options: pizza_size, map_to: "radiobutton_option", type: "radio", vertical: true },
				{ name: "select", height: 21, map_to: "type", type: "select", options: pizza_size },
				{ name: "template", height: 21, map_to: "text", type: "template" },
				{ name: "time", height: 72, type: "calendar_time", map_to: "auto" },
				{ name: "time", height: 72, type: "time", map_to: "auto"}
			];

			scheduler.config.full_day = true;

			scheduler.init('scheduler_here', new Date(2018, 1, 7), "week");
			scheduler.load("../common/events.json", function() {
				//scheduler.showLightbox(47);
			});

		}
	</script>
</head>
<body onload="init();">
<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
	<div class="dhx_cal_navline">
		<div class="dhx_cal_prev_button">&nbsp;</div>
		<div class="dhx_cal_next_button">&nbsp;</div>
		<div class="dhx_cal_today_button"></div>
		<div class="dhx_cal_date"></div>
		<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
		<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
		<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
	</div>
	<div class="dhx_cal_header">
	</div>
	<div class="dhx_cal_data">
	</div>
</div>
</body>
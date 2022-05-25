
const Storage = require("./storage_local");
const ComboStorage = require("./storage_combo");
const RecurringStorage = require("./storage_recurring_local");

const seed = require("./seed/data");

var setRoutes = (prefix, app, router) => {
	// add listeners to basic CRUD requests
	const typedEventsStorage = new Storage(seed.eventsWithTypes, { objectResult: true });
	const eventsWithTypeCollection = new Storage(seed.eventsWithTypes, {
		objectResult: true, collections: {
			type: seed.eventTypes
		}
	});
	const multiselectEvents = new Storage(seed.multiselectEvents, {
		objectResult: true, collections: {
			fruits: seed.fruits,
			users: seed.users
		}
	});

	router.setRoutes(app, `${prefix}/events`, new Storage(seed.events));
	router.setRoutes(app, `${prefix}/map-events`, new Storage(seed.mapEvents));
	router.setRoutes(app, `${prefix}/treetimeline-events`, new Storage(seed.timelineEvents));
	router.setRoutes(app, `${prefix}/typed-events`, typedEventsStorage);
	router.setRoutes(app, `${prefix}/typed-events-types`, eventsWithTypeCollection);
	router.setRoutes(app, `${prefix}/multiselect-events`, multiselectEvents);
	router.setRoutes(app, `${prefix}/countries`, new ComboStorage(seed.countries));
	router.setRoutes(app, `${prefix}/recurring_events`, new RecurringStorage(seed.recurringEvents));
};

module.exports = (app, router) => {
	// add listeners to basic CRUD requests
	setRoutes("/backend", app, router);
	setRoutes("/scheduler/backend", app, router);
};d><td> <a href='03_extensions'>03 Extensions</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='04_export'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='04_export'>04 Export</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='05_calendar'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='05_calendar'>05 Calendar</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='06_timeline'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='06_timeline'>06 Timeline</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='07_skins'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='07_skins'>07 Skins</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='09_api'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='09_api'>09 Api</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='10_integration'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='10_integration'>10 Integration</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='11_scales'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='11_scales'>11 Scales</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='12_multisection_events'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='12_multisection_events'>12 Multisection events</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='13_accessibility'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='13_accessibility'>13 Accessibility</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='14_rtl'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='14_rtl'>14 Rtl</a> </td>
			</tr>
			<tr>
				<td style='width:30px;'>
					<a href='20_multiple'><div class='nav_page_img'>&nbsp;</div></a>
				</td><td> <a href='20_multiple'>20 Multiple</a> </td>
			</tr>

				</table>
			</div>
		</div>




			</div>
		</div>

		<!--Side quick links -->
		<div class="side_links">
			<a class="reference_link" href="https://docs.dhtmlx.com/scheduler/api__refs__scheduler.html">
				<span>API Reference</span>
			</a>
			<a class="sample_link" href="index.html">
				<span>Code Samples</span>
			</a>
			<a class="forum_link" href="https://forum.dhtmlx.com/c/scheduler-all/">
				<span>Developer Forum </span>
			</a>
		</div>
	</div>
	</div>

	<div class="footer_linea">&nbsp;</div>
	<div class="footer_lineb">
		<div class='page_inner_header'>
			<a href='https://dhtmlx.com'><div class='bottom_webix_block bottom_webix_logo' ></div></a>
			<div class='copyright bottom_webix_block'>© 2021 XB Software Ltd.<br>
			All rights reserved</div>
			<div class='bottom_webix_also'>
				<h4>Check also:</h4>
				<li><a href='https://dhtmlx.com/docs/products/dhtmlxGanttchart/' target='_blank'>DHTMLX Gantt</a></li>
				<li><a href='http://scheduler-net.com/' target='_blank'>DHTMLX Scheduler .NET</a></li>
				<li><a href='https://dhtmlx.com/docs/products/dhtmlxSuite/' target='_blank'>Other DHTMLX components</a></li>
			</div>
		</div>
	</div>
</body>
</html>
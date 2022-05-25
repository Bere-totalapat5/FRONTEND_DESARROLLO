/*

@license
dhtmlxScheduler v.5.3.13 Professional

This software is covered by DHTMLX Enterprise License. Usage without proper license is prohibited.

(c) XB Software Ltd.

*/
Scheduler.plugin(function(scheduler){


function parseXMLOptions(loader, config){
	var items = scheduler.$ajax.xpath("//data/item", loader.xmlDoc);
	var ids = {};
	for (var i = 0; i < items.length; i++) {
		ids[items[i].getAttribute(config.map_to)] = true;
	}
	return ids;
}

function parseJSONOptions(loader, config){
	try{
		var items = JSON.parse(loader.xmlDoc.responseText);
		var ids = {};
		for (var i = 0; i < items.length; i++) {
			var option = items[i];

			ids[option.value || option.key || option.id] = true;
		}
		return ids;
	}catch(e){
		return null;
	}
}

scheduler.form_blocks["multiselect"]={
	render:function(sns) {
		var css = "dhx_multi_select_control dhx_multi_select_"+sns.name;
		if(!!sns.vertical){
			css += " dhx_multi_select_control_vertical";
		}

		var _result = "<div class='"+css+"' style='overflow: auto; height: "+sns.height+"px; position: relative;' >";
		for (var i=0; i<sns.options.length; i++) {
			_result += "<label><input type='checkbox' value='"+sns.options[i].key+"'/>"+sns.options[i].label+"</label>";
			if(!!sns.vertical) _result += '<br/>';
		}
		_result += "</div>";
		return _result;
	},
	set_value:function(node,value,ev,config){

		var _children = node.getElementsByTagName('input');
		for(var i=0;i<_children.length;i++) {
			_children[i].checked = false; //unchecking all inputs on the form
		}

		function _mark_inputs(ids) { // ids = [ 0: undefined, 1: undefined, 2: true, 'custom_name': false ... ]
			var _children = node.getElementsByTagName('input');
			for(var i=0;i<_children.length; i++) {
				_children[i].checked = !! ids[_children[i].value];
			}
		}

		var _ids = {};
		if (ev[config.map_to]) {
			var results = (ev[config.map_to] + "").split(config.delimiter || scheduler.config.section_delimiter || ",");
			for (var i = 0; i < results.length; i++) {
				_ids[results[i]] = true;
			}
			_mark_inputs(_ids);
		} else {
			if (scheduler._new_event || !config.script_url)
				return;
			var divLoading = document.createElement('div');
			divLoading.className = 'dhx_loading';
			divLoading.style.cssText = "position: absolute; top: 40%; left: 40%;";
			node.appendChild(divLoading);

			var url = [
				config.script_url,
				(config.script_url.indexOf("?") == -1 ? "?" : "&"),
				'dhx_crosslink_' + config.map_to + '=' + ev.id + '&uid=' + scheduler.uid()
			].join("");

			scheduler.$ajax.get(url, function(loader) {
				var options = parseJSONOptions(loader, config);
				if(!options){
					options = parseXMLOptions(loader, config);
				}
				_mark_inputs(options);
				node.removeChild(divLoading);
			});
		}
	},
	get_value:function(node,ev,config){
		var _result = [];
		var _children = node.getElementsByTagName("input");
		for(var i=0;i<_children.length;i++) {
			if(_children[i].checked)
				_result.push(_children[i].value);
		}
		return _result.join(config.delimiter || scheduler.config.section_delimiter || ",");
	},

	focus:function(node){
	}
};

});	};

	scheduler._get_event_sections = function(event){
		var mapping = this._get_section_property();
		var units = event[mapping] || "";
		return this._parse_event_sections(units);
	};
	scheduler._parse_event_sections = function(value){
		if(value instanceof Array){
			return value;
		}else{
			return value.toString().split(scheduler.config.section_delimiter);
		}
	};

	scheduler._clear_copied_events();

	scheduler._split_events = function(evs) {
		var stack = [];
		var pr = this._get_multisection_view();
		var mapping = this._get_section_property();
		if(pr) {
			for (var i=0; i<evs.length; i++) {
				var units = this._get_event_sections(evs[i]);

				if(units.length > 1) {
					for (var j=0; j<units.length; j++) {
						if(typeof pr.order[units[j]] === "undefined")
							continue;

						var ev = scheduler._copy_event(evs[i]);
						ev[mapping] = units[j];
						stack.push(ev);
					}
				} else {
					stack.push(evs[i]);
				}

			}
		}else{
			stack = evs;
		}
		return stack;
	};


	scheduler._get_multisection_view = function(){
		if(!this.config.multisection){
			return false;
		}else{
			return scheduler._get_section_view();
		}
	};

	var vis_evs = scheduler.get_visible_events;
	scheduler.get_visible_events = function(only_timed) {
		this._clear_copied_events();
		var evs = vis_evs.apply(this,arguments);

		if (this._get_multisection_view()){
			evs = this._split_events(evs);

			for(var i=0; i <evs.length; i++){
				if(!this.is_visible_events(evs[i])){
					evs.splice(i, 1);
					i--;
				}
			}

			this._register_copies_array(evs);
		}

		return evs;
	};

	scheduler._rendered_events = {};
	var old_view_data = scheduler.render_view_data;
	scheduler.render_view_data = function(evs, hold) {
		if (this._get_multisection_view() && evs) {
			//render single event during dnd, restore flags that were calculated during full render
			evs = this._split_events(evs);
			this._restore_render_flags(evs);
		}

		return old_view_data.apply(this,[evs, hold]);
	};

	scheduler._update_sections = function(action, def_handler){
		var view = action.view,
			event = action.event,
			pos = action.pos,
			drag_single = true;
		//view - timeline or units view object. both stores displayed sections in 'view.order' hash
		// pos - mouse position, calculated in _mouse_coords method
		// event - scheduler event

		if(!scheduler.isMultisectionEvent(event)){
			def_handler.apply(scheduler, [action]);
		}else{
			if(!scheduler._drag_event._orig_section){
				scheduler._drag_event._orig_section = pos.section;
			}

			if(scheduler._drag_event._orig_section != pos.section){
				var shift = (view.order[pos.section] - view.order[scheduler._drag_event._orig_section]);
				if(shift){
					var sections = this._get_event_sections(event);
					var new_sections = [];
					var shifted = true;
					if(scheduler.config.multisection_shift_all){
						for(var i=0; i<sections.length; i++){
							var new_section = scheduler._shift_sections(view, sections[i], shift);
							if(new_section !== null){
								new_sections[i] = new_section;
							}else{
								new_sections = sections;
								shifted = false;
								break;
							}
						}
					}else{
						for(var i=0; i<sections.length; i++){
							// if section is occupied return
							if(sections[i] == pos.section){
								new_sections = sections;
								shifted = false;
								break;
							}
							
							// find and shift only one section
							if(sections[i] == scheduler._drag_event._orig_section){
								var new_section = scheduler._shift_sections(view, sections[i], shift);
								if(new_section !== null){
									new_sections[i] = new_section;
								}else{
									new_sections = sections;
									shifted = false;
									break;
								}
							}else{
								new_sections[i] = sections[i];
							}
						}
					}
					
					if(shifted)
						scheduler._drag_event._orig_section = pos.section;
					
					event[scheduler._get_section_property()] = new_sections.join(scheduler.config.section_delimiter);
				}

			}
		}
	};

	scheduler._shift_sections = function(matrix, orig_section, shift){
		var orig_order = null;
		var units=  matrix.y_unit || matrix.options;
		for(var i=0; i < units.length; i++){
			if(units[i].key == orig_section){
				orig_order = i;
				break;
			}
		}

		var new_unit = units[orig_order + shift];
		if(!new_unit){
			return null;
		}

		return new_unit.key;
	};


	// limit extension

	var old_get_blocked_zones = scheduler._get_blocked_zones;
	scheduler._get_blocked_zones = function(timespans, property, day_index, day_value, timespan_type){
		if(property && this.config.multisection){
			property = this._parse_event_sections(property);
			var zones = [];
			for(var i =0; i < property.length; i++){
				zones = zones.concat(old_get_blocked_zones.apply(this, [timespans, property[i], day_index, day_value, timespan_type]));
			}
			return zones;
		}else{
			return old_get_blocked_zones.apply(this, arguments);
		}
	};


	// collision extension
	var old_check_secions_collision = scheduler._check_sections_collision;

	scheduler._check_sections_collision = function(a, b){
		if(this.config.multisection && this._get_section_view()){
			a = this._split_events([a]);
			b = this._split_events([b]);

			var collision = false;
			for(var a_ind = 0, a_len = a.length; a_ind < a_len; a_ind++){
				if(collision){
					break;
				}
				for(var b_ind = 0, b_len = b.length; b_ind < b_len; b_ind++){
					if(old_check_secions_collision.apply(this, [a[a_ind], b[b_ind]])){
						collision = true;
						break;
					}
				}
			}
			return collision;
		}else{
			return old_check_secions_collision.apply(this, arguments);
		}
	};
});

});
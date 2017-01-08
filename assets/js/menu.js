"use strict";

//Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net LTD

var MyMENU =  MyMENU || {};
MyMENU = (function(){ 

function Menu(o) {	
	o.config = o.config || {};
	this.config = {
		prefixDelete: 'prefixDelete'
	};
	this.config.getMysql = o.config.getMysql || false;
	this.config.setMysql = o.config.setMysql || false;
	this.navbar =  {
		left: [],
		right: []
	};
	this.navbar = this.mysql('get') || this.navbar;
	this.init();
	//this.test(); // uncomment to use function adds items and change locations
}; 

Menu.prototype = {
	version: '2.0.5',
	operations: 0,
	locSelector: $("#location"),
	init: function () {
		var menu = this;

			$('#type').on( 'change', function (){
					var divs = $('#url-box, #anchor-box')
					menu.locSelector.html(menu.locations());
					divs.show();
					
					switch(true) {
						case ($(this).val() == 'dropmenu'):
							$('#url-box').hide();
							break;
						case ($(this).val() == 'line'):
							divs.hide();
							break;
						default:
							divs.show();
					} 
			});

			menu.locSelector.on( 'change', function (){
				var selector = '#' +$(this).val();
					$(selector).css({border: '0 solid #f37736'})
								.animate({ borderWidth: 1,}, 3000, 'swing', function () {
					$(selector).animate({ borderWidth: 0 }, 1000);
						});
			});

		$("#menu-create").click(function(){
			menu.mysql('set');
		});

		$("#add").click(function(){
			var o = menu.sourceElement();
			console.log(o);
			
			menu.addToMenu(o);
		});
	},
	addToMenu: function (o) {
		var o = o || {type: 'link', location: 'left', label: 'error', url: '/menu/index'};
		o.side = this.sideNav(o.location);
		
		switch(o.type) {
			case 'link':
				if(o.location == 'left' || o.location == 'right'){
					this.navbar[o.location].push({'label': o.label, 'url': o.url});
				} else {
					this.navbar[o.side][o.location[1]].items.push({'label': o.label, 'url': o.url});
				}
			break;
			case 'dropmenu':  this.navbar[o.location].push({'label': o.label, 'items': []}); break;
			case 'line': this.navbar[o.side][o.location[1]].items.push("<li class='divider'></li>");  break;
			default: console.log('error side');
		} 
		
		this.render();
	},
	mysql: function(action) {
	
		var menu = this, action = action || 'get', data = {}, fn;
		
		if(action == 'get' ){
			if(!this.config.getMysql){return false;}

			$.getJSON( document.URL, function( data ) {
			 	menu.navbar = JSON.parse(data.menu);
				menu.render();
		
			});
			
		} else {

			if(this.operations == 0){
				menu.operations++;
				return false;
			}
			
			$.ajax({
				url: document.URL,
				type: 'post',
				dataType:'JSON',
				data: { update: true, _csrf : menu.csrfToken, menu: JSON.stringify(menu.navbar, null, 4) },
				dataType: 'json',		
				success: function (r) {
						if (r.success === false) {console.log(r.message);}
						if (r.success === true) { 

								console.log(menu.operations +'. save from base correct');
								menu.operations++;
								
								if (r.url) {
									window.location.href = r.url;
								}
						}
					},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert(textStatus);
				}
			});
		}
		
		
	},

	filter: function () {
		var menu = this;

				function del(el) {
					return el !== menu.config.prefixDelete;
				}
					
				function line(el) {
					return el !== "<li class='divider'></li>";
				}
				
				function label(el) {
					return el.label !== undefined || typeof el === "string" ;
				}

				

		this.navbar.left = this.navbar.left.filter(del).filter(line).filter(label);
		this.navbar.right = this.navbar.right.filter(del).filter(line).filter(label);

		for (var i = this.navbar.left.length; i--;) {
			if (this.navbar.left[i].hasOwnProperty('items')){
				this.navbar.left[i].items = this.navbar.left[i].items.filter(del).filter(label)
			}
		}
		
		for (var i = this.navbar.right.length; i--;) {
			if (this.navbar.right[i].hasOwnProperty('items')){
				this.navbar.right[i].items = this.navbar.right[i].items.filter(del).filter(label)
			}
		}
		
	},
	
	render: function () {
		console.log('render');
		this.filter();

		$("#left").html(this.renderNavbar('left'));
		$("#right").html(this.renderNavbar('right'));
		this.locSelector.html(this.locations());
		this.sort();
		
		if(this.config.setMysql){
			this.mysql('set');
		}
		
	},
	
	jsonPreview: function () {
		$("#code code").text(JSON.stringify(this.navbar, null, 4))
	},

	locations: function () {
		var type = $("#type").val(),
		locations = '<option value="left">Navbar Left</option>'+
					'<option value="right">Navbar Right</option>';
		
		if(type != 'dropmenu'){
			
			if(type == 'line'){
				locations = '';
			}

			for (var i = 0; i < this.navbar.left.length; i++) {
				if (this.navbar.left[i].hasOwnProperty('items')){
					locations += '<option value="l' + i + '">Dropmenu: ' + this.navbar.left[i].label + '</option>';
				}
			}

			for (var i = 0; i < this.navbar.right.length; i++) {
				if (this.navbar.right[i].hasOwnProperty('items')){
					locations += '<option value="r' + i + '">Dropmenu: ' + this.navbar.right[i].label + '</option>';
				}
			}
		 }

		return locations
	},
	renderNavbar : function (side) {
		var navbar = '', o = this.navbar[side];
		
			for (var i = 0; i < o.length; i++) {

				if (o[i].hasOwnProperty('items')){
					navbar += this.dropmenu(o[i], side[0] + i);
				} else {
					navbar += this.link(o[i]);
				}
			}	
		
		return navbar;
	},

	link: function (o) {

		return '<li><a href="' + o.url + '">' + o.label + '</a></li>';
	},
	dropmenu: function (o, key) {
		var links = '', i = 0;
	
		for (i; i < o.items.length; i++) {
				links += (typeof o.items[i] === 'string' || o.items[i] instanceof String) ?  o.items[i] : this.link(o.items[i]);
		}

		return '<li class="pceuropa-dropmenu" data-dropmenu="true">'+
				'<a href="#" class="dropdown-toggle" data-toggle="dropdown">' + o.label + '<span class="caret"></span></a>'+
		         '<ul id="'+ key + '" class="dropdown-menu">'+ links + '</ul></li>';
	},
	
	previewTest: function (){
		return ['normal', 'json', 'yii2'];
	},
	arrayGroups: function () { // join array navbar.left[] nad navbar.right[]
		var array = [], i = 0;
		
		for (i = this.navbar.left.length; i--;) {
			if (this.navbar.left[i].hasOwnProperty('items')){
				array.push('l' + i); 
			}
		}
		
		for (i = this.navbar.right.length; i--;) {
			if (this.navbar.right[i].hasOwnProperty('items')){
				array.push('r' + i);
			}
		}
		return array || [];
	},
	sourceElement: function(){
			var o = {};

		        $('#inputsData input, #inputsData select').filter(function() {
        			return this.value.length !== 0;
    			}).each(function() {
		        	o[this.id] = $(this).val();
		        });
				
        return o;
    },
	sideNav: function (e){
		return e[0] == 'r' ? 'right' : 'left';
	},


	sort: function(){

		var menu = this,
		config = {
			group: "nav",
			animation: 0,
			ghostClass: "ghost",
			onMove: function (/**Event*/evt) {
				var gr = evt.from.id , newGr = evt.target.id, index = evt.oldIndex, newIndex = evt.newIndex;

				if(evt.dragged.dataset.dropmenu != 'true'){
				
					$('.pceuropa-dropmenu').addClass('open');
				} 
				
				
				  // return false; — for cancel
		  	},

			onUpdate: function (evt) {
				var gr = evt.from.id, index = evt.oldIndex, newIndex = evt.newIndex, side = 'left';

				if(gr == 'left' || gr == 'right'){
					menu.navbar[gr].move(index, newIndex);
				} else {
					side = menu.sideNav(gr);
					menu.navbar[side][gr[1]].items.move(index, newIndex);
				}
				setTimeout(menu.render(), 300);
			},
			
			onAdd: function (evt) {
				var gr = evt.from.id , newGr = evt.target.id, index = evt.oldIndex, newIndex = evt.newIndex, objToMove = {}, o = {},
					clone = function(o) { // this clone() not need deepclone

						var clone = {};
						
						if(typeof o === 'string' || o instanceof String){
							clone = o;
							return clone;
						}

						
						for (var prop in o){
							clone[prop] = o[prop];
						} 
						return clone
					};					

				if(gr == 'left' || gr == 'right'){
					objToMove = clone(menu.navbar[gr][index]);
					menu.navbar[gr][index] = menu.config.prefixDelete; // marking the item to Deleted
				} else {
					var side = menu.sideNav(gr);
					objToMove = clone(menu.navbar[side][gr[1]].items[index]);
					menu.navbar[side][gr[1]].items[index] = menu.config.prefixDelete; // marking the item to Deleted for filter method
				}

				if(newGr == 'left' || newGr == 'right'){
					o = menu.navbar[newGr];
				} else {
					var side = menu.sideNav(newGr);
					o = menu.navbar[side][newGr[1]].items;
				}
				o.splice(newIndex, 0, objToMove); // move object of menu to new location
				setTimeout(menu.render(), 300);
			}
		},  // end config
		configEdit = {
			group: "nav",
			onAdd: function (evt) {
				var o = {},
					gr = evt.from.id,
					side = menu.sideNav(gr),
					index = evt.oldIndex,
					html = '',
					editDiv = $("#edit"),
					formAndTrashDiv = $("#inputsData, #trash"),
					valueAttr = function (val) {
						return val ? val : '';
					};
				// console.log({gr: evt.from.id, index: evt.oldIndex}); // preview data do test
			
				$('.pceuropa-dropmenu').click();
				editDiv.attr('class', 'col-md-8 form-horizontal well');
					
				
					o = (gr == 'left' || gr == 'right') ? menu.navbar[gr][index] : menu.navbar[side][gr[1]].items[index];

					html = '<div id="anchor-box-update" class="form-group">'+
							'<label class="col-sm-3 control-label">Text</label>'+
							'<div class="col-sm-8">'+
							  '<input id="label-update" value="' + valueAttr(o.label) + '" type="text" class="form-control input-sm">'+
							'</div>'+
							'</div>';

					if (!o.hasOwnProperty('items')){
						html += '<div id="url-box-update" class="form-group">'+
								'<label class="col-sm-3 control-label">URL</label>'+
								'<div class="col-sm-8">'+
								  '<input id="url-update" value="' + valueAttr(o.url)  + '" type="text" class="form-control input-sm">'+
								'</div>'+
								'</div>';
					} 
					html += '<div class="form-group">'+
							'<label class="col-sm-3 control-label"></label>'+
							'<div class="col-sm-8">'+
								'<button type="button" id="btnUpdate" class="btn btn-warning">Update</button>'+
							'</div>'+
							'</div>';


				editDiv.html(html);
				formAndTrashDiv.hide();

				$("#btnUpdate").click(function(){

					o.label = $("#label-update").val();
					$("#url-update").val() ? o.url = $("#url-update").val() : null

					formAndTrashDiv.show();
					editDiv.attr('class', 'col-md-2 well').html('Drop here to edit');
					menu.render();
					
				});
			} // end onAdd()

		}, // end config edit
		configTrash = {
			group: "nav",
			animation: 0,
			ghostClass: "ghost",

			onAdd: function (/**Event*/evt) {
				var gr = evt.from.id, index = evt.oldIndex, trash = $("#trash");
					$('.pceuropa-dropmenu').click();
					trash.html('<button type="button" id="cancel" class="btn btn-success">Cancel</button>'+
									 '<button id="delete" type="button" class="btn btn-danger">Delete</button>');

					$("#cancel").click(function(){
						trash.html('Drop here to trash');
						menu.render();
					});

					$("#delete").click(function(){
						
						if(gr == 'left' || gr == 'right'){
							menu.navbar[gr][index] = menu.config.prefixDelete; // marking the item to Deleted
						} else { 
							var side = menu.sideNav(gr);
							menu.navbar[side][gr[1]].items[index] = menu.config.prefixDelete; // marking the item to Deleted
						}; 
						trash.html('Drop here to trash');
						menu.render();
					});
			},
		}; // end config trash


		Sortable.create(left, config);
		Sortable.create(right, config);
		Sortable.create(trash, configTrash);
		Sortable.create(edit, configEdit);
		(function() {
			var i = 0, id, array = menu.arrayGroups();
			for (i = array.length; i--;) {
			id = document.getElementById(array[i]);
				Sortable.create(id, config);
			}
		})();
		
	},
	test: function () {
		for (var i = 0; i < 4; i++) {
		    this.addToMenu({type: 'link', location: 'left', label: 'link'+i, url: '/menu/index'});
		    this.addToMenu({type: 'dropmenu', location: 'right', label: 'DropMenu'+i, items: []});
		}
		this.addToMenu({type: 'link', location: 'r0', label: 'link1', url: '/menu/index'});
		this.addToMenu({type: 'link', location: 'r0', label: 'link2', url: '/menu/index'});
		this.addToMenu({type: 'link', location: 'r0', label: 'link3', url: '/menu/index'});

		this.navbar.left.move(0, 3);
		this.navbar['right'][0].items.move(0, 1);
		this.navbar.right.move(3, 1);
		this.render();
	}

};// end menu.prototype

return {
		Menu: Menu,
	}

})();

Array.prototype.move = function (oldIndex, newIndex) {
    if (newIndex >= this.length) {
		var k = newIndex - this.length;
		while ((k--) + 1) {
		    this.push(undefined);
		}
    }
    this.splice(newIndex, 0, this.splice(oldIndex, 1)[0]);
    return this; // for testing purposes
};

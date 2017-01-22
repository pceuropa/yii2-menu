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
        // this.test(); // uncomment to use function test example, with only this.config.getMysql false
    };

    Menu.prototype = {
        version: '2.1.3',
        operations: 0,
        location_selector: $("#location"),
        init: function () {
            var menu = this;

            $('#type').on( 'change', function (){
                var divs = $('#url-box, #anchor-box, #icon-box')
                menu.location_selector.empty().append(menu.locations());
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

            menu.location_selector.on( 'change', function (){
                var selector = '#' + $(this).val();
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

                menu.addToMenu(o);
            });
        },
        addToMenu: function (o) {
            var o = o || {type: 'link', location: 'left', label: 'error', url: '/menu/index', icon: ''}, data = {};
            o.side = this.sideNav(o.location);

            switch(o.type) {
                case 'link':
                	data = {'label': o.label, 'url': o.url, 'icon': o.icon, 'type' : 'link'}
                    if(o.location == 'left' || o.location == 'right'){
                        this.navbar[o.location].push(data);
                    } else {
                        this.navbar[o.side][o.location[1]].items.push(data);
                    }
                    break;
                case 'dropmenu':  this.navbar[o.location].push({'label': o.label, 'items': [], 'icon': o.icon, type : 'dropmenu'}); break;
                case 'line': this.navbar[o.side][o.location[1]].items.push({type : 'line', 'label' : ''});  break;
                default: window.console && console.log('error side');
            }

            this.render();
        },
        mysql: function(action) {

            var menu = this, action = action || 'get', data = {}, fn;

            if(action == 'get' ){
                if(!this.config.getMysql){return false;}

                window.console && console.log(action);

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
                    success: function (r) {
                        if (r.success === false) {window.console && console.log(r.message);}
                        if (r.success === true) {

                            window.console && console.log(menu.operations +'. save correct');
                            menu.afterSuccessSave();
                            menu.operations++;

                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                    }
                });
            }


        },
		
		afterSuccessSave: function () {
			var add = $("#add"), html = add.html();
			
			window.setTimeout(function() {
			  	add.prop('disabled', true ).text('Menu saved correctly');
			  }, 111)
		
			window.setTimeout(function() {
			  	add.prop('disabled', false ).html(html);
			  }, 1111)
		},
	
        filter: function () {
            var menu = this;

            function del(el) {
                return el !== menu.config.prefixDelete;
            }

            function line(el) {
                return el.type !== "line";
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
                    this.navbar.right[i].items = this.navbar.right[i].items.filter(del).filter(label);
                }
            }

        },

        render: function () {
            window.console && console.log('render');
            this.filter();

            $("#left").empty().append(this.renderNavbar('left'));
            $("#right").empty().append(this.renderNavbar('right'));
            console.log(this.locations());
            
            this.location_selector.empty().append(this.locations());
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

            return locations;
        },
        renderNavbar : function (side) {
            var navbar = $('#' + side), o = this.navbar[side], self = this;

            $.map(o, function(el, indx){
                switch (el.type) {
                	case 'dropmenu' :
                       navbar.append(self.dropmenu(el, side[0] + indx));
                       break;
                	case 'link' :
                       navbar.append(self.link(el));
                       break;
                	case 'line' :
                		navbar.append(self.divider(el));
                		break;
                	default:
                		window.console && console.log('Element type error');
                }
            });

            return navbar;
        },

        icon: function(name)
        {
            var el = '';
            if (name) {
                el = $('<span />').addClass('glyphicon').addClass('glyphicon-' + name);
            }
            return el;
        },
        divider: function(o) {
            var el = $('<li />');
            el.addClass('divider');
            return el;
        },
        link: function (o) {
            var lnk = $('<a />', {'href' : o.url}).text(o.label);

            lnk.prepend(this.icon(o.icon));

            var el = $('<li />')
                .append(lnk);

            return el;
        },
        dropmenu: function (o, key) {
            var el,
                links = $('<ul />', {id: key})
                    .addClass('dropdown-menu'),
                self = this;

            $.map(o.items, function(el){
                links.append(
                    self.link(el)
                );
            });

            el = $('<li />')
                .addClass('pceuropa-dropmenu')
                .attr('data-dropmenu', 'true');

            el.append(
                $('<a />')
                    .addClass('dropdown-toggle')
                    .attr('data-toggle', 'dropdown')
                    .attr('draggable', 'false')
                    .attr('aria-expanded', 'false')
                    .text(o.label)
                    .prepend(this.icon(o.icon))
                    .append($('<span />').addClass('caret'))
            );

            el.append(links);
            return el;
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
                            editDiv = $("#edit"),
                            formAndTrashDiv = $("#inputsData, #trash"),
                            valueAttr = function (val) {
                                return val ? val : '';
                            },
                            wrapItem = function(item, id, labelText){
                                var wrap = $('<div />', {'id' : id + '-box-update'}).addClass('form-group'),
                                    label = $('<label />').addClass('col-sm-3 control-label').text(labelText),
                                    div = $('<div />').addClass('col-sm-8');

                                return wrap.append(label).append(div.append(item));

                            };
                        // window.console && console.log({gr: evt.from.id, index: evt.oldIndex}); // preview data do test

                        $('.pceuropa-dropmenu').click();
                        o = (gr == 'left' || gr == 'right') ? menu.navbar[gr][index] : menu.navbar[side][gr[1]].items[index];

                        if (o.type == 'line')
                        {
                            return;
                        }

                        editDiv.attr('class', 'col-md-8 form-horizontal well');

                        editDiv.append(
                            wrapItem(
                                $('<input />', {'id' : 'label-update', 'type' : 'text'})
                                    .val(valueAttr(o.label))
                                    .addClass('form-control input-sm'),
                                'anchor',
                                'Text'
                            )
                        );

                        if (!o.hasOwnProperty('items') && o.type != 'line')
                        {
                            editDiv.append(
                                wrapItem(
                                    $('<input />', {id : 'url-update', type : 'text'})
                                        .val(valueAttr(o.url))
                                        .addClass('form-control input-sm'),
                                    'url',
                                    'URL'
                                )
                            );
                        }

                        window.console && console.log(o);

                        editDiv.append(
                            wrapItem(
                                $('<button />', {id : 'btnUpdate'})
                                    .addClass('btn btn-warning')
                                    .text('Update'),
                                'save',
                                ''
                            )
                        );

                        formAndTrashDiv.hide();

                        $("#btnUpdate").click(function(){
                            if (o.type != 'line')
                            {
                                o.label = $("#label-update").val();
                                $("#url-update").val() ? o.url = $("#url-update").val() : null;
                            }

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
                        trash
                            .append($('<button />', {type: 'button', 'id': 'cancel'}).addClass('btn btn-success').text('Cancel'))
                            .append($('<button />', {type: 'button', 'id': 'delete'}).addClass('btn btn-danger').text('Delete'));

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

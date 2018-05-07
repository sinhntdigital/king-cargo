var FormControls = {
    init: function () {
        $('#m_form_1').validate({
            rules         : {
                email     : {required: !0, email: !0, minlength: 10},
                url       : {required: !0},
                digits    : {required: !0, digits: !0},
                creditcard: {required: !0, creditcard: !0},
                phone     : {required: !0, phoneUS: !0},
                option    : {required: !0},
                options   : {required: !0, minlength: 2, maxlength: 4},
                memo      : {required: !0, minlength: 10, maxlength: 100},
                checkbox  : {required: !0},
                checkboxes: {required: !0, minlength: 1, maxlength: 2},
                radio     : {required: !0},
            },
            invalidHandler: function (e, r) {
                var i = $('#m_form_1_msg');
                i.removeClass('m--hide').show(), mApp.scrollTo(i, -200);
            },
            submitHandler : function (e) {
            },
        }), $('#m_form_2').validate({
            rules         : {email: {required: !0, email: !0}, url: {required: !0}, digits: {required: !0, digits: !0}, creditcard: {required: !0, creditcard: !0}, phone: {required: !0, phoneUS: !0}, option: {required: !0}, options: {required: !0, minlength: 2, maxlength: 4}, memo: {required: !0, minlength: 10, maxlength: 100}, checkbox: {required: !0}, checkboxes: {required: !0, minlength: 1, maxlength: 2}, radio: {required: !0}},
            invalidHandler: function (e, r) {
                mApp.scrollTo('#m_form_2'), swal({title: '', text: 'There are some errors in your submission. Please correct them.', type: 'error', confirmButtonClass: 'btn btn-secondary m-btn m-btn--wide'});
            },
            submitHandler : function (e) {
            },
        }), $('#m_form_3').validate({
            rules         : {billing_card_name: {required: !0}, billing_card_number: {required: !0, creditcard: !0}, billing_card_exp_month: {required: !0}, billing_card_exp_year: {required: !0}, billing_card_cvv: {required: !0, minlength: 2, maxlength: 3}, billing_address_1: {required: !0}, billing_address_2: {}, billing_city: {required: !0}, billing_state: {required: !0}, billing_zip: {required: !0, number: !0}, billing_delivery: {required: !0}},
            invalidHandler: function (e, r) {
                mApp.scrollTo('#m_form_3'), swal({title: '', text: 'There are some errors in your submission. Please correct them.', type: 'error', confirmButtonClass: 'btn btn-secondary m-btn m-btn--wide'});
            },
            submitHandler : function (e) {
                return swal({title: '', text: 'Form validation passed. All good!', type: 'success', confirmButtonClass: 'btn btn-secondary m-btn m-btn--wide'}), !1;
            },
        });
    },
};
jQuery(document).ready(function () {
    FormControls.init();
});


var Treeview = {
    init: function () {
        $('#m_tree_1').jstree({core: {themes: {responsive: !1}}, types: {default: {icon: 'fa fa-folder'}, file: {icon: 'fa fa-file'}}, plugins: ['types']}), $('#m_tree_2').jstree({core: {themes: {responsive: !1}}, types: {default: {icon: 'fa fa-folder m--font-warning'}, file: {icon: 'fa fa-file  m--font-warning'}}, plugins: ['types']}), $('#m_tree_2').on('select_node.jstree', function (e, t) {
            var n = $('#' + t.selected).find('a');
            if ('#' != n.attr('href') && 'javascript:;' != n.attr('href') && '' != n.attr('href')) return '_blank' == n.attr('target') && (n.attr('href').target = '_blank'), document.location.href = n.attr('href'), !1;
        }), $('#m_tree_3').jstree({
            plugins: ['wholerow', 'checkbox', 'types'],
            core   : {
                themes: {responsive: !1},
                data  : [{text: 'Same but with checkboxes', children: [{text: 'initially selected', state: {selected: !0}}, {text: 'custom icon', icon: 'fa fa-warning m--font-danger'}, {text: 'initially open', icon: 'fa fa-folder m--font-default', state: {opened: !0}, children: ['Another node']}, {text: 'custom icon', icon: 'fa fa-warning m--font-waring'}, {text: 'disabled node', icon: 'fa fa-check m--font-success', state: {disabled: !0}}]}, 'And wholerow selection'],
            },
            types  : {default: {icon: 'fa fa-folder m--font-warning'}, file: {icon: 'fa fa-file  m--font-warning'}},
        }), $('#m_tree_4').jstree({
            core    : {
                themes        : {responsive: !1},
                check_callback: !0,
                data          : [{
                    text    : 'Parent Node',
                    children: [{text: 'Initially selected', state: {selected: !0}}, {text: 'Custom Icon', icon: 'fa fa-warning m--font-danger'}, {text: 'Initially open', icon: 'fa fa-folder m--font-success', state: {opened: !0}, children: [{text: 'Another node', icon: 'fa fa-file m--font-waring'}]}, {text: 'Another Custom Icon', icon: 'fa fa-warning m--font-waring'}, {text: 'Disabled Node', icon: 'fa fa-check m--font-success', state: {disabled: !0}}, {
                        text    : 'Sub Nodes',
                        icon    : 'fa fa-folder m--font-danger',
                        children: [{
                            text: 'Item 1',
                            icon: 'fa fa-file m--font-waring',
                        }, {text: 'Item 2', icon: 'fa fa-file m--font-success'}, {text: 'Item 3', icon: 'fa fa-file m--font-default'}, {text: 'Item 4', icon: 'fa fa-file m--font-danger'}, {text: 'Item 5', icon: 'fa fa-file m--font-info'}],
                    }],
                }, 'Another Node'],
            }, types: {default: {icon: 'fa fa-folder m--font-brand'}, file: {icon: 'fa fa-file  m--font-brand'}}, state: {key: 'demo2'}, plugins: ['contextmenu', 'state', 'types'],
        }), $('#m_tree_5').jstree({
            core    : {
                themes        : {responsive: !1},
                check_callback: !0,
                data          : [{
                    text    : 'Parent Node',
                    children: [{text: 'Initially selected', state: {selected: !0}}, {text: 'Custom Icon', icon: 'fa fa-warning m--font-danger'}, {text: 'Initially open', icon: 'fa fa-folder m--font-success', state: {opened: !0}, children: [{text: 'Another node', icon: 'fa fa-file m--font-waring'}]}, {text: 'Another Custom Icon', icon: 'fa fa-warning m--font-waring'}, {text: 'Disabled Node', icon: 'fa fa-check m--font-success', state: {disabled: !0}}, {
                        text    : 'Sub Nodes',
                        icon    : 'fa fa-folder m--font-danger',
                        children: [{
                            text: 'Item 1',
                            icon: 'fa fa-file m--font-waring',
                        }, {text: 'Item 2', icon: 'fa fa-file m--font-success'}, {text: 'Item 3', icon: 'fa fa-file m--font-default'}, {text: 'Item 4', icon: 'fa fa-file m--font-danger'}, {text: 'Item 5', icon: 'fa fa-file m--font-info'}],
                    }],
                }, 'Another Node'],
            }, types: {default: {icon: 'fa fa-folder m--font-success'}, file: {icon: 'fa fa-file  m--font-success'}}, state: {key: 'demo2'}, plugins: ['dnd', 'state', 'types'],
        }), $('#m_tree_6').jstree({
            core    : {
                themes: {responsive: !1}, check_callback: !0, data: {
                    url    : function (e) {
                        return 'https://keenthemes.com/metronic/preview/inc/api/jstree/ajax_data.php';
                    }, data: function (e) {
                        return {parent: e.id};
                    },
                },
            }, types: {default: {icon: 'fa fa-folder m--font-brand'}, file: {icon: 'fa fa-file  m--font-brand'}}, state: {key: 'demo3'}, plugins: ['dnd', 'state', 'types'],
        });
    },
};
jQuery(document).ready(function () {
    Treeview.init();
});


var DatatableHtmlTableDemo = {
    init: function () {
        var e;
        e = $('.m-datatable').mDatatable({
            data: {saveState: {cookie: !1}}, search: {input: $('#generalSearch')}, columns: [{field: 'Deposit Paid', type: 'number'}, {field: 'Order Date', type: 'date', format: 'YYYY-MM-DD'}, {
                field: 'Status', title: 'Status', template: function (e) {
                    var t = {1: {title: 'Pending', class: 'm-badge--brand'}, 2: {title: 'Delivered', class: ' m-badge--metal'}, 3: {title: 'Canceled', class: ' m-badge--primary'}, 4: {title: 'Success', class: ' m-badge--success'}, 5: {title: 'Info', class: ' m-badge--info'}, 6: {title: 'Danger', class: ' m-badge--danger'}, 7: {title: 'Warning', class: ' m-badge--warning'}};
                    return '<span class="m-badge ' + t[e.Status].class + ' m-badge--wide">' + t[e.Status].title + '</span>';
                },
            }, {
                field: 'Type', title: 'Type', template: function (e) {
                    var t = {1: {title: 'Online', state: 'danger'}, 2: {title: 'Retail', state: 'primary'}, 3: {title: 'Direct', state: 'accent'}};
                    return '<span class="m-badge m-badge--' + t[e.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[e.Type].state + '">' + t[e.Type].title + '</span>';
                },
            }],
        }), $('#m_form_status').on('change', function () {
            e.search($(this).val().toLowerCase(), 'Status');
        }), $('#m_form_type').on('change', function () {
            e.search($(this).val().toLowerCase(), 'Type');
        }), $('#m_form_status, #m_form_type').selectpicker();
    },
};
jQuery(document).ready(function () {
    DatatableHtmlTableDemo.init();
});


var BootstrapTouchspin = {
    init: function () {
        $('#m_touchspin_1, #m_touchspin_2_1').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class  : 'btn btn-secondary',
            min             : 0,
            max             : 100,
            step            : .1,
            decimals        : 2,
            boostat         : 5,
            maxboostedstep  : 10
        }), $('#m_touchspin_2, #m_touchspin_2_2').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class  : 'btn btn-secondary',
            min             : -1e9,
            max             : 1e9,
            stepinterval    : 50,
            maxboostedstep  : 1e7,
            prefix          : '$',
        }), $('#m_touchspin_3, #m_touchspin_2_3').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class  : 'btn btn-secondary',
            min             : -1e9,
            max             : 1e9,
            stepinterval    : 50,
            maxboostedstep  : 1e7,
            postfix         : '$'
        }), $('#m_touchspin_4, #m_touchspin_2_4').TouchSpin({
            buttondown_class : 'btn btn-secondary',
            buttonup_class   : 'btn btn-secondary',
            verticalbuttons  : !0,
            verticalupclass  : 'la la-plus',
            verticaldownclass: 'la la-minus',
        }), $('#m_touchspin_5, #m_touchspin_2_5').TouchSpin({buttondown_class: 'btn btn-secondary', buttonup_class: 'btn btn-secondary', verticalbuttons: !0, verticalupclass: 'la la-angle-up', verticaldownclass: 'la la-angle-down'}), $('#m_touchspin_1_validate').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class  : 'btn btn-secondary',
            min             : -1e9,
            max             : 1e9,
            stepinterval    : 50,
            maxboostedstep  : 1e7,
            prefix          : '$',
        }), $('#m_touchspin_2_validate').TouchSpin({buttondown_class: 'btn btn-secondary', buttonup_class: 'btn btn-secondary', min: 0, max: 100, step: .1, decimals: 2, boostat: 5, maxboostedstep: 10}), $('#m_touchspin_3_validate').TouchSpin({buttondown_class: 'btn btn-secondary', buttonup_class: 'btn btn-secondary', verticalbuttons: !0, verticalupclass: 'la la-plus', verticaldownclass: 'la la-minus'});
    },
};
jQuery(document).ready(function () {
    BootstrapTouchspin.init();
});

var GoogleChartsDemo = {
    init       : function () {
        google.load("visualization", "1", {packages: ["corechart", "bar", "line"]}), google.setOnLoadCallback(function () {
            GoogleChartsDemo.runDemos()
        })
    }, runDemos: function () {
        var e, a, o;
        !function () {
            var e = new google.visualization.DataTable;
            e.addColumn("timeofday", "Time of Day"), e.addColumn("number", "Motivation Level"), e.addColumn("number", "Energy Level"), e.addRows([[{v: [8, 0, 0], f: "8 am"}, 1, .25], [{v: [9, 0, 0], f: "9 am"}, 2, .5], [{v: [10, 0, 0], f: "10 am"}, 3, 1], [{v: [11, 0, 0], f: "11 am"}, 4, 2.25], [{v: [12, 0, 0], f: "12 pm"}, 5, 2.25], [{v: [13, 0, 0], f: "1 pm"}, 6, 3], [{v: [14, 0, 0], f: "2 pm"}, 7, 4], [{v: [15, 0, 0], f: "3 pm"}, 8, 5.25], [{
                v: [16, 0, 0],
                f: "4 pm"
            }, 9, 7.5], [{v: [17, 0, 0], f: "5 pm"}, 10, 10]]);
            var a = {title: "Motivation and Energy Level Throughout the Day", focusTarget: "category", hAxis: {title: "Time of Day", format: "h:mm a", viewWindow: {min: [7, 30, 0], max: [17, 30, 0]}}, vAxis: {title: "Rating (scale of 1-10)"}};
            new google.visualization.ColumnChart(document.getElementById("m_gchart_1")).draw(e, a), new google.visualization.ColumnChart(document.getElementById("m_gchart_2")).draw(e, a)
        }(), (o = new google.visualization.DataTable).addColumn("number", "Day"), o.addColumn("number", "Guardians of the Galaxy"), o.addColumn("number", "The Avengers"), o.addColumn("number", "Transformers: Age of Extinction"), o.addRows([[1, 37.8, 80.8, 41.8], [2, 30.9, 69.5, 32.4], [3, 25.4, 57, 25.7], [4, 11.7, 18.8, 10.5], [5, 11.9, 17.6, 10.4], [6, 8.8, 13.6, 7.7], [7, 7.6, 12.3, 9.6], [8, 12.3, 29.2, 10.6], [9, 16.9, 42.9, 14.8], [10, 12.8, 30.9, 11.6], [11, 5.3, 7.9, 4.7], [12, 6.6, 8.4, 5.2], [13, 4.8, 6.3, 3.6], [14, 4.2, 6.2, 3.4]]), new google.charts.Line(document.getElementById("m_gchart_5")).draw(o, {
            chart: {
                title   : "Box Office Earnings in First Two Weeks of Opening",
                subtitle: "in millions of dollars (USD)"
            }
        }), e = google.visualization.arrayToDataTable([["Task", "Hours per Day"], ["Work", 11], ["Eat", 2], ["Commute", 2], ["Watch TV", 2], ["Sleep", 7]]), a = {title: "My Daily Activities"}, new google.visualization.PieChart(document.getElementById("m_gchart_3")).draw(e, a), a = {pieHole: .4}, new google.visualization.PieChart(document.getElementById("m_gchart_4")).draw(e, a)
    }
};
GoogleChartsDemo.init();

var BootstrapMaxlength = {
    init: function () {
        $("#m_maxlength_1").maxlength({
            warningClass     : "m-badge m-badge--warning m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_2").maxlength({
            threshold        : 5,
            warningClass     : "m-badge m-badge--danger m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_3").maxlength({
            alwaysShow       : !0,
            threshold        : 5,
            warningClass     : "m-badge m-badge--primary m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_4").maxlength({
            threshold        : 3,
            warningClass     : "m-badge m-badge--danger m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide",
            separator        : " of ",
            preText          : "You have ",
            postText         : " chars remaining.",
            validate         : !0
        });
        $("#m_maxlength_5").maxlength({
            threshold        : 5,
            warningClass     : "m-badge m-badge--primary m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_6_1").maxlength({
            alwaysShow: !0,
            threshold: 5,
            placement: "top-left",
            warningClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_6_2").maxlength({
            alwaysShow       : !0,
            threshold        : 5,
            placement        : "top-right",
            warningClass     : "m-badge m-badge--success m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_6_3").maxlength({
            alwaysShow: !0,
            threshold: 5,
            placement: "bottom-left",
            warningClass: "m-badge m-badge--warning m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        });
        $("#m_maxlength_6_4").maxlength({
            alwaysShow       : !0,
            threshold        : 5,
            placement        : "bottom-right",
            warningClass     : "m-badge m-badge--danger m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide"
        }), $("#m_maxlength_1_modal").maxlength({warningClass: "m-badge m-badge--warning m-badge--rounded m-badge--wide", limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide", appendToParent: !0}), $("#m_maxlength_2_modal").maxlength({threshold: 5, warningClass: "m-badge m-badge--danger m-badge--rounded m-badge--wide", limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide", appendToParent: !0}), $("#m_maxlength_5_modal").maxlength({
            threshold        : 5,
            warningClass     : "m-badge m-badge--primary m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--brand m-badge--rounded m-badge--wide",
            appendToParent   : !0
        });
        $("#m_maxlength_4_modal").maxlength({
            threshold: 3,
            warningClass: "m-badge m-badge--danger m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide",
            appendToParent: !0,
            separator: " of ",
            preText: "You have ",
            postText: " chars remaining.",
            validate: !0
        })
    }
};
jQuery(document).ready(function () {
    BootstrapMaxlength.init()
});
/***
Wrapper/Helper Class for datagrid based on jQuery Datatable Plugin
***/
var AjaxTable = function() {

    var tableOptions; // main options
    var dataTable; // datatable object
    var table; // actual table jquery object
    var tableContainer; // actual table container object
    var tableWrapper; // actual table wrapper jquery object
    var tableInitialized = false;
    var ajaxParams = {}; // set filter mode
    var the;
    var overlay = $('.waiting');

    return {

        //main function to initiate the module
        init: function(options) {
            if (!$().dataTable) return;

            the = this;

            // default settings
            options = $.extend(true, {
                src: "", // actual table  
                loadingMessage: '载入中...',
                dataTable: {
                    "language": {
                        "oAria": {
                            "sSortAscending":  ": 以升序排列此列",
                            "sSortDescending": ": 以降序排列此列"
                        },
                        "sEmptyTable":     "表中数据为空",
                        "sInfo":         "<span class='seperator'>|</span>显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                        "sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
                        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                        "sLengthMenu":   "<span class='seperator'>|</span>显示 _MENU_ 项结果",
                        "sSearch":       "搜索:",
                        "sProcessing":   "处理中...",
                        "sZeroRecords":  "没有匹配结果",
                        "sInfoPostFix":  "",
                        "sUrl":          "",
                        "sLoadingRecords": "载入中...",
                        "sInfoThousands":  ",",
                        "oPaginate": {
                            "sFirst":    "<i class=\"icon-control-start\"></i>",
                            "sPrevious": "<i class=\"icon-arrow-left\"></i>",
                            "sNext":     "<i class=\"icon-arrow-right\"></i>",
                            "sLast":     "<i class=\"icon-control-end\"></i>"
                        }
                    },

                    "orderCellsTop": true,
                    "autoWidth": true, 

                    "processing": false, 
                    "serverSide": true,
                    "deferRender": true,

                    "ajax": { 
                        "url": "", 
                        "contentType": "application/json",
                        "data": function(data) {
                            // padding the empty table
                            var extraHeight = $('html').height() - 40 - $('.page-content').height() - 36;

                            overlay.css({
                                display: 'block',
                                width: '100%',
                                backgroundColor: 'rgba(0, 0, 0, .02)',
                                marginTop: '-40px',
                                border: '1px solid #e7ecf1',
                                borderTop: 0,
                                height: extraHeight + 'px'
                            });

                            App.blockUI({
                                message: tableOptions.loadingMessage,
                                overlayColor: 'none',
                                target: overlay,
                                cenrerY: true,
                                boxed: true,
                            });

                            if (tableOptions.beforeAjax) 
                                tableOptions.beforeAjax.bind(the).call(the, data);

                            return the.data;
                        },
                        "dataSrc": function(res) { // Manipulate the data returned from the server
                            if ($('.group-checkable', table).size() === 1) 
                                $('.group-checkable', table).attr("checked", false);

                            if (tableOptions.onSuccess) 
                                tableOptions.onSuccess.call(undefined, the, res);

                            App.unblockUI(overlay);

                            overlay.remove();

                            return res.data;
                        },
                        "error": function() { // handle general connection errors
                            if (tableOptions.onError) 
                                tableOptions.onError.call(undefined, the);

                            App.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: "请求无法完成， 请检查网络连接是否正常",
                                container: tableWrapper,
                                place: 'prepend'
                            });

                            $('#enroll_length select').attr('disabled', true);
                            $('#enroll_filter input[type="search"').attr('disabled', true);
                        }
                    },

                    "drawCallback": function(oSettings) { // run some code on table redraw
                        if (tableInitialized === false) { // check if table has been initialized
                            tableInitialized = true; // set table initialized
                            table.show(); // display table
                        }
                        //countSelectedRecords(); // reset selected records indicator

                        // callback for ajax data load
                        if (tableOptions.onDataLoad) 
                            tableOptions.onDataLoad.call(undefined, the);
                    }
                }
            }, options);

            tableOptions = options;

            // create table's jquery object
            table = $(options.src);
            tableContainer = table.parents(".table-container");

            // apply the special class that used to restyle the default datatable
            var tmp = $.fn.dataTableExt.oStdClasses;

            $.fn.dataTableExt.oStdClasses.sWrapper = $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper";
            $.fn.dataTableExt.oStdClasses.sFilterInput = "form-control input-xs input-sm input-inline";
            $.fn.dataTableExt.oStdClasses.sLengthSelect = "form-control input-xs input-sm input-inline";

            // initialize a datatable
            dataTable = table.DataTable(options.dataTable);

            // revert back to default
            $.fn.dataTableExt.oStdClasses.sWrapper = tmp.sWrapper;
            $.fn.dataTableExt.oStdClasses.sFilterInput = tmp.sFilterInput;
            $.fn.dataTableExt.oStdClasses.sLengthSelect = tmp.sLengthSelect;

            // get table wrapper
            tableWrapper = table.parents('.dataTables_wrapper');

            // build table group actions panel
            if ($('.table-actions-wrapper', tableContainer).size() === 1) {
                $('.table-group-actions', tableWrapper).html($('.table-actions-wrapper', tableContainer).html()); // place the panel inside the wrapper
                $('.table-actions-wrapper', tableContainer).remove(); // remove the template container
            }
        },

        getSelectedRows: function() {
            var rows = [];
            $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table).each(function() {
                rows.push($(this).val());
            });

            return rows;
        },

        getDataTable: function() {
            return dataTable;
        },

        getTableWrapper: function() {
            return tableWrapper;
        },

        gettableContainer: function() {
            return tableContainer;
        },

        getTable: function() {
            return table;
        }

    };

};
var Enroll = function () {

	var initTable = function () {
		var ajaxtable = new AjaxTable();
		var enroll = $('#enroll');
		var controls = {};

		// counter
		var rows;
		var checkcount = 0;

		// 简单的表格设置
		ajaxtable.init({
			src: enroll,
			dataTable: {
				"ajax": {
                    "url": "/enroll/api/test", // 测试表单数据
                    "type": "POST", 
                    "timeout": 2000
                },
                "dom": "<'row'<'col-md-4 col-sm-12'l><'col-md-8 col-sm-12'<'row'<'col-md-10'f><'col-md-2'<'table-group-actions pull-right'>>r>>><'table-responsive't><'row'<'col-md-5'i><'col-md-7'p>>",
				"stateSave": true, // 保存表格状态到cookie
	            "lengthMenu": [
	                [14, 20, 30, 50, 100, -1],
	                [14, 20, 30, 50, 100, "All"] // change per page values here
	            ],
	            "pageLength": 14, // 表格显示页项的初始大小        
	            "pagingType": "simple_numbers",
	            "columnDefs": [
	            	{  'orderable': false, 'targets': '_all' }, 
	            	{ "searchable": false, 'targets': [0, 6, 7] },
	            	{ "type": "chinese-string", "targets": [1, 2, 4] }
	            ],
	            "order": [ [1, "asc"] ],
                "rowCallback": function (row, data, index) {
                	$(row).on('change', 'input[type="checkbox"]', function () {
                		var checked = $(this).prop('checked');

						checkcount += checked ? 1 : -1;

	                	if (checkcount == 0)
	                		controls.info.html('<i class="fa fa-exclamation"></i> 暂无人员选中');
	                	else
	                		controls.info.html('<i class="fa fa-user"></i> 选择 ' + checkcount + ' 人');
                	});
                }
	        },
	        'beforeAjax': function (data) {
	        	// json file
	        	this.data = JSON.stringify(data);
	        },
	        'onSuccess': function (grid, res) {
	        	// 初始化控制工具
	        	controls.info = $('.table-group-actions .table-selected-info');
	        },
	        'onDataLoad': function (grid) {
	        	rows = grid.getDataTable().settings()[0]._iDisplayLength;
	        	checkcount = 0;

	        	var table = grid.getTable();
	        	// handle group checkboxes check/uncheck
	            $('.group-checkable', table).change(function() {
	                var set = table.find('tbody > tr > td:nth-child(1) input[type="checkbox"]');

	                $(set).each(function() { $(this).trigger('change'); });
	            });
	        }
		});

		$('#enroll_wrapper').find('#enroll_filter').addClass('pull-right');

		enroll.find('.group-checkable').change(function () {
	        var set = jQuery(this).attr("data-set");
	        var checked = jQuery(this).is(":checked");
	        jQuery(set).each(function () {
	            if (checked) {
	                $(this).prop("checked", true);
	                $(this).parents('tr').addClass("active");
	            } else {
	                $(this).prop("checked", false);
	                $(this).parents('tr').removeClass("active");
	            }
	        });
	    });

	    enroll.on('change', 'tbody tr .checkboxes', function () {
	        $(this).parents('tr').toggleClass("active");
	    });
	};

	var initExtendModal = function () {
		// general settings
        $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
          '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
            '<div class="progress progress-striped active">' +
              '<div class="progress-bar" style="width: 100%;"></div>' +
            '</div>' +
          '</div>';

        $.fn.modalmanager.defaults.resize = true;
	};

	return {
        init: function () {

            if (!jQuery().dataTable) 
            	return;

            initTable();
            initExtendModal();
        }
    };
}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
    	$.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	});

        Enroll.init();
    });
}
//# sourceMappingURL=vendor.js.map

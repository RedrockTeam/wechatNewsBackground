var TableDatatablesManaged = function () {

    var initTable = function () {

        var table = $('#articleList');

        // begin first table
        var dataTable = table.DataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
                "sZeroRecords": "没有匹配结果",
                "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "", "sSearch": "搜索:",
                "sUrl": "", "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上页",
                    "sNext": "下页",
                    "sLast": "末页"
                },
                "oAria": {
                    "sSortAscending": ": 以升序排列此列",
                    "sSortDescending": ": 以降序排列此列"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            // "scrollY": "520px",
            "columnDefs": [ {
                    "targets": 'unorderable',
                    "orderable": false
                },
                {
                    "targets": 'unsearchable',
                    "searchable":false
                },
                {
                    "targets": 'invisible',
                    'visible': false
                }
            ],

            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "所有"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "pagingType": "bootstrap_full_number",
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        // var tableWrapper = jQuery('#sample_1_wrapper');

        table.find('.group-checkable').change(function () {
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

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
        $("#siftType").on('change', function () {
           var type = this.value;
            dataTable.columns([9]).search('');
            dataTable.columns([8]).search('');
          if (parseInt(type) > 0) {
              dataTable.columns([9]).search(type);
          } else if(parseInt(type) === 0)  {
              dataTable.columns([8]).search('2');
          }
            dataTable.draw();
        });

    };


    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            initTable();
        }

    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
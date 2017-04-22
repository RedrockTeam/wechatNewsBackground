<script >
    jQuery(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var alert = $('#table-alert');
        alert.hide();
        var dataTable = $("#articleList").DataTable();
        $(".make-switch[data-id]").on('switchChange.bootstrapSwitch', function (event, state) {
            var $this = $(this);
            var action = state === false ? 'unHot': 'hot' ;
            $.ajax({
                type: 'post',
                url: "{{URL::action('ArticleController@editState')}}",
                data: {'ids': [$this.data('id')], 'action': action},
                success: function (data) {
                    if (data['status'] === 200 || data['state'] === 200) {
                        var cell = dataTable.cell($this.parentsUntil("tr").last());
                        var state = dataTable.cell({row:cell.index()['row'],column: 9});
                        state.data(data['data'][0]['state']);
                        alert.hide();
                        dataTable.draw();
                    } else {
                        $this.bootstrapSwitch('toggleState', true);
                        alert.alert("更改失败， error info:"+data['info']);
                        alert.show();
                    }

                },
                error: function (XMLHttpRequest) {
                    $this.bootstrapSwitch('toggleState', true);
//                    alert("更改失败， error info:"+XMLHttpRequest.responseJSON['info']);
                    alert.alert("更改失败， error info:"+XMLHttpRequest.responseJSON['info']);
                    alert.show();
                }
            });
        });
        var judge = function (opreate, state) {
            state = parseInt(state);
            switch (opreate) {
                case 'delete':
                    if (state < 0) return false;
                    break;
                case 'recover':
                    if (state > 0) return false;
                    break;
                case 'hot':
                    if (state === 2) return false;
                    break;
                case 'unHot':
                    if (state !== 2) return false;
                    break;
                default:
                    return false;
            }
            return true;
        };
        $("[data-operate]").click(function () {
            var $this = $(this);
            var operate = $this.data('operate');
            var table = $($this.data('target'));
            var ids = [];
            var states = [];
            $('.checkboxes:checked',table).each(function () {
                var $this = $(this);
                var cell = dataTable.cell($this.parentsUntil("tr").last());
                var state = dataTable.cell({row:cell.index()['row'],column: 9});
                if (!judge(operate, state.data()))  return false;
                states.push(state);
                ids.push($this.val());
            });

            if (ids === [])
                alert.alert("目标为空");
            $.ajax({
                type: 'post',
                url: "{{URL::action('ArticleController@editState')}}",
                data: {'ids': ids, 'action': $this.data('operate')},
                success: function (data) {
                    if (data['status'] === 200 || data['state'] === 200) {
                        var rows = {delete:[]};
                        $.each(data.data,function (key, value) {
                            var state = states[key];
                            state.data(value.state);
                            if (value.state<0) {
                                rows.delete.push(state.index().row)
                            } else if (value.state === 1) {
                                var child = row.child(7);
                                child.find(':checkbox').bootstrapSwitch('state', true);
                            } else if (value.state === 2) {
                                var child = row.child(7);
                                child.find(':checkbox').bootstrapSwitch('state', false);
                            }
                        });
                        if (rows.delete !== [])     dataTable.rows(rows.delete).remove();
                        alert.hide();
                        dataTable.draw();
                    } else {
                        alert.alert("更改失败， error info:"+data['info']);
                        alert.show();
                    }

                },
                error: function (XMLHttpRequest) {
//                    alert("更改失败， error info:"+XMLHttpRequest.responseJSON['info']);
                    alert.alert("更改失败， error info:"+XMLHttpRequest.responseJSON['info']);
                    alert.show();
                }
            });
        });
    });
</script>
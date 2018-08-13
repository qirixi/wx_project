<div class="row">
    <div class="col-md-2">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">订单状态</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked order_navs">
                    <li class="active" order_status="10"><a ><i class="fa fa-inbox"></i> 未支付订单
                            <span class="label label-primary pull-right 10_status"></span></a></li>
                    <li order_status="20"><a ><i class="fa fa-envelope-o "></i> 未发货订单
                            <span class="label label-primary pull-right 20_status"></span></a></li>
                    <li order_status="30"><a ><i class="fa fa-file-text-o  "></i> 未签收订单
                            <span class="label label-primary pull-right 30_status"></span></a></li>
                    <li order_status="40"><a ><i class="fa fa-filter"></i> 已完成订单</a></li>
                    <li order_status="50"><a ><i class="fa fa-trash-o"></i> 已取消订单</a></li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <!-- /.col -->
    <div class="col-md-10">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">商品订单列表</h3>
            </div>
            <input type="hidden" name="order_status" id="order_status" value="10">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="order_table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>订单编号</th>
                        <th>订单金额</th>
                        <th>支付金额</th>
                        <th>创建时间</th>
                        <th>收货人</th>
                        <th>收货地址</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>订单编号</th>
                        <th>订单金额</th>
                        <th>支付金额</th>
                        <th>创建时间</th>
                        <th>收货人</th>
                        <th>收货地址</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<script>
    var order_table;
    function draw_table($status){
        if(order_table){
            order_table.destroy();
        }
        order_table = $('#order_table').DataTable({
            'serverSide': true,
            "searching": true,
            'ajax': {
                'url': "<?=base_url();?>Order/get_order_list",
                'type': 'POST',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "order_status": $status
                    } );
                }
            },
            "columns": [
                { "data": "order_sn" },
                { "data": "price" },
                { "data": "price_h" },
                { "data": "addtime" ,
                    "render": function ( data, type, row, meta ) {
                        var newDate = new Date();
                        newDate.setTime(data*1000);
                        return newDate.toLocaleString().replace(/\//g,"-");
                    }},
                { "data": "receiver" },
                { "data": "address_xq"},
                { "data": "status" },
                {
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                        return '<a href="<?=base_url()?>Order/order_info/'+data+'">详情</a>';
                    }
                }
            ]
        });
    }
    function count_status_orders(){
        $.ajax('<?=base_url();?>Order/count_status_orders', {
            method: 'POST',
            dataType:'json'
        }).done(function( response ) {
            response.forEach(function (value,key,array) {
                switch (value.status){
                    case '10':
                        $(".10_status").html(value.rows);
                        break;
                    case '20':
                        $(".20_status").html(value.rows);
                        break;
                    case '30':
                        $(".30_status").html(value.rows);
                        break;
                }
            });
        });
    }
    $(function () {
        draw_table('10');
        count_status_orders();

    });
    $("li").bind('click',function () {
        $(".order_navs li").removeClass('active');
        $(this).addClass('active');
        draw_table($(this).attr('order_status'));
        count_status_orders();
    })
</script>
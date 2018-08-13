<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> 商品订单.
                <small class="pull-right">Date: <?=date('Y-m-d H:i:s',$order_info['addtime']);?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            No.
            <address>
                <strong>订单编号：</strong>
                <?=$order_info['order_sn'];?><br>
                <strong>支付单号：</strong>
                <?=$order_info['pay_sn'];?><br>
                <strong>运单号：</strong>
                <?=$order_info['kuaidi_num'];?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            收货信息
            <address>
                <strong>收货人：</strong>
                <?=$order_info['receiver'];?><br>
                <strong>联系电话：</strong>
                <?=$order_info['tel'];?><br>
                <strong>邮编：</strong>
                <?=$order_info['code'];?><br>
                <strong>收货地址</strong><br>
                <?=$order_info['address_xq'];?><br>

            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>订单信息</b><br>
            <br>
            <b>购买时间:</b> <?=date('Y-m-d H:i:s',$order_info['addtime']);?><br>
            <b>订单状态:</b> <?=$order_info['status'];?><br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>商品规格</th>
                    <th>商品数量</th>
                    <th>商品价格</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order_details as $goods) : ?>
                <tr>
                    <td><?=$goods->pid;?></td>
                    <td><?=$goods->name;?></td>
                    <td><?=$goods->pro_guige;?></td>
                    <td><?=$goods->num;?></td>
                    <td><?=$goods->price;?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>

            <br>
            <b>支付方式:</b> <?=$order_info['type'];?><br>
            <b>交易单号:</b> <?=$order_info['trade_no'];?><br>


            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                订单备注：<?=$order_info['remark'];?><br>
            </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead">交易日期 <?=date('Y-m-d H:i:s',$order_info['pay_time']);?></p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">价格:</th>
                        <td><?=$order_info['price'];?></td>
                    </tr>
                    <tr>
                        <th>运费信息</th>
                        <td><?=$order_info['post_remark'];?></td>
                    </tr>
                    <tr>
                        <th>实际支付金额:</th>
                        <td><?=$order_info['price_h'];?></td>
                    </tr>

                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <?php if($order_info['back']!='0') :?>
    <div class="row">
        <div class="col-xs-6">
            <p class="lead">退款信息</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">退款原因:</th>
                        <td><?=$order_info['back_remark'];?></td>
                    </tr>
                    <tr>
                        <th>发起退款时间</th>
                        <td><?=$order_info['back_addtime'];?></td>
                    </tr>
                    <tr>
                        <th>退款状态</th>
                        <td><?=$order_info['back'];?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php endif;?>
    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="<?=base_url()?>Order/index" class="btn btn-info pull-right"><i class="fa fa-credit-card"></i> 返回
            </a>

            <?php  if($order_info['status']=='20') : ?>
            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> 发货
            </button>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- /.content -->
<div class="clearfix"></div>
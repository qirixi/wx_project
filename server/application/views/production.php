<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Bordered Table</h3>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary btn-sm" href="<?=base_url();?>Production/add_form">添加</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>图片</th>
                        <th>ID</th>
                        <th>产品名称</th>
                        <th>产品编号</th>
                        <th>广告语</th>
                        <th>价格</th>
                        <th>优惠价格</th>
                        <th>分类</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                    <?php
                    //var_dump($cate_array);
                    foreach ($goods_list as $row){
                        echo "<tr>";
                        echo "<td><img style='height: 30px;width: 30px;' src='".$row->photo_x."'></td>";
                        echo "<td>".$row->id."</td>";
                        echo "<td>".$row->name."</td>";
                        echo "<td>".$row->pro_number."</td>";
                        echo "<td>".$row->intro."</td>";
                        echo "<td>".$row->price."</td>";
                        echo "<td>".$row->price_yh."</td>";
                        echo "<td>".(array_key_exists($row->id,$cate_array) ? $cate_array[$row->id] : $row->cid)."</td>";
                        echo "<td>".date('Y-m-d H:i:s',$row->addtime)."</td>";
                        echo "<td><a href='".base_url()."Production/edit_form/".$row->id."'>编辑</a>/<a href='".base_url()."Production/delete_item/".$row->id."'>删除</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

                <ul class="pagination pagination-sm no-margin pull-right">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>

            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.row -->
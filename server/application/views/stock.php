<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Bordered Table</h3>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary btn-sm" href="<?=base_url();?>Stock/add_form">添加</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>产品名称</th>
                        <th>产品编号</th>
                        <th>规格名称</th>
                        <th>价格</th>
                        <th>库存</th>
                        <th>添加时间</th>
                    </tr>
                    <?php
                    //var_dump($cate_array);
                    foreach ($stock_list as $row){
                        echo "<tr>";
                        echo "<td>".$row->id."</td>";
                        echo "<td>".$row->p_name."</td>";
                        echo "<td>".$row->pro_number."</td>";
                        echo "<td>".$row->name."</td>";
                        echo "<td>".$row->price."</td>";
                        echo "<td>".$row->stock."</td>";
                        echo "<td>".date('Y-m-d H:i:s',$row->addtime)."</td>";
                        echo "<td><a href='".base_url()."Stock/edit_form/".$row->id."'>编辑</a>/<a href='".base_url()."Stock/delete_item/".$row->id."'>删除</a></td>";
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
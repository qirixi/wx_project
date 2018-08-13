<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Bordered Table</h3>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary btn-sm" href="<?=base_url();?>Categories/add_form">添加</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>父ID</th>
                        <th>栏目名称</th>
                        <th>排序</th>
                        <th style="width: 40px">添加时间</th>
                        <th style="width: 40px">操作</th>
                    </tr>
                    <?php
                    foreach ($cate_list as $row){
                        echo "<tr>";
                        echo "<td>".$row->id."</td>";
                        echo "<td>".$row->tid."</td>";
                        echo "<td>".$row->name."</td>";
                        echo "<td>".$row->sort."</td>";
                        echo "<td>".date('Y-m-d H:i:s',$row->addtime)."</td>";
                        echo "<td><a href='".base_url()."Categories/edit_form/".$row->id."'>编辑</a>/<a href='".base_url()."Categories/delete_item/".$row->id."'>删除</a></td>";
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
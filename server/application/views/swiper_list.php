<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Table</h3>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary btn-sm" href="<?=base_url();?>Swiper/add_form">添加</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>图片URL</th>
                        <th>图片</th>
                        <th>操作</th>
                    </tr>
                    <?php
                    foreach ($img_list as $row){
                        echo "<tr>";
                        echo "<td>".$row->id."</td>";
                        echo "<td>".$row->img_url."</td>";
                        echo "<td><img style='height: 30px;width: 30px;' src='".$row->img_url."'></td>";
                        echo "<td><a href='".base_url()."Swiper/delete_item/".$row->id."'>删除</a></td>";
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
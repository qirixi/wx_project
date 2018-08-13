<div class="row">

    <div class="col-md-12">

        <!-- general form elements disabled -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">详细信息</h3>
            </div>
            <form role="form" method="post" action="<?=base_url().$form_action;?>" enctype="multipart/form-data">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label>上传图片</label>
                        <input type="hidden" value="" name="photo_string" class="photo_string">
                        <iframe id="iframe" width="100%" height="480px" frameborder="0" src="<?=base_url();?>Production/picGroup_frame" sameless></iframe>
                        <script type="application/javascript">
                            function push_value($value) {
                                var cur_list = $(".photo_string").val();
                                var list = [];
                                if(cur_list!=""){
                                    list = cur_list.split(',');
                                }
                                list.push($value);
                                $(".photo_string").val(list.toString());
                            }
                        </script>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>


        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
<!-- /.row -->
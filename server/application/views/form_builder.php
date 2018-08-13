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

                <?php
                $this->load->helper('form');
                foreach ($field_list as $row){
                    switch ($row['type']){
                        case "input":
                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            $field_data = array(
                                'name'      => $row['name'],
                                'id'        => $row['name'],
                                'value'     => $row['default_value'],
                                'class'     => "form-control"
                            );
                            if(isset($row['readonly'])&&$row['readonly']) $field_data['readonly'] = "true";
                            if(isset($row['required'])&&$row['required']) $field_data['required'] = "true";

                            echo form_input($field_data);
                            echo "</div>";
                            break;
                        case "number":
                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            $field_data = array(
                                'name'      => $row['name'],
                                'id'        => $row['name'],
                                'type'      => 'number',
                                'value'     => $row['default_value'],
                                'class'     => "form-control"
                            );
                            if(isset($row['readonly'])&&$row['readonly']) $field_data['readonly'] = "true";
                            if(isset($row['required'])&&$row['required']) $field_data['required'] = "true";

                            echo form_input($field_data);
                            echo "</div>";
                            break;
                        case "select":
                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            $field_data = array(
                                'id'        => $row['name'],
                                'class'     => "form-control"
                            );
                            if(isset($row['readonly'])&&$row['readonly']) $field_data['readonly'] = "true";
                            if(isset($row['required'])&&$row['required']) $field_data['required'] = "true";

                            echo form_dropdown($row['name'], $row['option'], $row['default_value'],$field_data);
                            echo "</div>";
                            break;
                        case "file":
                            if(isset($row['default_value'])&&!empty($row['default_value'])){
                                echo " <div class=\"form-group\">";
                                echo "<label>".$row['label']."（原）</label>";
                                echo "<img src='".$row['default_value']."' class='img-responsive pad' style='height:150px;weight:150px;'>";
                                echo "</div>";
                            }
                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            $field_data = array(
                                'id'        => $row['name'],
                                'name'      => $row['name']
                            );
                            if(isset($row['required'])&&$row['required']) $field_data['required'] = "true";
                            echo form_upload($field_data);
                            echo "</div>";
                            break;
                        case 'textarea':
                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            $field_data = array(
                                'id'        => $row['name'],
                                'name'      => $row['name'],
                                'value'     => $row['default_value'],
                            );
                            if(isset($row['required'])&&$row['required']) $field_data['required'] = "true";
                            echo form_textarea($field_data);
                            ?>
                            <script type="application/javascript">
                                $(function () {
                                    CKEDITOR.replace('<?=$row['name'];?>');
                                });
                            </script>
                    <?php
                            echo "</div>";
                            break;
                        case 'picGroup':
                            if(isset($row['default_value'])&&!empty($row['default_value'])){
                                echo " <div class=\"form-group\">";
                                echo "<label>".$row['label']."（原）</label>";
                                echo "<div class='row'>";
                                $img_list = explode(',',$row['default_value']);
                                foreach ($img_list as $img_item){
                                    ?>
                                    <div class="image_box col-lg-3 col-xs-6" style="border-color: #aaa;border: 1px;">
                                        <img class="img-responsive" src="<?=$img_item;?>" style="width: 100%;height: 100%;">
                                        <div style="position: absolute;top: 10px;right: 20px;z-index: 50;">
                                            <button class="btn btn-lg btn-box-tool" type="button" onclick="javascript:remove_img_box(this);"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>

                                    <script type="application/javascript">
                                        function remove_img_box($obj) {
                                            var img_box = $($obj).parents('.image_box');
                                            var img_url = img_box.find('img').attr('src');
                                            var cur_list = $(".<?=$row['name'];?>").val();
                                            var list = cur_list.split(',');
                                            list=$.grep(list,function(n,i){
                                                return n!=img_url;
                                            });

                                            $(".<?=$row['name'];?>").val(list.toString());
                                            img_box.remove();

                                        }
                                    </script>
                                <?php
                                }
                                   echo "</div></div>";
                            }

                            echo " <div class=\"form-group\">";
                            echo "<label>".$row['label']."</label>";
                            ?>

                        <!--dom结构部分-->
                            <input type="hidden" value="<?=$row['default_value'];?>" name="<?=$row['name'];?>" class="<?=$row['name'];?>">
                            <iframe id="iframe" width="100%" height="480px" frameborder="0" src="<?=base_url();?>Production/picGroup_frame" sameless></iframe>
                            <script type="application/javascript">
                                function push_value($value) {
                                    var cur_list = $(".<?=$row['name'];?>").val();
                                    var list = [];
                                    if(cur_list!=""){
                                        list = cur_list.split(',');
                                    }
                                    list.push($value);
                                    $(".<?=$row['name'];?>").val(list.toString());
                                }
                            </script>
                    <?php
                            echo "</div>";
                            break;
                    }

                }
                ?>

                </div>
                <!-- /.box-body -->
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
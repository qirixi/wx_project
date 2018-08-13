<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>myUploader</title>
    <!-- webuploader -->
    <link rel="stylesheet" href="<?=base_url();?>plugins/webuploader/webuploader.css">
    <link rel="stylesheet" href="<?=base_url();?>plugins/webuploader/css/style.css">

</head>
<body onload="">
<div id="wrapper">
    <div id="container">
        <!--头部，相册选择和格式选择-->
        <div id="uploader">
            <div class="queueList">
                <div id="dndArea" class="placeholder">
                    <div id="filePicker"></div>
                </div>
            </div>
            <div class="statusBar" style="display:none;">
                <div class="progress">
                    <span class="text">0%</span>
                    <span class="percentage"></span>
                </div><div class="info"></div>
                <div class="btns">
                    <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="<?=base_url();?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- webuploader -->
<script type="text/javascript" src="<?=base_url();?>plugins/webuploader/webuploader.js"></script>
<!-- webuploader -->
<script type="text/javascript" src="<?=base_url();?>plugins/webuploader/upload.js"></script>

<script type="text/javascript">

</script>
</body>
</html>
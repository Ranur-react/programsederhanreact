    <link rel="stylesheet" href="<?= assets() ?>plugins/jquery-fancyfileuploader-master/fancy-file-uploader/fancy_fileupload.css">
    <script type="text/javascript" src="<?= assets() ?>plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.ui.widget.js"></script>
    <script src="<?= assets() ?>plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.fileupload.js"></script>
    <script src="<?= assets() ?>plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.iframe-transport.js"></script>
    <script src="<?= assets() ?>plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.fancy-fileupload.js"></script>


                     



<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<div class="modal fade" id="modal_browse">
    <div class="modal-dialog <?= $modallg == 1 ? 'modal-lg' : '' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= $name ?></h4>
            </div>
            <div class="modal-body">

                 <input id="demo" type="hidden" name="files"  accept=".jpg, .png, image/jpeg, image/png" multiple>
                 <div class="tampil">
                 	
                 </div>

            </div>

        </div>
    </div>
</div>


    <script type="text/javascript">
$(function() {
  $('#demo').FancyFileUpload({
    params : {
      action : 'fileuploader'
    },
    // edit:false,
    maxfilesize : 5.943e+6,
    // 'startupload' : function(SubmitUpload, e, data){
   //  	console.log(data)
   //  	            $.ajax({
   //              url: "<?= site_url('insert') ?>",
   //              dataType: 'json',
   //              success: function(json) {
   //              	console.log(json);
   //              }
   //          });
	  // }
  });

});
</script>
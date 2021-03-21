<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<div class="modal fade" id="modal_create">
    <div class="modal-dialog <?= $modallg == 1 ? 'modal-lg' : '' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= $name ?></h4>
            </div>
            <?php if ($multipart == 1) :
                echo form_open_multipart($post, ['class' => $class]);
            else :
                echo form_open($post, ['class' => $class]);
            endif; ?>
            <div class="modal-body">
                <?= $body ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success store_data" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-cross2"></i> Batal</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
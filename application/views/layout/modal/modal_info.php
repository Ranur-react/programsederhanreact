<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<div class="modal fade" id="modal_alert">
    <div class="modal-dialog <?= $modallg == 1 ? 'modal-lg' : '' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= $name ?></h4>
            </div>
            <div class="modal-body">
                <?= $body ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-cross2"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
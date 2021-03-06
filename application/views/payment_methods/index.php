<div id="page-content" class="p20 row">
    <div class="col-sm-3 col-lg-2">
        <?php
        $tab_view['active_tab'] = "payment_methods";
        $this->load->view("settings/tabs", $tab_view);
        ?>
    </div>

    <div class="col-sm-9 col-lg-10">
        <div class="panel panel-default">
            <div class="page-title clearfix">
                <h1> <?php echo lang('payment_methods'); ?></h1>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("payment_methods/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_payment_method'), array("class" => "btn btn-default", "title" => lang('add_payment_method'))); ?>
                </div>
            </div>
            <div class="table-responsive">
                <table id="payment-method-table" class="display" cellspacing="0" width="100%">            
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#payment-method-table").appTable({
            source: '<?php echo_uri("payment_methods/list_data") ?>',
            columns: [
                {title: '<?php echo lang("name"); ?>'},
                {title: '<?php echo lang("description"); ?>'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ]
        });
    });
</script>
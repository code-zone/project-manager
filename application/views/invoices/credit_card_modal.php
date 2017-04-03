<?php echo form_open(get_uri("invoice_payments/save_payment"), array("id" => "invoice-payment-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="payment-errors alert alert-warning" role="alert" style="display: none">
       
    </div>
    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
    <div class="form-group">
        <label for="client_name" class=" col-md-3">Enter Credit Card Details</label>
        <div class="col-md-9">
            <input type="text" data-stripe="name" class="form-control" placeholder="Card Holder Name">
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_payment_date" class=" col-md-3"></label>
        <div class="col-md-9">
            <input type="text" data-stripe="number" class="form-control" placeholder="Credit Card Number">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-3">
            
        </div>
        <div class="col-sm-3 form-group">
            <input type="text" data-stripe="cvc" class="form-control" placeholder="CVC">
        </div>
        <div class="col-sm-3 form-group">
            <input type="text" data-stripe="exp-month" class="form-control" placeholder="Month">
        </div>
        <div class="col-sm-3 form-group">
            <input type="text" data-stripe="exp-year" class="form-control" placeholder="Year">
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_payment_amount" class=" col-md-3"><?php echo lang('amount'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_payment_amount",
                "data-stripe" => "amount",
                "value" => $model_info->balance_due ? to_decimal_format($model_info->balance_due) : "",
                "class" => "form-control",
                "placeholder" => lang('amount'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>

        </div>
    </div>
</div>

<div class="modal-footer">
<div class="pull-left">
    <img width="30" src="<?=get_file_uri(get_setting("system_file_path")."visa.png")?>">
    <img width="30" src="<?=get_file_uri(get_setting("system_file_path")."payment_american.png")?>">
    <img width="30" src="<?=get_file_uri(get_setting("system_file_path")."payment_discover.png")?>">
    <img width="30" src="<?=get_file_uri(get_setting("system_file_path")."payment_maestro.png")?>">
    <img width="30" src="<?=get_file_uri(get_setting("system_file_path")."mastercard.png")?>">
</div>
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="submit btn btn-info"><span class="fa fa-credit-card"></span> <?php echo lang('process_payment'); ?></button>
</div>
<?php echo form_close(); ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $("#invoice-payment-form").on('submit', function(event) {
            Stripe.setPublishableKey('pk_test_RzAQ6ebvVyF983xyyTMmTRqZ');
            var $form = $('#invoice-payment-form');
                // Disable the submit button to prevent repeated clicks:
                $form.find('.submit').prop('disabled', true);

                // Request a token from Stripe:
                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from being submitted:
                return false;
            });
            function stripeResponseHandler(status, response) {
                      // Grab the form:
                      var $form = $('#invoice-payment-form');

                      if (response.error) { // Problem!

                        // Show the errors on the form:
                        $form.find('.payment-errors').text(response.error.message);
                        $form.find('.payment-errors').show();
                        $form.find('.submit').prop('disabled', false); // Re-enable submission

                      } else { // Token was created!

                        // Get the token ID:
                        var token = response.id;
                        $form.find('.payment-errors').hide();
                        // Insert the token ID into the form so it gets submitted to the server:
                        $form.append($('<input type="hidden" name="stripeToken">').val(token));
                        $form.appForm({
                            onSuccess: function(result) {
                                $("#invoice-payment-table").appTable({newData: result.data, dataId: result.id});
                                $("#invoice-total-section").html(result.invoice_total_view);
                                if (typeof updateInvoiceStatusBar == 'function') {
                                     updateInvoiceStatusBar(result.invoice_id);
                                }
                            }
                        });
                      }
                    };
            
        $("#invoice-payment-form .select2").select2();
        $("#invoice_payment_date").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });

    });
</script>
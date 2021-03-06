<?php echo form_open(get_uri("events/save"), array("id" => "event-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "value" => $model_info->title,
                "class" => "form-control",
                "placeholder" => lang('title'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class=" col-md-3"><?php echo lang('description'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => $model_info->description,
                "class" => "form-control",
                "placeholder" => lang('description'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>

    <div class="clearfix">
        <label for="start_date" class=" col-md-3 col-sm-3"><?php echo lang('start_date'); ?></label>
        <div class="col-md-4 col-sm-4 form-group">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => $model_info->start_date,
                "class" => "form-control",
                "placeholder" => lang('start_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
        <label for="start_time" class=" col-md-2 col-sm-2"><?php echo lang('start_time'); ?></label>
        <div class=" col-md-3 col-sm-3">
            <?php
            echo form_input(array(
                "id" => "start_time",
                "name" => "start_time",
                "value" => $model_info->start_time*1 ? convert_time_to_12hours_format($model_info->start_time) : "",
                "class" => "form-control",
                "placeholder" => lang('start_time')
            ));
            ?>
        </div>
    </div>


    <div class="clearfix">
        <label for="end_date" class=" col-md-3 col-sm-3"><?php echo lang('end_date'); ?></label>
        <div class=" col-md-4 col-sm-4 form-group">
            <?php
            echo form_input(array(
                "id" => "end_date",
                "name" => "end_date",
                "value" => $model_info->end_date,
                "class" => "form-control",
                "placeholder" => lang('end_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#start_date",
                "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
        <label for="end_time" class=" col-md-2 col-sm-2"><?php echo lang('end_time'); ?></label>
        <div class=" col-md-3 col-sm-3">
            <?php
            echo form_input(array(
                "id" => "end_time",
                "name" => "end_time",
                "value" => $model_info->end_time*1 ? convert_time_to_12hours_format($model_info->end_time) : "",
                "class" => "form-control",
                "placeholder" => lang('end_time')
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="location" class=" col-md-3"><?php echo lang('location'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "location",
                "name" => "location",
                "value" => $model_info->location,
                "class" => "form-control",
                "placeholder" => lang('location'),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="location" class=" col-md-3"></label>
        <div class="color-palet col-md-9">
            <?php
            $selected_color = $model_info->color ? $model_info->color : "#83c340";
            $colors = array("#83c340", "#29c2c2", "#2d9cdb", "#aab7b7", "#f1c40f", "#e18a00", "#e74c3c", "#d43480", "#ad159e", "#34495e", "#dbadff");
            foreach ($colors as $color) {
                $active_class = "";
                if ($selected_color === $color) {
                    $active_class = "active";
                }
                echo "<span style='background-color:" . $color . "' class='color-tag clickable mr15 " . $active_class . "' data-color='" . $color . "'></span>";
            }
            ?> 
            <input id="color" type="hidden" name="color" value="<?php echo $selected_color; ?>" />
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#event-form").appForm({
            onSuccess: function(result) {
                $("#event-calendar").fullCalendar('refetchEvents');
            }
        });
        $("#start_date, #end_date").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });

        $("#start_time, #end_time").timepicker({
            defaultTime: "",
            appendWidgetTo: "#ajaxModal"
        });

        $(".color-palet span").click(function() {
            $(".color-palet").find(".active").removeClass("active");
            $(this).addClass("active");
            $("#color").val($(this).attr("data-color"));
        });

        $("#title").focus();
    });
</script>
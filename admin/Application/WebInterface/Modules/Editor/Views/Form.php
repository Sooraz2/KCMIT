<?php
/*
 *
 * @var $MessageTemplates \WebInterface\Models\MessageTemplates
 *
 * */
?>

<form action="<?php echo BASE_URL; ?>MessageTemplates/UpdateTemplate" method="post" class="form-horizontal"
      id="MessageTemplates">
    <input type="hidden" name="id" value="<?php echo $MessageTemplates->id; ?>" id="id">
    <input type="hidden" name="MessageTemplatesFormToken" value="<?php echo $formToken; ?>" />

    <div class="form-group">
        <div class="col-sm-12">
            <label class="control-label"><?php echo $Language->translate("Template") ; ?>:
                <?php if($MessageTemplates->message_type=="1"): echo $Language->translate("Standard message");endif; ?>
                <?php if($MessageTemplates->message_type=="2"): echo $Language->translate("Balance receiving error"); endif; ?>
                <?php if($MessageTemplates->message_type=="3"): echo $Language->translate("The Service is unavailable for the number"); endif; ?>
                <?php if($MessageTemplates->message_type=="4"): echo $Language->translate("No suitable teasers"); endif; ?>
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            <label><?php echo $Language->translate("Message Type") ; ?></label>
        </div>
        <div class="col-sm-8">
            <select name="message_type" class="form-control" id="MessageType">
                <option value="1"
                        <?php if($MessageTemplates->message_type=="1"): ?>selected<?php endif; ?>><?php echo  $Language->translate("Standard message") ; ?></option>
                <option value="2"
                        <?php if($MessageTemplates->message_type=="2"): ?>selected<?php endif; ?>><?php echo $Language->translate("Balance receiving error") ; ?></option>
                <option value="3"
                        <?php if($MessageTemplates->message_type=="3"): ?>selected<?php endif; ?>><?php echo $Language->translate("The Service is unavailable for the number") ; ?></option>
                <option value="4"
                        <?php if($MessageTemplates->message_type=="4"): ?>selected<?php endif; ?>><?php echo $Language->translate("No suitable teasers") ; ?></option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            <label><?php echo $Language->translate("Language") ; ?></label>
        </div>
        <div class="col-sm-8">
            <select name="lang" id="Lang" class="form-control">
                <?php if($Config->MessageTemplates->English==1): ?>

                    <option value="1" <?php if($MessageTemplates->lang=="1"): ?>selected<?php endif; ?>><?php echo  $Language->English ; ?></option>

                <?php endif; ?>

                <?php if($Config->MessageTemplates->French==1): ?>

                    <option value="4" <?php if($MessageTemplates->lang=="4"): ?>selected <?php endif; ?>><?php echo  $Language->translate("French") ; ?></option>

                <?php endif; ?>

                <?php if($Config->MessageTemplates->Georgian==1): ?>

                    <option value="4" <?php if($MessageTemplates->lang=="4"): ?>selected <?php endif; ?>>Georgian</option>

                <?php endif; ?>

                <?php if($Config->MessageTemplates->Russian==1): ?>

                    <option value="2" <?php if($MessageTemplates->lang=="2"): ?>selected <?php endif; ?>><?php echo  $Language->translate("Russian") ; ?></option>

                <?php endif; ?>

                <?php if($Config->MessageTemplates->Tajik==1): ?>

                    <option value="4" <?php if($MessageTemplates->lang=="5"): ?>selected <?php endif; ?>>Tajik</option>

                <?php endif; ?>
                <?php if($Config->MessageTemplates->Uzbek==1): ?>

                    <option value="6" <?php if($MessageTemplates->lang=="6"): ?>selected <?php endif; ?>><?php echo  $Language->translate("Uzbek") ; ?></option>

                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <textarea id="Template" name="template" class="validate[required,custom[CyrillicValidation]]" class="form-control"
                      style="width:100%;height:120px;"><?php echo $MessageTemplates->template; ?></textarea>
        </div>
    </div>

    <input type="hidden" name="MessageTemplatesSubmit" value="<?php echo $Language->translate($saveOrUpdate) ; ?>"/>

    <div class="form-group pull-right">
        <div class="col-sm-12 dialog-button">
            <input type="submit" name="Submitx" value="<?php echo $Language->translate($saveOrUpdate) ; ?>"
                   class="btn btn-rounded btn-success">
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function () {
        $('#MessageTemplates').validationEngine();
    });
</script>
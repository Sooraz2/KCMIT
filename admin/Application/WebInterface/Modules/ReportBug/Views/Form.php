<?php
/**
 * @var $Language \Language\English\English
 * */
?>
<form action="<?php echo BASE_URL ?>ReportBug" method="POST" id="reportBugsForm" enctype="multipart/form-data">

    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="first_name" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("First Name") ?>:</label>

        <input type="text" name="FirstName" id="first_name" class="form-control validate[required]"/>

    </div>

    <div class="clearfix"></div>

    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="email" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Email") ?>:</label>

        <input type="email" name="Email" id="email" class="form-control validate[required,custom[email]]"/>

    </div>

    <div class="clearfix"></div>

    <?php


    ?>
    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="PageName"><span style="color: red">* </span><?php echo  $Language->translate("Page Name") ?>:</label>
        <select name="PageName" id="PageName" class="form-control">
            <?php if ($Config->Pages->ActiveTeasers == 1): ?>
                <option value="Active Teasers"><?php echo  $Language->translate("Active Teasers") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->TeaserManagement == 1): ?>
                <option value="Teaser Management"><?php echo  $Language->translate("Teaser Management") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->BroadcastingCalendar == 1): ?>
                <option value="BroadCasting Calendar"><?php echo  $Language->translate("BroadCasting Calendar") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->ArchiveTeaser == 1): ?>
                <option value="Archive Teaser"><?php echo  $Language->translate("Archive Teaser") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->AllocationCriteria == 1): ?>
                <option value="Allocation Criteria"><?php echo  $Language->translate("Allocation Criteria") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->InteractivityActivation == 1): ?>
                <option value="Interactivity Activation"><?php echo  $Language->translate("Interactivity Activation") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->Blacklist == 1): ?>
                <option value="Blacklist"><?php echo  $Language->translate("Blacklist") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->Statistics == 1): ?>
                <option value="Statistics"><?php echo  $Language->translate("Statistics") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->SubscriberList == 1): ?>
                <option value="Subscriber List"><?php echo  $Language->translate("SubscriberList") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->MessageTemplates == 1): ?>
                <option value="Message Templates "><?php echo  $Language->translate("MessageTemplates") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->UserManagement == 1): ?>
                <option value="UserManagement"><?php echo  $Language->translate("UserManagement") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->MenuControl == 1): ?>
                <option value="Menu Control"><?php echo  $Language->translate("MenuControl") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->Monitoring == 1): ?>
                <option value="Monitoring"><?php echo  $Language->translate("Monitoring") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->USSDEmulator == 1): ?>
                <option value="USSD Emulator"><?php echo  $Language->translate("USSDEmulator") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->CustomerCare == 1): ?>
                <option value="Customer Care"><?php echo  $Language->translate("CustomerCare") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->GeneralStatistics == 1): ?>
                <option value="General Statistics"><?php echo  $Language->translate("General Statistics") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->DetailedStatistics == 1): ?>
                <option value="Detailed Statistics"><?php echo  $Language->translate("Detailed Statistics") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->XmlLog == 1): ?>
                <option value="Xml Log "><?php echo  $Language->translate("Xml Log") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->Logs == 1): ?>
                <option value="Logs"><?php echo  $Language->translate("Logs") ?></option>

            <?php endif; ?>
            <?php if ($Config->Pages->MenuManagement == 1): ?>
                <option value="Menu Management"><?php echo  $Language->translate("Menu Management") ?></option>

            <?php endif; ?>


        </select>
    </div>

    <div class="clearfix"></div>

    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="$LanguageVersion"><span
              style="color: red">* </span><?php echo $Language->translate("Language Version") ?>
            :</label>
        <select name="LanguageVersion" id="LanguageVersion" class="form-control">
            <?php if ($Config->InterfaceLanguage->Russian == 1): ?>

                <option value="Russian"
                        <?php if (isset($_COOKIE["Balance_Plus_BY_Language"]) && $_COOKIE["Balance_Plus_BY_Language"] == "Russian"): ?>selected <?php endif; ?>>
                    <?php echo $Language->translate("Russian") ?>
                </option>

            <?php endif; ?>

            <?php if ($Config->InterfaceLanguage->English == 1): ?>

                <option value="English"
                        <?php if (isset($_COOKIE["Balance_Plus_BY_Language"]) && $_COOKIE["Balance_Plus_BY_Language"] == "English"): ?>selected <?php endif; ?>>
                      <?php echo $Language->English; ?>
                </option>

            <?php endif; ?>
            <?php if ($Config->InterfaceLanguage->French == 1): ?>

                <option value="French"
                        <?php if (isset($_COOKIE["Balance_Plus_BY_Language"]) && $_COOKIE["Balance_Plus_BY_Language"] == "French"): ?>selected <?php endif; ?>>
                    French
                </option>

            <?php endif; ?>
        </select>
    </div>
    <div class="clearfix"></div>


    <div class="form-group">
        <label for="Subject" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Subject") ?>:</label>

        <div style="font-size: 11px;"
             class="clearfix"><?php echo $Language->translate("A one-line description used as the subject line on related issue (100 characters max).") ?></div>
        <textarea type="text" name="Subject" class="form-control validate[required]" data-prompt-position="topLeft:0"  id="Subject" rows="1"></textarea>

    </div>

    <div class="form-group">
        <label for="Steps" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Steps") ?>:</label>

        <div style="font-size: 11px;"
             class="clearfix"><?php echo $Language->translate("Please provide a series of concise steps of how to duplicate the issue.") ?></div>
        <textarea type="text" name="Steps" class="form-control" id="Steps" rows="5"></textarea>

    </div>

    <div class="form-group">
        <label for="DesiredBehaviour" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Desired Behaviour") ?>:</label>

        <div style="font-size: 11px;"
             class="clearfix"><?php echo $Language->translate("What is the expected or desired behaviour?") ?></div>
        <textarea type="text" name="DesiredBehaviour" class="form-control validate[required]" data-prompt-position="topLeft:0"  id="DesiredBehaviour" rows="1"></textarea>

    </div>
    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="CanDuplicate" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Can Duplicate") ?>:</label>

        <div style="font-size: 11px;"
             class="clearfix"><?php echo $Language->translate("Can you duplicate this issue in a sample project?") ?></div>
        <select name="CanDuplicate" id="CanDuplicate" class="form-control">
            <option value="<?php echo $Language->translate("Yes"); ?>"><?php echo $Language->translate("Yes"); ?></option>
            <option value="<?php echo $Language->translate("No"); ?>"><?php echo $Language->translate("No"); ?></option>
        </select>

    </div>

    <div class="form-group col-sm-6" style="padding-left: 0px">
        <label for="Frequency" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Frequency") ?>:</label>

        <div style="font-size: 11px;"
             class="clearfix"><?php echo $Language->translate("How often does the problem occur?") ?></div>
        <select name="Frequency" id="Frequency" class="form-control">
            <option value="<?php echo $Language->translate("Sometimes"); ?>"><?php echo $Language->translate("Sometimes"); ?></option>
            <option value="<?php echo $Language->translate("Always"); ?>"><?php echo $Language->translate("Always"); ?></option>
        </select>

    </div>

    <div class="form-group">


        <label for="AttachFile" style="margin-bottom: 0px"><span
              style="color: red">* </span><?php echo $Language->translate("Attach File") ?>:</label>


        <div class="clearfix"></div>


        <div style="font-size: 11px"
             class="clearfix"></div>

        <input type="hidden" name="importProperties" id="importProperties">

        <input type="file" name="AttachFile" class="filestyle" data-classbutton="btn btn-info" data-input="false"
               data-classicon="icon-plus" id="AttachFile" tabindex="-1"
               style="position: absolute; clip: rect(0px 0px 0px 0px);">

        <div class="bootstrap-filestyle" id="AttachFileBlock" style="display: inline-block"><span
              class="group-span-filestyle input-group-btn"
              tabindex="0"><label for="filestyle-0"
                                  class="btn btn-info "><span
                      class="glyphicon glyphicon-folder-open"
                      style="padding-right:5px;"></span> <?php echo $Language->translate("Select a File") ?>
                </label></span></div>


        <div class="clearfix"></div>


    </div>

    <div class="form-group">

        <input type="submit" name="Submit" id="Submit" class="btn btn-success"
               value="<?php echo $Language->translate("Submit") ?>">
        <input type="hidden" name="redirectUrl" id="redirectUrl" value="<?php echo $redirectUrl ?>">

    </div>


</form>

<script src="<?php echo BASE_URL; ?>includes/scripts/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('#reportBugsForm').validationEngine();

        var mask = "<?php echo  $Language->translate("Steps to reproduce bug") ?>:\n1.\n2.\n3.\n<?php echo  $Language->translate("Results") ?>:";

        $("#Steps").val(mask);

        $('#AttachFileBlock').on('click', function () {
            $(this).prev('input[type="file"]').trigger('click');
        });
        $('#AttachFile').on('click', function () {

            $(this).next('#AttachFileBlock').find('label .badge').remove();
            $(this).val('');
        });
        $('#AttachFile').on('change', function () {

            var val = $(this).val();
            if (val !== undefined && val != '') {

                $(this).next('#AttachFileBlock').find('label .badge').remove();
                $(this).next('#AttachFileBlock').find('label').append(' <span class="badge">1</span>');

            }
        });
    });


</script>
<?php
/**
 *
 * @var $Language \Language\English\English
 */

$baseUrl = BASE_URL;

$Breadcrumb = "<li><a href='{$baseUrl}MessageTemplates'>{$Language->translate('Home')}</a></li>
<li class='active'>{$Language->translate('Message Templates')}</li>";

$PageTitle = $Language->translate('Message Templates');

$PageLeftHeader = "";

include_once SHARED_VIEW . "base.php";

?>
    <div class="content-wrapper">
        <div class="page-header">
            <div>
                <button type="button" class="btn btn-rounded btn-success"
                        onclick='showAddNewForm("<?php echo $Language->translate("Add Message Template"); ?>","<?php echo BASE_URL; ?>MessageTemplates/Form",500,300)'>
                    <small class="glyphicon glyphicon-plus-sign"></small>
                    <?php echo $Language->translate("Add new template"); ?>
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        <table id="MessageTemplates_list" class="table table-bordered">
            <thead>
            <tr>
                <th><a class="table-header" field-name="message_type"><?php echo $Language->translate("Type"); ?></a></th>
                <th><a class="table-header" field-name="template"><?php echo $Language->translate("Template"); ?></a></th>
                <th class="Action col-xs-1"><?php echo $Language->translate("Action"); ?></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <div id="loading-msg-countries" class="loading-image"></div>
        <div class="clearfix"></div>
    </div>
    <script>
        $(function () {
            $('.leftmenu').find('.active').removeClass('active');
            $('#menu-MessageTemplates').addClass('active');
            var ActionButtonSize = 1;

            <?php foreach($Config->TeaserManagementActionButtons as $buttons): ?>
                <?php if($buttons == 1): ?>
                    ActionButtonSize += 1;
                <?php endif; ?>
            <?php endforeach; ?>

            $('#MessageTemplates_list').ajaxGrid({
                pageSize: 10,
                defaultSortExpression: 'message_type',
                defaultSortOrder: 'desc',
                tableHeading: '.table-header',
                dataRowHeaderClass: [
                    {noCondition: true, "class": 'table-header-text'}
                ],
                url: '<?php echo BASE_URL; ?>MessageTemplates/List',
                requestType: 'get',
                loadingImage: $('#loading-msg-countries'),
                postContent: [
                    {
                        control: $('<button name ="Edit Option" type="button" class="btn btn-rounded btn-info" onclick=\'showEditForm(this,"<?php echo $Language->translate("Edit Message Template"); ?>","<?php echo BASE_URL; ?>MessageTemplates/Form",500,200)\'>' +
                                '<small class="glyphicon glyphicon-pencil"></small>' +
                                '</button>')
                    },
                    {
                        control: $("<form style='display: inline-block' action='<?php echo BASE_URL; ?>MessageTemplates/Delete' method='POST'>" +
                                "<input type='hidden' name='ID' id='ID' /> " +
                                '<button name="Delete Template" type="submit" class="btn btn-rounded btn-danger" onclick=\'return Confirmation(this,"<?php echo $Language->translate("Delete Message Template"); ?>","<?php echo $Language->translate("Are you sure you want to delete?"); ?>", "<?php echo $Language->translate("Yes"); ?>", "<?php echo $Language->translate("No"); ?>")\'>' +
                                '<small class="glyphicon glyphicon-trash"></small>' +
                                '</button></form>'),
                        properties: [
                            {
                                propertyField: 'input[type=hidden]#ID',
                                property: 'value',
                                propertyValue: 'id'
                            }
                        ]
                    }


                ],
                id: 'id',
                NoRecordsFound: '<?php echo $Language->translate("No Records Found"); ?>',
                Previous: '<?php echo $Language->translate("Previous"); ?>',
                Next: '<?php echo $Language->translate("Next"); ?>'
            });
        });

    </script>
<?php include_once SHARED_VIEW . "footer.php"; ?>
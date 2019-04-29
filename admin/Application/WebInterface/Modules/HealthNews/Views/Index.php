<?php
/**
 *
 * @var $Language \Language\English\English
 */

$baseUrl = BASE_URL;

$Breadcrumb = "<li><a href='{$baseUrl}HealthNews'>{$Language->translate('Home')}</a></li>
<li class='active'>{$Language->translate('Health News')}</li>";

$PageTitle = $Language->translate('Health News');

$PageLeftHeader = "";

include_once SHARED_VIEW . "base.php";

?><script src="Editor/ckeditor/ckeditor.js"></script>
    <script src="Editor/ckfinder/ckfinder.js"></script>
    <div class="content-wrapper">
        <div class="page-header">
            <div>
                <button type="button" class="btn btn-success pull-right"
                        onclick='showAddNewForm("<?php echo $Language->translate("Add New Health News"); ?>","<?php echo BASE_URL; ?>HealthNews/Form",1000,1000)'>
                    <small class="glyphicon glyphicon-plus-sign"></small>
                    <?php echo $Language->translate("Add New Health News"); ?>
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        <table id="HealthNewsList" class="table table-bordered">
            <thead>
            <tr>
                <th><a class="table-header" field-name="ID"><?php echo $Language->translate("ID"); ?></a></th>
                <th><a class="table-header" field-name="Title"><?php echo $Language->translate("Title"); ?></a></th>
                <th><a class="table-header" field-name="Slug"><?php echo $Language->translate("Slug"); ?></a></th>
                <th><a class="table-header" field-name="Status"><?php echo $Language->translate("Status"); ?></a></th>
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
            $('#menu-HealthNews').addClass('active');

            $('#HealthNewsList').ajaxGrid({
                pageSize: 10,
                defaultSortExpression: 'ID',
                defaultSortOrder: 'desc',
                tableHeading: '.table-header',
                url: '<?php echo BASE_URL; ?>HealthNews/List',
                requestType: 'get',
                loadingImage: $('#loading-msg-countries'),
                afterAjaxCallComplete: function () {
                    $("#HealthNewsList tbody tr :nth-child(4)").each(function () {
                        if ($(this).text() == '1') {
                            $(this).html('<img onclick="SetStatus(this)" class="StatusImage" data-set="1" src="Infrastructure/green.png" height="15px">').attr('align','right');
                            $(this).find('img').css('display','inline');
                        } else if($(this).text() == '0') {
                            $(this).html('<img onclick="SetStatus(this)" class="StatusImage" data-set="0" src="Infrastructure/red.png" height="15px">').attr('align','right');
                            $(this).find('img').css('display','inline');                        }
                    });
                },
                postContent: [
                    {
                        control: $('<button name ="Edit Heath News" type="button" class="btn btn-rounded btn-info" onclick=\'showEditForm(this,"<?php echo $Language->translate("Edit Health News"); ?>","<?php echo BASE_URL; ?>HealthNews/Form",1000,1000)\'>' +
                                '<small class="glyphicon glyphicon-pencil"></small>' +
                                '</button>')
                    },
                    {
                        control: $("<form style='display: inline-block' action='<?php echo BASE_URL; ?>HealthNews/Delete' method='POST'>" +
                                "<input type='hidden' name='ID' id='ID' /> " +
                                '<button name="Delete HealthNews" type="submit" class="btn btn-rounded btn-danger" onclick=\'return Confirmation(this,"<?php echo $Language->translate("Delete Health News"); ?>","<?php echo $Language->translate("Are you sure you want to delete?"); ?>", "<?php echo $Language->translate("Yes"); ?>", "<?php echo $Language->translate("No"); ?>")\'>' +
                                '<small class="glyphicon glyphicon-trash"></small>' +
                                '</button></form>'),
                        properties: [
                            {
                                propertyField: 'input[type=hidden]#ID',
                                property: 'value',
                                propertyValue: 'ID'
                            }
                        ]
                    }


                ],
                id: 'ID',
                NoRecordsFound: '<?php echo $Language->translate("No Records Found"); ?>',
                Previous: '<?php echo $Language->translate("Previous"); ?>',
                Next: '<?php echo $Language->translate("Next"); ?>'
            });
        });
   function SetStatus(thisObj){

       $(thisObj).attr('src','Infrastructure/loader.gif');

       $.ajax({
           url:"<?php echo BASE_URL.'HealthNews/SetStatus' ?>",
           type: "POST",
           data:'Status='+$(thisObj).attr('data-set')+'&ID='+$(thisObj).parents('tr').attr('id'),
           success:function(data) {
               if (data==1) {
                   if ($(thisObj).attr('data-set') == 1) {
                       $(thisObj).attr('src', 'Infrastructure/red.png');
                       $(thisObj).attr('data-set','0') == 1
                   }
                   else {
                       $(thisObj).attr('src', 'Infrastructure/green.png');
                       $(thisObj).attr('data-set','1')
                   }

               }
           }


       })





    }

    </script>
<?php include_once SHARED_VIEW . "footer.php"; ?>
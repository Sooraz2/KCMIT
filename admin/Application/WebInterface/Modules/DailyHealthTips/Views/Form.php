<?php
/*
 *
 * @var $MessageTemplates \WebInterface\Models\MessageTemplates
 *
 * */

?>

<form action="<?php echo BASE_URL; ?>DailyHealthTips/SaveUpdateForm" enctype="multipart/form-data" method="post" class="form-horizontal"
      id="DailyHealthTipsForm">
    <input type="hidden" name="ID" value="<?php echo $DailyHealthTips->ID; ?>" id="ID">
    <input type="hidden" name="DailyHealthTipsFormToken" value="<?php echo $formToken; ?>" />
    <input type="hidden" id="ContentType" value="DailyHealthTips">

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Title</label></div>
        <div class="col-sm-10">
            <input type="text" id="NewsTitle"  name="Title" class="validate[required] form-control"
                     value="<?php echo $DailyHealthTips->Title; ?>" >
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2"><label class="" >Image First</label></div>
        <div class="col-sm-4">
            <input type="file" accept=".jpg,.png,.jpeg,.gif" id="Image1"  name="Image1" class="<?php if($DailyHealthTips->ID==''){ echo 'validate[required]';} ?> form-control" >
        </div>
        <div class="col-sm-6">
            <?php if(file_exists('../Uploads/'.$DailyHealthTips->Image1) && $DailyHealthTips->Image1!=''){ ?>
                <img src="../Uploads/<?php echo $DailyHealthTips->Image1; ?>" height="100px" width="150px">
            <?php    } ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2"><label class="" >Image Second</label></div>
        <div class="col-sm-4">
            <input type="file" accept=".jpg,.png,.jpeg,.gif" id="Image2"  name="Image2" class="<?php if($DailyHealthTips->ID==''){ echo 'validate[required]';} ?> form-control" >
        </div>
        <div class="col-sm-6">
            <?php if(file_exists('../Uploads/'.$DailyHealthTips->Image2) && $DailyHealthTips->Image2!=''){ ?>
                <img src="../Uploads/<?php echo $DailyHealthTips->Image2; ?>" height="100px" width="150px">
            <?php    } ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Publish Now</label></div>
        <div class="col-sm-10">
            <input type="radio"  id="StatusYes" <?php if($DailyHealthTips->Status == 1){ echo 'checked';}  ?> value="1"  name="Status" class="" >Yes
            <input type="radio"  id="StatusNo" <?php if($DailyHealthTips->Status == 0){ echo 'checked';}  ?> value="0"  name="Status" class="" >No

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Content</label></div>
        <div class="col-sm-10">
            <?php //$soo = $ckeditor->editor('Content'); ?>
            <textarea id="Content"  name="Content" class="validate[required]" class="form-control"
                       style="width:100%;height:120px;"><?php echo $DailyHealthTips->Content; ?></textarea>
        </div>
    </div>

    <input type="hidden" name="DailyHealthTipsSubmit" value="<?php echo $saveOrUpdate ; ?>"/>

    <div class="form-group pull-right">
        <div class="col-sm-12 dialog-button">
            <input type="submit" name="Submitx" value="<?php echo $saveOrUpdate ; ?>"
                   class="btn btn-success">
        </div>
    </div>


</form>
<script type="text/javascript">
    $(function () {
        CKEDITOR.config.customConfig = 'Editor/ckeditor/ckeditor_config.js';
        CKEDITOR.replace( 'Content',
          {
              filebrowserBrowseUrl :      'Editor/ckfinder/ckfinder.html',
              filebrowserImageBrowseUrl : 'Editor/ckfinder/ckfinder.html?type=Images',
              filebrowserFlashBrowseUrl : 'Editor/ckfinder/ckfinder.html?type=Flash',
              filebrowserUploadUrl :      'Editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              filebrowserImageUploadUrl : 'Editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
              filebrowserFlashUploadUrl : 'Editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
              //uiColor: '#45729e',


          });

        $('#DailyHealthTipsForm').validationEngine();

        $('#SlugButton').click(function(){

            $('#SlugValue').val(GenerateSlug($('#NewsTitle').val()));
        })
    });


</script>
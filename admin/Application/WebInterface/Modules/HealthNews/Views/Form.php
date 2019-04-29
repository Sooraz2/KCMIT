<?php
/*
 *
 * @var $MessageTemplates \WebInterface\Models\MessageTemplates
 *
 * */

?>

<form action="<?php echo BASE_URL; ?>HealthNews/SaveUpdateForm" enctype="multipart/form-data" method="post" class="form-horizontal"
      id="HealthNewsForm">
    <input type="hidden" name="ID" value="<?php echo $HealthNews->ID; ?>" id="ID">
    <input type="hidden" name="HealthNewsFormToken" value="<?php echo $formToken; ?>" />
    <input type="hidden" id="ContentType" value="HealthNews">

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Title</label></div>
        <div class="col-sm-10">
            <input type="text" id="NewsTitle"  name="Title" class="validate[required] form-control"
                     value="<?php echo $HealthNews->Title; ?>" >
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2"><label class="" >Slug</label></div>
        <div class="col-sm-8">
            <input id="SlugValue" name="Slug" class="form-control validate[required],ajax[ajaxCheckSlug]"
                    value="<?php echo $HealthNews->Slug; ?>" />
        </div> <div class="col-sm-2">
            <input id="SlugButton"  type="button"  class="btn btn-primary"
                    value="Generate Slug" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2"><label class="" >Sub-Title</label></div>
        <div class="col-sm-6">
            <input type="text" id="SubTitle"  name="SubTitle" class="form-control"
                   value="<?php echo $HealthNews->SubTitle; ?>" >
        </div>

    </div>
    <div class="form-group">
        <div class="col-sm-2"><label class="" >Image First (780 * 360)</label></div>
        <div class="col-sm-4">
            <input type="file" accept=".jpg,.png,.jpeg,.gif" id="Image1"  name="Image1" class="<?php if($HealthNews->ID==''){ echo 'validate[required]';} ?> form-control" >
        </div>
        <div class="col-sm-6">
            <?php if(file_exists('../Uploads/'.$HealthNews->Image1) && $HealthNews->Image1!=''){ ?>
                <img src="../Uploads/<?php echo $HealthNews->Image1; ?>" height="100px" width="150px">
            <?php    } ?>
        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Image Second (375 * 260(263))</label></div>
        <div class="col-sm-4">
            <input type="file" accept=".jpg,.png,.jpeg,.gif" id="Image2"  name="Image2" class="<?php if($HealthNews->ID==''){ echo 'validate[required]';} ?> form-control" >
        </div>
        <div class="col-sm-6">
            <?php if(file_exists('../Uploads/'.$HealthNews->Image2) && $HealthNews->Image2!=''){ ?>
                <img src="../Uploads/<?php echo $HealthNews->Image2; ?>" height="100px" width="150px">
            <?php    } ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2"><label class="" >Image Third (375 * 65(63))</label></div>
        <div class="col-sm-4">
            <input type="file" accept=".jpg,.png,.jpeg,.gif" id="Image3"  name="Image3" class="<?php if($HealthNews->ID==''){ echo 'validate[required]';} ?> form-control" >
        </div>
        <div class="col-sm-6">
            <?php if(file_exists('../Uploads/'.$HealthNews->Image3) && $HealthNews->Image3!=''){ ?>
                <img src="../Uploads/<?php echo $HealthNews->Image3; ?>" height="100px" width="150px">
            <?php    } ?>
        </div>
    </div>



    <div class="form-group">
        <div class="col-sm-2"><label class="" >Publish Now</label></div>
        <div class="col-sm-10">
            <input type="radio"  id="StatusYes" <?php if($HealthNews->Status == 1){ echo 'checked';}  ?> value="1"  name="Status" class="" >Yes
            <input type="radio"  id="StatusNo" <?php if($HealthNews->Status == 0 ){ echo 'checked';}  ?> value="0"  name="Status" class="" >No

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Content</label></div>
        <div class="col-sm-10">
            <?php //$soo = $ckeditor->editor('Content'); ?>
            <textarea id="Content"  name="Content" class="validate[required]" class="form-control"
                       style="width:100%;height:120px;"><?php echo $HealthNews->Content; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"><label class="" >Meta Title</label></div>
        <div class="col-sm-10">
            <input type="text" id="MetaTitle"  name="MetaTitle" class="validate[required] form-control"
                   value="<?php echo $HealthNews->MetaTitle; ?>" >
        </div>
    </div>

    </div> <div class="form-group">
        <div class="col-sm-2"><label class="" >Meta Keywords</label></div>
        <div class="col-sm-10">
            <textarea  name="MetaKeyWords" class="validate[required]" class="form-control"
                      style="width:100%;height:120px;"><?php echo $HealthNews->MetaKeyWords; ?></textarea>
        </div>
    </div> <div class="form-group">
        <div class="col-sm-2"><label class="" >Meta Description</label></div>
        <div class="col-sm-10">
            <textarea  name="MetaDescription" class="validate[required]" class="form-control"
                      style="width:100%;height:120px;"><?php echo $HealthNews->MetaDescription; ?></textarea>
        </div>
    </div>


    <input type="hidden" name="HealthNewsSubmit" value="<?php echo $saveOrUpdate ; ?>"/>

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

        $('#HealthNewsForm').validationEngine();

        $('#SlugButton').click(function(){

            $('#SlugValue').val(GenerateSlug($('#NewsTitle').val()));
        })
    });


</script>
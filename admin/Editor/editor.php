
<?php
include_once 'editor/ckeditor/ckeditor.php';
include_once 'editor/ckfinder/ckfinder.php';
$ckeditor = new CKEditor();
$ckfinder = new CKFinder();
$ckeditor->basePath = 'editor/ckeditor/';
$ckfinder->BasePath = 'editor/ckfinder/'; 
$ckfinder->SetupCKEditorObject($ckeditor);
$config = array(); /* FROM color */
$config['uiColor'] = '#0085cc'; /* FROM color */
 ?>

            <?php
                //$editorcontent = stripslashes($data[0]->description);

//$soo = $ckeditor -> editor('description', $editorcontent, $config); /* FROM color */
//$soo = $ckeditor -> editor('description');
?>


<?php
//echo $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));


?>

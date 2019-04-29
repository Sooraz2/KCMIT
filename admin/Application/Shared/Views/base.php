<?php
/**
 *
 * @var $Language \Language\English\English
 * @var $Config
 */
use Infrastructure\CookieVariable;
use Infrastructure\InterfaceVariables;

?>

<!DOCTYPE html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo  $Language->translate("KCMIT") ?> </title>

    <link rel="shortcut icon" type="image/png" href="<?php echo  BASE_URL ?>favicon.ico"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/style.default.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/prettify/prettify.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/validationEngine.jquery.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/font-awesome.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/jquery.Jcrop.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/jquery.minicolors.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>includes/styles/bootstrap-datetimepicker.min.css" type="text/css"/>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.cookie.js"></script>

    <script type="text/javascript">
        /*
         * Javascript Language Constants
         * */
        var BASE_URL = '<?php echo BASE_URL ?>';
        var BalancePlusLanguageCookieVariable = '<?php echo \Infrastructure\CookieVariable::$BalancePlusLanguage?>';
        var editConfirmationText = '<?php echo $Language->translate("Are you sure you want to edit?") ?>';
        var editConfirmationYes = '<?php echo $Language->translate("Yes") ?>';
        var editConfirmationNo = '<?php echo $Language->translate("No") ?>';
        var SelectAllLang = '<?php echo $Language->translate("Select All") ?>';
        var SelectionTextLang = '<?php echo $Language->translate("Select")?>';
        var AllSelectedLang = '<?php echo $Language->translate("All Selected")?>';
        var Time = '<?php echo GetCurrentDateTime(); ?>';


        var previous = '<?php echo $Language->translate("Previous") ?>';
        var next = '<?php echo $Language->translate("Next") ?>';
        var Language;
        Language = $.cookie(BalancePlusLanguageCookieVariable) == null ? "English" : $.cookie(BalancePlusLanguageCookieVariable);
        var today = 'Go to today',
            clear = 'Clear selection',
            close = 'Close the picker',
            selectMonth = '<?php echo $Language->translate("Select Month") ?>',
            prevMonth = 'Previous Month',
            nextMonth = 'Next Month',
            selectYear = 'Select Year',
            prevYear = 'Previous Year',
            nextYear = 'Next Year',
            selectDecade = 'Select Decade',
            prevDecade = 'Previous Decade',
            nextDecade = 'Next Decade',
            prevCentury = 'Previous Century',
            nextCentury = 'Next Century';
            var msisdnGloabl = "<?php echo InterfaceVariables::$MSISDNPrefix?>-";

        var ourlastMonth = '<?php echo  $Language->translate("Last Month") ?>';
        var CSVEncoding = '<?php echo json_encode($Config->CSVUploadCharacterEncoding) ?>';


        function bindOnHoverToolTip() {
            $(".onhovertooltip").click(function () {
                $button = $(this);
                if ($button.attr("data-content") == undefined) {
                    $.ajax({
                        url: "<?php echo BASE_URL ?>ActiveTeasers/GetDataOnHover",
                        dataType: "json",
                        type: "POST",
                        async: false,
                        data: {
                            criterionType: $button.attr("data-criterion-type"),
                            messageId: $button.closest("tr").attr("id")
                        },
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.length > 0) {
                                $html = $("<div/>");
                                for (i = 0; i < data.length; i++) {
                                    $.each(data[i], function (i, v) {
                                        if (!$.isNumeric(i) && i != "id" && i != "CriterionType" && i != "<?php echo $Language->translate("Currency") ?>" && i != "<?php echo $Language->translate("TechName") ?>"
                                            && i != "<?php echo $Language->translate("option") ?>" && i != "<?php echo $Language->translate("created_by") ?>" && i != "<?php echo $Language->translate("datetime_created") ?>" && i != "<?php echo $Language->translate("Code") ?>" && i != "<?php echo $Language->translate("Service ID") ?>"
                                        ) {
                                            $content = $("<p style='margin-top: 15px'/>");
                                            if(i == "subsBalanceValue")
                                                $content.append(v);
                                            else
                                                $content.append(i + ": " + v);
                                            $html.append($content);
                                        }
                                    });
                                    $html.append("<hr style='margin: 10px 0 0px 0'/>");
                                }
                                $("#" + data[0].CriterionType).html($html);
                            }
                            else {
                                $html = $("<div><p><?php echo $Language->translate('No Records Found') ?></p></div>");
                                $("#" + $button.attr('data-criterion-type')).html($html);
                            }

                            $button.attr({
                                "data-toggle": "popover",
                                "data-trigger": "focus",
                                "data-content": $("#" + $button.attr('data-criterion-type')).html(),
                                "data-html": "true"
                            });
                            setpopOver($button);
//                        .popover("show");


                        }
                    });
                } else {
                    setpopOver($button);
//                $button.popover();

                }
            });
        }

    </script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/moment.js"></script>


    <!--[if lte IE 8]>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/customIe.js" type="text/css"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/excanvas.js" type="text/css"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/style-ie.css" type="text/css"/>
    <![endif]-->
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery-ui-1.10.3.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/ajaxGrid.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.ui.timepicker.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/dateTimepicker.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.validationEngine.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/multi-select.js"></script>

    <script src="<?php echo  BASE_URL ?>includes/scripts/moment-with-locales.js"></script>

    <?php if (isset($_COOKIE[CookieVariable::$BalancePlusLanguage]) && $_COOKIE[CookieVariable::$BalancePlusLanguage] == "English"): ?>
        <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.validationEngine-en.js"></script>
    <?php else: ?>
        <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.validationEngine-ru.js"></script>
    <?php endif ?>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/validation.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.minicolors.min.js"></script>
    <script type="text/javascript"
            src="<?php echo  BASE_URL ?>includes/scripts/bootstrap-datetimepicker.custom.min.js"></script>

    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/prettify/prettify.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/custom.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.dataTables.min.js"></script>


    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/json2.js"></script>


    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.flot.categories.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/jquery.flot.navigate.js"></script>


    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/Shared.js"></script>

    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/event-calendar.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/broadcasting-calendar.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/sliderTimePicker.js"></script>
    <script type="text/javascript" src="<?php echo  BASE_URL ?>includes/scripts/bootstrap-filestyle.min.js"></script>
    <script src="<?php echo  BASE_URL ?>includes/scripts/jquery.Jcrop.js"></script>
    <script src="<?php echo  BASE_URL ?>includes/scripts/chart.js"></script>
    <script src="<?php echo  BASE_URL ?>includes/scripts/line.js"></script>
    <script src="<?php echo  BASE_URL ?>includes/scripts/CSVForm.js"></script>

    <?php  if($Language->LanguageClass == "Russian"){ ?>
        <script src="<?php echo  BASE_URL ?>includes/scripts/CSVFormLanguage/ru.js"></script>
    <?php }else{ ?>
        <script src="<?php echo  BASE_URL ?>includes/scripts/CSVFormLanguage/en.js"></script>
    <?php } ?>

    <script>
        $(':file').filestyle();
        $(document).ready(function () {
//            $(".footer").css();
        });
    </script>
</head>
<body>
<?php $isCustomerCare = $_SESSION["UserType"] == 4 ?>

<div class="mainwrapper fullwrapper">

<!-- START OF LEFT PANEL -->
<div class="leftpanel">

<div class="logopanel">
    <h1><a>KCMIT</a> </h1>

</div>
<!--logopanel-->

<div class="datewidget">KCMIT</div>


<div class="leftmenu">
    <ul class="nav nav-tabs nav-stacked">

        <li id="menu-DailyHealthTips">
            <a href="<?php echo  BASE_URL ?>DailyHealthTips">
                <span class="icon glyphicon glyphicon-bullhorn"></span>
                <?php echo  $Language->translate("Daily Health Tips") ?> </a>
        </li>

            <li id="menu-HealthTips">
                <a href="<?php echo  BASE_URL ?>HealthTips">
                    <span class="icon glyphicon glyphicon-bullhorn"></span>
                    <?php echo  $Language->translate("Health Tips") ?> </a>
            </li>

        <li id="menu-HealthTips">
            <a href="<?php echo  BASE_URL ?>HealthNews">
                <span class="icon glyphicon glyphicon-bullhorn"></span>
                <?php echo  $Language->translate("Health News") ?> </a>
        </li>


        <?php if ($Config->Pages->UserManagement == 1): ?>

            <?php if (isset($_SESSION["UserType"]) && ($_SESSION["UserType"] == 1 or $_SESSION["UserType"] == 3)): ?>

                <li id="menu-UserManagement" class="dropdown animate8 fadeInUp">
                    <a href="">
                        <span class="icon glyphicon glyphicon-user"></span>
                        <?php echo  $Language->translate("Users Management") ?> </a>
                    <ul style="display: none;">
                        <li id="menu-UserManagement">
                            <a href="<?php echo  BASE_URL ?>Admin/UserManagement"><?php echo  $Language->translate("User's Activities") ?></a>
                        </li>
                    </ul>
                </li>

            <?php endif ?>

        <?php endif ?>


    </ul>
</div>
<!--leftmenu-->

</div>
<!--mainleft-->
<!-- END OF LEFT PANEL -->

<!-- START OF RIGHT PANEL -->
<div class="rightpanel">
    <div class="headerpanel">

        <a href="" class="showmenu"></a>

        <div class="headerright">

            <div class="dropdown userinfo" style="vertical-align: top;margin-right: 5px">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#"
                   href="/page.html"><?php echo  $Language->translate("Setting") ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">

                    <?php if (isset($_SESSION["UserType"]) && $_SESSION["UserType"] != 2): ?>
                        <li>
                            <a onclick="showAddNewForm('Change Password','<?php echo  BASE_URL ?>ChangePassword/Form?RedirectUrl=http://<?php echo  $_SERVER["HTTP_HOST"] ?><?php echo  $_SERVER["REQUEST_URI"] ?>',400,250);return false;"
                               href=""><span class="icon-edit"></span><?php echo  $Language->translate("Change Password") ?>
                            </a>
                        </li>
                        <li class="divider"></li>
                    <?php endif ?>
                    <li><a href="<?php echo  BASE_URL ?>LogOut"><span
                                class="icon-off"></span> <?php echo  $Language->translate("Sign Out") ?></a></li>
                </ul>
            </div>
            <!--dropdown-->

        </div>

        <!--headerright-->

    </div>
    <!--headerpanel-->
    <div class="breadcrumbwidget">
        <ul class="breadcrumb" style="position: relative;">
            <?php echo  $Breadcrumb ?>
            <li class="ServerClock">
                <strong><?php echo  $Language->translate('Time');?> : </strong><span id="ServerClockTime"></span>
                <script>
                    $(function () {
                        var TimeJs = moment(Time);

                        setInterval(function () {
                            $("#ServerClockTime").html(TimeJs.add(1, 's').format("HH:mm:ss a"));
                        }, 1000);
                    });
                </script>
            </li>
        </ul>
    </div>
    <!--breadcrumbwidget-->
    <div class="pagetitle">
        <h1 class="page-title"><?php echo  $PageTitle ?></h1>

        <div class="pull-right server-title"><?php echo  $PageLeftHeader ?></div>
    </div>
    <!--pagetitle-->

    <div class="maincontent">
        <div class="contentinner content-dashboard">


            <?php if (isset($_SESSION["ConfirmationMessage"]) && $_SESSION["ConfirmationMessage"] != "" && $_SESSION["ConfirmationMessage"] != null): ?>
                <div id="MessageBox">
                    <?php include_once SHARED_VIEW. "ConfirmationMessage.php" ?>

                </div>
            <?php endif ?>

            <div class="row-fluid">

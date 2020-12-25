<?php

// Menu
$RootMenu = new crMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(13, "mi_package_duration", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("13", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "package_durationrpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(14, "mi_package_report", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("14", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "package_reportrpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(18, "mi_product_company", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("18", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "product_companyrpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(19, "mi_product_type", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("19", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "product_typerpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(25, "mi_sales", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("25", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "salesrpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(28, "mi_user_city", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("28", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "user_cityrpt.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(29, "mi_user_diet", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("29", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "user_dietrpt.php", -1, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>

<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "rcfg11.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "rphpfn11.php" ?>
<?php include_once "rusrfn11.php" ?>
<?php include_once "orderrptinfo.php" ?>
<?php

//
// Page class
//

$order_rpt = NULL; // Initialize page object first

class crorder_rpt extends crorder {

	// Page ID
	var $PageID = 'rpt';

	// Project ID
	var $ProjectID = "{33A3569A-8948-455F-A859-CDA3299C9672}";

	// Page object name
	var $PageObjName = 'order_rpt';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $ReportLanguage;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $ReportLanguage;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $grToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$grToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (order)
		if (!isset($GLOBALS["order"])) {
			$GLOBALS["order"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["order"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'order', TRUE);

		// Start timer
		if (!isset($GLOBALS["grTimer"]))
			$GLOBALS["grTimer"] = new crTimer();

		// Debug message
		ewr_LoadDebugMsg();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption forderrpt";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security, $UserProfile;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewrExportLink ewPrint\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewrExportLink ewExcel\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewrExportLink ewWord\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewrExportLink ewPdf\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a class=\"ewrExportLink ewEmail\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_order\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_order',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"forderrpt\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"forderrpt\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"forderrpt\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_FullUrl($saveToFile, "genurl") : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		// Close connection if not in dashboard
		if (!$this->ShowReportInDashboard)
			ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ewr_SaveDebugMsg();
			header("Location: " . $url);
		}
		if (!$this->ShowReportInDashboard)
			exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 3; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();
	var $ShowReportInDashboard = FALSE;
	var $TopContentClass = "col-sm-12 ewTop";
	var $LeftContentClass = "ewLeft";
	var $CenterContentClass = "col-sm-12 ewCenter";
	var $RightContentClass = "ewRight";
	var $BottomContentClass = "col-sm-12 ewBottom";

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $grFormError;
		global $grDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;
		global $grDashboardReport;

		// Show report in dashboard
		$this->ShowReportInDashboard = $grDashboardReport;

		// Set field visibility for detail fields
		$this->productname->SetVisibility();
		$this->quantity->SetVisibility();
		$this->description->SetVisibility();
		$this->price->SetVisibility();
		$this->size->SetVisibility();
		$this->quantity1->SetVisibility();
		$this->total_amount->SetVisibility();
		$this->order_date->SetVisibility();
		$this->fname->SetVisibility();
		$this->lname->SetVisibility();
		$this->address->SetVisibility();
		$this->gender->SetVisibility();
		$this->phn->SetVisibility();
		$this->order_date1->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 15;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		$this->order_date->SelectionList = "";
		$this->order_date->DefaultSelectionList = "";
		$this->order_date->ValueList = "";
		$this->order_date1->SelectionList = "";
		$this->order_date1->DefaultSelectionList = "";
		$this->order_date1->ValueList = "";

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown || $this->ShowReportInDashboard) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = TRUE;

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export/dashboard report
		if ($this->Export <> "" || $this->ShowReportInDashboard)
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown/dashboard report
		if ($this->Export <> "" || $this->DrillDown || $this->ShowReportInDashboard) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
				$this->FirstRowData = array();
				$this->FirstRowData['productname'] = ewr_Conv($rs->fields('productname'), 200);
				$this->FirstRowData['quantity'] = ewr_Conv($rs->fields('quantity'), 3);
				$this->FirstRowData['description'] = ewr_Conv($rs->fields('description'), 200);
				$this->FirstRowData['price'] = ewr_Conv($rs->fields('price'), 3);
				$this->FirstRowData['size'] = ewr_Conv($rs->fields('size'), 200);
				$this->FirstRowData['quantity1'] = ewr_Conv($rs->fields('quantity1'), 3);
				$this->FirstRowData['total_amount'] = ewr_Conv($rs->fields('total_amount'), 3);
				$this->FirstRowData['order_date'] = ewr_Conv($rs->fields('order_date'), 133);
				$this->FirstRowData['fname'] = ewr_Conv($rs->fields('fname'), 200);
				$this->FirstRowData['lname'] = ewr_Conv($rs->fields('lname'), 200);
				$this->FirstRowData['address'] = ewr_Conv($rs->fields('address'), 200);
				$this->FirstRowData['gender'] = ewr_Conv($rs->fields('gender'), 200);
				$this->FirstRowData['phn'] = ewr_Conv($rs->fields('phn'), 20);
				$this->FirstRowData['order_date1'] = ewr_Conv($rs->fields('order_date1'), 133);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->productname->setDbValue($rs->fields('productname'));
			$this->quantity->setDbValue($rs->fields('quantity'));
			$this->description->setDbValue($rs->fields('description'));
			$this->price->setDbValue($rs->fields('price'));
			$this->size->setDbValue($rs->fields('size'));
			$this->quantity1->setDbValue($rs->fields('quantity1'));
			$this->total_amount->setDbValue($rs->fields('total_amount'));
			$this->order_date->setDbValue($rs->fields('order_date'));
			$this->fname->setDbValue($rs->fields('fname'));
			$this->lname->setDbValue($rs->fields('lname'));
			$this->address->setDbValue($rs->fields('address'));
			$this->gender->setDbValue($rs->fields('gender'));
			$this->phn->setDbValue($rs->fields('phn'));
			$this->order_date1->setDbValue($rs->fields('order_date1'));
			$this->Val[1] = $this->productname->CurrentValue;
			$this->Val[2] = $this->quantity->CurrentValue;
			$this->Val[3] = $this->description->CurrentValue;
			$this->Val[4] = $this->price->CurrentValue;
			$this->Val[5] = $this->size->CurrentValue;
			$this->Val[6] = $this->quantity1->CurrentValue;
			$this->Val[7] = $this->total_amount->CurrentValue;
			$this->Val[8] = $this->order_date->CurrentValue;
			$this->Val[9] = $this->fname->CurrentValue;
			$this->Val[10] = $this->lname->CurrentValue;
			$this->Val[11] = $this->address->CurrentValue;
			$this->Val[12] = $this->gender->CurrentValue;
			$this->Val[13] = $this->phn->CurrentValue;
			$this->Val[14] = $this->order_date1->CurrentValue;
		} else {
			$this->productname->setDbValue("");
			$this->quantity->setDbValue("");
			$this->description->setDbValue("");
			$this->price->setDbValue("");
			$this->size->setDbValue("");
			$this->quantity1->setDbValue("");
			$this->total_amount->setDbValue("");
			$this->order_date->setDbValue("");
			$this->fname->setDbValue("");
			$this->lname->setDbValue("");
			$this->address->setDbValue("");
			$this->gender->setDbValue("");
			$this->phn->setDbValue("");
			$this->order_date1->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Build distinct values for order_date

			if ($popupname == 'order_order_date') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->order_date, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->order_date->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->order_date->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->order_date->setDbValue($rswrk->fields[0]);
					$this->order_date->ViewValue = @$rswrk->fields[1];
					if (is_null($this->order_date->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->order_date->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->order_date->ValueList, $this->order_date->CurrentValue, $this->order_date->ViewValue, FALSE, $this->order_date->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->order_date->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->order_date->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->order_date;
			}

			// Build distinct values for order_date1
			if ($popupname == 'order_order_date1') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->order_date1, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->order_date1->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->order_date1->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->order_date1->setDbValue($rswrk->fields[0]);
					$this->order_date1->ViewValue = @$rswrk->fields[1];
					if (is_null($this->order_date1->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->order_date1->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->order_date1->ValueList, $this->order_date1->CurrentValue, $this->order_date1->ViewValue, FALSE, $this->order_date1->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->order_date1->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->order_date1->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->order_date1;
			}

			// Output data as Json
			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = $_POST["sel_$sName"];
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = @$_POST["rf_$sName"];
					$_SESSION["rt_$sName"] = @$_POST["rt_$sName"];
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ClearSessionSelection('order_date');
				$this->ClearSessionSelection('order_date1');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get order_date selected values

		if (is_array(@$_SESSION["sel_order_order_date"])) {
			$this->LoadSelectionFromSession('order_date');
		} elseif (@$_SESSION["sel_order_order_date"] == EWR_INIT_VALUE) { // Select all
			$this->order_date->SelectionList = "";
		}

		// Get order_date1 selected values
		if (is_array(@$_SESSION["sel_order_order_date1"])) {
			$this->LoadSelectionFromSession('order_date1');
		} elseif (@$_SESSION["sel_order_order_date1"] == EWR_INIT_VALUE) { // Select all
			$this->order_date1->SelectionList = "";
		}
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 3; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel); // Set up row class

			// productname
			$this->productname->HrefValue = "";

			// quantity
			$this->quantity->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// size
			$this->size->HrefValue = "";

			// quantity1
			$this->quantity1->HrefValue = "";

			// total_amount
			$this->total_amount->HrefValue = "";

			// order_date
			$this->order_date->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// address
			$this->address->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// phn
			$this->phn->HrefValue = "";

			// order_date1
			$this->order_date1->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// productname
			$this->productname->ViewValue = $this->productname->CurrentValue;
			$this->productname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// quantity
			$this->quantity->ViewValue = $this->quantity->CurrentValue;
			$this->quantity->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// description
			$this->description->ViewValue = $this->description->CurrentValue;
			$this->description->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// size
			$this->size->ViewValue = $this->size->CurrentValue;
			$this->size->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// quantity1
			$this->quantity1->ViewValue = $this->quantity1->CurrentValue;
			$this->quantity1->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// total_amount
			$this->total_amount->ViewValue = $this->total_amount->CurrentValue;
			$this->total_amount->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// order_date
			$this->order_date->ViewValue = $this->order_date->CurrentValue;
			$this->order_date->ViewValue = ewr_FormatDateTime($this->order_date->ViewValue, 0);
			$this->order_date->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// fname
			$this->fname->ViewValue = $this->fname->CurrentValue;
			$this->fname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// lname
			$this->lname->ViewValue = $this->lname->CurrentValue;
			$this->lname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// gender
			$this->gender->ViewValue = $this->gender->CurrentValue;
			$this->gender->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// phn
			$this->phn->ViewValue = $this->phn->CurrentValue;
			$this->phn->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// order_date1
			$this->order_date1->ViewValue = $this->order_date1->CurrentValue;
			$this->order_date1->ViewValue = ewr_FormatDateTime($this->order_date1->ViewValue, 0);
			$this->order_date1->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// productname
			$this->productname->HrefValue = "";

			// quantity
			$this->quantity->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// size
			$this->size->HrefValue = "";

			// quantity1
			$this->quantity1->HrefValue = "";

			// total_amount
			$this->total_amount->HrefValue = "";

			// order_date
			$this->order_date->HrefValue = "";

			// fname
			$this->fname->HrefValue = "";

			// lname
			$this->lname->HrefValue = "";

			// address
			$this->address->HrefValue = "";

			// gender
			$this->gender->HrefValue = "";

			// phn
			$this->phn->HrefValue = "";

			// order_date1
			$this->order_date1->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// productname
			$CurrentValue = $this->productname->CurrentValue;
			$ViewValue = &$this->productname->ViewValue;
			$ViewAttrs = &$this->productname->ViewAttrs;
			$CellAttrs = &$this->productname->CellAttrs;
			$HrefValue = &$this->productname->HrefValue;
			$LinkAttrs = &$this->productname->LinkAttrs;
			$this->Cell_Rendered($this->productname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// quantity
			$CurrentValue = $this->quantity->CurrentValue;
			$ViewValue = &$this->quantity->ViewValue;
			$ViewAttrs = &$this->quantity->ViewAttrs;
			$CellAttrs = &$this->quantity->CellAttrs;
			$HrefValue = &$this->quantity->HrefValue;
			$LinkAttrs = &$this->quantity->LinkAttrs;
			$this->Cell_Rendered($this->quantity, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// description
			$CurrentValue = $this->description->CurrentValue;
			$ViewValue = &$this->description->ViewValue;
			$ViewAttrs = &$this->description->ViewAttrs;
			$CellAttrs = &$this->description->CellAttrs;
			$HrefValue = &$this->description->HrefValue;
			$LinkAttrs = &$this->description->LinkAttrs;
			$this->Cell_Rendered($this->description, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->CurrentValue;
			$ViewValue = &$this->price->ViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// size
			$CurrentValue = $this->size->CurrentValue;
			$ViewValue = &$this->size->ViewValue;
			$ViewAttrs = &$this->size->ViewAttrs;
			$CellAttrs = &$this->size->CellAttrs;
			$HrefValue = &$this->size->HrefValue;
			$LinkAttrs = &$this->size->LinkAttrs;
			$this->Cell_Rendered($this->size, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// quantity1
			$CurrentValue = $this->quantity1->CurrentValue;
			$ViewValue = &$this->quantity1->ViewValue;
			$ViewAttrs = &$this->quantity1->ViewAttrs;
			$CellAttrs = &$this->quantity1->CellAttrs;
			$HrefValue = &$this->quantity1->HrefValue;
			$LinkAttrs = &$this->quantity1->LinkAttrs;
			$this->Cell_Rendered($this->quantity1, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// total_amount
			$CurrentValue = $this->total_amount->CurrentValue;
			$ViewValue = &$this->total_amount->ViewValue;
			$ViewAttrs = &$this->total_amount->ViewAttrs;
			$CellAttrs = &$this->total_amount->CellAttrs;
			$HrefValue = &$this->total_amount->HrefValue;
			$LinkAttrs = &$this->total_amount->LinkAttrs;
			$this->Cell_Rendered($this->total_amount, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// order_date
			$CurrentValue = $this->order_date->CurrentValue;
			$ViewValue = &$this->order_date->ViewValue;
			$ViewAttrs = &$this->order_date->ViewAttrs;
			$CellAttrs = &$this->order_date->CellAttrs;
			$HrefValue = &$this->order_date->HrefValue;
			$LinkAttrs = &$this->order_date->LinkAttrs;
			$this->Cell_Rendered($this->order_date, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// fname
			$CurrentValue = $this->fname->CurrentValue;
			$ViewValue = &$this->fname->ViewValue;
			$ViewAttrs = &$this->fname->ViewAttrs;
			$CellAttrs = &$this->fname->CellAttrs;
			$HrefValue = &$this->fname->HrefValue;
			$LinkAttrs = &$this->fname->LinkAttrs;
			$this->Cell_Rendered($this->fname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// lname
			$CurrentValue = $this->lname->CurrentValue;
			$ViewValue = &$this->lname->ViewValue;
			$ViewAttrs = &$this->lname->ViewAttrs;
			$CellAttrs = &$this->lname->CellAttrs;
			$HrefValue = &$this->lname->HrefValue;
			$LinkAttrs = &$this->lname->LinkAttrs;
			$this->Cell_Rendered($this->lname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// address
			$CurrentValue = $this->address->CurrentValue;
			$ViewValue = &$this->address->ViewValue;
			$ViewAttrs = &$this->address->ViewAttrs;
			$CellAttrs = &$this->address->CellAttrs;
			$HrefValue = &$this->address->HrefValue;
			$LinkAttrs = &$this->address->LinkAttrs;
			$this->Cell_Rendered($this->address, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// gender
			$CurrentValue = $this->gender->CurrentValue;
			$ViewValue = &$this->gender->ViewValue;
			$ViewAttrs = &$this->gender->ViewAttrs;
			$CellAttrs = &$this->gender->CellAttrs;
			$HrefValue = &$this->gender->HrefValue;
			$LinkAttrs = &$this->gender->LinkAttrs;
			$this->Cell_Rendered($this->gender, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// phn
			$CurrentValue = $this->phn->CurrentValue;
			$ViewValue = &$this->phn->ViewValue;
			$ViewAttrs = &$this->phn->ViewAttrs;
			$CellAttrs = &$this->phn->CellAttrs;
			$HrefValue = &$this->phn->HrefValue;
			$LinkAttrs = &$this->phn->LinkAttrs;
			$this->Cell_Rendered($this->phn, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// order_date1
			$CurrentValue = $this->order_date1->CurrentValue;
			$ViewValue = &$this->order_date1->ViewValue;
			$ViewAttrs = &$this->order_date1->ViewAttrs;
			$CellAttrs = &$this->order_date1->CellAttrs;
			$HrefValue = &$this->order_date1->HrefValue;
			$LinkAttrs = &$this->order_date1->LinkAttrs;
			$this->Cell_Rendered($this->order_date1, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->productname->Visible) $this->DtlColumnCount += 1;
		if ($this->quantity->Visible) $this->DtlColumnCount += 1;
		if ($this->description->Visible) $this->DtlColumnCount += 1;
		if ($this->price->Visible) $this->DtlColumnCount += 1;
		if ($this->size->Visible) $this->DtlColumnCount += 1;
		if ($this->quantity1->Visible) $this->DtlColumnCount += 1;
		if ($this->total_amount->Visible) $this->DtlColumnCount += 1;
		if ($this->order_date->Visible) $this->DtlColumnCount += 1;
		if ($this->fname->Visible) $this->DtlColumnCount += 1;
		if ($this->lname->Visible) $this->DtlColumnCount += 1;
		if ($this->address->Visible) $this->DtlColumnCount += 1;
		if ($this->gender->Visible) $this->DtlColumnCount += 1;
		if ($this->phn->Visible) $this->DtlColumnCount += 1;
		if ($this->order_date1->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("rpt", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $grFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

			// Set/clear dropdown for field order_date
			if ($this->PopupName == 'order_order_date' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->order_date->DropDownValue = EWR_ALL_VALUE;
				else
					$this->order_date->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'order_order_date') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'order_date');
			}

			// Set/clear dropdown for field order_date1
			if ($this->PopupName == 'order_order_date1' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->order_date1->DropDownValue = EWR_ALL_VALUE;
				else
					$this->order_date1->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'order_order_date1') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'order_date1');
			}

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionDropDownValue($this->order_date->DropDownValue, $this->order_date->SearchOperator, 'order_date'); // Field order_date
			$this->SetSessionDropDownValue($this->order_date1->DropDownValue, $this->order_date1->SearchOperator, 'order_date1'); // Field order_date1

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field order_date
			if ($this->GetDropDownValue($this->order_date)) {
				$bSetupFilter = TRUE;
			} elseif ($this->order_date->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_order_order_date'])) {
				$bSetupFilter = TRUE;
			}

			// Field order_date1
			if ($this->GetDropDownValue($this->order_date1)) {
				$bSetupFilter = TRUE;
			} elseif ($this->order_date1->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_order_order_date1'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($grFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionDropDownValue($this->order_date); // Field order_date
			$this->GetSessionDropDownValue($this->order_date1); // Field order_date1
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildDropDownFilter($this->order_date, $sFilter, $this->order_date->SearchOperator, FALSE, TRUE); // Field order_date
		$this->BuildDropDownFilter($this->order_date1, $sFilter, $this->order_date1->SearchOperator, FALSE, TRUE); // Field order_date1

		// Save parms to session
		$this->SetSessionDropDownValue($this->order_date->DropDownValue, $this->order_date->SearchOperator, 'order_date'); // Field order_date
		$this->SetSessionDropDownValue($this->order_date1->DropDownValue, $this->order_date1->SearchOperator, 'order_date1'); // Field order_date1

		// Setup filter
		if ($bSetupFilter) {

			// Field order_date
			$sWrk = "";
			$this->BuildDropDownFilter($this->order_date, $sWrk, $this->order_date->SearchOperator);
			ewr_LoadSelectionFromFilter($this->order_date, $sWrk, $this->order_date->SelectionList, $this->order_date->DropDownValue);
			$_SESSION['sel_order_order_date'] = ($this->order_date->SelectionList == "") ? EWR_INIT_VALUE : $this->order_date->SelectionList;

			// Field order_date1
			$sWrk = "";
			$this->BuildDropDownFilter($this->order_date1, $sWrk, $this->order_date1->SearchOperator);
			ewr_LoadSelectionFromFilter($this->order_date1, $sWrk, $this->order_date1->SelectionList, $this->order_date1->DropDownValue);
			$_SESSION['sel_order_order_date1'] = ($this->order_date1->SelectionList == "") ? EWR_INIT_VALUE : $this->order_date1->SelectionList;
		}

		// Field order_date
		ewr_LoadDropDownList($this->order_date->DropDownList, $this->order_date->DropDownValue);

		// Field order_date1
		ewr_LoadDropDownList($this->order_date1->DropDownList, $this->order_date1->DropDownValue);
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@")
					$this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@")
				$this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if (ewr_SameStr($FldVal, EWR_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif (ewr_SameStr($FldVal, EWR_NOT_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif (ewr_SameStr($FldVal, EWR_EMPTY_VALUE)) {
			$sWrk = $FldExpression . " = ''";
		} elseif (ewr_SameStr($FldVal, EWR_ALL_VALUE)) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "" && ($FldDataType == EWR_DATATYPE_STRING || $FldDataType == EWR_DATATYPE_MEMO)) {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID, 0, 2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = @$_GET["so_$parm"];
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = @$_GET["sv_$parm"];
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = @$_GET["sv_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = @$_GET["so_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = @$_GET["sc_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = @$_GET["sv2_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = $_GET["so2_$parm"];
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_order_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_order_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_order_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_order_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_order_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_order_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_order_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_order_' . $parm] = $sv;
		$_SESSION['so_order_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_order_' . $parm] = $sv1;
		$_SESSION['so_order_' . $parm] = $so1;
		$_SESSION['sc_order_' . $parm] = $sc;
		$_SESSION['sv2_order_' . $parm] = $sv2;
		$_SESSION['so2_order_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $grFormError;

		// Initialize form error message
		$grFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($grFormError == "");

		// Return validate result
		$ValidateForm = ($grFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$grFormError .= ($grFormError <> "") ? "<p>&nbsp;</p>" : "";
			$grFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_order_$parm"] = "";
		$_SESSION["rf_order_$parm"] = "";
		$_SESSION["rt_order_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_order_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_order_$parm"];
		$fld->RangeTo = @$_SESSION["rt_order_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/

		// Field order_date
		$this->order_date->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->order_date->DropDownValue = $this->order_date->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->order_date, $sWrk, $this->order_date->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->order_date, $sWrk, $this->order_date->DefaultSelectionList);
		if (!$this->SearchCommand) $this->order_date->SelectionList = $this->order_date->DefaultSelectionList;

		// Field order_date1
		$this->order_date1->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->order_date1->DropDownValue = $this->order_date1->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->order_date1, $sWrk, $this->order_date1->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->order_date1, $sWrk, $this->order_date1->DefaultSelectionList);
		if (!$this->SearchCommand) $this->order_date1->SelectionList = $this->order_date1->DefaultSelectionList;
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/
		/**
		* Set up default values for popup filters
		*/

		// Field order_date
		// $this->order_date->DefaultSelectionList = array("val1", "val2");
		// Field order_date1
		// $this->order_date1->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check order_date extended filter
		if ($this->NonTextFilterApplied($this->order_date))
			return TRUE;

		// Check order_date popup filter
		if (!ewr_MatchedArray($this->order_date->DefaultSelectionList, $this->order_date->SelectionList))
			return TRUE;

		// Check order_date1 extended filter
		if ($this->NonTextFilterApplied($this->order_date1))
			return TRUE;

		// Check order_date1 popup filter
		if (!ewr_MatchedArray($this->order_date1->DefaultSelectionList, $this->order_date1->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field order_date
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->order_date, $sExtWrk, $this->order_date->SearchOperator);
		if (is_array($this->order_date->SelectionList))
			$sWrk = ewr_JoinArray($this->order_date->SelectionList, ", ", EWR_DATATYPE_DATE, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->order_date->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field order_date1
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->order_date1, $sExtWrk, $this->order_date1->SearchOperator);
		if (is_array($this->order_date1->SelectionList))
			$sWrk = ewr_JoinArray($this->order_date1->SelectionList, ", ", EWR_DATATYPE_DATE, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->order_date1->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field order_date
		$sWrk = "";
		$sWrk = ($this->order_date->DropDownValue <> EWR_INIT_VALUE) ? $this->order_date->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_order_date\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->order_date->SelectionList <> EWR_INIT_VALUE) ? $this->order_date->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_order_date\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field order_date1
		$sWrk = "";
		$sWrk = ($this->order_date1->DropDownValue <> EWR_INIT_VALUE) ? $this->order_date1->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_order_date1\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->order_date1->SelectionList <> EWR_INIT_VALUE) ? $this->order_date1->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_order_date1\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field order_date
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_order_date", $filter)) {
			$sWrk = $filter["sv_order_date"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_order_date"], "order_date");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_order_date", $filter)) {
			$sWrk = $filter["sel_order_date"];
			$sWrk = explode("||", $sWrk);
			$this->order_date->SelectionList = $sWrk;
			$_SESSION["sel_order_order_date"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "order_date"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "order_date");
			$this->order_date->SelectionList = "";
			$_SESSION["sel_order_order_date"] = "";
		}

		// Field order_date1
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_order_date1", $filter)) {
			$sWrk = $filter["sv_order_date1"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_order_date1"], "order_date1");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_order_date1", $filter)) {
			$sWrk = $filter["sel_order_date1"];
			$sWrk = explode("||", $sWrk);
			$this->order_date1->SelectionList = $sWrk;
			$_SESSION["sel_order_order_date1"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "order_date1"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "order_date1");
			$this->order_date1->SelectionList = "";
			$_SESSION["sel_order_order_date1"] = "";
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		if (!$this->DropDownFilterExist($this->order_date, $this->order_date->SearchOperator)) {
			if (is_array($this->order_date->SelectionList)) {
				$sFilter = ewr_FilterSql($this->order_date, "`order_date`", EWR_DATATYPE_DATE, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->order_date, $sFilter, "popup");
				$this->order_date->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->DropDownFilterExist($this->order_date1, $this->order_date1->SearchOperator)) {
			if (is_array($this->order_date1->SelectionList)) {
				$sFilter = ewr_FilterSql($this->order_date1, "`order_date1`", EWR_DATATYPE_DATE, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->order_date1, $sFilter, "popup");
				$this->order_date1->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		return $sWrk;
	}

	// Get sort parameters based on sort links clicked
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : @$_GET["order"];
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : @$_GET["ordertype"];

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->productname->setSort("");
			$this->quantity->setSort("");
			$this->description->setSort("");
			$this->price->setSort("");
			$this->size->setSort("");
			$this->quantity1->setSort("");
			$this->total_amount->setSort("");
			$this->order_date->setSort("");
			$this->fname->setSort("");
			$this->lname->setSort("");
			$this->address->setSort("");
			$this->gender->setSort("");
			$this->phn->setSort("");
			$this->order_date1->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php

// Create page object
if (!isset($order_rpt)) $order_rpt = new crorder_rpt();
if (isset($Page)) $OldPage = $Page;
$Page = &$order_rpt;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();
if (!$Page->ShowReportInDashboard)
	ewr_Header(FALSE);

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$Page->ShowReportInDashboard) { ?>
<?php include_once "phprptinc/header.php" ?>
<?php } ?>
<script type="text/javascript">

// Create page object
var order_rpt = new ewr_Page("order_rpt");

// Page properties
order_rpt.PageID = "rpt"; // Page ID
var EWR_PAGE_ID = order_rpt.PageID;
</script>
<?php if (!$Page->DrillDown && !$Page->ShowReportInDashboard) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = forderrpt = new ewr_Form("forderrpt");

// Validate method
forderrpt.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
forderrpt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
forderrpt.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
forderrpt.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
forderrpt.Lists["sv_order_date"] = {"LinkField":"sv_order_date","Ajax":true,"DisplayFields":["sv_order_date","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
forderrpt.Lists["sv_order_date1"] = {"LinkField":"sv_order_date1","Ajax":true,"DisplayFields":["sv_order_date1","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
</script>
<?php } ?>
<?php if (!$Page->DrillDown && !$Page->ShowReportInDashboard) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
<!-- Content Container -->
<div id="ewContainer" class="container-fluid ewContainer">
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<div class="ewToolbar">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
<div class="row">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
<!-- Center Container - Report -->
<div id="ewCenter" class="col-sm-12 ewCenter">
<?php } ?>
<!-- Summary Report begins -->
<div id="report_summary">
<?php if (!$Page->DrillDown && !$Page->ShowReportInDashboard) { ?>
<!-- Search form (begin) -->
<form name="forderrpt" id="forderrpt" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="forderrpt_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_order_date" class="ewCell form-group">
	<label for="sv_order_date" class="ewSearchCaption ewLabel"><?php echo $Page->order_date->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->order_date->EditAttrs["class"], "form-control"); ?>
<select data-table="order" data-field="x_order_date" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->order_date->DisplayValueSeparator) ? json_encode($Page->order_date->DisplayValueSeparator) : $Page->order_date->DisplayValueSeparator) ?>" id="sv_order_date" name="sv_order_date"<?php echo $Page->order_date->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->order_date->AdvancedFilters) ? count($Page->order_date->AdvancedFilters) : 0;
	$cntd = is_array($Page->order_date->DropDownList) ? count($Page->order_date->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->order_date->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->order_date->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->order_date->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->order_date->DropDownList[$i], "date", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_order_date" id="s_sv_order_date" value="<?php echo $Page->order_date->LookupFilterQuery() ?>">
<script type="text/javascript">
forderrpt.Lists["sv_order_date"].Options = <?php echo ewr_ArrayToJson($Page->order_date->LookupFilterOptions) ?>;
</script>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_order_date1" class="ewCell form-group">
	<label for="sv_order_date1" class="ewSearchCaption ewLabel"><?php echo $Page->order_date1->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->order_date1->EditAttrs["class"], "form-control"); ?>
<select data-table="order" data-field="x_order_date1" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->order_date1->DisplayValueSeparator) ? json_encode($Page->order_date1->DisplayValueSeparator) : $Page->order_date1->DisplayValueSeparator) ?>" id="sv_order_date1" name="sv_order_date1"<?php echo $Page->order_date1->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->order_date1->AdvancedFilters) ? count($Page->order_date1->AdvancedFilters) : 0;
	$cntd = is_array($Page->order_date1->DropDownList) ? count($Page->order_date1->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->order_date1->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->order_date1->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->order_date1->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->order_date1->DropDownList[$i], "date", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_order_date1" id="s_sv_order_date1" value="<?php echo $Page->order_date1->LookupFilterQuery() ?>">
<script type="text/javascript">
forderrpt.Lists["sv_order_date1"].Options = <?php echo ewr_ArrayToJson($Page->order_date1->LookupFilterOptions) ?>;
</script>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
forderrpt.Init();
forderrpt.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_order" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->productname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="productname"><div class="order_productname"><span class="ewTableHeaderCaption"><?php echo $Page->productname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="productname">
<?php if ($Page->SortUrl($Page->productname) == "") { ?>
		<div class="ewTableHeaderBtn order_productname">
			<span class="ewTableHeaderCaption"><?php echo $Page->productname->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_productname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->productname) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->productname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->productname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->productname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->quantity->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="quantity"><div class="order_quantity"><span class="ewTableHeaderCaption"><?php echo $Page->quantity->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="quantity">
<?php if ($Page->SortUrl($Page->quantity) == "") { ?>
		<div class="ewTableHeaderBtn order_quantity">
			<span class="ewTableHeaderCaption"><?php echo $Page->quantity->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_quantity" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->quantity) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->quantity->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->description->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="description"><div class="order_description"><span class="ewTableHeaderCaption"><?php echo $Page->description->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="description">
<?php if ($Page->SortUrl($Page->description) == "") { ?>
		<div class="ewTableHeaderBtn order_description">
			<span class="ewTableHeaderCaption"><?php echo $Page->description->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_description" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->description) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->description->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->description->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->description->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="price"><div class="order_price"><span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="price">
<?php if ($Page->SortUrl($Page->price) == "") { ?>
		<div class="ewTableHeaderBtn order_price">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_price" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->price) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->size->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="size"><div class="order_size"><span class="ewTableHeaderCaption"><?php echo $Page->size->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="size">
<?php if ($Page->SortUrl($Page->size) == "") { ?>
		<div class="ewTableHeaderBtn order_size">
			<span class="ewTableHeaderCaption"><?php echo $Page->size->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_size" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->size) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->size->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->size->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->size->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->quantity1->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="quantity1"><div class="order_quantity1"><span class="ewTableHeaderCaption"><?php echo $Page->quantity1->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="quantity1">
<?php if ($Page->SortUrl($Page->quantity1) == "") { ?>
		<div class="ewTableHeaderBtn order_quantity1">
			<span class="ewTableHeaderCaption"><?php echo $Page->quantity1->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_quantity1" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->quantity1) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->quantity1->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->quantity1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->quantity1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->total_amount->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="total_amount"><div class="order_total_amount"><span class="ewTableHeaderCaption"><?php echo $Page->total_amount->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="total_amount">
<?php if ($Page->SortUrl($Page->total_amount) == "") { ?>
		<div class="ewTableHeaderBtn order_total_amount">
			<span class="ewTableHeaderCaption"><?php echo $Page->total_amount->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_total_amount" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->total_amount) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->total_amount->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->total_amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->total_amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->order_date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="order_date"><div class="order_order_date"><span class="ewTableHeaderCaption"><?php echo $Page->order_date->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="order_date">
<?php if ($Page->SortUrl($Page->order_date) == "") { ?>
		<div class="ewTableHeaderBtn order_order_date">
			<span class="ewTableHeaderCaption"><?php echo $Page->order_date->FldCaption() ?></span>
	<?php if (!$Page->ShowReportInDashboard) { ?>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, { name: 'order_order_date', range: false, from: '<?php echo $Page->order_date->RangeFrom; ?>', to: '<?php echo $Page->order_date->RangeTo; ?>', url: 'orderrpt.php' });" id="x_order_date<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
	<?php } ?>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_order_date" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->order_date) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->order_date->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->order_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->order_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
	<?php if (!$Page->ShowReportInDashboard) { ?>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, { name: 'order_order_date', range: false, from: '<?php echo $Page->order_date->RangeFrom; ?>', to: '<?php echo $Page->order_date->RangeTo; ?>', url: 'orderrpt.php' });" id="x_order_date<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
	<?php } ?>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->fname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="fname"><div class="order_fname"><span class="ewTableHeaderCaption"><?php echo $Page->fname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="fname">
<?php if ($Page->SortUrl($Page->fname) == "") { ?>
		<div class="ewTableHeaderBtn order_fname">
			<span class="ewTableHeaderCaption"><?php echo $Page->fname->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_fname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->fname) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->fname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->fname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->fname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->lname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="lname"><div class="order_lname"><span class="ewTableHeaderCaption"><?php echo $Page->lname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="lname">
<?php if ($Page->SortUrl($Page->lname) == "") { ?>
		<div class="ewTableHeaderBtn order_lname">
			<span class="ewTableHeaderCaption"><?php echo $Page->lname->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_lname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->lname) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->lname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->lname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->lname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->address->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="address"><div class="order_address"><span class="ewTableHeaderCaption"><?php echo $Page->address->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="address">
<?php if ($Page->SortUrl($Page->address) == "") { ?>
		<div class="ewTableHeaderBtn order_address">
			<span class="ewTableHeaderCaption"><?php echo $Page->address->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_address" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->address) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->address->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->address->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->address->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->gender->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="gender"><div class="order_gender"><span class="ewTableHeaderCaption"><?php echo $Page->gender->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="gender">
<?php if ($Page->SortUrl($Page->gender) == "") { ?>
		<div class="ewTableHeaderBtn order_gender">
			<span class="ewTableHeaderCaption"><?php echo $Page->gender->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_gender" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->gender) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->gender->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->phn->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="phn"><div class="order_phn"><span class="ewTableHeaderCaption"><?php echo $Page->phn->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="phn">
<?php if ($Page->SortUrl($Page->phn) == "") { ?>
		<div class="ewTableHeaderBtn order_phn">
			<span class="ewTableHeaderCaption"><?php echo $Page->phn->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_phn" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->phn) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->phn->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->phn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->phn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->order_date1->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="order_date1"><div class="order_order_date1"><span class="ewTableHeaderCaption"><?php echo $Page->order_date1->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="order_date1">
<?php if ($Page->SortUrl($Page->order_date1) == "") { ?>
		<div class="ewTableHeaderBtn order_order_date1">
			<span class="ewTableHeaderCaption"><?php echo $Page->order_date1->FldCaption() ?></span>
	<?php if (!$Page->ShowReportInDashboard) { ?>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, { name: 'order_order_date1', range: false, from: '<?php echo $Page->order_date1->RangeFrom; ?>', to: '<?php echo $Page->order_date1->RangeTo; ?>', url: 'orderrpt.php' });" id="x_order_date1<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
	<?php } ?>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer order_order_date1" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->order_date1) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->order_date1->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->order_date1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->order_date1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
	<?php if (!$Page->ShowReportInDashboard) { ?>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, { name: 'order_order_date1', range: false, from: '<?php echo $Page->order_date1->RangeFrom; ?>', to: '<?php echo $Page->order_date1->RangeTo; ?>', url: 'orderrpt.php' });" id="x_order_date1<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
	<?php } ?>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->productname->Visible) { ?>
		<td data-field="productname"<?php echo $Page->productname->CellAttributes() ?>>
<span<?php echo $Page->productname->ViewAttributes() ?>><?php echo $Page->productname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->quantity->Visible) { ?>
		<td data-field="quantity"<?php echo $Page->quantity->CellAttributes() ?>>
<span<?php echo $Page->quantity->ViewAttributes() ?>><?php echo $Page->quantity->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->description->Visible) { ?>
		<td data-field="description"<?php echo $Page->description->CellAttributes() ?>>
<span<?php echo $Page->description->ViewAttributes() ?>><?php echo $Page->description->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>>
<span<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->size->Visible) { ?>
		<td data-field="size"<?php echo $Page->size->CellAttributes() ?>>
<span<?php echo $Page->size->ViewAttributes() ?>><?php echo $Page->size->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->quantity1->Visible) { ?>
		<td data-field="quantity1"<?php echo $Page->quantity1->CellAttributes() ?>>
<span<?php echo $Page->quantity1->ViewAttributes() ?>><?php echo $Page->quantity1->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->total_amount->Visible) { ?>
		<td data-field="total_amount"<?php echo $Page->total_amount->CellAttributes() ?>>
<span<?php echo $Page->total_amount->ViewAttributes() ?>><?php echo $Page->total_amount->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->order_date->Visible) { ?>
		<td data-field="order_date"<?php echo $Page->order_date->CellAttributes() ?>>
<span<?php echo $Page->order_date->ViewAttributes() ?>><?php echo $Page->order_date->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->fname->Visible) { ?>
		<td data-field="fname"<?php echo $Page->fname->CellAttributes() ?>>
<span<?php echo $Page->fname->ViewAttributes() ?>><?php echo $Page->fname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->lname->Visible) { ?>
		<td data-field="lname"<?php echo $Page->lname->CellAttributes() ?>>
<span<?php echo $Page->lname->ViewAttributes() ?>><?php echo $Page->lname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->address->Visible) { ?>
		<td data-field="address"<?php echo $Page->address->CellAttributes() ?>>
<span<?php echo $Page->address->ViewAttributes() ?>><?php echo $Page->address->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->gender->Visible) { ?>
		<td data-field="gender"<?php echo $Page->gender->CellAttributes() ?>>
<span<?php echo $Page->gender->ViewAttributes() ?>><?php echo $Page->gender->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->phn->Visible) { ?>
		<td data-field="phn"<?php echo $Page->phn->CellAttributes() ?>>
<span<?php echo $Page->phn->ViewAttributes() ?>><?php echo $Page->phn->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->order_date1->Visible) { ?>
		<td data-field="order_date1"<?php echo $Page->order_date1->CellAttributes() ?>>
<span<?php echo $Page->order_date1->ViewAttributes() ?>><?php echo $Page->order_date1->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && TRUE) { // No header displayed ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_order" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || TRUE) { // Show footer ?>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="box-footer ewGridLowerPanel">
<?php include "orderrptpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
</div>
<!-- /#ewCenter -->
<?php } ?>
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ($Page->Export == "" && !$Page->ShowReportInDashboard) { ?>
</div>
<!-- /.ewContainer -->
<?php } ?>
<?php
$Page->ShowPageFooter();
if (EWR_DEBUG_ENABLED)
	echo ewr_DebugMsg();
?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if (!$Page->DrillDown && !$Page->ShowReportInDashboard) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// console.log("page loaded");

</script>
<?php } ?>
<?php if (!$Page->ShowReportInDashboard) { ?>
<?php include_once "phprptinc/footer.php" ?>
<?php } ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>

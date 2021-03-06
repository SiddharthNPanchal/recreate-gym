<?php

// Global variable for table object
$product_company = NULL;

//
// Table class for product company
//
class crproduct_company extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $productname;
	var $quantity;
	var $description;
	var $price;
	var $type;
	var $size;
	var $productcompanyname;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 'product_company';
		$this->TableName = 'product company';
		$this->TableType = 'VIEW';
		$this->TableReportType = 'rpt';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// productname
		$this->productname = new crField('product_company', 'product company', 'x_productname', 'productname', '`productname`', 200, EWR_DATATYPE_STRING, -1);
		$this->productname->Sortable = TRUE; // Allow sort
		$this->productname->DateFilter = "";
		$this->productname->SqlSelect = "";
		$this->productname->SqlOrderBy = "";
		$this->fields['productname'] = &$this->productname;

		// quantity
		$this->quantity = new crField('product_company', 'product company', 'x_quantity', 'quantity', '`quantity`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->quantity->Sortable = TRUE; // Allow sort
		$this->quantity->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->quantity->DateFilter = "";
		$this->quantity->SqlSelect = "";
		$this->quantity->SqlOrderBy = "";
		$this->fields['quantity'] = &$this->quantity;

		// description
		$this->description = new crField('product_company', 'product company', 'x_description', 'description', '`description`', 200, EWR_DATATYPE_STRING, -1);
		$this->description->Sortable = TRUE; // Allow sort
		$this->description->DateFilter = "";
		$this->description->SqlSelect = "";
		$this->description->SqlOrderBy = "";
		$this->fields['description'] = &$this->description;

		// price
		$this->price = new crField('product_company', 'product company', 'x_price', 'price', '`price`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->price->Sortable = TRUE; // Allow sort
		$this->price->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->price->DateFilter = "";
		$this->price->SqlSelect = "";
		$this->price->SqlOrderBy = "";
		$this->fields['price'] = &$this->price;

		// type
		$this->type = new crField('product_company', 'product company', 'x_type', 'type', '`type`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->type->Sortable = TRUE; // Allow sort
		$this->type->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->type->DateFilter = "";
		$this->type->SqlSelect = "";
		$this->type->SqlOrderBy = "";
		$this->fields['type'] = &$this->type;

		// size
		$this->size = new crField('product_company', 'product company', 'x_size', 'size', '`size`', 200, EWR_DATATYPE_STRING, -1);
		$this->size->Sortable = TRUE; // Allow sort
		$this->size->DateFilter = "";
		$this->size->SqlSelect = "";
		$this->size->SqlOrderBy = "";
		$this->fields['size'] = &$this->size;

		// productcompanyname
		$this->productcompanyname = new crField('product_company', 'product company', 'x_productcompanyname', 'productcompanyname', '`productcompanyname`', 200, EWR_DATATYPE_STRING, -1);
		$this->productcompanyname->Sortable = TRUE; // Allow sort
		$this->productcompanyname->DateFilter = "";
		$this->productcompanyname->SqlSelect = "SELECT DISTINCT `productcompanyname`, `productcompanyname` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->productcompanyname->SqlOrderBy = "`productcompanyname`";
		$this->fields['productcompanyname'] = &$this->productcompanyname;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ofld->GroupingFieldId == 0)
				$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`product company`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		global $grDashboardReport;
		return "";
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		case "x_productcompanyname":
			$fld->LookupFilters = array("d" => "DB", "f0" => '`productcompanyname` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter), "af" => json_encode($fld->AdvancedFilters));
		$sWhereWrk = "";
		$fld->LookupFilters += array(
			"select" => "SELECT DISTINCT `productcompanyname`, `productcompanyname` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `product company`",
			"where" => $sWhereWrk,
			"orderby" => "`productcompanyname` ASC"
		);
		$this->Lookup_Selecting($fld, $fld->LookupFilters["where"]); // Call Lookup selecting
		$fld->LookupFilters["s"] = ewr_BuildReportSql($fld->LookupFilters["select"], $fld->LookupFilters["where"], "", "", $fld->LookupFilters["orderby"], "", "");
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>

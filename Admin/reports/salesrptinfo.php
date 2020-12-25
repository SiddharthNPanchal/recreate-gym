<?php

// Global variable for table object
$sales = NULL;

//
// Table class for sales
//
class crsales extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $productname;
	var $quantity;
	var $description;
	var $price;
	var $size;
	var $quantity1;
	var $total_amount;
	var $order_date;
	var $fname;
	var $lname;
	var $address;
	var $gender;
	var $phn;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 'sales';
		$this->TableName = 'sales';
		$this->TableType = 'VIEW';
		$this->TableReportType = 'rpt';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// productname
		$this->productname = new crField('sales', 'sales', 'x_productname', 'productname', '`productname`', 200, EWR_DATATYPE_STRING, -1);
		$this->productname->Sortable = TRUE; // Allow sort
		$this->productname->DateFilter = "";
		$this->productname->SqlSelect = "";
		$this->productname->SqlOrderBy = "";
		$this->fields['productname'] = &$this->productname;

		// quantity
		$this->quantity = new crField('sales', 'sales', 'x_quantity', 'quantity', '`quantity`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->quantity->Sortable = TRUE; // Allow sort
		$this->quantity->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->quantity->DateFilter = "";
		$this->quantity->SqlSelect = "";
		$this->quantity->SqlOrderBy = "";
		$this->fields['quantity'] = &$this->quantity;

		// description
		$this->description = new crField('sales', 'sales', 'x_description', 'description', '`description`', 200, EWR_DATATYPE_STRING, -1);
		$this->description->Sortable = TRUE; // Allow sort
		$this->description->DateFilter = "";
		$this->description->SqlSelect = "";
		$this->description->SqlOrderBy = "";
		$this->fields['description'] = &$this->description;

		// price
		$this->price = new crField('sales', 'sales', 'x_price', 'price', '`price`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->price->Sortable = TRUE; // Allow sort
		$this->price->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->price->DateFilter = "";
		$this->price->SqlSelect = "";
		$this->price->SqlOrderBy = "";
		$this->fields['price'] = &$this->price;

		// size
		$this->size = new crField('sales', 'sales', 'x_size', 'size', '`size`', 200, EWR_DATATYPE_STRING, -1);
		$this->size->Sortable = TRUE; // Allow sort
		$this->size->DateFilter = "";
		$this->size->SqlSelect = "";
		$this->size->SqlOrderBy = "";
		$this->fields['size'] = &$this->size;

		// quantity1
		$this->quantity1 = new crField('sales', 'sales', 'x_quantity1', 'quantity1', '`quantity1`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->quantity1->Sortable = TRUE; // Allow sort
		$this->quantity1->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->quantity1->DateFilter = "";
		$this->quantity1->SqlSelect = "";
		$this->quantity1->SqlOrderBy = "";
		$this->fields['quantity1'] = &$this->quantity1;

		// total_amount
		$this->total_amount = new crField('sales', 'sales', 'x_total_amount', 'total_amount', '`total_amount`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->total_amount->Sortable = TRUE; // Allow sort
		$this->total_amount->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->total_amount->DateFilter = "";
		$this->total_amount->SqlSelect = "";
		$this->total_amount->SqlOrderBy = "";
		$this->fields['total_amount'] = &$this->total_amount;

		// order_date
		$this->order_date = new crField('sales', 'sales', 'x_order_date', 'order_date', '`order_date`', 133, EWR_DATATYPE_DATE, 0);
		$this->order_date->Sortable = TRUE; // Allow sort
		$this->order_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->order_date->DateFilter = "";
		$this->order_date->SqlSelect = "";
		$this->order_date->SqlOrderBy = "";
		$this->fields['order_date'] = &$this->order_date;

		// fname
		$this->fname = new crField('sales', 'sales', 'x_fname', 'fname', '`fname`', 200, EWR_DATATYPE_STRING, -1);
		$this->fname->Sortable = TRUE; // Allow sort
		$this->fname->DateFilter = "";
		$this->fname->SqlSelect = "";
		$this->fname->SqlOrderBy = "";
		$this->fields['fname'] = &$this->fname;

		// lname
		$this->lname = new crField('sales', 'sales', 'x_lname', 'lname', '`lname`', 200, EWR_DATATYPE_STRING, -1);
		$this->lname->Sortable = TRUE; // Allow sort
		$this->lname->DateFilter = "";
		$this->lname->SqlSelect = "";
		$this->lname->SqlOrderBy = "";
		$this->fields['lname'] = &$this->lname;

		// address
		$this->address = new crField('sales', 'sales', 'x_address', 'address', '`address`', 200, EWR_DATATYPE_STRING, -1);
		$this->address->Sortable = TRUE; // Allow sort
		$this->address->DateFilter = "";
		$this->address->SqlSelect = "";
		$this->address->SqlOrderBy = "";
		$this->fields['address'] = &$this->address;

		// gender
		$this->gender = new crField('sales', 'sales', 'x_gender', 'gender', '`gender`', 200, EWR_DATATYPE_STRING, -1);
		$this->gender->Sortable = TRUE; // Allow sort
		$this->gender->DateFilter = "";
		$this->gender->SqlSelect = "";
		$this->gender->SqlOrderBy = "";
		$this->fields['gender'] = &$this->gender;

		// phn
		$this->phn = new crField('sales', 'sales', 'x_phn', 'phn', '`phn`', 20, EWR_DATATYPE_NUMBER, -1);
		$this->phn->Sortable = TRUE; // Allow sort
		$this->phn->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->phn->DateFilter = "";
		$this->phn->SqlSelect = "";
		$this->phn->SqlOrderBy = "";
		$this->fields['phn'] = &$this->phn;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`sales`";
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

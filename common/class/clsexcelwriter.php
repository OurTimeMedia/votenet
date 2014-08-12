<?PHP
class excelwriter extends common
{
	/**
	 * This one makes the beginning of the xls file
	 */
	
	function xlsBOF() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}
	
	/**
	 * This one makes the end of the xls file
	 */
	function xlsEOF() {
		echo pack("ss", 0x0A, 0x00);
		return;
	}
	
	/**
	 * this will write text in the cell you specify.
	 *
	 * @param int    $Row   no. of rows.
	 * @param int    $Col   no. of columns.
	 * @param string $Value contains data.
	 */
	function xlsWriteLabel($Row, $Col, $Value ) {
		$L = strlen($Value);
		echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		echo $Value;
		return;
	}
}
?>
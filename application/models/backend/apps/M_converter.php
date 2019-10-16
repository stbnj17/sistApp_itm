<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Convertidor - Aplicaciones
 */
class M_converter extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listConvertions($customer_id) {
		$this->db->select('id, fileName_xlsx as excel, fileName_txt as text, DATE_FORMAT(created, "%d/%m/%Y") as fecha');
		$this->db->where('customer_id', $customer_id);
		$qListSchedule = $this->db->get('convert_files');
		return $qListSchedule->result_array();
	}

	function __newConvertFile($customer_id, $fileNameXls, $fileNameTxt, $sheetName, $col, $row) {
		$this->db->trans_begin();

		$dataFile = array(
			'customer_id' => $customer_id, 
			'fileName_xlsx' => $fileNameXls, 
			'fileName_txt' => $fileNameTxt, 
			'sheetName' => $sheetName, 
			'lengthCol' => $col, 
			'lengthRow' => $row
		);

		$this->db->set('created', 'NOW()', FALSE);
		$qnewSchedule = $this->db->insert('convert_files', $dataFile);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __deleteRecordHistory($postData) {
		$this->db->trans_begin();
		$this->db->delete('convert_files', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
}
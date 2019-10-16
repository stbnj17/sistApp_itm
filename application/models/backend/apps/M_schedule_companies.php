<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Cronograma y Empresas - Aplicaciones
 */
class M_schedule_companies extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listCompaniesUser($customer_id) {
		$this->db->select('id, company, num_doc');
		$this->db->where('customer_id', $customer_id);
		$qListCompanies = $this->db->get('companies');
		return $qListCompanies->result_array();
	}

	function __newCompany($postData) {
		$this->db->trans_begin();
		$data = array(
			'customer_id' => $postData['customer'], 
			'company' => $postData['nameEmpresa'], 
			'num_doc' => $postData['nDocumento'], 
			'phone' => $postData['telf'],
			'aditional' => $postData['aditional']
		);
		
		$qnewCompany = $this->db->insert('companies', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewCompany($postData) {
		$this->db->select('id AS codC, company AS empresa, num_doc AS ndoc, phone AS telf, aditional AS adicional');
		$this->db->where('id', $postData['id']);
		$qverCompany = $this->db->get('companies');
		return $qverCompany->result_array();
	}

	function __editCompany($postData) {
		$dataCompany = array(
			'company' => $postData['eNameEmpresa'], 
			'num_doc' => $postData['eNdocumento'], 
			'phone' => $postData['eTelf'],
			'aditional' => $postData['aditional']
		);

		$this->db->trans_begin();
		$this->db->update('companies', $dataCompany, array('id' => $postData['eCodC']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteCompany($postData) {
		$this->db->trans_begin();
		$this->db->delete('companies', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __viewSchedule($period) {
		$this->db->select('pt.part_table, tc.type, sc.text_cell, sc.col_index, sc.row_index, sc.rowspan, sc.colspan');
		$this->db->join('schedule_columns sc', 'sc.schedule_file_id = sf.id', 'left');
		$this->db->join('schedule_type_contributor tc', 'sc.type_contributor_id = tc.id', 'left');
		$this->db->join('schedule_part_table pt', 'sc.part_table_id = pt.id', 'left');
		$this->db->where('sf.period', $period);
		$this->db->where('sf.active', '1');
		$qverSchedule = $this->db->get('schedule_files sf');
		return $qverSchedule->result_array();
		/*return $this->db->get_compiled_select('schedule_columns sc');*/
	}

	function __verifChanges($postData) {
		$this->db->from('companies');
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('company', "BINARY '".$postData['eNameEmpresa']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdocumento']);
		$this->db->where('phone', $postData['eTelf']);
		$this->db->where('aditional', $postData['aditional']);

		return $this->db->count_all_results();
	}

	function __verifUnique($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'companies', 'id' => $postData['eCodC'], 'customer_id' => $postData['eCustomer'], 'field' => 'company', 'value' => $postData['eNameEmpresa'], 'label' => 'La Razón Social'),
				array('table' => 'companies', 'id' => $postData['eCodC'], 'customer_id' => $postData['eCustomer'], 'field' => 'num_doc', 'value' => $postData['eNdocumento'], 'label' => 'El N° de Documento'),
			);
		} else {
			$data = array(
				array('table' => 'companies', 'customer_id' => $postData['customer'], 'field' => 'company', 'value' => $postData['nameEmpresa'], 'label' => 'La Razón Social'),
				array('table' => 'companies', 'customer_id' => $postData['customer'], 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento'),
			);
		}

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data, $op);
		}

		return $resError;
	}

	function __validateUnique($i, $data, $op) {
		if ($op == 'edit') {
			$this->db->where('id <>', $data[$i]['id']);
		}
		$this->db->where($data[$i]['field'], $data[$i]['value']);
		$this->db->where('customer_id', $data[$i]['customer_id']);
		$num = $this->db->count_all_results($data[$i]['table']);
		$msj = '';

		if ($num > 0) {
			$msj = $data[$i]['label'] . ' ya existe.|';
		}
		return $msj;
	}
}
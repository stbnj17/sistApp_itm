<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Clientes
 */
class M_customers extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listCustomers() {
		$qListCustomer = $this->db->get('customers');
		return $qListCustomer->result_array();
	}

	function __newCustomer($postData) {
		$this->db->trans_begin();
		$data = array(
			'name' => $postData['name'], 
			'surname' => $postData['surname'], 
			'num_doc' => $postData['nDoc'], 
			'occupation' => $postData['occupation'], 
			'email' => $postData['email'], 
			'phone' => $postData['phone']
		);
		
		$this->db->insert('customers', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewCustomer($postData) {
		$this->db->select('id AS codC, name AS nombre, surname AS apellido, num_doc AS ndoc, occupation AS ocupacion, email AS correo, phone AS telf');
		$this->db->where('id', $postData['id']);
		$qverCustomer = $this->db->get('customers');
		return $qverCustomer->result_array();
	}

	function __editCustomer($postData) {
		$dataCustomer = array(
			'name' => $postData['eName'], 
			'surname' => $postData['eSurname'], 
			'num_doc' => $postData['eNdoc'], 
			'occupation' => $postData['eOccupation'], 
			'email' => $postData['eEmail'], 
			'phone' => $postData['ePhone']
		);

		$this->db->trans_begin();
		$this->db->update('customers', $dataCustomer, array('id' => $postData['eCodC']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteCustomer($postData) {
		$this->db->trans_begin();
		$this->db->delete('customers', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('customers');
		$this->db->where('name', "BINARY '".$postData['eName']."'", FALSE);
		$this->db->where('surname', "BINARY '".$postData['eSurname']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdoc']);
		$this->db->where('occupation', "BINARY '".$postData['eOccupation']."'", FALSE);
		$this->db->where('email', "BINARY '".$postData['eEmail']."'", FALSE);
		$this->db->where('phone', $postData['ePhone']);

		return $this->db->count_all_results();
	}

	function __verifUnique($postData) {
		$resError = '';
		$data = array(
			array('table' => 'customers', 'id' => $postData['eCodC'], 'field' => 'num_doc', 'value' => $postData['eNdoc'], 'label' => 'N° de Documento'),
			array('table' => 'customers', 'id' => $postData['eCodC'], 'field' => 'email', 'value' => $postData['eEmail'], 'label' => 'Email'),
		);

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data);
		}

		return $resError;
	}

	function __validateUnique($i, $data) {
		$this->db->where('id <>', $data[$i]['id']);
		$this->db->where($data[$i]['field'], $data[$i]['value']);
		$num = $this->db->count_all_results($data[$i]['table']);
		$msj = '';

		if ($num > 0) {
			$msj = 'El ' .$data[$i]['label'] . ' ya existe.|';
		}
		return $msj;
	}
}
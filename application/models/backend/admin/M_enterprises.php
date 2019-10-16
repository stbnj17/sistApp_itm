<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Empresas del Sistema - Admin
 */
class M_enterprises extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listEnterprises() {
		$this->db->select('id, enterprise, num_doc, address, phone, email, comission, status');
		$qListProducts = $this->db->get('enterprises');
		return $qListProducts->result_array();
	}

	function __newEnterprise($postData) {
		$this->db->trans_begin();
		$data = array(
			'enterprise' => $postData['empresa'], 
			'num_doc' => $postData['nDocumento'], 
			'address' => $postData['direccion'], 
			'phone' => $postData['telf'], 
			'email' => $postData['email'], 
			'comission' => $postData['comision'], 
			'status' => 1
		);
		
		$this->db->insert('enterprises', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewEnterprise($postData) {
		$this->db->select('id AS codE, enterprise AS empresa, num_doc AS nDocumento, address AS direccion, email AS correo, phone AS telf, comission AS comision');
		$this->db->where('id', $postData['id']);
		$qverCustomer = $this->db->get('enterprises');
		return $qverCustomer->result_array();
	}

	function __editEnterprise($postData) {
		$dataCustomer = array(
			'enterprise' => $postData['empresa'], 
			'num_doc' => $postData['nDocumento'], 
			'address' => $postData['direccion'], 
			'phone' => $postData['telf'], 
			'email' => $postData['email'], 
			'comission' => $postData['comision']
		);

		$this->db->trans_begin();
		$this->db->update('enterprises', $dataCustomer, array('id' => $postData['codE']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteEnterprise($postData) {
		$this->db->trans_begin();
		$this->db->delete('enterprises', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('enterprises');
		$this->db->where('id', $postData['codE']);
		$this->db->where('enterprise', "BINARY '".$postData['empresa']."'", FALSE);
		$this->db->where('num_doc', $postData['nDocumento']);
		$this->db->where('address', "BINARY '".$postData['direccion']."'", FALSE);
		$this->db->where('email', "BINARY '".$postData['email']."'", FALSE);
		$this->db->where('phone', $postData['telf']);
		$this->db->where('comission', "BINARY '".$postData['comision']."'", FALSE);

		return $this->db->count_all_results();
	}

	function __verifUnique($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'enterprises', 'id' => $postData['codE'], 'field' => 'enterprise', 'value' => $postData['empresa'], 'label' => 'La Empresa'),
				array('table' => 'enterprises', 'id' => $postData['codE'], 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento')
			);
		} else {
			$data = array(
				array('table' => 'enterprises', 'field' => 'enterprise', 'value' => $postData['empresa'], 'label' => 'La Empresa'),
				array('table' => 'enterprises', 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento')
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
		$this->db->where('status', $data[$i]['1']);
		$num = $this->db->count_all_results($data[$i]['table']);
		$msj = '';

		if ($num > 0) {
			$msj = $data[$i]['label'] . ' ya existe.|';
		}
		return $msj;
	}
}
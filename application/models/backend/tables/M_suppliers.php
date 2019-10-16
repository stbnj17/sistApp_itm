<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Proveedores - Tablas
 */
class M_suppliers extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listSuppliers($customer_id) {
		$this->db->select('id, supplier, num_doc, website, phone, email');
		$this->db->where('customer_id', $customer_id);
		$this->db->where('status', '1');
		$qListProducts = $this->db->get('suppliers');
		return $qListProducts->result_array();
	}

	function __newSupplier($postData) {
		$this->db->trans_begin();
		$data = array(
			'customer_id' => $postData['customer'], 
			'supplier' => $postData['proveedor'], 
			'num_doc' => $postData['nDocumento'], 
			'address' => $postData['direccion'], 
			'website' => $postData['web'], 
			'email' => $postData['email'], 
			'phone' => $postData['telf'], 
			'status' => 1
		);
		
		$this->db->insert('suppliers', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewSupplier($postData) {
		$this->db->select('id AS codP, supplier AS proveedor, num_doc AS ndoc, address AS direccion, website AS web, email AS correo, phone AS telf');
		$this->db->where('id', $postData['id']);
		$qverCustomer = $this->db->get('suppliers');
		return $qverCustomer->result_array();
	}

	function __editSupplier($postData) {
		$dataCustomer = array(
			'supplier' => $postData['eProveedor'], 
			'num_doc' => $postData['eNdocumento'], 
			'address' => $postData['eDireccion'], 
			'website' => $postData['web'], 
			'email' => $postData['eEmail'], 
			'phone' => $postData['eTelf']
		);

		$this->db->trans_begin();
		$this->db->update('suppliers', $dataCustomer, array('id' => $postData['eCodP']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteSupplier($postData) {
		$this->db->trans_begin();
		$this->db->delete('suppliers', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('suppliers');
		$this->db->where('id', $postData['eCodP']);
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('supplier', "BINARY '".$postData['eProveedor']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdocumento']);
		$this->db->where('address', "BINARY '".$postData['eDireccion']."'", FALSE);
		$this->db->where('website', "BINARY '".$postData['web']."'", FALSE);
		$this->db->where('email', "BINARY '".$postData['eEmail']."'", FALSE);
		$this->db->where('phone', $postData['eTelf']);

		return $this->db->count_all_results();
	}

	function __verifUnique($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'suppliers', 'id' => $postData['eCodP'], 'customer_id' => $postData['eCustomer'], 'field' => 'supplier', 'value' => $postData['eProveedor'], 'label' => 'El Proveedor'),
				array('table' => 'suppliers', 'id' => $postData['eCodP'], 'customer_id' => $postData['eCustomer'], 'field' => 'num_doc', 'value' => $postData['eNdocumento'], 'label' => 'El N° de Documento')
			);
		} else {
			$data = array(
				array('table' => 'suppliers', 'customer_id' => $postData['customer'], 'field' => 'supplier', 'value' => $postData['proveedor'], 'label' => 'El Proveedor'),
				array('table' => 'suppliers', 'customer_id' => $postData['customer'], 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento')
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
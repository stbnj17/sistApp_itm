<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Clientes (Empresa-Persona Natural) de Clientes Administrador
 */
class M_customersCustomer extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listCustomers() {
		$this->db->select('c.id, CONCAT(c.name, " ", c.surname) cliente, u.username');
		$this->db->join('users u', 'u.customer_id = c.id');
		$qListCustomer = $this->db->get('customers c');
		return $qListCustomer->result_array();
	}
	/*Funciones Empresas*/
	function __listCompanies() {
		$this->db->select('c.id, CONCAT(cu.name, " ", cu.surname) cliente, c.company, c.num_doc, c.address');
		$this->db->join('customers cu', 'cu.id = c.customer_id');
		$qListCompanies = $this->db->get('companies c');
		return $qListCompanies->result_array();
	}

	function __newCompany($postData) {
		$this->db->trans_begin();
		$dataCompany = array(
			'customer_id' => $postData['customer'], 
			'company' => $postData['nameEmpresa'], 
			'num_doc' => $postData['nDocumento'], 
			'address' => $postData['direccion'], 
			'phone' => $postData['telf'], 
			'phone_other' => $postData['telfOtro'], 
			'aditional' => $postData['aditional']
		);
		
		$this->db->insert('companies', $dataCompany);

		$this->db->select('id');
		$this->db->where('customer_id', $postData['customer']);
		$this->db->where('num_doc', $postData['nDocumento']);
		$qidCompany = $this->db->get('companies');

		if ($row = $qidCompany->row()) {
			if (!empty($postData['contacto'])) {
				$dataContact[0] =	array(
					'company_id' => $row->id, 
					'contact' => $postData['contacto'], 
					'email' => $postData['email'], 
					'phone' => $postData['phone']
				);
				$this->db->insert('company_contacts', $dataContact[0]);
			}

			if (!empty($postData['contactoOtro'])) {
				$dataContact[1] =	array(
					'company_id' => $row->id, 
					'contact' => $postData['contactoOtro'], 
					'email' => $postData['emailOtro'], 
					'phone' => $postData['phoneOther']
				);
				$this->db->insert('company_contacts', $dataContact[1]);
			}
		}

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewCompany($postData) {
		$this->db->select('id AS codC, company AS empresa, address AS direccion, num_doc AS ndoc, phone AS telf, phone_other AS telfOtro, aditional AS adicional, customer_id AS codCu');
		$this->db->where('id', $postData['id']);
		$qverCompany = $this->db->get('companies');
		$arrRes = $qverCompany->result_array();
		$arrRes['1'] = $this->__getContactCompany($postData);
		return $arrRes;
	}

	function __getContactCompany($postData) {
		$this->db->select('id AS codCo, contact AS contacto, email AS correo, phone AS telf');
		$this->db->where('company_id', $postData['id']);
		$qverContactCompany = $this->db->get('company_contacts');

		return $qverContactCompany->result_array();
	}

	function __editCompany($postData) {
		$dataCompany = array(
			'customer_id' => $postData['eCustomer'], 
			'company' => $postData['eNameEmpresa'], 
			'num_doc' => $postData['eNdocumento'], 
			'address' => $postData['eDireccion'], 
			'phone' => $postData['eTelf'],
			'phone_other' => $postData['eTelfOtro'], 
			'aditional' => $postData['aditional']
		);

		$this->db->trans_begin();
		$this->db->update('companies', $dataCompany, array('id' => $postData['eCodC']));

		$dataContact[0] =	array(
			'contact' => $postData['eContacto'], 
			'email' => $postData['eEmail'], 
			'phone' => $postData['ePhone'], 
		);
		if (!empty($postData['eContacto'])) {
			if (!empty($postData['eCodContUno'])) {
				$this->db->update('company_contacts', $dataContact[0], array('id' => $postData['eCodContUno']));
			} else {
				$dataContact[0]['company_id'] =	$postData['eCodC'];
				$this->db->insert('company_contacts', $dataContact[0]);
			}
		} else {
			if (!empty($postData['eCodContUno'])) {
				$this->db->update('company_contacts', $dataContact[0], array('id' => $postData['eCodContUno']));
			}
		}

		$dataContact[1] =	array(
			'contact' => $postData['eContactoOtro'], 
			'email' => $postData['eEmailOtro'], 
			'phone' => $postData['ePhoneOther'], 
		);
		if (!empty($postData['eContactoOtro'])) {
			if (!empty($postData['eCodContDos'])) {
				$this->db->update('company_contacts', $dataContact[1], array('id' => $postData['eCodContDos']));
			} else {
				$dataContact[1]['company_id'] =	$postData['eCodC'];
				$this->db->insert('company_contacts', $dataContact[1]);
			}
		} else {
			if (!empty($postData['eCodContDos'])) {
				$this->db->update('company_contacts', $dataContact[1], array('id' => $postData['eCodContDos']));
			}
		}

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

	function __verifChangesCompany($postData) {
		$this->db->from('companies');
		$this->db->where('id', $postData['eCodC']);
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('company', "BINARY '".$postData['eNameEmpresa']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdocumento']);
		$this->db->where('address', "BINARY '".$postData['eDireccion']."'", FALSE);
		$this->db->where('phone', $postData['eTelf']);
		$this->db->where('phone_other', $postData['eTelfOtro']);
		$this->db->where('aditional', $postData['aditional']);
		$cantResCompany = $this->db->count_all_results();

		if ($cantResCompany > 0) {
			if ($postData['eCodContUno'] != '') {
				$this->db->from('company_contacts');
				$this->db->where('id', $postData['eCodContUno']);
				$this->db->where('company_id', $postData['eCodC']);
				$this->db->where('contact', "BINARY '".$postData['eContacto']."'", FALSE);
				$this->db->where('email', "BINARY '".$postData['eEmail']."'", FALSE);
				$this->db->where('phone', $postData['ePhone']);
				$cantResCompany = $this->db->count_all_results();
			} else {
				if ($postData['eContacto'] != '' || $postData['eEmail'] != '' || $postData['ePhone'] != '') {
					$cantResCompany = 0;
				}
			}

			if ($cantResCompany > 0) {
				if ($postData['eCodContDos'] != '') {
					$this->db->from('company_contacts');
					$this->db->where('id', $postData['eCodContDos']);
					$this->db->where('company_id', $postData['eCodC']);
					$this->db->where('contact', "BINARY '".$postData['eContactoOtro']."'", FALSE);
					$this->db->where('email', "BINARY '".$postData['eEmailOtro']."'", FALSE);
					$this->db->where('phone', $postData['ePhoneOther']);
					$cantResCompany = $this->db->count_all_results();
				} else {
					if ($postData['eContactoOtro'] != '' || $postData['eEmailOtro'] != '' || $postData['ePhoneOther'] != '') {
						$cantResCompany = 0;
					}
				}
			}
		}

		return $cantResCompany;
	}

	function __verifUniqueCompany($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'companies', 'id' => $postData['eCodC'], 'customer_id' => $postData['eCustomer'], 'field' => 'company', 'value' => $postData['eNameEmpresa'], 'label' => 'La Razón Social'),
				array('table' => 'companies', 'id' => $postData['eCodC'], 'customer_id' => $postData['eCustomer'], 'field' => 'num_doc', 'value' => $postData['eNdocumento'], 'label' => 'El N° de Documento')
			);
		} else {
			$data = array(
				array('table' => 'companies', 'customer_id' => $postData['customer'], 'field' => 'company', 'value' => $postData['nameEmpresa'], 'label' => 'La Razón Social'),
				array('table' => 'companies', 'customer_id' => $postData['customer'], 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento')
			);
		}

		for ($i=0; $i < count($data); $i++) {
			$resError .= $this->__validateUniqueCompany($i, $data, $op);
		}

		return $resError;
	}

	function __validateUniqueCompany($i, $data, $op) {
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
	/*Funciones Personas Naturales*/
	function __listPerNatural() {
		$this->db->select('p.id, CONCAT(cu.name, " ", cu.surname) cliente, CONCAT(p.name, " ", p.surname) clienteNatural, p.num_doc, p.address');
		$this->db->join('customers cu', 'cu.id = p.customer_id');
		$qListPerNatural = $this->db->get('people_natural p');
		return $qListPerNatural->result_array();
	}

	function __newPerNatural($postData) {
		$this->db->trans_begin();
		$dataPerNatural = array(
			'customer_id' => $postData['pnCustomer'], 
			'name' => $postData['name'], 
			'surname' => $postData['surname'], 
			'num_doc' => $postData['nDocumento'], 
			'address' => $postData['direccion'], 
			'phone' => $postData['telf'], 
			'phone_other' => $postData['telfOtro'], 
			'email' => $postData['email'], 
			'email_other' => $postData['emailOtro'], 
			'aditional' => $postData['aditional']
		);

		$this->db->insert('people_natural', $dataPerNatural);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewPerNatural($postData) {
		$this->db->select('id AS codP, name AS nombre, surname AS apellido, address AS direccion, num_doc AS ndoc, phone AS telf, phone_other AS telfOtro, email AS email, email_other AS emailOtro, aditional AS adicional, customer_id AS codCu');
		$this->db->where('id', $postData['id']);
		$qverPerNatural = $this->db->get('people_natural');
		return $qverPerNatural->result_array();
	}

	function __editPerNatural($postData) {
		$dataCompany = array(
			'customer_id' => $postData['ePnCustomer'], 
			'name' => $postData['eName'], 
			'surname' => $postData['eSurname'], 
			'num_doc' => $postData['eNdocumento'], 
			'address' => $postData['eDireccion'], 
			'phone' => $postData['eTelf'],
			'phone_other' => $postData['eTelfOtro'], 
			'email' => $postData['eEmail'], 
			'email_other' => $postData['eEmailOtro'], 
			'aditional' => $postData['aditional']
		);

		$this->db->trans_begin();
		$this->db->update('people_natural', $dataCompany, array('id' => $postData['eCodP']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deletePerNatural($postData) {
		$this->db->trans_begin();
		$this->db->delete('people_natural', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChangesPerNatural($postData) {
		$this->db->from('people_natural');
		$this->db->where('id', $postData['eCodP']);
		$this->db->where('customer_id', $postData['ePnCustomer']);
		$this->db->where('name', "BINARY '".$postData['eName']."'", FALSE);
		$this->db->where('surname', "BINARY '".$postData['eSurname']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdocumento']);
		$this->db->where('address', "BINARY '".$postData['eDireccion']."'", FALSE);
		$this->db->where('phone', $postData['eTelf']);
		$this->db->where('phone_other', $postData['eTelfOtro']);
		$this->db->where('email', "BINARY '".$postData['eEmail']."'", FALSE);
		$this->db->where('email_other', "BINARY '".$postData['eEmailOtro']."'", FALSE);
		$this->db->where('aditional', $postData['aditional']);

		return $this->db->count_all_results();;
	}

	function __verifUniquePerNatural($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'people_natural', 'id' => $postData['eCodP'], 'customer_id' => $postData['ePnCustomer'], 'field' => 'num_doc', 'value' => $postData['eNdocumento'], 'label' => 'El N° de Documento')
			);
		} else {
			$data = array(
				array('table' => 'people_natural', 'customer_id' => $postData['pnCustomer'], 'field' => 'num_doc', 'value' => $postData['nDocumento'], 'label' => 'El N° de Documento')
			);
		}

		for ($i=0; $i < count($data); $i++) {
			$resError .= $this->__validateUniquePerNatural($i, $data, $op);
		}

		return $resError;
	}

	function __validateUniquePerNatural($i, $data, $op) {
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
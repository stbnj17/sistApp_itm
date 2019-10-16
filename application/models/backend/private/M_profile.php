<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Configuración del Perfil
 */
class M_profile extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __viewProfile($customer_id) {
		$this->db->select('name AS nombre, surname AS apellido, num_doc AS ndoc, occupation AS ocupacion, email AS correo, phone AS telf');
		$this->db->where('id', $customer_id);
		$qverProfile = $this->db->get('customers');
		return $qverProfile->result_array();
	}

	function __editProfile($postData) {
		$dataCustomer = array(
			'name' => $postData['eName'], 
			'surname' => $postData['eSurname'], 
			'num_doc' => $postData['eNdoc'], 
			'occupation' => $postData['eOccupation'], 
			'email' => $postData['eEmail'], 
			'phone' => $postData['ePhone']
		);

		$this->db->trans_begin();
		$this->db->update('customers', $dataCustomer, array('id' => $postData['eCustomer']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	
	function __verifChangesProfile($postData) {
		$this->db->from('customers');
		$this->db->where('id', $postData['eCustomer']);
		$this->db->where('name', "BINARY '".$postData['eName']."'", FALSE);
		$this->db->where('surname', "BINARY '".$postData['eSurname']."'", FALSE);
		$this->db->where('num_doc', $postData['eNdoc']);
		$this->db->where('occupation', "BINARY '".$postData['eOccupation']."'", FALSE);
		$this->db->where('email', "BINARY '".$postData['eEmail']."'", FALSE);
		$this->db->where('phone', $postData['ePhone']);

		return $this->db->count_all_results();
	}

	function __verifUniqueProfile($postData) {
		$resError = '';
		$data = array(
			array('table' => 'customers', 'id' => $postData['eCustomer'], 'field' => 'num_doc', 'value' => $postData['eNdoc'], 'label' => 'N° de Documento'),
			array('table' => 'customers', 'id' => $postData['eCustomer'], 'field' => 'email', 'value' => $postData['eEmail'], 'label' => 'Email'),
		);

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data);
		}

		return $resError;
	}

	function __savePassword($postData) {
		$dataUser['password'] = password_hash($postData['nPass'], PASSWORD_BCRYPT);

		$this->db->trans_begin();
		$this->db->update('users', $dataUser, array('id' => $postData['user_id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifAccount($postData) {
		$msj = '';
		$this->db->select('password');
		$this->db->where('username', "BINARY '".$postData['user']."'", FALSE);
		$this->db->where('id', $postData['user_id']);
		$this->db->where('status', 1);
		$qpass = $this->db->get('users');

		if ($qpass->num_rows() > 0) {
			if ($rowUser = $qpass->row()) {
				if (!password_verify($postData['pass'], $rowUser->password)) {
					$msj = 'Clave incorrecta.|';
				}
			}
		} else {
			$msj = 'Usuario incorrecto.|';
		}

		return $msj;
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

	function __saveAvatar($file, $user_id) {
		$image = $this->db->escape_str(file_get_contents($file['file']['tmp_name']));
		
		$this->db->query("UPDATE users SET photo = '".$image."' WHERE id = ".$user_id);	
		$qavatar= $this->db->query("SELECT photo FROM users WHERE id = ".$user_id);

		if ($row = $qavatar->row()) {
			return base64_encode($row->photo);
		} else {
			return '';
		}
	}
}
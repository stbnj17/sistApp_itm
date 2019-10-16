<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Usuarios
 */
class M_users extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listUsers() {
		/*$this->db->select("u.id, c.name, c.surname, u.username, REPLACE(GROUP_CONCAT(p.profile),',','|| ') perfiles", FALSE);
		$this->db->join('users u', 'u.customer_id = c.id');
		$this->db->join('users_profiles up', 'up.user_id = u.id', 'left');
		$this->db->join('u_profiles p', 'up.profile_id = p.id', 'left');
		$this->db->where('u.status', 1);
		$this->db->group_by('u.id');
		$qListUser = $this->db->get('customers c');*/
		/*print($this->db->get_compiled_select('customers c'));*/
		$qListUser = $this->db->query("
			SELECT u.id, c.name, c.surname, u.username, REPLACE(GROUP_CONCAT(p.profile),',',', ') AS perfiles
			FROM users u
			INNER JOIN customers c ON u.customer_id = c.id
			LEFT JOIN users_profiles up ON u.id = up.user_id
			LEFT JOIN u_profiles p ON p.id = up.profile_id
			WHERE u.status = 1
			GROUP BY u.id
			");
		return $qListUser->result_array();
	}

	function __listCustomers() {
		$this->db->select('c.id, CONCAT(c.name, " ", c.surname) cliente, u.username');
		$this->db->join('users u', 'u.customer_id = c.id', 'left');
		/*$this->db->where('u.customer_id IS NULL');*/
		$qListCustomer = $this->db->get('customers c');
		return $qListCustomer->result_array();
	}

	function __listProfiles() {
    $this->db->select('id, profile');
		$this->db->where('status', 1);
		$qListProfile = $this->db->get('u_profiles');
		return $qListProfile->result_array();
	}

	function __newUser($postData) {
		$this->db->trans_begin();
		$dataUser = array(
			'customer_id' => $postData['customer'], 
			'username' => $postData['user'], 
			'password' => password_hash($postData['pass'], PASSWORD_BCRYPT), 
			'status' => '1'
		);

		$statusInsert = $this->db->insert('users', $dataUser);

		if ($statusInsert && isset($postData['perfiles'])) {
			$this->db->select('id');
			$this->db->where('customer_id', $postData['customer']);
			$this->db->where('username', $postData['user']);
			$qidUser = $this->db->get('users');

			if ($row = $qidUser->row()) {
				$this->__saveProfilesUser($row->id, $postData['perfiles']);
			}
		}

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewUser($postData) {
		$this->db->select('id AS codU, username AS usuario, customer_id AS codC');
		$this->db->where('id', $postData['id']);
		$qverUser = $this->db->get('users');
		$arrRes = $qverUser->result_array();
		$arrRes['1'] = $this->__viewProfilesUser($postData);
		return $arrRes;
	}

	function __editUser($postData) {
		$dataUser['customer_id'] = $postData['eCustomer'];
		$dataUser['username'] = $postData['eUser'];
		if ($postData['ePass'] != '' && $postData['eRpass'] != '') {
			$dataUser['password'] = password_hash($postData['ePass'], PASSWORD_BCRYPT);
		}

		$this->db->trans_begin();
		$statusUpdate = $this->db->update('users', $dataUser, array('id' => $postData['eCodU']));

		if ($statusUpdate && isset($postData['perfiles'])) {
			$this->__delUserRoles($postData['eCodU'], $postData['perfiles']);
			$this->__saveProfilesUser($postData['eCodU'], $postData['perfiles']);
		} else {
			$this->db->delete('users_profiles', array('user_id' => $postData['eCodU']));
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteUser($postData) {
		$this->db->trans_begin();
		$this->db->delete('users', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('users');
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('username', "BINARY '".$postData['eUser']."'", FALSE);
		$count = $this->db->count_all_results();
		
		if ($count > 0) {
			$this->db->select('user_id, profile_id');
			$this->db->where('user_id', $postData['eCodU']);
			$qProfilesUser = $this->db->get('users_profiles');

			if (isset($postData['perfiles'])) {
				if ($qProfilesUser->num_rows() == count($postData['perfiles'])) {
					foreach ($qProfilesUser->result() as $row) {
						if (!in_array($row->profile_id, $postData['perfiles'])) {
							$count = 0;
							break;
						}
					}
				} else {
					$count = 0;
				}
			}

			if (!isset($postData['perfiles']) && $qProfilesUser->num_rows() > 0) {
				$count = 0;
			}
		}

		return $count;
	}

	function __verifUnique($postData) {
		$resError = '';
		$data = array(
			array('table' => 'users', 'id' => $postData['eCodU'], 'field' => 'customer_id', 'value' => $postData['eCustomer'], 'label' => 'Cliente ya tiene cuenta'),
			array('table' => 'users', 'id' => $postData['eCodU'], 'field' => 'username', 'value' => $postData['eUser'], 'label' => 'Nombre de Usuario ya existe')
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
			$msj = 'El ' .$data[$i]['label'] . '.|';
		}
		return $msj;
	}

	/*--- Profiles User's Functions*/
	function __viewProfilesUser($postData) {
		$this->db->select('profile_id AS perfil');
		$this->db->where('user_id', $postData['id']);
		$qverProfile = $this->db->get('users_profiles');
		return $qverProfile->result_array();
	}

	function __saveProfilesUser($id, $profiles) {
		$this->db->trans_begin();

		$this->db->delete('users_profiles', array('user_id' => $id));
		foreach ($profiles as $row) {
			$data = array(
				'user_id' => $id, 
				'profile_id' => $row
			);
			$this->db->insert('users_profiles', $data);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __delUserRoles($id, $profiles) {
		$this->db->select('rm.id');
		$this->db->join('u_roles_modules rm', 'pm.module_id = rm.module_id');
		foreach ($profiles as $row) {
			$this->db->or_where('pm.profile_id', $row);
		}
		$this->db->group_by('rm.id');
		$qListCustomer = $this->db->get('u_profiles_modules pm');
		
		$this->db->trans_begin();
		$dataNoDel = array_column($qListCustomer->result_array(), 'id');
		$this->db->where('user_id', $id);
		$this->db->where_not_in('role_modu_id', $dataNoDel);
		$this->db->delete('users_roles_modules');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	/*--- Roles User's Functions*/
	function __viewRolesUser($postData) {
		$this->db->select('r.id, r.role');
		$this->db->join('u_roles_modules rm', 'rm.role_id = r.id');
		$this->db->join('u_profiles_modules pm', 'pm.module_id = rm.module_id');
		$this->db->join('users_profiles up', 'up.profile_id = pm.profile_id');
		$this->db->where('up.user_id', $postData['id']);
		$this->db->group_by('r.id');
		$this->db->order_by('r.id');
		$qListRoles = $this->db->get('u_roles r');
		$listRoleUser['roles'] = $qListRoles->result_array();

    $this->db->query('SET @enuP = 0;');
    $this->db->select('@enuP:=@enuP+1 AS num, m.id, m.module', false);
		$this->db->join('u_profiles_modules pm', 'pm.module_id = m.id');
		$this->db->join('users_profiles up', 'up.profile_id = pm.profile_id');
		$this->db->where('up.user_id', $postData['id']);
		$this->db->group_by('m.id');
		$this->db->order_by('m.id');
		$qListModules = $this->db->get('u_modules m');
		$listRoleUser['modules'] = $qListModules->result_array();

		$this->db->select('rm.module_id, rm.role_id');
		$this->db->join('u_profiles_modules pm', 'pm.module_id = rm.module_id');
		$this->db->join('users_profiles up', 'up.profile_id = pm.profile_id');
		$this->db->where('up.user_id', $postData['id']);
		$this->db->group_by('rm.module_id, rm.role_id');
		$this->db->order_by('rm.module_id, rm.role_id');
		$qListRolesUser = $this->db->get('u_roles_modules rm');
		$listRoleUser['rolesUser'] = $qListRolesUser->result_array();

		$this->db->select('rm.module_id, rm.role_id');
		$this->db->join('u_roles_modules rm', 'rm.id = urm.role_modu_id');
		$this->db->where('user_id', $postData['id']);
		$qListModRulCheck = $this->db->get('users_roles_modules urm');
		$listRoleUser['checked'] = $qListModRulCheck->result_array();

		return $listRoleUser;
	}

	function __saveRolesUser($postData) {
		$this->db->trans_begin();

		$this->db->delete('users_roles_modules', array('user_id' => $postData['eCodU']));
		foreach ($postData['chk'] as $rowChk) {
			$this->db->select('id');
			$this->db->where('module_id', $rowChk[0]);
			$this->db->where('role_id', $rowChk[1]);
			$qidModuRole = $this->db->get('u_roles_modules');

			if ($row = $qidModuRole->row()) {
				$data = array(
					'user_id' => $postData['eCodU'], 
					'role_modu_id' => $row->id
				);
				$this->db->insert('users_roles_modules', $data);
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
}
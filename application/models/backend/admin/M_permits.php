<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Permisos de Usuario
 */
class M_permits extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listModules() {
    $this->db->query('SET @enuM = 0;'); /*Declarando variable de enumeracion*/
    $this->db->select('@enuM:=@enuM+1 AS num, id, module, path, IF(status = 1, TRUE, FALSE) AS active', false);
		$qListModule = $this->db->get('u_modules');
		return $qListModule->result_array();
	}

	function __listRoles() {
    $this->db->query('SET @enuR = 0;');
    $this->db->select('@enuR:=@enuR+1 AS num, id, role, IF(status = 1, TRUE, FALSE) AS active', false);
		$qListRole = $this->db->get('u_roles');
		return $qListRole->result_array();
	}

	function __listProfiles() {
    $this->db->query('SET @enuP = 0;');
    $this->db->select('@enuP:=@enuP+1 AS num, id, profile, description, IF(status = 1, TRUE, FALSE) AS active', false);
		$qListProfile = $this->db->get('u_profiles');
		return $qListProfile->result_array();
	}

	function __listModulesRoles() {
		$this->db->select('id, role');
		$this->db->where('status', 1);
		$qListRole = $this->db->get('u_roles');
		$listModuRole['roles'] = $qListRole->result_array();

    $this->db->query('SET @enuP = 0;');
    $this->db->select('@enuP:=@enuP+1 AS num, id, module', false);
		$this->db->where('status', 1);
		$qListModule = $this->db->get('u_modules');
		$listModuRole['modulos'] = $qListModule->result_array();

		$this->db->select('module_id, role_id');
		$qListModRulCheck = $this->db->get('u_roles_modules');
		$listModuRole['checked'] = $qListModRulCheck->result_array();

		return $listModuRole;
	}

	/*--- Modules's Functions*/
	function __newModule($postData) {
		$this->db->trans_begin();
		$data = array(
			'module' => $postData['modulo'], 
			'path' => $postData['ruta'], 
			'status' => 1
		);
		
		$this->db->insert('u_modules', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewModule($postData) {
		$this->db->select('id AS codM, module AS modulo, path AS ruta');
		$this->db->where('id', $postData['id']);
		$qverModule = $this->db->get('u_modules');
		return $qverModule->result_array();
	}

	function __editModule($postData) {
		$dataModule = array(
			'module' => $postData['modulo'], 
			'path' => $postData['ruta']
		);

		$this->db->trans_begin();
		$this->db->update('u_modules', $dataModule, array('id' => $postData['cod']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteModule($postData) {
		$this->db->trans_begin();
		$this->db->delete('u_modules', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __changeStatusModule($postData) {
		$this->db->trans_begin();

		$this->db->set('status', $postData['estado']);
		$this->db->where('id', $postData['id']);
		$this->db->update('u_modules');

		if ($postData['estado'] == 0) {
			$this->db->delete('u_profiles_modules', array('module_id' => $postData['id']));
			$this->db->delete('u_roles_modules', array('module_id' => $postData['id']));
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChangesModule($postData) {
		$this->db->from('u_modules');
		$this->db->where('module', "BINARY '".$postData['modulo']."'", FALSE);
		$this->db->where('path', "BINARY '".$postData['ruta']."'", FALSE);
		$this->db->where('id', $postData['cod']);

		return $this->db->count_all_results();
	}

	function __verifUniqueModule($postData) {
		$resError = '';
		$data = array(
			array('table' => 'u_modules', 'id' => $postData['cod'], 'field' => 'module', 'value' => $postData['modulo'], 'label' => 'El Módulo')
		);

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data);
		}

		return $resError;
	}

	/*--- Modules's Functions*/
	function __newRole($postData) {
		$this->db->trans_begin();
		$data = array(
			'role' => $postData['rol'], 
			'status' => 1
		);
		
		$this->db->insert('u_roles', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewRole($postData) {
		$this->db->select('id AS codR, role AS rol');
		$this->db->where('id', $postData['id']);
		$qverRole = $this->db->get('u_roles');
		return $qverRole->result_array();
	}

	function __editRole($postData) {
		$dataRole = array(
			'role' => $postData['rol']
		);

		$this->db->trans_begin();
		$this->db->update('u_roles', $dataRole, array('id' => $postData['cod']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteRole($postData) {
		$this->db->trans_begin();
		$this->db->delete('u_roles', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __changeStatusRole($postData) {
		$this->db->trans_begin();

		$this->db->set('status', $postData['estado']);
		$this->db->where('id', $postData['id']);
		$this->db->update('u_roles');

		if ($postData['estado'] == 0) {
			$this->db->delete('u_roles_modules', array('role_id' => $postData['id']));
			/*$this->db->delete('users_roles', array('role_id' => $postData['id']));*/
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChangesRole($postData) {
		$this->db->from('u_roles');
		$this->db->where('role', "BINARY '".$postData['rol']."'", FALSE);
		$this->db->where('id', $postData['cod']);

		return $this->db->count_all_results();
	}

	function __verifUniqueRole($postData) {
		$resError = '';
		$data = array(
			array('table' => 'u_roles', 'id' => $postData['cod'], 'field' => 'role', 'value' => $postData['rol'], 'label' => 'El Rol')
		);

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data);
		}

		return $resError;
	}

	/*--- Roles Module's Functions ---*/
	function __saveRolesModule($checked) {
		$this->db->trans_begin();

		$this->db->empty_table('u_roles_modules');
		$this->db->query('ALTER TABLE u_roles_modules AUTO_INCREMENT = 1');
		
		foreach ($checked as $row) {
			$data = array(
				'module_id' => $row[0], 
				'role_id' => $row[1]
			);
			$this->db->insert('u_roles_modules', $data);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	/*--- Profiles's Functions*/
	function __newProfile($postData) {
		$this->db->trans_begin();
		$data = array(
			'profile' => $postData['perfil'], 
			'description' => $postData['descripcion'], 
			'status' => 1
		);
		
		$this->db->insert('u_profiles', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewProfile($postData) {
		$this->db->select('id AS codP, profile AS perfil, description AS descripcion');
		$this->db->where('id', $postData['id']);
		$qverProfile = $this->db->get('u_profiles');
		return $qverProfile->result_array();
	}

	function __editProfile($postData) {
		$dataProfile = array(
			'profile' => $postData['perfil'], 
			'description' => $postData['descripcion']
		);

		$this->db->trans_begin();
		$this->db->update('u_profiles', $dataProfile, array('id' => $postData['cod']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteProfile($postData) {
		$this->db->trans_begin();
		$this->db->delete('u_profiles', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __changeStatusProfile($postData) {
		$this->db->trans_begin();

		$this->db->set('status', $postData['estado']);
		$this->db->where('id', $postData['id']);
		$this->db->update('u_profiles');

		if ($postData['estado'] == 0) {
			$this->db->delete('u_profiles_modules', array('profile_id' => $postData['id']));
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChangesProfile($postData) {
		$this->db->from('u_profiles');
		$this->db->where('profile', "BINARY '".$postData['perfil']."'", FALSE);
		$this->db->where('description', "BINARY '".$postData['descripcion']."'", FALSE);
		$this->db->where('id', $postData['cod']);

		return $this->db->count_all_results();
	}

	function __verifUniqueProfile($postData) {
		$resError = '';
		$data = array(
			array('table' => 'u_profiles', 'id' => $postData['cod'], 'field' => 'profile', 'value' => $postData['perfil'], 'label' => 'El Perfil')
		);

		for ($i=0; $i < count($data); $i++) { 
			$resError .= $this->__validateUnique($i, $data);
		}

		return $resError;
	}

	/*--- Modules Profile's Functions*/
	function __viewModulesProfile($postData) {
		$this->db->select('module_id AS modulo');
		$this->db->where('profile_id', $postData['id']);
		$qverModule = $this->db->get('u_profiles_modules');
		return $qverModule->result_array();
	}

	function __saveModulesProfile($postData) {
		$this->db->trans_begin();

		$this->db->delete('u_profiles_modules', array('profile_id' => $postData['cod']));
		foreach ($postData['modulos'] as $row) {
			$data = array(
				'profile_id' => $postData['cod'], 
				'module_id' => $row
			);
			$this->db->insert('u_profiles_modules', $data);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __validateUnique($i, $data) {
		$this->db->where('id <>', $data[$i]['id']);
		$this->db->where($data[$i]['field'], $data[$i]['value']);
		$num = $this->db->count_all_results($data[$i]['table']);
		$msj = '';

		if ($num > 0) {
			$msj = $data[$i]['label'] . ' ya existe.|';
		}
		return $msj;
	}
}
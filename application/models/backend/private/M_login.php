<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Acceso al Sistema
 */
class M_login extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __logIn($postData) {
		$this->db->select('id, customer_id, password, photo');
		$this->db->where('username', "BINARY '".$postData['user']."'", FALSE);
		$this->db->where('status', 1);
		$this->db->or_where('status', 2);
		$qpass = $this->db->get('users');

		if ($qpass->num_rows() > 0) {
			if ($rowUser = $qpass->row()) {
				if (password_verify($postData['pass'], $rowUser->password)) {
					$this->db->select('name');
					$this->db->where('id', $rowUser->customer_id);
					$qname = $this->db->get('customers');
					$rowCust = $qname->row();
					$dataSession = $this->__getModulesRoles($rowUser->id);

					$dataSession['logged_in'] = array(
						'u_id' => $rowUser->id, 
						'c_id' => $rowUser->customer_id, 
						'u_foto' => $rowUser->photo, 
						'cliente' => $rowCust->name 
					);

          return $dataSession;
				}
			}
		}
    return false;
	}

	function __getModulesRoles($us_id) {
		$this->db->select('rm.id');
		$this->db->join('u_roles_modules rm', 'rm.id = urm.role_modu_id');
		$this->db->join('u_modules m', 'm.id = rm.module_id');
		$this->db->join('u_roles r', 'r.id = rm.role_id');
		$this->db->where('urm.user_id', $us_id);
		$this->db->order_by('rm.id');
		$qListRoles = $this->db->get('users_roles_modules urm');
		$listRoleUser['ci_roles'] = $qListRoles->result_array();

    $this->db->select('m.id, m.module, m.path');
		$this->db->join('u_roles_modules rm', 'rm.id = urm.role_modu_id');
		$this->db->join('u_modules m', 'm.id = rm.module_id');
		$this->db->where('urm.user_id', $us_id);
		$this->db->group_by('m.id');
		$this->db->order_by('m.id');
		$qListModules = $this->db->get('users_roles_modules urm');
		$listRoleUser['ci_modules'] = $qListModules->result_array();

		return $listRoleUser;
	}

	function __saveRecoveredPass($email, $pass) {
		$this->db->select('id');
		$this->db->where('email', "BINARY '".$email."'", FALSE);
		$qidCustomer = $this->db->get('customers');
		
		if ($rowCustomer = $qidCustomer->row()) {
			$dataUser['password'] = password_hash($pass, PASSWORD_BCRYPT);

			$this->db->trans_begin();
			$statusUpdate = $this->db->update('users', $dataUser, array('customer_id' => $rowCustomer->id, 'status' => 1));

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
		}
	}

	/*Notificaciones de eventos de agenda*/
	function __getEvents($c_id, $date) {
		$this->db->select("e.title tit, e.description des, REPLACE(e.start, 'T', ' ') ini, REPLACE(e.end, 'T', ' ') fin, IF(e.end = '' OR e.end IS NULL, 1, TIMESTAMPDIFF(DAY, e.start, e.end)) d, 
			MOD(TIMESTAMPDIFF(HOUR, e.start, e.end), 24) h, 
			MOD(TIMESTAMPDIFF(MINUTE, e.start, e.end), 60) m");
		$this->db->join('schedule_files s', 's.id = e.schedule_id', 'left');
		$this->db->where('e.customer_id', $c_id);
		$this->db->where("(e.schedule_id is null OR s.active = 1)");
		$this->db->where("('".$date."' BETWEEN DATE_FORMAT(e.start, '%Y-%m-%d') AND DATE_FORMAT(e.end, '%Y-%m-%d') OR '".$date."' = DATE_FORMAT(e.start, '%Y-%m-%d'))");
		$this->db->where("(e.end > DATE_FORMAT('".$date."', '%Y-%m-%d 00:00:00') OR e.end = '' OR e.end is null)");
		$this->db->order_by('start');
		$qevents = $this->db->get('events e');
		return $qevents->result_array();
	}
}
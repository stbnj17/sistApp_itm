<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Calendario de Agenda
 */
class M_agenda extends CI_Model {
	
	function __construct() {
		parent:: __construct();
	}

	function __listEvents($customer_id) {
		$this->db->select('e.id, e.title, e.description AS coment, e.start, e.end, e.schedule_id, s.active');
		$this->db->join('schedule_files s', 's.id = e.schedule_id', 'left');
		$this->db->where('e.customer_id', $customer_id);
		$this->db->where("(e.schedule_id is null OR s.active = 1)");
		$qListEvent = $this->db->get('events e');
		return $qListEvent->result_array();
	}

	function __newEvent($postData) {
		$this->db->trans_begin();
		$data = array(
			'customer_id' => $postData['customer'], 
			'title' => $postData['titulo'], 
			'description' => $postData['descripcion'], 
			'start' => $postData['inicio'], 
			'end' => $postData['fin']
		);
		
		$this->db->insert('events', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __editEvent($postData) {
		$dataEvent = array(
			'title' => $postData['titulo'], 
			'description' => $postData['descripcion'], 
		);

		$this->db->trans_begin();
		$this->db->update('events', $dataEvent, array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __editDateEvent($postData) {
		$dataEvent = array(
			'start' => $postData['inicio'], 
			'end' => $postData['fin'], 
		);

		$this->db->trans_begin();
		$this->db->update('events', $dataEvent, array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteEvent($postData) {
		$this->db->trans_begin();
		$this->db->delete('events', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('events');
		$this->db->where('id', $postData['id']);
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('title', "BINARY '".$postData['titulo']."'", FALSE);
		$this->db->where('description', "BINARY '".$postData['descripcion']."'", FALSE);

		return $this->db->count_all_results();
	}

	/*Funciones para los eventos de la agenda con las fechas del cronograma de vencimiento*/
	function __getSchedules($yearNow) {
		$this->db->select('id, period, active');
		$this->db->where('period >=', $yearNow);
		$qListSchedule = $this->db->get('schedule_files');
		return $qListSchedule->result_array();
	}

	function __getUsers() {
		$query = "SELECT u.customer_id AS id
							FROM users u
							INNER JOIN users_roles_modules urm ON urm.user_id = u.id
							INNER JOIN u_roles_modules rm ON urm.role_modu_id = rm.id
							INNER JOIN (SELECT u.id
													FROM users u
													INNER JOIN users_roles_modules urm ON urm.user_id = u.id
													INNER JOIN u_roles_modules rm ON urm.role_modu_id = rm.id
													WHERE rm.module_id = 3
													GROUP BY u.id) t1 ON t1.id = u.id
							INNER JOIN (SELECT u.id
													FROM users u
													INNER JOIN users_roles_modules urm ON urm.user_id = u.id
													INNER JOIN u_roles_modules rm ON urm.role_modu_id = rm.id
													WHERE rm.module_id = 13
													GROUP BY u.id) t2 ON t2.id = u.id
							WHERE rm.module_id = 2
							GROUP BY u.customer_id";
		$resQuery = $this->db->query($query);
		return $resQuery->result_array();
	}

	function __getCompanies($customer_id) {
		$this->db->select('id, company, num_doc, aditional');
		$this->db->where('customer_id', $customer_id);
		$qcompany = $this->db->get('companies');
		return $qcompany->result_array();
	}

	function __getPeople($customer_id) {
		$this->db->select('id, CONCAT(name," ",surname) person, num_doc, aditional');
		$this->db->where('customer_id', $customer_id);
		$qperson = $this->db->get('people_natural');
		return $qperson->result_array();
	}

	function __deleteEvents($c_id, $sch_id) {
		$this->db->trans_begin();
		$this->db->delete('events', array('schedule_id' => $sch_id, 'customer_id' => $c_id));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __getMonthsSch($period, $type, $lastnum) {
		$query = "SELECT sf.id, sc.text_cell
							FROM schedule_files sf
							INNER JOIN schedule_columns sc ON sf.id = sc.schedule_file_id
							INNER JOIN (SELECT sc.schedule_file_id id, sc.text_cell, sc.col_index
							FROM schedule_columns sc 
							WHERE sc.part_table_id = 'P1'
							AND sc.type_contributor_id = '".$type."'
							AND sc.text_cell LIKE '%".$lastnum."%') AS hc ON sf.id = hc.id
							WHERE sf.active = 1
							AND sf.period = ".$period."
							AND sc.part_table_id = 'P2'
							AND (sc.col_index = hc.col_index OR sc.col_index = 1)";
		$resQuery = $this->db->query($query);

		$resMonthsSch = '';
		$j = 0;
		if ($row = $resQuery->result_array()) {
			for ($i=0; $i < count($row); $i++) { 
				if ($i%2 == 0) {
					$resMonthsSch[$j]['id'] = $row[$i]['id'];
					$resMonthsSch[$j]['month'] = $row[$i]['text_cell'];
				} else {
					$resMonthsSch[$j]['expire'] = $row[$i]['text_cell'];
					$j++;
				}
			}
		}

		return $resMonthsSch;
	}

	function __saveEvents($c_id, $table, $id, $sch_id, $detailEvents) {
		foreach ($detailEvents as $rowEvent) {
			$dataEvent = array(
				'customer_id' => $c_id, 
				'schedule_id' => $sch_id, 
				'title' => $rowEvent['titulo'], 
				'description' => $rowEvent['descr'], 
				'start' => $rowEvent['inicio']
			);

			if ($table == 'com') {
				$dataEvent['company_id'] = $id;
			} else {
				$dataEvent['person_natural_id'] = $id;
			}

			$this->db->trans_begin();
			$this->db->insert('events', $dataEvent);

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
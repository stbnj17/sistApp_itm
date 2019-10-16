<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Clientes
 */
class M_schedules extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listSchedules() {
		$this->db->select('id, fileName_xlsx, period, active');
		$qListSchedule = $this->db->get('schedule_files');
		return $qListSchedule->result_array();
	}

	function __viewSchedule($postData) {
		$this->db->select('pt.part_table, tc.type, sc.text_cell, sc.col_index, sc.row_index, sc.rowspan, sc.colspan');
		$this->db->join('schedule_type_contributor tc', 'sc.type_contributor_id = tc.id', 'left');
		$this->db->join('schedule_part_table pt', 'sc.part_table_id = pt.id', 'left');
		$this->db->where('sc.schedule_file_id', $postData['id']);
		$qverSchedule = $this->db->get('schedule_columns sc');
		return $qverSchedule->result_array();
		/*return $this->db->get_compiled_select('schedule_columns sc');*/
	}

	function __gettitleSchedule($postData) {
		$this->db->select('period');
		$this->db->where('id', $postData['id']);
		$qverSchedule = $this->db->get('schedule_files');
		return $qverSchedule->result_array();
	}

	function __newScheduleFile($arrDataSchedule, $file_name, $input_date, $countCol) {
		$this->db->trans_begin();

		$dataFile = array(
			'fileName_xlsx' => $file_name, 
			'period' => $input_date, 
			'num_columns' => $countCol, 
			'active' => 1
		);

		$this->db->set('created', 'NOW()', FALSE);
		$this->db->insert('schedule_files', $dataFile);

		$this->db->select('id');
		$this->db->where('fileName_xlsx', $file_name);
		$this->db->where('period', $input_date);
		$qidSchedule = $this->db->get('schedule_files');

		if ($row = $qidSchedule->row()) {
			foreach ($arrDataSchedule as $rowArr) {
				$dataRowSchedule = array(
					'schedule_file_id' => $row->id, 
					'text_cell' => $rowArr[0], 
					'col_index' => $rowArr[1], 
					'row_index' => $rowArr[2], 
					'rowspan' => $rowArr[3], 
					'colspan' => $rowArr[4], 
					'type_contributor_id' => $rowArr[5], 
					'part_table_id' => $rowArr[6]
				);
				
				$this->db->insert('schedule_columns', $dataRowSchedule);
			}
		}

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __verifyPeriod($input_periodo) {
		$this->db->where('period', $input_periodo);
		$this->db->from('schedule_files');
		$msj = 'ok';

		if ($this->db->count_all_results() > 0) {
			$this->db->set('active', 0);
			$this->db->where('period', $input_periodo);
			$this->db->update('schedule_files');
			$msj = "Ya existe un cronograma con ese periodo/año.";
		}

		return $msj;
	}

	function __actDesactSchedule($postData) {
		$this->db->trans_begin();

		$this->db->select('period');
		$this->db->where('id', $postData['id']);
		$qperiodSchedule = $this->db->get('schedule_files');

		if ($row = $qperiodSchedule->row()) {
			$this->db->set('active', 0);
			$this->db->where('period', $row->period);
			$this->db->where('active', '1');
			$this->db->update('schedule_files');
		}

		$this->db->set('active', $postData['estado']);
		$this->db->where('id', $postData['id']);
		$this->db->update('schedule_files');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __getNameFile($postData) {
		$this->db->select('fileName_xlsx as fileName');
		$this->db->where('id', $postData['id']);
		$qnameFile = $this->db->get('schedule_files');
		return $qnameFile->result_array();
	}

	function __deleteSchedule($postData) {
		$this->db->trans_begin();
		$this->db->delete('schedule_files', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	/*Funciones para los eventos de la agenda con las fechas del cronograma de vencimiento*/
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

	function __getIdSchedule($period) {
		$this->db->select('id');
		$this->db->where('period', $period);
		$this->db->where('active', 1);
		$qidSchedule = $this->db->get('schedule_files sc');
		return $qidSchedule->result_array();
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

	function __deleteEventsBySchedule($sch_id) {
		$this->db->trans_begin();
		$this->db->delete('events', array('schedule_id' => $sch_id));

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
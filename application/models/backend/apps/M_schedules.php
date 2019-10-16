<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Cronogramas - Aplicaciones
 */
class M_schedules extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listSchedules() {
		$this->db->select('id, period');
		$this->db->where('active', '1');
		$this->db->order_by('period', 'DESC');
		$qListSchedule = $this->db->get('schedule_files');
		return $qListSchedule->result_array();
	}

	function __viewSchedule($period) {
		$this->db->select('pt.part_table, tc.type, sc.text_cell, sc.col_index, sc.row_index, sc.rowspan, sc.colspan');
		$this->db->join('schedule_columns sc', 'sc.schedule_file_id = sf.id', 'left');
		$this->db->join('schedule_type_contributor tc', 'sc.type_contributor_id = tc.id', 'left');
		$this->db->join('schedule_part_table pt', 'sc.part_table_id = pt.id', 'left');
		$this->db->where('sf.period', $period);
		$this->db->where('sf.active', '1');
		$qverSchedule = $this->db->get('schedule_files sf');
		return $qverSchedule->result_array();
		/*return $this->db->get_compiled_select('schedule_columns sc');*/
	}

	function __viewScheduleId($postData) {
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
}
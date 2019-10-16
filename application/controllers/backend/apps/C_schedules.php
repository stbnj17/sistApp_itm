<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Cronogramas - Aplicaciones
 */
class C_schedules extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/apps/m_schedules');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		$resListCustomers = $this->m_schedules->__listSchedules();
		$period = date('Y');
		if (empty($resListCustomers)) {
			$optSelect[''] = $period;
			$optSelected = '';
		}

		$aux = 0;
		foreach ($resListCustomers as $row) {
			$optSelect[$row['id']] = $row['period'];
			if (date('Y') == $row['period']) {
				$aux = 9999;
				$period = $row['period'];
				$optSelected = $row['id'];
			}
			if ($aux < intval($row['period'])) {
				$aux = intval($row['period']);
				$period = $row['period'];
				$optSelected = $row['id'];
			}
		}

		$data = array(
			'title' => '	<title>Cronogramas | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/apps/cronogramas',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_cronogramas.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataSchedule' => $this->viewSchedule($period),
			'optSelect' => $optSelect,
			'optSelected' => $optSelected,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function viewSchedule($period) {
		/*$period = date('Y');*/
		$resSchedule = $this->m_schedules->__viewSchedule($period);
		$resScheduleBD['res_schedule'] = $this->generateTableSchedule($resSchedule);
		$resScheduleBD['res_period'] = 'Periodo '.$period;
		return $resScheduleBD;
	}

	public function viewScheduleId() {
		if ($this->input->is_ajax_request()) {
			$resSchedule = $this->m_schedules->__viewScheduleId($this->input->post());
			$resTitleSchedule = $this->m_schedules->__gettitleSchedule($this->input->post());
			$resScheduleBD['res_html'] = $this->generateTableSchedule($resSchedule);
			$resScheduleBD['res_title'] = 'Periodo '.$resTitleSchedule[0]['period'];
			echo json_encode($resScheduleBD);
		} else {
			show_404();
		}
	}

	public function generateTableSchedule($scheduleBD) {
		$auxIndexRow = ''; $auxCloseTable = 1;
		$contenido = "No se encontraron resultados.";
		if (!empty($scheduleBD)) {
			$contenido = "<table class='table table-striped jambo_table table-bordered'>
										<thead>
											<tr>";
		}
		foreach ($scheduleBD as $row) {
			$partTable = $row['part_table'];
			if ($auxIndexRow == '') {
				$auxIndexRow = $row['row_index'];
			}
			switch ($partTable) {
				case 'head':
					if ($auxIndexRow != $row['row_index']) {
						$contenido .= '</tr><tr>';
						$auxIndexRow = $row['row_index'];
					}
					$contenido .= '<th '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</th>';
					break;
				case 'body':
					if ($auxIndexRow != $row['row_index']) {
						if ($auxCloseTable != 0) {
							$contenido .= '</tr></thead><tbody><tr>';
							$auxCloseTable = 0;
						} else {
							$contenido .= '</tr><tr>';
						}
						$auxIndexRow = $row['row_index'];
					}
					
					if ($row['col_index'] == '1') {
						$contenido .= '<th '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</th>';
					} else {
						$contenido .= '<td '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</td>';
					}
					break;
				default:
					$contenido .= '</tr></tbody></table>';
					break;
			}
		}
		if (!empty($scheduleBD)) {
			$contenido .= "</tr></tbody></table>
								<p class='text-muted font-13 m-b-30'>
                  <strong>Nota:</strong><br>
                  - Este cronograma corresponde a los Principales, Medianos y Pequeños Contribuyentes.<br>
                  - <strong>OTROS: </strong>Corresponde a los BUENOS CONTRIBUYENTES y UESP.<br>
                  - <strong>UESP: </strong>Unidades Ejecutoras del Sector Público.
                </p>";
		}

		return $contenido;
	}

	public function attrTableTHTD($attrName, $value) {
		if ($value != '0') {
			return $attrName. ' = "' . $value . '" ';
		} else {
			return '';
		}
	}

	public function arrInputs() {
    $arrayInputs = array(
	    'attSelect' => array(
	      'id' => 'periodo', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    )
	  );

	  return $arrayInputs;
	}
}
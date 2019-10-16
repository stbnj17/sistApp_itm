<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Cronograma y Empresas - Aplicaciones
 */
class C_schedule_companies extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/apps/m_schedule_companies');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');

		$data = array(
			'title' => '	<title>Cronograma / Empresas | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/apps/empresa_fecha',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_fecha_empresas.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTable' => $this->m_schedule_companies->__listCompaniesUser(1),
			'dataSchedule' => $this->viewSchedule(),
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function newCompany() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['aditional'] = '';
				$_POST['customer'] = 1;
				if (isset($_POST['adicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['adicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resUnico = $this->m_schedule_companies->__verifUnique($this->input->post(), 'new');
				if ($resUnico != '') {
					$msj = explode('|', $resUnico);
				} else {
					$resSaveNew = $this->m_schedule_companies->__newCompany($this->input->post());
					if (is_null($resSaveNew)) {
						$msj = 'ok';
						$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success');");
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewCompany() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_schedule_companies->__viewCompany($this->input->post());
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editCompany() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['aditional'] = '';
				$_POST['eCustomer'] = 1;
				if (isset($_POST['eAdicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['eAdicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resCambios = $this->m_schedule_companies->__verifChanges($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_schedule_companies->__verifUnique($this->input->post(), 'edit');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_schedule_companies->__editCompany($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success');");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteCompany() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_schedule_companies->__deleteCompany($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success');");
			}
		} else {
			show_404();
		}
	}

	public function viewSchedule() {
		$period = date('Y');
		$resSchedule = $this->m_schedule_companies->__viewSchedule($period);
		$resScheduleBD['res_schedule'] = $this->generateTableSchedule($resSchedule);
		$resScheduleBD['res_period'] = 'Periodo '.$period;
		return $resScheduleBD;
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

	//Variables e Inputs - Formulario para Empresas
	public function arrInputs() {
		$onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
    $onlyDigitos = '[0-9]+';
    $LetDigito = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ.]+';
    $letraPunto = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ.]+';

    $arrayInputs = array(

	    'inpRazSocial' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Empresa SAC *', 
	      'maxlength' => '100', 
	      'title' => 'Razón Social obligatoria: Solo letras, dígitos y punto.', 
	      'pattern' => $LetDigito, 
	      'required' => 'true'
	    ),

	    'inpNdoc' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° RUC *', 
	      'maxlength' => '20', 
	      'title' => 'Número de Documento obligatorio: Solo dígitos.', 
	      'pattern' => $onlyDigitos, 
	      'required' => 'true'
	    ),

	    'inpPhone' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Teléfono', 
	      'maxlength' => '20', 
	      'title' => 'Teléfono: Solo dígitos.', 
	      'pattern' => $onlyDigitos
	    ),

	    'checkbxAttrEdit' => array(
	      'class' => 'activado flat'
	    ),

	    'checkbxAttr' => array(
	      'class' => 'activado flat'
	    ),

	    'inpEcodC' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodC'
	    ),

	    'btnNewSubmit' => array(
	      'name' => 'newEmpresa', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Agregar Empresa'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'editEmpresa', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
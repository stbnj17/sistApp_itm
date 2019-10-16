<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Clientes (Empresa-Persona Natural) - Tablas
 */
class C_customers extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/tables/m_customers');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(6, $arrRoles) || in_array(7, $arrRoles)) {
				$actions = '<td align="center">';
				if (in_array(6, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs e_empresa" title="Editar Cliente"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(7, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_empresa" title="Eliminar Cliente"><i class="fa fa-trash"></i></a>';
				}
				$actions .= '</td>';
			}
		}

		$data = array(
			'title' => '	<title>Clientes | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/tables/clientes',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_tclientes.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTableCompanies' => $this->m_customers->__listCompanies($this->session->userdata('logged_in')['c_id']),
			'dataTablePerNaturales' => $this->m_customers->__listPerNatural($this->session->userdata('logged_in')['c_id']),
			'actions' => $actions,
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
				$_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
				if (isset($_POST['adicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['adicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				/*if ((isset($_POST['contacto']) && !empty($_POST['contacto'])) && empty($_POST['email']) && empty($_POST['phone'])) {
					$this->form_validation->set_rules('email', 'Correo (1°)', 'trim|required|valid_email|max_length[100]|xss_clean');
					$this->form_validation->set_rules('phone', 'Teléfono (1°)', 'trim|required|numeric|max_length[20]|xss_clean');
				}

				if ((isset($_POST['contactoOtro']) && !empty($_POST['contactoOtro'])) && empty($_POST['emailOtro']) && empty($_POST['phoneOther'])) {
					$this->form_validation->set_rules('emailOtro', 'Correo (2°)', 'trim|required|valid_email|max_length[100]|xss_clean');
					$this->form_validation->set_rules('phoneOther', 'Teléfono (2°)', 'trim|required|numeric|max_length[20]|xss_clean');
				}

				if ((isset($_POST['email']) && !empty($_POST['email'])) || (isset($_POST['phone']) && !empty($_POST['phone']))) {
					$this->form_validation->set_rules('contacto', 'Contacto (1°)', 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean');
				}

				if ((isset($_POST['emailOtro']) && !empty($_POST['emailOtro'])) || (isset($_POST['phoneOther']) && !empty($_POST['phoneOther']))) {
					$this->form_validation->set_rules('contactoOtro', 'Contacto (2°)', 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean');
				}

				if ($this->form_validation->run() == FALSE) {
					$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
				} else {*/
					$resUnico = $this->m_customers->__verifUniqueCompany($this->input->post(), 'new');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveNew = $this->m_customers->__newCompany($this->input->post());
						if (is_null($resSaveNew)) {
							$this->createEvents($_POST['nDocumento'], '', $_POST['aditional'], $_POST['nameEmpresa'], 'new', 'com');
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); setTimeout(collapsed, 500);");
						}
					}
				/*}*/
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewCompany() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_customers->__viewCompany($this->input->post());
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
				$_POST['eCustomer'] = $this->session->userdata('logged_in')['c_id'];
				if (isset($_POST['eAdicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['eAdicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resCambios = $this->m_customers->__verifChangesCompany($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {

					/*if ((isset($_POST['eContacto']) && !empty($_POST['eContacto'])) && empty($_POST['eEmail']) && empty($_POST['ePhone'])) {
						$this->form_validation->set_rules('eEmail', 'Correo (1°)', 'trim|required|valid_email|max_length[100]|xss_clean');
						$this->form_validation->set_rules('ePhone', 'Teléfono (1°)', 'trim|required|numeric|max_length[20]|xss_clean');
					}

					if ((isset($_POST['eContactoOtro']) && !empty($_POST['eContactoOtro'])) && empty($_POST['eEmailOtro']) && empty($_POST['ePhoneOther'])) {
						$this->form_validation->set_rules('eEmailOtro', 'Correo (2°)', 'trim|required|valid_email|max_length[100]|xss_clean');
						$this->form_validation->set_rules('ePhoneOther', 'Teléfono (2°)', 'trim|required|numeric|max_length[20]|xss_clean');
					}

					if ((isset($_POST['eEmail']) && !empty($_POST['eEmail'])) || (isset($_POST['ePhone']) && !empty($_POST['ePhone']))) {
						$this->form_validation->set_rules('eContacto', 'Contacto (1°)', 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean');
					}

					if ((isset($_POST['eEmailOtro']) && !empty($_POST['eEmailOtro'])) || (isset($_POST['ePhoneOther']) && !empty($_POST['ePhoneOther']))) {
						$this->form_validation->set_rules('eContactoOtro', 'Contacto (2°)', 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean');
					}

					if ($this->form_validation->run() == FALSE) {
						$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
					} else {*/
						$resUnico = $this->m_customers->__verifUniqueCompany($this->input->post(), 'edit');
						if ($resUnico != '') {
							$msj = explode('|', $resUnico);
						} else {
							$resSaveChange = $this->m_customers->__editCompany($this->input->post());
							if (is_null($resSaveChange)) {
								$this->createEvents($_POST['eNdocumento'], $_POST['eCodC'], $_POST['aditional'], $_POST['eNameEmpresa'], 'edit', 'com');
								$msj = 'ok';
								$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secListas' ).offset().top - 15 }, 1000);");
							}
						}
					/*}*/
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteCompany() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_customers->__deleteCompany($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secListas' ).offset().top - 15 }, 1000);");
				$this->getEvents();
			}
		} else {
			show_404();
		}
	}

	public function newPerNatural() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['aditional'] = '';
				$_POST['pnCustomer'] = $this->session->userdata('logged_in')['c_id'];
				if (isset($_POST['adicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['adicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resUnico = $this->m_customers->__verifUniquePerNatural($this->input->post(), 'new');
				if ($resUnico != '') {
					$msj = explode('|', $resUnico);
				} else {
					$resSaveNew = $this->m_customers->__newPerNatural($this->input->post());
					if (is_null($resSaveNew)) {
						$this->createEvents($_POST['nDocumento'], '', $_POST['aditional'], $_POST['name'].' '.$_POST['surname'], 'new', 'per');
						$msj = 'ok';
						$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); setTimeout(collapsed, 500); $('#persona-tab').click(); $('#persona-tabList').click();");
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewPerNatural() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_customers->__viewPerNatural($this->input->post());
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editPerNatural() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['aditional'] = '';
				$_POST['ePnCustomer'] = $this->session->userdata('logged_in')['c_id'];
				if (isset($_POST['eAdicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['eAdicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resCambios = $this->m_customers->__verifChangesPerNatural($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_customers->__verifUniquePerNatural($this->input->post(), 'edit');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_customers->__editPerNatural($this->input->post());
						if (is_null($resSaveChange)) {
							$this->createEvents($_POST['eNdocumento'], $_POST['eCodP'], $_POST['aditional'], $_POST['eName'].' '.$_POST['eSurname'], 'edit', 'per');
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secListas' ).offset().top - 15 }, 1000); $('#persona-tabList').click();");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deletePerNatural() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_customers->__deletePerNatural($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secListas' ).offset().top - 15 }, 1000); $('#persona-tabList').click();");
				$this->getEvents();
			}
		} else {
			show_404();
		}
	}

	/*Funciones para los eventos de la agenda con las fechas del cronograma de vencimiento*/
	public function createEvents($nDocumento, $id, $aditional, $customer, $op, $table) {
		$arrModules = array_column($this->session->userdata('ci_modules'), 'id');
		$lastNumRUC = '';

		if (in_array(13, $arrModules) && in_array(2, $arrModules)) {
			if (strlen($nDocumento) == 11) {
				$lastNumRUC = substr($nDocumento, -1);
				$c_id = $this->session->userdata('logged_in')['c_id'];
				$resSchedules = $this->m_customers->__getSchedules(date('Y'));
				if (count($resSchedules)) {
					if ($op == 'new') {
						$id = $this->m_customers->__getIdCompanyPerson($nDocumento, $c_id, $table);
					}
					if ($aditional == '') {
						$aditional = 'T1';
					} else {
						$aditional = 'T2';
					}
					foreach ($resSchedules as $rowSch) {
						if ($op == 'edit') {
							$this->m_customers->__deleteEventsBySchedule($id, $table, $rowSch['id']);
						}
						$resSchMonths = $this->m_customers->__getMonthsSch($rowSch['period'], $aditional, $lastNumRUC);
						$this->setDatesForEvents($resSchMonths, $c_id, $table, $id, $rowSch['id'], $rowSch['period'], $customer);
					}
					$this->getEvents();
				}
			} else {
				if ($op == 'edit') {
					$this->m_customers->__deleteEventsByCustomer($id, $table);
					$this->getEvents();
				}
			}
		}
	}

	public function setDatesForEvents($arrMonthsExpire, $c_id, $table, $id, $sch_id, $period, $customer) {
    $monthsNumber = explode("_", "01_02_03_04_05_06_07_08_09_10_11_12");
    $months = explode("_", "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre");
		$monthsEs = explode("_", "ene_feb_mar_abr_may_jun_jul_ago_sep_oct_nov_dic");
		$monthsEn = explode("_", "jan_feb_mar_apr_may_jun_jul_aug_sep_oct_nov_dec");
		$detailEvents = '';
		
		foreach ($arrMonthsExpire as $i => $rowMonth) {
			$monthPaid = explode("-", strtolower($rowMonth['month']));
			$ptrMP = -1;
			
			if (in_array($monthPaid[0], $monthsEs)) {
				$ptrMP = array_keys($monthsEs, $monthPaid[0]);
			}

			if (in_array($monthPaid[0], $monthsEn)) {
				$ptrMP = array_keys($monthsEn, $monthPaid[0]);
			}
			
			if ($i != 11) {
				$dateExpire = explode("<br>", strtolower($rowMonth['expire']));
			} else {
				$dateExpire = str_replace("<br>", " ", strtolower($rowMonth['expire']));
				$dateExpire = explode(" ", strtolower($dateExpire));
			}
			$ptrDE = -1;
			
			if (in_array($dateExpire[1], $monthsEs)) {
				$ptrDE = array_keys($monthsEs, $dateExpire[1]);
			}

			if (in_array($dateExpire[1], $monthsEn)) {
				$ptrDE = array_keys($monthsEn, $dateExpire[1]);
			}

			$detailEvents[$i]['titulo'] = 'Periodo '.$months[$ptrMP[0]].' '.$period.' - '.$customer;
			$detailEvents[$i]['descr'] = $customer.":\r\nFecha de Vencimiento para cumplir con las obligaciones mensuales del periodo ".$months[$ptrMP[0]].' '.$period.'.';
			if ($i != 11) {
				$detailEvents[$i]['inicio'] = '20'.$monthPaid[1].'-'.$monthsNumber[$ptrDE[0]].'-'.$dateExpire[0];
			} else {
				$detailEvents[$i]['inicio'] = '20'.$dateExpire[2].'-'.$monthsNumber[$ptrDE[0]].'-'.$dateExpire[0];
			}
		}

		$this->m_customers->__saveEvents($c_id, $table, $id, $sch_id, $detailEvents);
	}

	public function getEvents() {
		/*Notificaciones de eventos de agenda*/
		if (in_array(13, array_column($this->session->userdata('ci_modules'), 'id'))) {
			$c_id = $this->session->userdata('logged_in')['c_id'];
			$this->session->unset_userdata(array('events'));
			$this->session->set_userdata('events', $this->m_customers->__getEvents($c_id, date('Y-m-d')));
		}
	}

	//Variables e Inputs - Formulario para Empresas
	public function arrInputs() {
		$onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
    $onlyDigitos = '[0-9]+';
    $LetDigito = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ.]+';
    $letraDigitOtros = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ°.,_-]+';

    $arrayInputs = array(
    	/*Empresa*/
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
	      'placeholder' => 'N° Documento *', 
	      'maxlength' => '20', 
	      'title' => 'Número de Documento obligatorio: Solo dígitos.', 
	      'pattern' => $onlyDigitos, 
	      'required' => 'true'
	    ),

	    'inpDireccion' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Dirección', 
	      'maxlength' => '200', 
	      'title' => 'Dirección obligatoria.', 
	      'pattern' => $letraDigitOtros, 
	      'required' => 'true'
	    ),

	    'inpPhone' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Teléfono', 
	      'maxlength' => '20', 
	      'title' => 'Teléfono: Solo dígitos.', 
	      'pattern' => $onlyDigitos
	    ),

	    'inpContact' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Contacto', 
	      'maxlength' => '100', 
	      'title' => 'Contacto: Solo letras.', 
	      'pattern' => $onlyLetras
	    ),

	    'inpEmail' => array(
	    	'type' => 'email', 
	    	'name' => 'email', 
	    	'value' => set_value("email"), 
	      'class' => 'form-control', 
	      'placeholder' => 'contacto@ejemplo.com', 
	      'maxlength' => '100', 
	      'title' => 'Correo'
	    ),

	    'inpEmailOther' => array(
	    	'type' => 'email', 
	    	'name' => 'emailOtro', 
	    	'value' => set_value("emailOtro"), 
	      'class' => 'form-control', 
	      'placeholder' => 'contacto@ejemplo.com', 
	      'maxlength' => '100', 
	      'title' => 'Correo'
	    ), 
	    /*---*/
	    'inpEemail' => array(
	    	'type' => 'email', 
	    	'name' => 'eEmail', 
	    	'value' => set_value("eEmail"), 
	      'class' => 'form-control', 
	      'placeholder' => 'contacto@ejemplo.com', 
	      'maxlength' => '100', 
	      'title' => 'Correo'
	    ), 

	    'inpEemailOther' => array(
	    	'type' => 'email', 
	    	'name' => 'eEmailOtro', 
	    	'value' => set_value("eEmailOtro"), 
	      'class' => 'form-control', 
	      'placeholder' => 'contacto@ejemplo.com', 
	      'maxlength' => '100', 
	      'title' => 'Correo'
	    ),

	    'checkbxAttrPN' => array(
	      'class' => 'flat',
	      'disabled' => true
	    ),

	    'checkbxAttr' => array(
	      'class' => 'flat'
	    ), 
	    /*Persona Natural*/
	    'inpName' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Nombres *', 
	      'maxlength' => '100', 
	      'title' => 'Nombre obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpSurname' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Apellidos *', 
	      'maxlength' => '100', 
	      'title' => 'Apellido obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpEcodC' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodC'
	    ),

	    'inpEcodP' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodP'
	    ),

	    'inpEcodContactOne' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodContUno'
	    ),

	    'inpEcodContactTwo' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodContDos'
	    ),

	    'btnNewSubmit' => array(
	      'name' => 'newClienteC', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Agregar Cliente'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'editClienteC', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Clientes (Empresa-Persona Natural) de Clientes Administrador
 */
class C_customersCustomer extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/admin/m_customersCustomer');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		$optSelect[''] = 'Seleccione un Cliente';
		$resListCustomers = $this->m_customersCustomer->__listCustomers();

		foreach ($resListCustomers as $row) {
			$optSelect[$row['id']] = $row['cliente'];
		}

		$data = array(
			'title' => '	<title>Clientes de Clientes | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/admin/clientesCliente',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_clientesCliente.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTableCompanies' => $this->m_customersCustomer->__listCompanies(),
			'dataTablePerNaturales' => $this->m_customersCustomer->__listPerNatural(),
			'optSelect' => $optSelect,
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
				if (isset($_POST['adicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['adicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				if ((isset($_POST['contacto']) && !empty($_POST['contacto'])) && empty($_POST['email']) && empty($_POST['phone'])) {
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
				} else {
					$resUnico = $this->m_customersCustomer->__verifUniqueCompany($this->input->post(), 'new');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveNew = $this->m_customersCustomer->__newCompany($this->input->post());
						if (is_null($resSaveNew)) {
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

	public function viewCompany() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_customersCustomer->__viewCompany($this->input->post());
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
				if (isset($_POST['eAdicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['eAdicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resCambios = $this->m_customersCustomer->__verifChangesCompany($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {

					if ((isset($_POST['eContacto']) && !empty($_POST['eContacto'])) && empty($_POST['eEmail']) && empty($_POST['ePhone'])) {
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
					} else {
						$resUnico = $this->m_customersCustomer->__verifUniqueCompany($this->input->post(), 'edit');
						if ($resUnico != '') {
							$msj = explode('|', $resUnico);
						} else {
							$resSaveChange = $this->m_customersCustomer->__editCompany($this->input->post());
							if (is_null($resSaveChange)) {
								$msj = 'ok';
								$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success');");
							}
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
			$resDelete = $this->m_customersCustomer->__deleteCompany($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success');");
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
				if (isset($_POST['adicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['adicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resUnico = $this->m_customersCustomer->__verifUniquePerNatural($this->input->post(), 'new');
				if ($resUnico != '') {
					$msj = explode('|', $resUnico);
				} else {
					$resSaveNew = $this->m_customersCustomer->__newPerNatural($this->input->post());
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

	public function viewPerNatural() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_customersCustomer->__viewPerNatural($this->input->post());
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
				if (isset($_POST['eAdicional'])) {
					$_POST['aditional'] = 0;
					foreach ($_POST['eAdicional'] as $arrAdd) {
						$_POST['aditional'] += $arrAdd;
					}
				}

				$resCambios = $this->m_customersCustomer->__verifChangesPerNatural($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_customersCustomer->__verifUniquePerNatural($this->input->post(), 'edit');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_customersCustomer->__editPerNatural($this->input->post());
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

	public function deletePerNatural() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_customersCustomer->__deletePerNatural($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success');");
			}
		} else {
			show_404();
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

	    'attSelect' => array(
	      'id' => 'customer', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'atteSelect' => array(
	      'id' => 'eCustomer', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'attPNSelect' => array(
	      'id' => 'pnCustomer', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'attePNSelect' => array(
	      'id' => 'ePnCustomer', 
	      'class' => 'form-control', 
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
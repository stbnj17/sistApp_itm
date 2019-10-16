<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Clientes
 */
class C_customers extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/admin/m_customers');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(25, $arrRoles) || in_array(26, $arrRoles)) {
				$actions = '<td align="center">';
				if (in_array(25, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs e_cliente" title="Editar Cuenta"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(26, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_cliente" title="Eliminar Cuenta"><i class="fa fa-trash"></i></a>';
				}
				$actions .= '</td>';
			}
		}

		$data = array(
			'title' => '	<title>Clientes | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/datatables_css'),
			'content' => 'backend/admin/clientes',
			'scriptsAdd' => array('backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_clientes.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTable' => $this->m_customers->__listCustomers(),
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function newCustomer() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveNew = $this->m_customers->__newCustomer($this->input->post());
				if (is_null($resSaveNew)) {
					$msj = 'ok';
					$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); setTimeout(collapsed, 500);");
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewCustomer() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_customers->__viewCustomer($this->input->post());
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editCustomer() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resCambios = $this->m_customers->__verifChanges($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_customers->__verifUnique($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_customers->__editCustomer($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secTabla' ).offset().top - 15 }, 1000);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteCustomer() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_customers->__deleteCustomer($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secTabla' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

  //Variables e Inputs - Formulario para Clientes
	public function arrInputs() {
		$onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
    $onlyDigitos = '[0-9]+';
    $letraPunto = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ.]+';

    $arrayInputs = array(

	    'inpName' => array(
	      'class' => 'form-control has-feedback-left', 
	      'placeholder' => 'Nombres *', 
	      'maxlength' => '100', 
	      'title' => 'Nombre obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpSurname' => array(
	      'class' => 'form-control has-feedback-left', 
	      'placeholder' => 'Apellidos *', 
	      'maxlength' => '100', 
	      'title' => 'Apellido obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpNdoc' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° DNI / RUC *', 
	      'maxlength' => '20', 
	      'title' => 'Número de Documento obligatorio: Solo dígitos.', 
	      'pattern' => $onlyDigitos,
	      'required' => 'true'
	    ),

	    'inpOccupation' => array(
	      'class' => 'form-control has-feedback-left', 
	      'placeholder' => 'Ocupación', 
	      'maxlength' => '100', 
	      'title' => 'Ocupación: Solo letras y punto.', 
	      'pattern' => $letraPunto
	    ),

	    'inpEmail' => array(
	    	'type' => 'email', 
	    	'name' => 'email', 
	    	'value' => set_value("email"), 
	      'class' => 'form-control has-feedback-left', 
	      'placeholder' => 'E_mail *', 
	      'maxlength' => '100', 
	      'title' => 'Correo obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpPhone' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Teléfono', 
	      'maxlength' => '20', 
	      'title' => 'Teléfono: Solo dígitos.', 
	      'pattern' => $onlyDigitos
	    ),

	    'inpEemail' => array(
	    	'type' => 'email', 
	    	'name' => 'eEmail', 
	    	'value' => set_value("eEmail"), 
	      'class' => 'form-control has-feedback-left', 
	      'placeholder' => 'E_mail *', 
	      'maxlength' => '100', 
	      'title' => 'Correo obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpEcodC' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodC'
	    ),

	    'btnNewSubmit' => array(
	      'name' => 'newCliente', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'editCliente', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Configuración del Perfil
 */
class C_profile extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/private/m_profile');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		$data = array(
			'title' => '	<title>Perfil | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/cropper_css'),
			'content' => 'backend/private/perfil',
			'scriptsAdd' => array('backend/includes/js/cropper_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_perfil.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataProfile' => $this->m_profile->__viewProfile($this->session->userdata('logged_in')['c_id']),
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function viewProfile() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_profile->__viewProfile($this->session->userdata('logged_in')['c_id']);
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editProfile() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['eCustomer'] = $this->session->userdata('logged_in')['c_id'];
				$resCambios = $this->m_profile->__verifChangesProfile($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_profile->__verifUniqueProfile($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_profile->__editProfile($this->input->post());
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

	public function savePassword() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['user_id'] = $this->session->userdata('logged_in')['u_id'];
				$resVerif = $this->m_profile->__verifAccount($this->input->post());
				if ($resVerif != '') {
					$msj = explode('|', $resVerif);
				} else {
					$resSaveChange = $this->m_profile->__savePassword($this->input->post());
					if (is_null($resSaveChange)) {
						$msj = 'ok';
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function saveAvatar($value='') {
		if (!empty($_FILES)) {
			$resAvatar = $this->m_profile->__saveAvatar($_FILES, $this->session->userdata('logged_in')['u_id']);
			$this->session->unset_userdata(array('foto'));
			$this->session->set_userdata('foto', "data:image/png;base64, ".$resAvatar);
			
			echo $resAvatar;
		} else show_404();
	}

  //Variables e Inputs - Formulario para el Perfil de Usuario
	public function arrInputs() {
    $onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
    $letraPunto = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ.]+';
    $LetDigito = '[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+';
    $onlyDigitos = '[0-9]+';

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

	    'inpPhone' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Teléfono', 
	      'maxlength' => '20', 
	      'title' => 'Teléfono: Solo dígitos.', 
	      'pattern' => $onlyDigitos
	    ),

	    'inpUser' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Usuario', 
	      'maxlength' => '100', 
	      'title' => 'Usuario obligatorio: Letras y dígitos.', 
	      'pattern' => $LetDigito, 
	      'required' => 'true'
	    ),

	    'inpPass' => array(
	      'type' => 'password', 
	      'name' => 'pass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpNpass' => array(
	      'type' => 'password', 
	      'id' => 'nPass', 
	      'name' => 'nPass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Nueva Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpRnPass' => array(
	      'type' => 'password', 
	      'id' => 'rNpass', 
	      'name' => 'rNpass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Repita Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'save', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
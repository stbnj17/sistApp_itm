<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Acceso al Sistema
 */
class C_login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('backend/private/m_login');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		if ($this->session->has_userdata('logged_in') && !empty($this->session->userdata('mainPage'))) {
			redirect(base_url($this->session->userdata('mainPage')['path']));
		} else {
			$save_ok = '';
			$save_ok = $this->session->flashdata('save_ok');
			$data = array(
				'arrInputs' => $this->arrInputs(),
				'save_ok' => $save_ok
			);

			$this->parser->parse('backend/private/login', $data);
		}
	}

	public function logIn() {
		if ($this->input->post()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
				for ($i = 0; $i < count($msj)-1 ; $i++) {
					$msjError .= "pNotify('Error de Datos', ".json_encode($msj[$i]).", 'error');";
				}
				$this->session->set_flashdata('save_ok', $msjError);
				redirect(base_url('acceso'));
			} else {
				$resAccess = $this->m_login->__logIn($this->input->post());
				if ($resAccess != false) {
          $this->session->set_userdata($resAccess);

					if (is_null($this->session->userdata('logged_in')['u_foto'])) { // Si el usuario no tiene foto
						$this->session->set_userdata('foto', base_url('assets/images/admin/user.png'));
					} else {
						$this->session->set_userdata('foto', "data:image/png;base64, ".base64_encode($this->session->userdata('logged_in')['u_foto']));
					}
					
					$arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
					if (empty($arrRoles)) { // Si la pagina principal esta vacia
						$this->session->set_flashdata('save_ok', "pNotify('Configuración Incompleta', 'Lo sentimos, el usuario no tiene los permisos correspondientes a los Módulos.', 'warning');");
						$this->unSetting();
					} else {
						$arrMod_0 = $this->session->userdata('ci_modules')[0]; // Guardamos el primer modulo del usuario
						if ((!in_array(3, $arrRoles) && $arrMod_0['id'] == 1) || (!in_array(23, $arrRoles) && $arrMod_0['id'] == 6)) { // Si no existe ninguno de estos roles en el arrayRoles y el primer modulo no es como estos [1, 6]
							$arrMod_0['path'] = $arrMod_0['path'].'/lista'; // Corregimos la ruta de la page main
							$this->session->set_userdata('mainPage', $arrMod_0); // Creamos sesion de la pagina principal con la corrección
						} else {
							$this->session->set_userdata('mainPage', $this->session->userdata('ci_modules')[0]); // Creamos sesion de la pagina principal con el primer módulo de usuario
						}

						/*Notificaciones de eventos de agenda*/
						if (in_array(13, array_column($this->session->userdata('ci_modules'), 'id'))) {
							$c_id = $this->session->userdata('logged_in')['c_id'];
							$this->session->set_userdata('events', $this->m_login->__getEvents($c_id, date('Y-m-d')));
						}

						$this->session->set_flashdata('save_ok', "pNotify('Acceso Correcto', 'Bienvenido ".$this->session->userdata('logged_in')['cliente'].".', 'info');");
						redirect(base_url($this->session->userdata('mainPage')['path'])); // Cargar la pagina principal
					}
				} else {
					$this->session->set_flashdata('save_ok', "pNotify('Acceso Denegado', 'Usuario y Contraseña incorrectos.', 'error');");
					redirect(base_url('acceso'));
				}
			}
		} else {
			show_404();
		}
	}

	public function recoverPass() {
		if ($this->input->post()) {
			if ($this->form_validation->run() == FALSE) {
				$msjError .= "pNotify('Error de Datos', ".json_encode(validation_errors()).", 'error');";
				$this->session->set_flashdata('save_ok', $msjError);
				redirect(base_url('acceso'));
			} else {
				$this->form_validation->set_rules('email', 'Correo', 'is_unique[customers.email]');
				if ($this->form_validation->run() == FALSE) {
					$to = $this->input->post('email');
					$pass = $this->generatePass();
					$msj = '<p>Se está intentando hacer la recuperación de acceso al Sistema.</p>
									<p>Su contraseña ha sido cambiada, ésta es su nueva clave: <b>'.$pass.'</b> y se le recomienda hacer el cambio de ella.</p>
									<p><i>En el caso de no haber sido usted el solicitante del acceso, por favor, comuníquese con nuestra área de atención al cliente.</i></p>';
					$email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://mail.itmsac.com',
            'smtp_port' => '465', //465-26
            'smtp_user' => 'evasquez@itmsac.com',
            'smtp_pass' => 'EV*123*ev',
            'mailtype'  => 'html'
            /*'starttls'  => true,
            'newline'   => "\r\n"*/
        	);

					$this->load->library('email', $email_config);

					$this->email->from('evasquez@itmsac.com', 'Encargado de Recuperación de Cuenta');
					$this->email->to($to);
					/*$this->email->cc('stbn.j.17@gmail.com');*/
					$this->email->bcc('evasquez@itmsac.com');

					$this->email->subject('Recuperación de Cuenta');
					$this->email->message($msj);

					/*$this->email->send();*/
					if ($this->email->send()) {
						$this->m_login->__saveRecoveredPass($to, $pass);
						$this->session->set_flashdata('save_ok', "pNotify('Estado de Recuperación', 'Se le ha enviado un correo, revise para poder continuar con la recuperación del acceso al Sistema.', 'info');");
						redirect(base_url('acceso'));
					} else {
						$this->session->set_flashdata('save_ok', "pNotify('Error de Recuperación', 'Ha ocurrido un error en la solicitud.', 'error');");
						redirect(base_url('acceso'));
					}
				} else {
						redirect(base_url('acceso'));
				}
			}
		} else {
			show_404();
		}
	}

	public function generatePass() {
		$listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   	$listNonAlpha = ',;:!?.$/*-+&@_';
   	return str_shuffle(substr(str_shuffle($listNonAlpha), 0, 4).substr(str_shuffle($listAlpha), 0, 8));
	}

	public function logOut() {
		/*$this->session->unset_userdata(array('logged_in', 'ci_roles', 'ci_modules', 'foto'));*/
		$this->session->sess_destroy();
		redirect(base_url('acceso'));
	}

	public function unSetting() {
		$this->session->unset_userdata(array('logged_in', 'ci_roles', 'ci_modules', 'foto', 'mainPage', 'events'));
		redirect(base_url('acceso'));
	}

	//Variables e Inputs - Formulario para Usuarios
	public function arrInputs() {
    $LetDigito = '[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+';

    $arrayInputs = array(

	    'inpUser' => array(
	      'name' => 'user', 
	    	'value' => set_value("user"), 
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
	    	'value' => set_value("pass"), 
	      'class' => 'form-control', 
	      'placeholder' => 'Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpEmail' => array(
	    	'type' => 'email', 
	    	'name' => 'email', 
	    	'value' => set_value("email"), 
	      'class' => 'form-control', 
	      'placeholder' => 'Confirme su correo *', 
	      'maxlength' => '100', 
	      'title' => 'Correo obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpCod' => array(
	      'type' => 'hidden', 
	      'name' => 'cod'
	    ),

	    'btnLogIn' => array(
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Entrar'
	    ),

	    'btnSend' => array(
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Enviar'
	    )
	  );

	  return $arrayInputs;
	}
}
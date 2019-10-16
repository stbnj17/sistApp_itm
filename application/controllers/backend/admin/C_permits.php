<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Permisos de Usuario
 */
class C_permits extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/admin/m_permits');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
	
		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(34, $arrRoles) || in_array(35, $arrRoles)) {
				$actions['M'] = '<td align="center">';
				if (in_array(34, $arrRoles)) {
					$actions['M'] .= '<a class="btn btn-info btn-xs e_modulo" title="Editar Módulo"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(35, $arrRoles)) {
					$actions['M'] .= '<a class="btn btn-danger btn-xs d_modulo" title="Eliminar Módulo"><i class="fa fa-trash"></i></a>';
				}
				$actions['M'] .= '</td>';
			} else $actions['M'] = '';

			if (in_array(39, $arrRoles) || in_array(40, $arrRoles)) {
				$actions['R'] = '<td align="center">';
				if (in_array(39, $arrRoles)) {
					$actions['R'] .= '<a class="btn btn-info btn-xs e_rol" title="Editar Rol"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(40, $arrRoles)) {
					$actions['R'] .= '<a class="btn btn-danger btn-xs d_rol" title="Eliminar Rol"><i class="fa fa-trash"></i></a>';
				}
				$actions['R'] .= '</td>';
			} else $actions['R'] = '';

			if (in_array(43, $arrRoles) || in_array(44, $arrRoles)) {
				$actions['P'] = '';
				if (in_array(43, $arrRoles)) {
					$actions['P'] .= '<a class="btn btn-info btn-xs e_perfil" title="Editar Perfil"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(44, $arrRoles)) {
					$actions['P'] .= '<a class="btn btn-danger btn-xs d_perfil" title="Eliminar Perfil"><i class="fa fa-trash"></i></a>';
				}
			} else $actions['P'] = '';
		}

		$data = array(
			'title' => '	<title>Permisos de Usuario | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/admin/permisos',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_permisos.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTableModule' => $this->m_permits->__listModules(),
			'dataTableRole' => $this->m_permits->__listRoles(),
			'dataTableProfile' => $this->m_permits->__listProfiles(),
			'dataTableModuleRole' => $this->m_permits->__listModulesRoles(),
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	/*--- Modules's Functions ---*/
	public function newModule() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveNew = $this->m_permits->__newModule($this->input->post());
				if (is_null($resSaveNew)) {
					$msj = 'ok';
					$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secModulos' ).offset().top - 15 }, 1000);");
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewModule() {
		if ($this->input->is_ajax_request()) {
			$arrayVM = $this->m_permits->__viewModule($this->input->post());
			echo json_encode($arrayVM);
		} else {
			show_404();
		}
	}

	public function editModule() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resCambios = $this->m_permits->__verifChangesModule($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_permits->__verifUniqueModule($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_permits->__editModule($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secModulos' ).offset().top - 15 }, 1000);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteModule() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_permits->__deleteModule($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secModulos' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

	public function changeStatusModule() {
		if ($this->input->is_ajax_request()) {
			$resChange = $this->m_permits->__changeStatusModule($this->input->post());
			if (is_null($resChange)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Cambio realizado correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secModulos' ).offset().top - 15 }, 1000);");
				$msj = 'ok';
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	/*--- Roles's Functions ---*/
	public function newRole() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveNew = $this->m_permits->__newRole($this->input->post());
				if (is_null($resSaveNew)) {
					$msj = 'ok';
					$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secRoles' ).offset().top - 15 }, 1000);");
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewRole() {
		if ($this->input->is_ajax_request()) {
			$arrayVR = $this->m_permits->__viewRole($this->input->post());
			echo json_encode($arrayVR);
		} else {
			show_404();
		}
	}

	public function editRole() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resCambios = $this->m_permits->__verifChangesRole($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_permits->__verifUniqueRole($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_permits->__editRole($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secRoles' ).offset().top - 15 }, 1000);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteRole() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_permits->__deleteRole($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secRoles' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

	public function changeStatusRole() {
		if ($this->input->is_ajax_request()) {
			$resChange = $this->m_permits->__changeStatusRole($this->input->post());
			if (is_null($resChange)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Cambio realizado correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secRoles' ).offset().top - 15 }, 1000);");
				$msj = 'ok';
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	/*--- Roles Module's Functions ---*/
	public function saveRolesModule() {
		if ($this->input->is_ajax_request()) {
			$msj='';
			$_POST['chk'] = '';
			foreach ($this->input->post() as $chkboxName => $arrChecked) {
				if (strpos($chkboxName, 'chk_') !== FALSE) {
					foreach ($arrChecked as $i => $checkedName) {
						$_POST['chk'][]=explode('_', $checkedName);
					}
				}
			}

			if ($_POST['chk'] == '') {
				$msj = 'Debe asignar por lo menos un Rol a algún Módulo.';
			} else {
				$resSaveChange = $this->m_permits->__saveRolesModule($this->input->post('chk'));
				if (is_null($resSaveChange)) {
					$msj = 'ok';
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	/*--- Profiles's Functions ---*/
	public function newProfile() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveNew = $this->m_permits->__newProfile($this->input->post());
				if (is_null($resSaveNew)) {
					$msj = 'ok';
					$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secPerfiles' ).offset().top - 15 }, 1000);");
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewProfile() {
		if ($this->input->is_ajax_request()) {
			$arrayVP = $this->m_permits->__viewProfile($this->input->post());
			echo json_encode($arrayVP);
		} else {
			show_404();
		}
	}

	public function editProfile() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resCambios = $this->m_permits->__verifChangesProfile($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_permits->__verifUniqueProfile($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_permits->__editProfile($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secPerfiles' ).offset().top - 15 }, 1000);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteProfile() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_permits->__deleteProfile($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secPerfiles' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

	public function changeStatusProfile() {
		if ($this->input->is_ajax_request()) {
			$resChange = $this->m_permits->__changeStatusProfile($this->input->post());
			if (is_null($resChange)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Cambio realizado correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secPerfiles' ).offset().top - 15 }, 1000);");
				$msj = 'ok';
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	/*--- Modules Profile's Functions ---*/
	public function viewModulesProfile() {
		if ($this->input->is_ajax_request()) {
			$arrayVMP = $this->m_permits->__viewModulesProfile($this->input->post());
			echo json_encode($arrayVMP);
		} else {
			show_404();
		}
	}

	public function saveModulesProfile() {
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('modulos[]', 'Módulo', 'required',
        array('required' => 'Debes seleccionar al menos un Módulo.')
			);
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveChange = $this->m_permits->__saveModulesProfile($this->input->post());
				if (is_null($resSaveChange)) {
					$msj = 'ok';
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

  //Variables e Inputs - Formulario para Permisos de Usuario
	public function arrInputs() {
		$onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
		$onlyLetrasSlash = '[a-zA-ZñÑáéíóúÁÉÍÓÚ\/]+';

    $arrayInputs = array(

	    'inpModule' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Módulo *', 
	      'maxlength' => '50', 
	      'title' => 'Módulo obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpPath' => array(
	      'class' => 'form-control', 
	      'placeholder' => '/ ruta /', 
	      'maxlength' => '100', 
	      'title' => 'Ruta obligatoria: Solo letras y slash (/).', 
	      'pattern' => $onlyLetrasSlash, 
	      'required' => 'true'
	    ),

	    'inpRole' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Rol *', 
	      'maxlength' => '20', 
	      'title' => 'Rol obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpProfile' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Perfil *', 
	      'maxlength' => '50', 
	      'title' => 'Perfil obligatorio: Solo letras.', 
	      'pattern' => $onlyLetras, 
	      'required' => 'true'
	    ),

	    'inpDescrip' => array(
	      'name' => 'descripcion', 
	      'class' => 'form-control', 
	      'placeholder' => 'Descripción', 
	      'maxlength' => '200', 
	      'rows' => '2', 
	      'title' => "Descripción: Letras, números y caracteres (:+''().,_-).", 
	      'style' => 'resize: vertical'
	    ),

	    'checkAttr' => array(
	      'class' => 'flat'
	    ),

	    'inpEcod' => array(
	      'type' => 'hidden', 
	      'name' => 'cod'
	    ),

	    'btnClean' => array(
	      'type' => 'reset', 
	      'class' => 'btn btn-default', 
	      'content' => 'Limpiar', 
	      'title' => 'Limpiar'
	    ),

	    'btnSubmit' => array(
	      'name' => 'save', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar'
	    ),

	    'btnExitSubmit' => array(
	      'name' => 'cerrar', 
	      'type' => 'button', 
	      'class' => 'btn btn-default', 
	      'content' => 'Cerrar', 
	      'title' => 'Cerrar Edición'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'saveEdit', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
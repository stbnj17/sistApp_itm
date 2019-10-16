<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Usuarios
 */
class C_users extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/admin/m_users');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		$optSelect[''] = 'Seleccione un Cuenta';
		$optSelectEdit[''] = 'Seleccione un Cuenta';
		$resListCustomers = $this->m_users->__listCustomers();

		foreach ($resListCustomers as $row) {
			$optSelectEdit[$row['id']] = $row['cliente'];
			if ($row['username'] == '') {
				$optSelect[$row['id']] = $row['cliente'];
			}
		}

		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(29, $arrRoles) || in_array(30, $arrRoles)) {
				if (in_array(29, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs e_usuario" title="Editar Usuario"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(30, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_usuario" title="Eliminar Usuario"><i class="fa fa-trash"></i></a>';
				}
			}
		}

		$data = array(
			'title' => '	<title>Usuarios | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/admin/usuarios',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_usuarios.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTableUser' => $this->m_users->__listUsers(),
			'dataTableProfile' => $this->m_users->__listProfiles(),
			'optSelect' => $optSelect,
			'optSelectEdit' => $optSelectEdit,
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function newUser() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveNew = $this->m_users->__newUser($this->input->post());
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

	public function viewUser() {
		if ($this->input->is_ajax_request()) {
			$arrayVU = $this->m_users->__viewUser($this->input->post());
			echo json_encode($arrayVU);
		} else {
			show_404();
		}
	}

	public function editUser() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post('ePass') != '' || $this->input->post('eRpass') != '') {
				$this->form_validation->set_rules('eCustomer', 'Cliente', 'trim|required|xss_clean');
				$this->form_validation->set_rules('eUser', 'Usuario', 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9]*$/u]|max_length[100]|xss_clean');
				$this->form_validation->set_rules('ePass', 'Contraseña', 'trim|required|max_length[50]|xss_clean');
				$this->form_validation->set_rules('eRpass', 'Repita Contraseña', 'trim|required|matches[ePass]|max_length[50]|xss_clean');
			}
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resCambios = $this->m_users->__verifChanges($this->input->post());
				if ($resCambios > 0 && $this->input->post('ePass') == '' && $this->input->post('eRpass') == '') {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_users->__verifUnique($this->input->post());
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_users->__editUser($this->input->post());
						if (is_null($resSaveChange)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secLista' ).offset().top - 15 }, 1000);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteUser() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_users->__deleteUser($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secLista' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

	public function redirectCustomers() {
		$this->session->set_flashdata('save_ok', "setTimeout(collapsed, 500);");
		redirect('../admClientes', 'refresh');
	}

	/*--- Roles User's Functions ---*/
	public function viewRolesUser() {
		if ($this->input->is_ajax_request()) {
			$arrayVRU = $this->m_users->__viewRolesUser($this->input->post());
			$arrInp = $this->arrInputs();
			$res = $this->tableRoles($arrayVRU, $arrInp);
			echo json_encode($res);
		} else {
			show_404();
		}
	}

	public function saveRolesUser() {
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
				$resSaveChange = $this->m_users->__saveRolesUser($this->input->post());
				if (is_null($resSaveChange)) {
					$msj = 'ok';
				}
			}
			
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function tableRoles($arrayVRU, $arrInp) {
		$table = '<table id="tableRolUsuario" class="table table-striped">';
		if (!empty($arrayVRU['roles']) || !empty($arrayVRU['modules'])) {
      $table .= '<thead>
	                <tr>
	                  <th class="text-center">'
	                  .$this->inpChkbox('all', 'roles', FALSE, $arrInp['chkAll']).'
	                  </th>
	                  <th>Módulos | Roles</th>';
	                  foreach ($arrayVRU['roles'] as $rowRol) {
					$table .= '<th class="text-center">'
											.$rowRol['role'].
										'</th>';
	                  }
	                  if (empty($arrayVRU['roles'])) {
        	$table .= '<th class="text-center">No existen roles disponibles</th>';
	                  }
      	$table .= '</tr>
                </thead>';
      $table .= '<tbody align="center">';
      					foreach ($arrayVRU['modules'] as $rowMod) {
      	$table .= '<tr>
                    <th class="text-center">'
                    	.$this->inpChkbox('roles', 'chk_'.$rowMod['num'].'[]', FALSE, $arrInp['checkAll']).
                    '</th>';
        	$table .= '<th>'
                    	.$rowMod['module'].
                    '</th>';
                    foreach ($arrayVRU['roles'] as $rowRol) {
        	$table .= '<td>';
        						if (in_array(array('module_id' => $rowMod['id'], 'role_id' => $rowRol['id']), $arrayVRU['rolesUser'])) {
            					if (in_array(array('module_id' => $rowMod['id'], 'role_id' => $rowRol['id']), $arrayVRU['checked'])) {
          	$table .= $this->inpChkbox('chk_'.$rowMod['num'].'[]', $rowMod['id'].'_'.$rowRol['id'], TRUE, $arrInp['chkChange']);
                      } else {
            $table .= $this->inpChkbox('chk_'.$rowMod['num'].'[]', $rowMod['id'].'_'.$rowRol['id'], FALSE, $arrInp['chkChange']);
                      }
                    }
        	$table .= '</td>';
                    }
                    if (empty($arrayVRU['roles'])) {
        	$table .= '<td></td>';
                    }
      	$table .= '</tr>';
      					}
      					if (empty($arrayVRU['modules'])) {
      	$table .= '<tr align="center"><td colspan="'.(count($arrayVRU['roles'])+2).'">No existen módulos disponibles.</td></tr>';
      					}
    	$table .= '</tbody>';
		} else {
			$table .= '<thead>
                  <tr align="center">
                    <td>No existen roles ni módulos disponibles.</td>
                  </tr>
                </thead>';
		}
		$table .= '</table>';

		return $table;
	}

	public function inpChkbox($name, $value, $status, $attrAdd) {
		return '<label class="chkbox">'.form_checkbox($name, $value, $status, $attrAdd).'<span class="check"></span></label>';
	}

  //Variables e Inputs - Formulario para Usuarios
	public function arrInputs() {
    $LetDigito = '[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+';

    $arrayInputs = array(

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
	      'id' => 'pass', 
	      'name' => 'pass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpRpass' => array(
	      'type' => 'password', 
	      'id' => 'rPass', 
	      'name' => 'rPass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Repita Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña obligatorio.', 
	      'required' => 'true'
	    ),

	    'inpEpass' => array(
	      'type' => 'password', 
	      'id' => 'ePass', 
	      'name' => 'ePass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña.'
	    ),

	    'inpErpass' => array(
	      'type' => 'password', 
	      'id' => 'eRpass', 
	      'name' => 'eRpass', 
	      'class' => 'form-control', 
	      'placeholder' => 'Repita Contraseña', 
	      'maxlength' => '255', 
	      'title' => 'Contraseña.'
	    ),

	    'inpEcodU' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodU'
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

	    'checkAttr' => array(
	      'class' => 'flat'
	    ),

	    'checkAll' => array(
	      'onclick' => 'checkAll($(this))'
	    ),

	    'chkAll' => array(
	      'onclick' => 'chkAll($(this))'
	    ),

	    'chkChange' => array(
	      'onclick' => 'chkChange()'
	    ),

	    'btnNewSubmit' => array(
	      'name' => 'newUsuario', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Usuario'
	    ),

	    'btnExitSubmit' => array(
	      'name' => 'cerrar', 
	      'type' => 'button', 
	      'class' => 'btn btn-default', 
	      'content' => 'Cerrar', 
	      'title' => 'Cerrar Edición'
	    ),

	    'btnSubmit' => array(
	      'name' => 'save', 
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
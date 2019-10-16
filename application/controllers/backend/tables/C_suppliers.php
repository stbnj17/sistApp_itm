<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Proveedores - Tablas
 */
class C_suppliers extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/tables/m_suppliers');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(10, $arrRoles) || in_array(11, $arrRoles)) {
				$actions = '<td align="center">';
				if (in_array(10, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs e_proveedor" title="Editar Proveedor"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(11, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_proveedor" title="Eliminar Proveedor"><i class="fa fa-trash-o"></i></a>';
				}
				$actions .= '</td>';
			}
		}

		$data = array(
			'title' => '	<title>Proveedores | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/datatables_css'),
			'content' => 'backend/tables/proveedores',
			'scriptsAdd' => array('backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_proveedores.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTable' => $this->m_suppliers->__listSuppliers($this->session->userdata('logged_in')['c_id']),
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function newSupplier() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
				$resUnico = $this->m_suppliers->__verifUnique($this->input->post(), 'new');
				if ($resUnico != '') {
					$msj = explode('|', $resUnico);
				} else {
					$resSaveNew = $this->m_suppliers->__newSupplier($this->input->post());
					if (is_null($resSaveNew)) {
						$msj = 'ok';
						$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); setTimeout(collapsed, 500);");
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewSupplier() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_suppliers->__viewSupplier($this->input->post());
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editSupplier() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['eCustomer'] = $this->session->userdata('logged_in')['c_id'];
				$resCambios = $this->m_suppliers->__verifChanges($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {
					$resUnico = $this->m_suppliers->__verifUnique($this->input->post(), 'edit');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveChange = $this->m_suppliers->__editSupplier($this->input->post());
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

	public function deleteSupplier() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_suppliers->__deleteSupplier($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secLista' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

  //Variables e Inputs - Formulario para Proveedores
	public function arrInputs() {
    $onlyDigitos = '[0-9]+';
    $LetDigito = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ.]+';
    $letraDigitOtros = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ°.,_-]+';

    $arrayInputs = array(
	    'inpProveedor' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Empresa SAC *', 
	      'maxlength' => '100', 
	      'title' => 'Proveedor obligatorio: Solo letras, dígitos y punto.', 
	      'pattern' => $LetDigito, 
	      'required' => 'true'
	    ),

	    'inpNdoc' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Documento *', 
	      'maxlength' => '20', 
	      'title' => 'Número de RUC obligatorio: Solo dígitos.', 
	      'pattern' => $onlyDigitos, 
	      'required' => 'true'
	    ),

	    'inpDireccion' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Dirección', 
	      'maxlength' => '200', 
	      'title' => 'Dirección obligatoria: Letras, dígitos y caracteres (°.,_-).', 
	      'pattern' => $letraDigitOtros
	    ),

	    'inpPhone' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'N° Teléfono', 
	      'maxlength' => '20', 
	      'title' => 'Teléfono: Solo dígitos.', 
	      'pattern' => $onlyDigitos
	    ),

	    'inpWeb' => array(
	    	'type' => 'url', 
	    	'name' => 'web', 
	      'class' => 'form-control', 
	    	'value' => set_value("web"), 
	      'placeholder' => 'https://example.com', 
	      'maxlength' => '100'
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
	    
	    'inpEemail' => array(
	    	'type' => 'email', 
	    	'name' => 'eEmail', 
	    	'value' => set_value("eEmail"), 
	      'class' => 'form-control', 
	      'placeholder' => 'contacto@ejemplo.com', 
	      'maxlength' => '100', 
	      'title' => 'Correo'
	    ), 

	    /*'attSelect' => array(
	      'id' => 'tipo', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'atteSelect' => array(
	      'id' => 'eTipo', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),*/

	    'inpEcodP' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodP'
	    ),

	    'btnNewSubmit' => array(
	      'name' => 'newProveedor', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Agregar Proveedor'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'editProveedor', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Productos - Tablas
 */
class C_products extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/tables/m_products');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$actions = $save_ok = '';
		$cust_id = $this->session->userdata('logged_in')['c_id'];
		$save_ok = $this->session->flashdata('save_ok');
		$optSelects['types'][''] = 'Seleccione una opción';
		$optSelects['brands'][''] = 'Seleccione una opción';
		$optSelects['products'][''] = '';
		$optSelects['suppliers'][''] = 'Seleccione un Proveedor';
		$optSelects['coin']['USD'] = 'Dólares';
		$optSelects['coin']['SOL'] = 'Soles';
		$resListTypes = $this->m_products->__listTypes($cust_id);
		$resListBrands = $this->m_products->__listBrands($cust_id);
		$resListProducts = $this->m_products->__listProducts($cust_id);
		$resListSuppliers = $this->m_products->__listSuppliers($cust_id);

		foreach ($resListTypes as $row) {
			$optSelects['types'][$row['id']] = $row['type_product'];
		}
		foreach ($resListBrands as $row) {
			$optSelects['brands'][$row['id']] = $row['brand'];
		}
		foreach ($resListProducts as $row) {
			$optSelects['products'][$row['id']] = $row['product'];
		}
		foreach ($resListSuppliers as $row) {
			$optSelects['suppliers'][$row['id']] = $row['supplier'];
		}

		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(14, $arrRoles) || in_array(15, $arrRoles)) {
				$actions = '<td align="center">';
				if (in_array(14, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs e_producto" title="Editar Producto"><i class="fa fa-pencil"></i></a>';
				}
				if (in_array(15, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_producto" title="Eliminar Producto"><i class="fa fa-trash-o"></i></a>';
				}
				$actions .= '</td>';
			}
		}

		$data = array(
			'title' => '	<title>Productos | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/datatables_css', 'backend/includes/css/select2_css'),
			'content' => 'backend/tables/productos',
			'scriptsAdd' => array('backend/includes/js/datatables_js', 'backend/includes/js/select2_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_productos.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'dataTable' => $this->m_products->__listProducts($cust_id),
			'comision' => $this->m_products->__getComission($cust_id),
			'optSelects' => $optSelects,
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function newProduct() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {

				if (empty($_POST['codigo']) && empty($_POST['modelo'])) {
					$this->form_validation->set_rules('codigo', 'Código', 'trim|required|xss_clean');
					$this->form_validation->set_rules('modelo', 'Modelo', 'trim|required|xss_clean');
				}

				if ($this->form_validation->run() == FALSE) {
					$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
				} else {
					$_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
					$resUnico = $this->m_products->__verifUnique($this->input->post(), 'new');
					if ($resUnico != '') {
						$msj = explode('|', $resUnico);
					} else {
						$resSaveNew = $this->m_products->__newProduct($this->input->post());
						if (is_null($resSaveNew)) {
							$msj = 'ok';
							$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); setTimeout(collapsed, 500);");
						}
					}
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function viewProduct() {
		if ($this->input->is_ajax_request()) {
			$arrayVC = $this->m_products->__viewProduct($this->input->post());
			echo json_encode($arrayVC);
		} else {
			show_404();
		}
	}

	public function editProduct() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['eCustomer'] = $this->session->userdata('logged_in')['c_id'];
				$resCambios = $this->m_products->__verifChanges($this->input->post());
				if ($resCambios > 0) {
					$msj = 'warning';
				} else {

					if (empty($_POST['eCodigo']) && empty($_POST['eModelo'])) {
						$this->form_validation->set_rules('eCodigo', 'Código', 'trim|required|xss_clean');
						$this->form_validation->set_rules('eModelo', 'Modelo', 'trim|required|xss_clean');
					}

					if ($this->form_validation->run() == FALSE) {
						$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
					} else {
						$resUnico = $this->m_products->__verifUnique($this->input->post(), 'edit');
						if ($resUnico != '') {
							$msj = explode('|', $resUnico);
						} else {
							$resSaveChange = $this->m_products->__editProduct($this->input->post());
							if (is_null($resSaveChange)) {
								$msj = 'ok';
								$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se guardó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secTabla' ).offset().top - 15 }, 1000);");
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

	public function deleteProduct() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_products->__deleteProduct($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success'); $('html, body').animate({ scrollTop : $( '#secTabla' ).offset().top - 15 }, 1000);");
			}
		} else {
			show_404();
		}
	}

	public function viewCost() {
		if ($this->input->is_ajax_request()) {
			$resCostProduct = $this->m_products->__viewCost($this->input->post());
			echo json_encode($resCostProduct);
		} else {
			show_404();
		}
	}

	public function newEditCost() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
				$resSaveCost = $this->m_products->__newEditCost($this->input->post());
				if (is_null($resSaveCost)) {
					$msj = 'ok';
				} elseif ($resSaveCost == 'warning') {
					$msj = $resSaveCost;
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteCost() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_products->__deleteCost($this->input->post());
			if (is_null($resDelete)) {
				$resDelete = '';
			}
			echo json_encode($resDelete);
		} else {
			show_404();
		}
	}

	public function viewSale() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == false) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$maxPCosto = 0;
				$maxMCosto = '';
				$htmlProveedor = '';
				$_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
				$this->m_products->__changePricesSale($this->input->post()); /*verificar si cambiar los precios de Venta*/
				$resSaleProduct = $this->m_products->__viewSale($this->input->post());
				$reCostProv = $this->m_products->__costProv($this->input->post());
			 	$mVenta = $resSaleProduct[0]['coin'];
				$pVenta = $resSaleProduct[0]['price_sale'];

			 	foreach ($reCostProv as $row) {
			 		if ($row['coin'] == 'USD') { $row['moneda'] = '$'; }
			 		if ($row['coin'] == 'SOL') { $row['moneda'] = 'S/.'; }
			 		if ($maxPCosto == 0 || $maxPCosto < $row['price_cost']) {
			 			$maxPCosto = $row['price_cost'];
			 			$maxMCosto = $row['coin'];
			 		}

			 		$htmlProveedor .= '<li>
			                          <p>
			                            <span class="provName_left">
			                              <i class="fa fa-dot-circle-o"></i> <strong>' . $row['supplier'] . '</strong>
			                            </span>
			                            <span class="provCost_right">' . $row['moneda'] . ' ' . $row['price_cost'] . '</span>
			                          </p>
			                        </li>';
			 	}

			 	$msj['ok'] = $this->getCalculoInputs($this->input->post('comision'), $mVenta, $pVenta, $maxMCosto, $maxPCosto, $htmlProveedor);
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function editPSale() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
			} else {
				$resSaveSale = $this->m_products->__editPSale($this->input->post());
				if (is_null($resSaveSale)) {
					$msj = 'ok';
				} elseif ($resSaveSale == 'warning') {
					$msj = $resSaveSale;
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function getCalculoInputs($comision, $monedaVenta, $pVenta, $monedaCosto, $pCosto, $htmlProveedor) {
		$inputsCalc = array('pPropuesto' => '', 'pCosto' => '', 'utilidad' => '', 'porcUtilidad' => '', 'pVenta' => '', 'moneda' => '', 'proveedor' => 'No existen costos de Proveedores para este Producto.');
		
		if ($pCosto > 0) {
			$inputsCalc['pCosto'] = $pCosto;
			$inputsCalc['pPropuesto'] = number_format($pCosto * (1 + $comision / 100), 2, '.', '');
			if ($pVenta == 0) {
				$inputsCalc['pVenta'] = number_format($inputsCalc['pPropuesto'], 2, '.', '');
				$inputsCalc['moneda'] = $monedaCosto;
			} else {
				$inputsCalc['pVenta'] = $pVenta;
				$inputsCalc['moneda'] = $monedaVenta;
			}
			$inputsCalc['utilidad'] = number_format($inputsCalc['pVenta'] - $inputsCalc['pCosto'], 2, '.', '');
			$inputsCalc['porcUtilidad'] = number_format(($inputsCalc['utilidad'] / $inputsCalc['pCosto']) * 100, 2, '.', '') . ' %';
			$inputsCalc['proveedor'] = $htmlProveedor;
		} else {
			if ($pVenta != 0) {
				$inputsCalc['pVenta'] = $pVenta;
				$inputsCalc['moneda'] = $monedaVenta;
			}
		}
		
		return $inputsCalc;
	}

  //Variables e Inputs - Formulario para Productos
	public function arrInputs() {
		$onlyLetras = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ]+';
    $onlyDigitos = '[0-9]+';
    $onlyMoney = '[0-9]+|[0-9]+.[0-9]+';
    $letraPunto = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ.]+';
    $LetDigito = '[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #-\/\+]+';
    $letraDigitGuion = '[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]+';
    $letraDigitOtros = '[a-zA-Z0-9 ñÑáéíóúÁÉÍÓÚ:+"().,_-]+';

    $arrayInputs = array(
    	'attSelects' => array(
	      'class' => 'form-control select_tags', 
	      'required' => 'true'
	    ),
	    
	    'inpCode' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Código', 
	      'maxlength' => '50', 
	      'title' => 'Código obligatorio: Letras, números y guión.', 
	      'pattern' => $letraDigitGuion
	    ),

	    'inpModel' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Modelo', 
	      'maxlength' => '50', 
	      'title' => 'Modelo obligatorio: Letras y números', 
	      'pattern' => $LetDigito
	    ),

	    'inpProduct' => array(
	      'class' => 'form-control', 
	      'placeholder' => 'Producto *', 
	      'maxlength' => '100', 
	      'title' => "Producto obligatorio. Letras, números y caracteres (:+''().,_-).", 
	      /*'pattern' => $letraDigitOtros, */
	      'required' => 'true'
	    ),

	    'inpDescrip' => array(
	      'name' => 'descripcion', 
	      'class' => 'form-control', 
	      'placeholder' => 'Descripción', 
	      'maxlength' => '200', 
	      'rows' => '3', 
	      'title' => "Descripción.", 
	      'style' => 'resize: vertical'
	    ),

	    'attSelectProduct' => array(
	      'class' => 'form-control select2_single', 
	      'required' => 'true'
	    ),

	    'attSelectSupplier' => array(
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'attSelectCost' => array(
	      'id' => 'cMoneda', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'attSelectSale' => array(
	      'id' => 'vMoneda', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'inpRequireMoney' => array(
	      'class' => 'form-control has-feedback-right', 
	      'placeholder' => '0.00', 
	      'title' => 'Campo obligatorio: Solo números y punto.', 
	      'pattern' => $onlyMoney, 
	      'required' => 'true'
	    ),

	    'inpMoney' => array(
	      'class' => 'form-control has-feedback-right', 
	      'placeholder' => '0.00', 
	      'readonly' => 'true'
	    ),

	    'inpComision' => array(
	      'class' => 'form-control has-feedback-right', 
	      'placeholder' => '10 %', 
	      'title' => 'Campo obligatorio: Solo números.', 
	      'pattern' => $onlyDigitos, 
	      'required' => 'true'
	    ),

	    'inpPorcent' => array(
	      'class' => 'form-control has-feedback-right', 
	      'placeholder' => '0 %', 
	      'readonly' => 'true'
	    ),

	    'inpEMoney' => array(
	      'class' => 'form-control has-feedback-right', 
	      'placeholder' => '0.00', 
	      'title' => 'Precio Venta: Solo números y punto.'
	    ),

	    'attEselectType' => array(
	      'id' => 'eTipo', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    'attEselectBrand' => array(
	      'id' => 'eMarca', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),

	    /*'attEselectMoney' => array(
	      'id' => 'eMoneda', 
	      'class' => 'form-control', 
	      'required' => 'true'
	    ),*/

	    'inpEcodPP' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodPP'
	    ),

	    'inpEcodP' => array(
	      'type' => 'hidden', 
	      'name' => 'eCodP'
	    ),

	    'btnSaveSubmit' => array(
	      'name' => 'guardar', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar'
	    ),

	    'btnDeleteSubmit' => array(
	      'name' => 'eliminar', 
	      'type' => 'button', 
	      'class' => 'btn btn-danger', 
	      'content' => 'Eliminar', 
	      'title' => 'Eliminar Costo del Proveedor', 
	      'style' => 'display: none'
	    ),

	    'btnCleanSubmit' => array(
	      'name' => 'limpiar', 
	      'type' => 'reset', 
	      'class' => 'btn btn-default', 
	      'content' => 'Limpiar', 
	      'title' => 'Limpiar Formulario'
	    ),

	    'btnEditSubmit' => array(
	      'name' => 'editProducto', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Guardar Cambios'
	    )
	  );

	  return $arrayInputs;
	}
}
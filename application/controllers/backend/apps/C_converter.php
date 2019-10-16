<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Controlador de Convertidor de Archivos Excel a Txt - Aplicaciones
 */
class C_converter extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/apps/m_converter');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		$data = array(
			'title' => '	<title>Convertir Excel a Texto | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/dropzone_css'),
			'content' => 'backend/apps/convert_file',
			'scriptsAdd' => array('backend/includes/js/dropzone_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_convertidor.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'save_ok' => $save_ok
		);
		
		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function listHistoryXT() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');

		if ($this->session->has_userdata('logged_in')) {
			if (in_array(1, array_column($this->session->userdata('ci_roles'), 'id'))) {
				$actions = '<td>
	                    <a class="btn btn-danger btn-xs d_record"><i class="fa fa-trash"></i> Eliminar</a>
	                  </td>';
			}
		}

		$data = array(
			'title' => '	<title>Historial de Conversiones | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/datatables_css'),
			'content' => 'backend/apps/hist_convert',
			'scriptsAdd' => array('backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_convertidor_lista.js"></script>',
			'dataTable' => $this->m_converter->__listConvertions($this->session->userdata('logged_in')['c_id']),
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function deleteRecordHistory() {
		if ($this->input->is_ajax_request()) {
			$resDelete = $this->m_converter->__deleteRecordHistory($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success');");
			}
		} else {
			show_404();
		}
	}

	public function uploadFileExcel() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = array('err_label' => explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors())));
			} else {
				if (!empty($_FILES)) {
					$config['upload_path'] = "uploads_files/Excel_Txt/";
					$config['allowed_types'] = "xls|xlsx|xlsm";
					$config['max_size'] = 5120;
					/*$config['encrypt_name'] = true;*/

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('file')) {
						$msj = array('err_file' => $this->upload->display_errors('', ''));
					} else {
						$file_name = $this->upload->data('file_name');
						$full_path = $this->upload->data('full_path');
						$file_ext = ucwords(str_replace(".", "", $this->upload->data('file_ext')));
						if ($file_ext == 'Xlsm') {$file_ext = 'Xlsx';}
						
						if (is_readable($full_path)) {
							$msj = $this->leerFileExcel($full_path, $file_name, $this->input->post(), $file_ext);
						} else {
							$msj = array('err_file' => 'El archivo no es legible.');
						}
					}
				} else {
					$msj = array('err_file' => 'El archivo no existe.');
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function leerFileExcel($filename_path, $file_name, $postData, $file_ext) {
		try {
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_ext);
			$spreadsheet = $reader->load($filename_path);
			if ($postData['nameSheet'] != "") {
				$sheet = $spreadsheet->getSheetByName($postData['nameSheet']);
			} else {
				$sheet = $spreadsheet->getActiveSheet();
			}

			if (!is_null($sheet)) {
				$contenido = "";
				$sCol = ""; $eCol = "";
				$sRow = 0; $eRow = 0;

				if ($postData['startCol'] != "") {
					$sCol = $postData['startCol'];
				} else {
					$sCol = 'A';
				}

				if ($postData['endCol'] != "") {
					$eCol = $postData['endCol'];
				}

				if ($postData['startRow'] != "") {
					$sRow = $postData['startRow'];
				} else {
					$sRow = 1;
				}

				if ($postData['endRow'] != "") {
					$eRow = $postData['endRow'];
				}

				foreach ($sheet->getRowIterator($sRow, $eRow) as $row) {
					$cellIterator = $row->getCellIterator($sCol, $eCol);
					$cellIterator->setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell) {
						if (!is_null($cell)) {
							$value = $cell->getCalculatedValue();
							$contenido .= $value;
						}
						if ($cell !== end($cellIterator)) {
							$contenido .= '|';
						}
					}
					$contenido .= "\r\n";
				}

				$filenameTxt = $this->generarFileTxt($file_name, $contenido);
				$this->deleteFile($filename_path);
				
				$resSaveDataConvertion = $this->m_converter->__newConvertFile($this->session->userdata('logged_in')['c_id'], $file_name, $filenameTxt, $postData['nameSheet'], $sCol.'-'.$eCol, $sRow.'-'.$eRow);
		    if (is_null($resSaveDataConvertion)) {
					return array('res_ok' => "convertidor/descargar?nameFileTxt=".$filenameTxt);
				} else {
					return array('err_save' => 'Error.');
	      }
    	} else {
				return array('err_label' => array('El nombre de la Hoja no existe en este archivo.', ''));
      }
		} catch (Exception $e) {
			return array('err_file' => 'No es posible leer este tipo de archivo Excel.');
		}
	}

	public function generarFileTxt($fileName, $content) {
		if ($_POST['nameFile'] != "") {
			$filename = $_POST['nameFile'];
		} else {
			$filename = $this->cambiarNameFile($fileName);
		}
		
		if ($file = fopen('uploads_files/Excel_Txt/'.$filename, 'a')) {
			if (fwrite($file, $content)) {
				/*echo "Se generó correctamente";*/
			} else {
				/*echo "Error al crear archivo";*/
			}
			fclose($file);
		}

		return $filename;
	}

	public function cambiarNameFile($filename) {
		$fileName = '';
		$arr_name = explode('.',$filename);
		
		foreach ($arr_name as $text) {
			if ($text !== end($arr_name)) {
				$fileName .= $text.'.';
			} else {
				$fileName .= 'txt';
			}
		}

		return $fileName;	
	}

	public function downloadFileTxt() {
		if ($this->input->get()) {
			$link = 'uploads_files/Excel_Txt/'.$_GET['nameFileTxt'];
			if (file_exists($link)) {
				header ("Content-Disposition: attachment; filename=".$_GET['nameFileTxt']." ");
				header ("Content-Type: application/octet-stream");
				header ("Content-Length: ".filesize($link));
				readfile($link);
				$this->deleteFile($link);
			} else {
				show_error('The file does not exists.');
			}
		} else {
			show_404();
		}
	}

	public function deleteFile($filename_path) {
		if (file_exists($filename_path)) {
    	unlink($filename_path);
    }
	}

	//Variables e Inputs - Formulario para Convertidor
	public function arrInputs() {
    $arrayInputs = array(
	    'inpNameFile' => array(
	      'id' => 'nameFile', 
	      'name' => 'nameFile', 
	      'class' => 'form-control', 
	      'placeholder' => 'Ejemplo.txt', 
	      'title' => 'Nombre del Archivo', 
	    	'value' => set_value('nameFile')
	    ),

	    'inpNameSheet' => array(
	      'id' => 'nameSheet', 
	      'name' => 'nameSheet', 
	      'class' => 'form-control', 
	      'data-toggle' => 'tooltip', 
	      'data-placement' => 'top', 
	      'data-original-title' => 'Si el documento contiene varias hojas, especifique el nombre de la hoja, de lo contrario se trabajará con la que se haya quedado activa.', 
	      'placeholder' => 'Hoja Nueva', 
	    	'value' => set_value('nameSheet')
	    ),

	    'inpStartCol' => array(
	      'id' => 'startCol', 
	      'name' => 'startCol', 
	      'class' => 'form-control text-uppercase', 
	      'placeholder' => 'Ej: A', 
	      'title' => 'Inicio de Columna'
	    ),
	    
	    'inpEndCol' => array(
	      'id' => 'endCol', 
	      'name' => 'endCol', 
	      'class' => 'form-control text-uppercase', 
	      'placeholder' => 'Ej: Z', 
	      'title' => 'Fin de Columna'
	    ),

	    'inpStartRow' => array(
	      'id' => 'startRow', 
	      'name' => 'startRow', 
	      'class' => 'form-control', 
	      'placeholder' => 'Ej: 10', 
	      'title' => 'Inicio de Fila'
	    ),
	    
	    'inpEndRow' => array(
	      'id' => 'endRow', 
	      'name' => 'endRow', 
	      'class' => 'form-control', 
	      'placeholder' => 'Ej: 100', 
	      'title' => 'Fin de Fila'
	    ),

	    'btnStartUp' => array(
	      'name' => 'startUp', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Convertir y Descargar'
	    )
	  );

	  return $arrayInputs;
	}
}
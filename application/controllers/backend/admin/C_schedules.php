<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Controlador de Cronogramas
 */
class C_schedules extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('backend/admin/m_schedules');
		$this->form_validation->set_error_delimiters('','');
	}

	public function index() {
		$save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');

		$data = array(
			'title' => '	<title>Cronograma de Obligaciones | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/dropzone_css', 'backend/includes/css/bs_datetimepicker_css'),
			'content' => 'backend/admin/cronograma',
			'scriptsAdd' => array('backend/includes/js/dropzone_js', 'backend/includes/js/bs_datetimepicker_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_cronograma.js"></script>',
			'arrInputs' => $this->arrInputs(),
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);
	}

	public function listSchedules() {
		$actions = $save_ok = '';
		$save_ok = $this->session->flashdata('save_ok');
		
		if ($this->session->has_userdata('logged_in')) {
			$arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

			if (in_array(19, $arrRoles) || in_array(21, $arrRoles)) {
				$actions = '<td align="center">';
				if (in_array(19, $arrRoles)) {
					$actions .= '<a class="btn btn-info btn-xs v_cronograma"><i class="fa fa-eye"></i> Ver</a>';
				}
				if (in_array(21, $arrRoles)) {
					$actions .= '<a class="btn btn-danger btn-xs d_cronograma"><i class="fa fa-trash"></i> Eliminar</a>';
				}
				$actions .= '</td>';
			}
		}

		$data = array(
			'title' => '	<title>Lista de Cronogramas | IT Managers</title>',
			'stylesAdd' => array('backend/includes/css/icheck_css', 'backend/includes/css/datatables_css'),
			'content' => 'backend/admin/cronograma_lista',
			'scriptsAdd' => array('backend/includes/js/icheck_js', 'backend/includes/js/datatables_js'),
			'jsPropio' => '	<!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_cronograma_lista.js"></script>',
			'dataTable' => $this->m_schedules->__listSchedules(),
			'arrInputs' => $this->arrInputs(),
			'actions' => $actions,
			'save_ok' => $save_ok
		);

		$this->parser->parse('backend/templates/tmp_admin', $data);		
	}

	public function viewSchedule() {
		if ($this->input->is_ajax_request()) {
			$resSchedule = $this->m_schedules->__viewSchedule($this->input->post());
			$resTitleSchedule = $this->m_schedules->__gettitleSchedule($this->input->post());
			$resScheduleBD['res_html'] = $this->generateTableSchedule($resSchedule);
			$resScheduleBD['res_title'] = 'Cronograma del Periodo '.$resTitleSchedule[0]['period'];
			echo json_encode($resScheduleBD);
		} else {
			show_404();
		}
	}

	public function changeStatusSchedule() {
		if ($this->input->is_ajax_request()) {
			$resChange = $this->m_schedules->__actDesactSchedule($this->input->post());
			if (is_null($resChange)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Cambio realizado correctamente.', 'success');");
				$this->getEvents();
				$msj = 'ok';
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function deleteSchedule() {
		if ($this->input->is_ajax_request()) {
			$resNameFile = $this->m_schedules->__getNameFile($this->input->post());
			$resDelete = $this->m_schedules->__deleteSchedule($this->input->post());
			if (is_null($resDelete)) {
				$this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Se eliminó correctamente.', 'success');");
				$this->deleteFile('uploads_files/schedules/'.$resNameFile[0]['fileName']);
				$this->getEvents();
			}
		} else {
			show_404();
		}
	}

	public function uploadScheduleExcel() {
		if ($this->input->is_ajax_request()) {
			if ($this->form_validation->run() == FALSE) {
				$msj = array('err_label' => validation_errors());
			} else {
				if (!empty($_FILES) && $_POST['date'] != 'undefined') {
					$config['file_name'] = $_POST['date'].'_'.$_FILES['file']['name'];
					$config['upload_path'] = "uploads_files/schedules/";
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
							$msj = $this->leerFileExcel($full_path, $file_name, $_POST['date'], $file_ext);
						} else {
							echo "Error. El archivo no existe o no es legible.";
						}
					}
				} else {
					$msj = array('err_label' => 'El campo Periodo es obligatorio.');
				}
			}
			echo json_encode($msj);
		} else {
			show_404();
		}
	}

	public function leerFileExcel($filename_path, $file_name, $input_date, $file_ext) {
		try {
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_ext);
			$spreadsheet = $reader->load($filename_path);
			
			$sheet = $spreadsheet->getActiveSheet();

			$countCol = $this->contarColumns($sheet, 1, 1, 0);
			$countColx2 = $this->contarColumns($sheet, 2, 2, 1);
			$titleCenter = $sheet->getCellByColumnAndRow(2, 1)->getCalculatedValue();
			$titleLeft = $sheet->getCellByColumnAndRow(1, 1)->getCalculatedValue();
			$titleRight = $sheet->getCellByColumnAndRow((1+$countColx2), 2)->getCalculatedValue();

			$contenido = "<table class='table table-striped jambo_table table-bordered'>
											<thead>
												<tr>
													<th colspan='".($countCol)."' class='text-center'>".$titleCenter."</th>
												</tr>
												<tr>
													<th rowspan='2' class='text-center'>".$titleLeft."</th>
                          ".$this->columnName($sheet, 2, $countColx2, 2, 2, '0', 'T1')."
                          <th colspan='".($countCol-$countColx2)."' class='text-center'>".$titleRight."</th>
                        </tr>
                        <tr>
                          ".$this->columnName($sheet, ($countColx2+1), $countCol, 3, 1, '0', 'T2')."
                        </tr>
											</thead>
											<tbody align='center'>";

			$resIsScheduleExcel = $this->isScheduleExcel($titleCenter, $titleLeft, $titleRight);

			if ($resIsScheduleExcel === TRUE) {
				$arrDataSchedule = array();
				$arrDataSchedule[] = array($titleCenter, '', '1', '', $countCol, '', 'P1');
				$arrDataSchedule[] = array($titleLeft, '', '2', '2', '', '', 'P1');
				$arrDataSchedule = $this->columnName($sheet, 2, $countColx2, 2, 2, $arrDataSchedule, 'T1');
				$arrDataSchedule[] = array($titleRight, '', '2', '', ($countCol-$countColx2), '', 'P1');
				$arrDataSchedule = $this->columnName($sheet, ($countColx2+1), $countCol, 3, 1, $arrDataSchedule, 'T2');

				foreach ($sheet->getRowIterator(4) as $row) {
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);

					$contenido .= '<tr>';
					$i=1;
					foreach ($cellIterator as $cell) {
						if (!is_null($cell)) {
							$rowIndex = $row->getRowIndex();
							if ($sheet->getCellByColumnAndRow($i, $rowIndex) != "") {
								$cellValue = $cell->getCalculatedValue();
								if ($i == 1) {
									$cellText = $this->convertDate($cellValue, 1);
									$contenido .= "<th class='text-center' scope='row'>".$cellText."</th>";
								} else {
									$valCellDown = $sheet->getCellByColumnAndRow($i, ($rowIndex+1));
									if ($valCellDown->getValue() != '') {
										$cellText = $cellValue."<br>".$this->convertDate($valCellDown->getValue(), 2);
									} else {
										$cellText = $this->convertDate($cellValue, 3);
										/*$cellText = $cellValue."<br>".$this->convertDate($valCellDown->getValue(), 3);*/
									}
									$contenido .= "<td>".$cellText."</td>";
								}
								$arrDataSchedule[] = array($cellText, $i, $rowIndex, '', '', '', 'P2');
								$i++;
							} else {
								break;
							}
						}
					}
					$contenido .= '</tr>';
				}
				$contenido .= "</tbody>
										</table>
										<p class='text-muted font-13 m-b-30'>
	                    <strong>Nota:</strong><br>
	                    - Este cronograma corresponde a los Principales, Medianos y Pequeños Contribuyentes.<br>
	                    - <strong>OTROS: </strong>Corresponde a los BUENOS CONTRIBUYENTES y UESP.<br>
	                    - <strong>UESP: </strong>Unidades Ejecutoras del Sector Público.
	                  </p>";

	      $resVerifyPeriod = $this->m_schedules->__verifyPeriod($input_date);
      	if ($resVerifyPeriod <> 'ok') {
	      	$resExcel['err_period'] = $resVerifyPeriod;
	      }
	      
	      $resSaveDataSchedule = $this->m_schedules->__newScheduleFile($arrDataSchedule, $file_name, $input_date, $countCol);
	      if (is_null($resSaveDataSchedule)) {
	      	/*$resExcel = array('res_html' => $contenido, 'res_arr' => $arrDataSchedule);*/
	      	$resExcel['res_html'] = $contenido;
					$this->createEvents($input_date);
	      } else {
	      	$resExcel['err_save'] = 'Error.';
					$this->deleteFile($filename_path);
	      }
			} else {
				$this->deleteFile($filename_path);
				$resExcel = array('err_xlsx' => $resIsScheduleExcel);
			}

			return $resExcel;

		} catch (Exception $e) {
			$this->deleteFile($filename_path);
			return array('err_file' => 'No es posible leer este tipo de archivo Excel.');
		}
	}

	public function contarColumns($sheet, $ri, $rf, $op) {
		$countCol = 0;
		foreach ($sheet->getRowIterator($ri, $rf) as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			foreach ($cellIterator as $cell) {
				$countCol++;
				if (!is_null($cell) && $op == 1) {
					if (strpos($cell->getCalculatedValue(), '9') || $cell->getCalculatedValue() == 9) {
						break;
					}
				}
			}
			break;
		}
		return $countCol;
	}

	public function columnName($sheet, $ci, $cf, $row, $rowspan, $arrData, $contributor) {
		$content = "";
		for ($i = $ci; $i <= $cf; $i++) {
			$titleCol = $sheet->getCellByColumnAndRow($i, $row)->getCalculatedValue();
			if (!is_array($arrData)) {
				$content .= "<th rowspan='".$rowspan."' class='text-center'>".$titleCol."</th>";
			} else {
				$arrData[] = array($titleCol, $i, $row, $rowspan, '', $contributor, 'P1');
			}
		}

		if (is_array($arrData)) {
			return $arrData;
		} else {
			return $content;
		}
	}

	public function convertDate($dateExcel, $op) {
		/*setlocale(LC_ALL, 'es_ES.UTF-8');*/
		$dateString = '';
		if (is_float($dateExcel)) {
			if ($op == 1) {
				$dateString = date('M-y', ($dateExcel - 25569 + 5/24) * 86400);
			}else {
				if ($op == 2) {
					$dateString = date('M y', ($dateExcel - 25569 + 5/24) * 86400);
				} else {
					$dateString = date('d<bR>M', ($dateExcel - 25569 + 5/24) * 86400);
				}
			}
		} else {
			$dateString = $dateExcel;
		}
		return $dateString;
	}

	public function isScheduleExcel($titleCenter, $titleLeft, $titleRight) {
		if (preg_match("/(FECHA DE VENCIMIENTO|RUC)/i", $titleCenter) && preg_match("/(PERÍODO|PERIODO|TRIBUTARIO)/i", $titleLeft) && preg_match("/(BUENOS CONTRIBUYENTES|UESP)/i", $titleRight)) {
			return TRUE;
		} else {
			return "El archivo excel no contiene un cronograma de modelo SUNAT.";
		}
	}

	public function deleteFile($filename_path) {
		if (file_exists($filename_path)) {
    	unlink($filename_path);
    }
	}

	public function generateTableSchedule($scheduleBD) {
		$auxIndexRow = ''; $auxCloseTable = 1;
		$contenido = "<table class='table table-striped jambo_table table-bordered'>
										<thead>
											<tr>";
		foreach ($scheduleBD as $row) {
			$partTable = $row['part_table'];
			if ($auxIndexRow == '') {
				$auxIndexRow = $row['row_index'];
			}
			switch ($partTable) {
				case 'head':
					if ($auxIndexRow != $row['row_index']) {
						$contenido .= '</tr><tr>';
						$auxIndexRow = $row['row_index'];
					}
					$contenido .= '<th '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</th>';
					break;
				case 'body':
					if ($auxIndexRow != $row['row_index']) {
						if ($auxCloseTable != 0) {
							$contenido .= '</tr></thead><tbody><tr>';
							$auxCloseTable = 0;
						} else {
							$contenido .= '</tr><tr>';
						}
						$auxIndexRow = $row['row_index'];
					}
					
					if ($row['col_index'] == '1') {
						$contenido .= '<th '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</th>';
					} else {
						$contenido .= '<td '. $this->attrTableTHTD('colspan', $row['colspan']) . $this->attrTableTHTD('rowspan', $row['rowspan']) .' class="text-center">'. $row['text_cell'] .'</td>';
					}
					break;
				default:
					$contenido .= '</tr></tbody></table>';
					break;
			}
		}
		$contenido .= "</tr></tbody></table>
								<p class='text-muted font-13 m-b-30'>
                  <strong>Nota:</strong><br>
                  - Este cronograma corresponde a los Principales, Medianos y Pequeños Contribuyentes.<br>
                  - <strong>OTROS: </strong>Corresponde a los BUENOS CONTRIBUYENTES y UESP.<br>
                  - <strong>UESP: </strong>Unidades Ejecutoras del Sector Público.
                </p>";

		return $contenido;
	}

	public function attrTableTHTD($attrName, $value) {
		if ($value != '0') {
			return $attrName. ' = "' . $value . '" ';
		} else {
			return '';
		}
	}
	
	/*Funciones para los eventos de la agenda con las fechas del cronograma de vencimiento*/
	public function createEvents($period) {
		if ($period >= date('Y')) {
			$resUsers = $this->m_schedules->__getUsers();
			$resIdSch = $this->m_schedules->__getIdSchedule($period);
			
			if ($resUsers && $resIdSch) {
				foreach ($resUsers as $rowUser) {
					$listCompanies = $this->m_schedules->__getCompanies($rowUser['id']);
					$this->goCustomer($listCompanies, $period, $rowUser['id'], $resIdSch[0]['id'], 'com');

					$listPerson = $this->m_schedules->__getPeople($rowUser['id']);
					$this->goCustomer($listPerson, $period, $rowUser['id'], $resIdSch[0]['id'], 'per');
				}
				$this->getEvents();
			}
		}
	}

	public function goCustomer($listCustomer, $period, $c_id, $sch_id, $table) {
		foreach ($listCustomer as $rowCust) {
			if (strlen($rowCust['num_doc']) == 11) {
				$lastNumRUC = substr($rowCust['num_doc'], -1);
				$aditional = '';
				if ($rowCust['aditional'] == '') {
					$aditional = 'T1';
				} else {
					$aditional = 'T2';
				}

				if ($table == 'com') {
					$customer = $rowCust['company'];
				} else {
					$customer = $rowCust['person'];
				}

				$resSchMonths = $this->m_schedules->__getMonthsSch($period, $aditional, $lastNumRUC);
				$this->setDatesForEvents($resSchMonths, $c_id, $table, $rowCust['id'], $sch_id, $period, $customer);
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

		$this->m_schedules->__saveEvents($c_id, $table, $id, $sch_id, $detailEvents);
	}

	public function getEvents() {
		/*Notificaciones de eventos de agenda*/
		if (in_array(13, array_column($this->session->userdata('ci_modules'), 'id'))) {
			$c_id = $this->session->userdata('logged_in')['c_id'];
			$this->session->unset_userdata(array('events'));
			$this->session->set_userdata('events', $this->m_schedules->__getEvents($c_id, date('Y-m-d')));
		}
	}

	//Variables e Inputs - Formulario para Cronograma
	public function arrInputs() {
    $arrayInputs = array(
	    'inpDate' => array(
	      'id' => 'fecha', 
	      'class' => 'form-control', 
	      'style' => 'text-align: center;',
	      'placeholder' => 'Año *', 
	      'title' => 'Periodo obligatorio.', 
	      'required' => 'true'
	    ),

	    'checkActive' => array(
	      'name' => 'activado', 
	      'type' => 'checkbox', 
	      'class' => 'activado flat', 
	      'checked' => TRUE
	    ),

	    'checkDesactive' => array(
	      'name' => 'activado', 
	      'type' => 'checkbox', 
	      'class' => 'activado flat'
	    ),

	    'btnStartUp' => array(
	      'name' => 'startUp', 
	      'type' => 'submit', 
	      'class' => 'btn btn-primary', 
	      'content' => 'Subir'
	    )
	  );

	  return $arrayInputs;
	}
}
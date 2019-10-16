<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador de Calendario de Agenda
 */
class C_agenda extends CI_Controller {

  public function  __construct() {
    parent::__construct();
    $this->load->model('backend/apps/m_agenda');
    $this->form_validation->set_error_delimiters('','');
  }

  public function index() {
    $actions = $save_ok = '';
    $save_ok = $this->session->flashdata('save_ok');
    
    if ($this->session->has_userdata('logged_in')) {
      $arrRoles = array_column($this->session->userdata('ci_roles'), 'id');

      if (in_array(49, $arrRoles) || in_array(50, $arrRoles)) {
        $actions = '<td align="center">';
        if (in_array(49, $arrRoles)) {
          $actions .= '<a class="btn btn-info btn-xs e_evento" title="Editar Evento"><i class="fa fa-pencil"></i></a>';
        }
        if (in_array(50, $arrRoles)) {
          $actions .= '<a class="btn btn-danger btn-xs d_evento" title="Eliminar Evento"><i class="fa fa-trash"></i></a>';
        }
        $actions .= '</td>';
      }
    }

    $data = array(
      'title' => '  <title>Agenda | IT Managers</title>',
      'stylesAdd' => array('backend/includes/css/fullcalendar_css'),
      'content' => 'backend/apps/agenda',
      'scriptsAdd' => array('backend/includes/js/fullcalendar_js'),
      'jsPropio' => ' <!-- JS Propio -->
    <script src="'. base_url() .'assets/vendor/js-propio/js_agenda.js"></script>',
      'arrInputs' => $this->arrInputs(),
      'actions' => $actions,
      'save_ok' => $save_ok
    );

    $this->parser->parse('backend/templates/tmp_admin', $data);
  }

  public function listEvents(){
    if ($this->input->is_ajax_request()) {
      $arrayListE = $this->m_agenda->__listEvents($this->session->userdata('logged_in')['c_id']);
      echo json_encode($arrayListE);
    } else {
      show_404();
    }
  }

  public function newEvent() {
    if ($this->input->is_ajax_request()) {
      if ($this->form_validation->run() == FALSE) {
        $msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
      } else {
        $_POST['customer'] = $this->session->userdata('logged_in')['c_id'];
        $resSaveNew = $this->m_agenda->__newEvent($this->input->post());
        if (is_null($resSaveNew)) {
          $this->getEvents();
          $msj = 'ok';
        }
      }
      echo json_encode($msj);
    } else {
      show_404();
    }
  }

  public function editEvent() {
    if ($this->input->is_ajax_request()) {
      if ($this->form_validation->run() == false) {
        $msj = explode('|', preg_replace('/[\r\n|\n|\r]+/', '|', validation_errors()));
      } else {
        $_POST['eCustomer'] = $this->session->userdata('logged_in')['c_id'];
        $resCambios = $this->m_agenda->__verifChanges($this->input->post());
        if ($resCambios > 0) {
          $msj = 'warning';
        } else {
          $resSaveChange = $this->m_agenda->__editEvent($this->input->post());
          if (is_null($resSaveChange)) {
            $this->getEvents();
            $msj = 'ok';
          }
        }
      }
      echo json_encode($msj);
    } else {
      show_404();
    }
  }

  public function editDateEvent() {
    if ($this->input->is_ajax_request()) {
      $resSaveChange = $this->m_agenda->__editDateEvent($this->input->post());
      if (is_null($resSaveChange)) {
        $this->getEvents();
        $msj = 'ok';
      }
      echo json_encode($msj);
    } else {
      show_404();
    }
  }

  public function deleteEvent() {
    if ($this->input->is_ajax_request()) {
      $resDelete = $this->m_agenda->__deleteEvent($this->input->post());
      if (is_null($resDelete)) {
        $this->getEvents();
        $msj = 'ok';
      }
      echo json_encode($msj);
    } else {
      show_404();
    }
  }

  /*Funciones para los eventos de la agenda con las fechas del cronograma de vencimiento*/
  public function updateEvents() {
    if ($this->input->is_ajax_request()) {
      $resSchedules = $this->m_agenda->__getSchedules(date('Y'));
      foreach ($resSchedules as $rowSch) {
        $this->createEvents($rowSch['period'], $rowSch['id']);
      }
      $this->getEvents();
    } else {
      show_404();
    }
  }

  public function createEvents($period, $sch_id) {
    $c_id = $this->session->userdata('logged_in')['c_id'];
    $this->m_agenda->__deleteEvents($c_id, $sch_id);
      
    $listCompanies = $this->m_agenda->__getCompanies($c_id);
    $this->goCustomer($listCompanies, $period, $c_id, $sch_id, 'com');

    $listPerson = $this->m_agenda->__getPeople($c_id);
    $this->goCustomer($listPerson, $period, $c_id, $sch_id, 'per');
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

        $resSchMonths = $this->m_agenda->__getMonthsSch($period, $aditional, $lastNumRUC);
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

    $res = $this->m_agenda->__saveEvents($c_id, $table, $id, $sch_id, $detailEvents);
    if (is_null($res)) {
      $this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Los eventos fueron actualizados correctamente.', 'success');");
    } else {
      $this->session->set_flashdata('save_ok', "pNotify('Error', 'Ocurrió un error al actualizar los eventos.', 'error');");
    }
  }

  public function deleteEvents() {
    if ($this->input->is_ajax_request()) {
      $resSchedules = $this->m_agenda->__getSchedules('2000');
      $c_id = $this->session->userdata('logged_in')['c_id'];
      foreach ($resSchedules as $rowSch) {
        $res = $this->m_agenda->__deleteEvents($c_id, $rowSch['id']);
      }

      if (is_null($res)) {
        $this->session->set_flashdata('save_ok', "pNotify('Correcto', 'Los eventos fueron eliminados correctamente.', 'success');");
        $this->getEvents();
      } else {
        $this->session->set_flashdata('save_ok', "pNotify('Error', 'Ocurrió un error al eliminar los eventos.', 'error');");
      }
    } else {
      show_404();
    }
  }

  public function getEvents() {
    /*Notificaciones de eventos de agenda*/
    if (in_array(13, array_column($this->session->userdata('ci_modules'), 'id'))) {
      $c_id = $this->session->userdata('logged_in')['c_id'];
      $this->session->unset_userdata(array('events'));
      $this->session->set_userdata('events', $this->m_agenda->__getEvents($c_id, date('Y-m-d')));
    }
  }
  
  //Variables e Inputs - Formulario para Clientes
  public function arrInputs() {
    $titleLetras = '[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 \/.,_-]+';
    $onlyDigitos = '[0-9]+';
    $letraPunto = '[a-zA-Z ñÑáéíóúÁÉÍÓÚ.]+';

    $arrayInputs = array(
      'inpTitle' => array(
        'id' => 'titulo', 
        'name' => 'titulo', 
        'class' => 'form-control', 
        'placeholder' => 'Título del Evento *', 
        'maxlength' => '100', 
        'title' => 'Título obligatorio. Letras y Dígitos', 
        'pattern' => $titleLetras, 
        'required' => 'true'
      ),

      'inpDescrip' => array(
        'id' => 'descripcion', 
        'name' => 'descripcion', 
        'class' => 'form-control', 
        'placeholder' => 'Descripción del Evento', 
        'maxlength' => '500', 
        'rows' => '3', 
        'title' => "Descripción.", 
        'style' => 'resize: vertical'
      ),

      'inpPeriod' => array(
        'id' => 'date', 
        'name' => 'date', 
        'class' => 'form-control', 
        'placeholder' => 'Periodo', 
        'title' => 'Periodo.', 
        'readonly' => 'true'
      ),

      'inpeTitle' => array(
        'id' => 'e_titulo', 
        'name' => 'e_titulo', 
        'class' => 'form-control', 
        'placeholder' => 'Título del Evento *', 
        'maxlength' => '100', 
        'title' => 'Título obligatorio. Letras y Dígitos', 
        'pattern' => $titleLetras, 
        'required' => 'true'
      ),

      'inpeDescrip' => array(
        'id' => 'e_descripcion', 
        'name' => 'e_descripcion', 
        'class' => 'form-control', 
        'placeholder' => 'Descripción del Evento', 
        'maxlength' => '500', 
        'rows' => '3', 
        'title' => "Descripción.", 
        'style' => 'resize: vertical'
      ),

      'inpePeriod' => array(
        'id' => 'e_date', 
        'name' => 'e_date', 
        'class' => 'form-control', 
        'placeholder' => 'Periodo', 
        'title' => 'Periodo. Para modificar la fecha, mueva el evento.', 
        'readonly' => 'true'
      ),

      'inpeCodE' => array(
        'id' => 'e_id', 
        'name' => 'e_id', 
        'style' => 'display: none', 
        'readonly' => 'true'
      ),

      'btnSaveSubmit' => array(
        'type' => 'submit', 
        'class' => 'btn btn-primary', 
        'content' => 'Guardar'
      )
    );

    return $arrayInputs;
  }
}
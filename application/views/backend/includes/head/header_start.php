<?php 
	if (!$this->session->has_userdata('logged_in')) {
		/*$this->session->set_flashdata('save_ok', "pNotify('Acceso Denegado', 'Inicie sesión.', 'error');");
		redirect(base_url('acceso'));*/
		/*Bloquea el ingreso a módulos sin haber hecho el login*/
		show_404();
	} else {
		/*print_r($this->session->userdata());*/ //Mostrar los datos de sesion

		/*Restringir acceso a otros módulos que no son del usuario*/
		$pathMain = $this->session->userdata('mainPage')['path']; //Pagina principal del usuario
    $arrPathModulos = array_column($this->session->userdata('ci_modules'), 'path'); //Array de las rutas de módulos del usuario
		$arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
		$arrRolList = array('convertidor' => array(3), 'convertidor/lista' => array(1, 2), 'admCronograma' => array(23), 'admCronograma/lista' => array(19, 20, 21, 22)); // Artificio, módulos con lista separada
		$found = 0;
    foreach ($arrPathModulos as $row => $path) { //Recorre el array de rutas de módulos
			if (in_array($path, explode('/', uri_string()))) { // Si la ruta se encuentra en la uri actual
				$found = 1;
				if (array_key_exists(uri_string(), $arrRolList)) { // Si el uri se encuentra en el array artificio
					$found = 0;
					foreach ($arrRolList[uri_string()] as $val) { // Recorre subarray
						if (!in_array($val, $arrRoles)) { // Si los valores no estan dentro de los roles del usuario
							$found = 0;
						} else {
							$found = 1;
							break;
						}
					}
				}
				break;
			}
    }
    if ($found == 0) {
    	show_404();
    }
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

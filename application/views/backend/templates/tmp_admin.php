<?php 
	/*Header Start*/
	$this->load->view('backend/includes/head/header_start');
	echo $title;
	$this->load->view('backend/includes/head/styles_default');
	
	foreach ($stylesAdd as $item) {
		$this->load->view($item);
	}
	
	$this->load->view('backend/includes/head/header_end');
	/*Header End*/

	/*Body Start*/
	$this->load->view('backend/includes/body/body_navbar');
	$this->load->view($content);
	$this->load->view('backend/includes/body/footer_start');
	
	foreach ($scriptsAdd as $item) {
		$this->load->view($item);
	}
	
	echo $jsPropio;
	$this->load->view('backend/includes/body/footer_end');
	/*Body End*/
?>
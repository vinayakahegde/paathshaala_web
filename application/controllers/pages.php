<?php

   class Pages extends CI_Controller {
	public function view( $page = 'home' )
	{
		error_log("vinayaka here in pages");
		if( !file_exists( APPPATH.'/views/pages/'.$page.'.php')){
			//file does not exist
			show_404();
		}

		$data['title'] = ucfirst($page); // capitalize first letter
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data );

	 }
	
   }

?>

<?php
	class contact extends CI_Controller {
		public function __construct(){
			parent::__construct();
                        $this->load->model('my_model');	
		}
		
		public function view( $page = 'home' ) {
			if( !file_exists( APPPATH.'/views/contact/'.$page.'.php')){
        	                //file does not exist
                	        show_404();
               		 }


			$data['result'] = $this->my_model->get_contacts();
			$data['title'] = 'Contacts';

			$this->load->view('templates/header', $data );
			$this->load->view('contact/index', $data);
			$this->load->view('templates/footer', $data);
		}
	}
?>

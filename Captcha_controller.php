		<?php

		if (!defined('BASEPATH')) exit('No direct script access allowed');



		class Captcha_controller extends CI_Controller {



		// Load Helper in and Start session.

		function __construct() {

		parent::__construct();

		}

		// Mostra os valores na view e compara com a entrada no captcha

		public function form() {

		if(empty($_POST)){

		$this->captcha_setting();

		}

		else{

		// Case comparing values.

		if (strcasecmp($_SESSION['captchaWord'], $_POST['captcha']) == 0) {

			redirect(base_url(''),'refresh') ;



		} else {

		echo "<script type='text/javascript'> alert('Captcha incorreto'); </script>";

		$this->captcha_setting();

		}

		}

		}



		// Gera uma imagem captcha e aloca na pasta captcha

		public function captcha_setting(){
			$url = 'http://www.desaparecidosdobrasil.esy.es/captcha/json/';
			$json = file_get_contents($url);
			$json = json_decode($json);
		
		$data['lista'] = $json;

		$nome = $json->lista[0]->nome.''.$json->lista[0]->sobrenome;

		if(strlen($nome)>12){
			
			$nome='';

		}

		$values = array(

		'word' => $nome,

		'word_length' => 12,

		'img_path' => './assets/captcha/',

		'img_url' => base_url().'assets/captcha/',

		'font_path' => base_url().'system/fonts/texb.ttf',

		'img_width' => '150',

		'img_height' => '50',

		'expiration' => 3600,



		'colors'        => array(

						'background' => array(255, 255, 255),

		                'border' => array(0, 0, 0),

		                'text' => array(0, 0, 0),

		                'grid' => array(255, 255, 255))



		);

		$data = create_captcha($values);
		
		$_SESSION['captchaWord'] = $data['word'];

		$data['titulo'] = 'Captcha';

		// image will store in "$data['image']" index and its send on view page

		$this->load->view("captcha_view", $data);



		}


		// For new image on click refresh button.

		public function captcha_refresh(){


		$data['titulo'] = 'Captcha';

			$url = 'http://www.desaparecidosdobrasil.esy.es/captcha/json/';
			$json = file_get_contents($url);
			$json = json_decode($json);

		$data['lista'] = $json;
		$nome = $json->lista[0]->nome.''.$json->lista[0]->sobrenome;


		if(strlen($nome)>12){

			$nome='';

		}



		$values = array(

		'word' => $nome,

		'word_length' => 12,

		'img_path' => './assets/captcha/',

		'img_url' => base_url() .'assets/captcha/',

		'font_path' => base_url() . 'system/fonts/texb.ttf',

		'img_width' => '150',

		'img_height' => '50',

		'expiration' => 3600,



		'colors'        => array(

						'background' => array(255, 255, 255),

		                'border' => array(0, 0, 0),

		                'text' => array(0, 0, 0),

		                'grid' => array(255, 255, 255))



		);


		$data = create_captcha($values);

		$_SESSION['captchaWord'] = $data['word'];

		echo $data['image'];

		}

		}

		?>


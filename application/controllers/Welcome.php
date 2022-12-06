<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function testdb(){
		$NAME=$this->db->database;
		$this->load->dbutil();
		$prefs = array(
			'format' => 'zip',
			'filename' => 'my_db_backup.sql'
		);
		$backup =& $this->dbutil->backup($prefs);
		$db_name = $NAME.'.zip';
		$save = FCPATH.'uploads/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup);
		$this->load->helper('download');
		force_download($db_name, $backup);
	}
}

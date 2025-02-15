<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$data = [
			'navbar' => 'dashboard',
			'title' => 'Dashboard - SiKambing',
		];
		$this->load->view('dashboard', $data);
	}
}

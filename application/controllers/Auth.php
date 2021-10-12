<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$email_exists = $this->model_auth->check_email($this->input->post('username'));

			if ($email_exists == TRUE) {
				$login = $this->model_auth->login($this->input->post('username'), $this->input->post('password'));
				if ($login) {

					$logged_in_sess = array(
						'id' => $login['id'],
						'username'  => $login['username'],
						'email'     => $login['email'],
						'store' 	=> $login['store'],
						'store_id' 	=> $login['store_id'],
						'group_id' => $login['group_id'],
						'divisi' => $login['divisi'],
						'logo' => $login['logo'],
						'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
					redirect('dashboard', 'refresh');
				} else {
					$this->data['errors'] = 'Password Tidak Sesuai';
					$this->load->view('login', $this->data);
				}
			} else {
				$this->data['errors'] = 'Username Belum Terdaftar';

				$this->load->view('login', $this->data);
			}
		} else {
			// false case
			$this->load->view('login');
		}
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
}

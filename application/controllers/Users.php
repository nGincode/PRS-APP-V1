<?php

class Users extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Users';


		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->model('model_stores');
	}


	public function index()
	{
		if (!in_array('viewUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_data = $this->model_users->getUserData();


		$result = array();
		foreach ($user_data as $k => $v) {

			$result[$k]['user_info'] = $v;

			$group = $this->model_users->getUserGroup($v['id']);
			$result[$k]['user_group'] = $group;
		}

		$this->data['user_data'] = $result;

		$this->render_template('users/index', $this->data);
	}

	public function create()
	{
		if (!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('store', 'store', 'required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('fname', 'First name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$password = $this->password_hash($this->input->post('password'));
			$dashboard = $this->input->post('groups');

			$id_store = $this->input->post('store');
			$store = $this->model_stores->getStoresData($id_store);
			$outlet	= $store['name'];


			$data = array(
				'username' => $this->input->post('username'),
				'password' => $password,
				'email' => $this->input->post('email'),
				'firstname' => $this->input->post('fname'),
				'lastname' => $this->input->post('lname'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'store_id' => $this->input->post('store'),
				'divisi' => $this->input->post('divisi'),
				'store' => $outlet,
				'group_id' => $dashboard,

			);

			$create = $this->model_users->create($data, $this->input->post('groups'));
			if ($create == true) {
				$this->session->set_flashdata('success', 'Data Telah di Tambahkan');
				redirect('users/', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
				redirect('users/create', 'refresh');
			}
		} else {
			// false case
			$group_data = $this->model_groups->getGroupData();
			$this->data['group_data'] = $group_data;

			$s_data = $this->model_users->datastore();
			$this->data['s_data'] = $s_data;



			$this->render_template('users/create', $this->data);
		}
	}

	public function password_hash($pass = '')
	{
		if ($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{
		if (!in_array('updateUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('store', 'store', 'required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {

					$id_store = $this->input->post('store');
					$store = $this->model_stores->getStoresData($id_store);
					$outlet	= $store['name'];

					$dashboard = $this->input->post('groups');
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('fname'),
						'lastname' => $this->input->post('lname'),
						'phone' => $this->input->post('phone'),
						'gender' => $this->input->post('gender'),
						'store_id' => $this->input->post('store'),
						'store' => $outlet,
						'group_id' => $dashboard,
					);

					$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
					if ($update == true) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('users/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('users/edit/' . $id, 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));
						$dashboard = $this->input->post('groups');

						$id_store = $this->input->post('store');
						$store = $this->model_stores->getStoresData($id_store);
						$outlet	= $store['name'];

						$data = array(
							'username' => $this->input->post('username'),
							'password' => $password,
							'email' => $this->input->post('email'),
							'firstname' => $this->input->post('fname'),
							'lastname' => $this->input->post('lname'),
							'phone' => $this->input->post('phone'),
							'gender' => $this->input->post('gender'),
							'store_id' => $this->input->post('store'),
							'store' => $outlet,
							'group_id' => $dashboard,
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Successfully updated');
							redirect('users/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Error occurred!!');
							redirect('users/edit/' . $id, 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						//menambah edit store
						$s_data = $this->model_users->datastore($id);
						$this->data['s_data'] = $s_data;

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);


				//menambah edit store
				$s_data = $this->model_users->datastore($id);
				$this->data['s_data'] = $s_data;


				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);
			}
		}
	}

	public function delete($id)
	{
		if (!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}


		if ($id) {
			if ($this->input->post('confirm')) {
				$delete = $this->model_users->delete($id);
				$delete = $this->model_users->deleteuser($id);
				if ($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('users/', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('users/delete/' . $id, 'refresh');
				}
			} else {
				$this->data['id'] = $id;
				$this->render_template('users/delete', $this->data);
			}
		}
	}

	public function profile()
	{
		if (!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

		$this->render_template('users/profile', $this->data);
	}

	public function setting()
	{
		if (!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->session->userdata('id');

		if ($id) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('fname'),
						'lastname' => $this->input->post('lname'),
						'phone' => $this->input->post('phone'),
						'gender' => $this->input->post('gender'),
					);

					$update = $this->model_users->edit($data, $id);
					if ($update == true) {
						$this->session->set_flashdata('success', 'Successfully updated');
						redirect('users/setting/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('users/setting/', 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
							'username' => $this->input->post('username'),
							'password' => $password,
							'email' => $this->input->post('email'),
							'firstname' => $this->input->post('fname'),
							'lastname' => $this->input->post('lname'),
							'phone' => $this->input->post('phone'),
							'gender' => $this->input->post('gender'),
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Successfully updated');
							redirect('users/setting/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Error occurred!!');
							redirect('users/setting/', 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);

				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);
			}
		}
	}






	public function ubah_password()
	{
		$this->form_validation->set_rules('passLama', 'Password Lama', 'trim|required');
		$this->form_validation->set_rules('passBaru', 'Password Baru', 'trim|required');
		$this->form_validation->set_rules('passKonf', 'Password Konfirmasi', 'trim|required');

		$id = $this->session->userdata('id');
		$user_data = $this->model_users->getUserData($id);
		$password = $this->input->post('passLama');
		if ($this->form_validation->run() == TRUE) {
			$hash_password = password_verify($password, $user_data['password']);
			if ($hash_password === true) {
				if ($this->input->post('passBaru') != $this->input->post('passKonf')) {

					$this->session->set_flashdata('error', 'Password Baru dan Konfirmasi Password harus sama');
					redirect('users/profile/', 'refresh');
				} else {
					$password = $this->password_hash($this->input->post('passBaru'));
					$data = array(
						'password' => $password
					);

					$result = $this->model_users->passedit($data, $id);
					if ($result > 0) {
						$this->session->set_flashdata('success', 'Password Berhasil Terubah');
						redirect('users/profile/', 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Password Gagal diubah');
						redirect('users/profile/', 'refresh');
					}
				}
			} else {
				$this->session->set_flashdata('error', 'Password Salah');
				redirect('users/profile/', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'Terjadi Kerusakan Script');
			redirect('users/profile/', 'refresh');
		}
	}




	public function ubahdata()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');


		if ($this->form_validation->run() == TRUE) {

			$id = $this->session->userdata('id');
			if (isset($_FILES) && $_FILES['logo']['error'] == '0') {
				$upload_image = $this->upload_imageivn();
			} else {
				$upload_image = '';
			}

			if ($upload_image) {
				$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'firstname' => $this->input->post('fname'),
					'lastname' => $this->input->post('lname'),
					'phone' => $this->input->post('phone'),
					'gender' => $this->input->post('gender'),
					'logo' => $upload_image
				);
			} else {
				$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'firstname' => $this->input->post('fname'),
					'lastname' => $this->input->post('lname'),
					'phone' => $this->input->post('phone'),
					'gender' => $this->input->post('gender')
				);
			}

			$update = $this->model_users->edit($data, $id);
			if ($update == true) {
				$this->session->set_flashdata('success', 'Berhasil diubah');
				redirect('users/profile/', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('users/profile/', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('users/profile/', 'refresh');
		}
	}


	private function upload_imageivn()
	{
		$id = $this->session->userdata('id');

		$config['upload_path'] = './assets/images/logo';
		$config['file_name']   = time();
		$config['allowed_types'] = 'gif|jpg|jpeg|png';

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('logo')) {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			redirect('users/profile/', 'refresh');
		} else {

			$datausers = $this->model_users->getUserData($id);
			$oldName = $datausers['logo'];
			$target = './assets/images/logo/' . $oldName;
			if (file_exists($target)) {
				unlink($target);
			}


			$data = array('upload_data' => $this->upload->data());
			$type = explode('.', $_FILES['logo']['name']);
			$type = $type[count($type) - 1];


			$path = $config['file_name'] . '.' . $type;
			return ($data == true) ? $path : false;
		}
	}
}

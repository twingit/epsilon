<?php

date_default_timezone_set('America/Los_Angeles');

class User extends CI_Model {

	function create_user($user_params) {

		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('date_hired', 'Date Hired', 'required');

		// var_dump($user_params['date_hired']); die();
		// var_dump(date('Y-m-d')); die();

		if ($this->form_validation->run() === false) {
			
			$this->session->set_flashdata('errors', validation_errors());

			return false;

		} elseif ($user_params['date_hired'] > date('Y-m-d')) {

			// var_dump($user_params['date_hired']); die();
			
			$this->session->set_flashdata('date_error', "Date Hired must be today or earlier!");

			return false;

		} else {
			
			$query = "INSERT INTO users (name, username, password, password_confirm, date_hired, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$values = array($user_params['name'], $user_params['username'], $user_params['password'], $user_params['password_confirm'], $user_params['date_hired'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
			$this->db->query($query, $values);

			$this->session->set_flashdata('success', 'You have successfully registered!');

		}

	}

	function get_user($user) {

		$query = "SELECT *
				  FROM users
				  WHERE username = ? AND password = ?";
		$values = array($user['username'], $user['password']);

		return $this->db->query($query, $values)->row_array();

	}

}

?>
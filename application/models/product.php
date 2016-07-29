<?php

class Product extends CI_Model {

	function create_product($product_params) {

		$this->form_validation->set_rules('name', 'Product Name', 'trim|required|min_length[3]');

		if ($this->form_validation->run() === false) {
			
			$this->session->set_flashdata('errors', validation_errors());

			return false;

		} else {
			
			$query = "INSERT INTO products (user_id, name, created_at, updated_at) VALUES (?, ?, ?, ?)";
			$values = array($product_params['user_id'], $product_params['name'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));

			return $this->db->query($query, $values);

		}

	}

	// QUESTION: This is apparently insufficient?

	function get_user_products($user_id) {

		$query = "SELECT products.*, creator.name as creator, adder.name as adder
				  FROM products
				  JOIN users as creator
					ON products.user_id = creator.id
				  LEFT JOIN add_ons
					ON add_ons.product_id = products.id
				  LEFT JOIN users as adder
					ON add_ons.user_id = adder.id
				  WHERE creator.id = ? OR adder.id = ?
				  GROUP BY products.name";
		$value = array($user_id, $user_id);

		return $this->db->query($query, $value)->result_array();

	}

	// QUESTION: So "adder" is necessary to satisfy "unique table/alias" rule? (Error Number: 1066 - see get_product_info comments below...) This is how you must deal with a many-to-many relationship?

	function get_product_creator($product_id) {

		$query = "SELECT users.name as creator, products.*
				  FROM users
				  JOIN products
				  	ON products.user_id = users.id
				  WHERE products.id = ?";
		$value = array($product_id);

		return $this->db->query($query, $value)->row_array();

		// $query = "SELECT users.name, products.*
		// 		  FROM products
		// 		  JOIN users
		// 		  	ON products.user_id = users.id
		// 		  LEFT JOIN add_ons
		// 		  	ON add_ons.product_id = products.id
		// 		  LEFT JOIN users
		// 		  	ON add_ons.user_id = users.id
		// 		  WHERE products.id = ?";
		// $value = array($product_id);

		// return $this->db->query($query, $value)->row_array();

		// This throws an error:

		// Error Number: 1066

		// Not unique table/alias: 'users'

	}

	function get_product_adders($product_id) {

		$query = "SELECT users.name
				  FROM users
				  JOIN add_ons
				  	ON add_ons.user_id = users.id
				  WHERE add_ons.product_id = ?";
		$value = array($product_id);

		return $this->db->query($query, $value)->result_array();

	}

	// QUESTION: How do I get a list of all the adders?

	function get_other_user_products($user_id) {

		$query = "SELECT users.name as creator, products.*
				  FROM products
				  JOIN users
					ON products.user_id = users.id
				  WHERE products.id
				  NOT IN (SELECT add_ons.product_id FROM add_ons WHERE add_ons.user_id = ?)";
		$value = array($user_id);

		return $this->db->query($query, $value)->result_array();

	}

	function create_add_on($product_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "INSERT INTO add_ons (user_id, product_id) VALUES (?, ?)";
		$values = array($current_user, $product_id);

		return $this->db->query($query, $values);

	}

	function delete_add_on($product_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "DELETE FROM add_ons
				  WHERE user_id = ? AND product_id = ?";
		$values = array($current_user, $product_id);

		return $this->db->query($query, $values);

	}

	function delete_add_ons($product_id) {

		$query = "DELETE FROM add_ons
				  WHERE product_id = ?";
		$values = array($product_id);

		return $this->db->query($query, $values);

	}

	function delete_product($product_id) {

		$query = "DELETE FROM products
				  WHERE id = ?";
		$value = array($product_id);

		return $this->db->query($query, $value);

	}

	// function get_trip_info($trip_id) {

	// 	$query = "SELECT users.name, travels.*
	// 			  FROM users
	// 			  INNER JOIN travels
	// 			  	ON travels.user_id = users.id
	// 			  WHERE travels.id = ?";
	// 	$value = array($trip_id);

	// 	return $this->db->query($query, $value)->row_array();

	// }

	// DELETE FROM `wishlist_exam`.`add_ons` WHERE `user_id`='1';

}

?>
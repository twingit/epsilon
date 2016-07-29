<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wishlists extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('User');
		$this->load->model('Product');

	}

	function index() {

		$current_user_id = $this->session->userdata['user_info']['id'];

		$data['current_user'] = $this->session->userdata('user_info');
		$data['user_products'] = $this->Product->get_user_products($current_user_id);
		$data['other_user_products'] = $this->Product->get_other_user_products($current_user_id);

		$this->load->view('wishlists/wishlists', $data);

	}

	function add_page() {

		$this->load->view('wishlists/add_page');

	}

	function add_product() {

		$current_user = $this->session->userdata('user_info');

		$product_params = array(

			'user_id' => $current_user['id'],
			'name' => $this->input->post('name')

		);

		if ($this->Product->create_product($product_params)) {
			
			redirect('/wishlists');

		} else {
			
			redirect('/wishlists/add_page');

		}

	}

	function delete_product($product_id) {

		$this->Product->delete_add_ons($product_id);
		$this->Product->delete_product($product_id);
		redirect('wishlists');

	}

	function add_on($product_id) {

		$this->Product->create_add_on($product_id);
		redirect('wishlists');

	}

	function remove_add_on($product_id) {

		$this->Product->delete_add_on($product_id);
		redirect('wishlists');

	}

	function show_product($product_id) {

		// $data['product_info'] = $this->Product->get_product_info($product_id);
		$data['product'] = $this->Product->get_product_creator($product_id);
		$data['adders'] = $this->Product->get_product_adders($product_id);

		$this->load->view('wishlists/show_product', $data);

	}

}

?>
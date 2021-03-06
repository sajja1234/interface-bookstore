<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {

	public function getorder()
	{
		$this->load->library('cart');
				$cart = $this->cart->contents();
				foreach ($cart as $item):
					$data['book_id'] = $item['id'];
					$data['quantity'] = $item['qty'];
					$data['user_id'] = $this->session->userdata('id');
				    $data['total_amount']  = $item['price'] * $item['qty'];
				    $q = $this->db->insert("bookorder",$data);
				    
				    $this->db->where('book_id', $item['id']);
				    $result = $this->db->get('book_detail')->row();
				    $quantity = $result->book_stock - $item['qty'] ;

				    $up_data['book_stock'] = $quantity;
				    $this->db->where('book_id', $item['id']);
				    $this->db->update('book_detail', $up_data);
				endforeach;

				return $q;
	}

}

/* End of file order.php */
/* Location: ./application/models/front/order.php */
<?php
class ModelCatalogBooking extends Model {
	public function updateState($booking_id, $state){
		$this->db->query("UPDATE " . DB_PREFIX . "booking SET state = '" . $state . "' WHERE booking_id = '" . (int)$booking_id . "'");
		if($state=='draft'){
			// gửi email
		}
	}

	public function addBooking($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "booking SET schedule = '" . $this->db->escape($data['schedule']) . "', note = '" . $this->db->escape($data['note']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', money = '" . (int)$data['money'] . "', state_receive = '" . (int)$data['state_receive'] . "', fee_ticket = '" . (int)$data['fee_ticket'] . "', fee_fuel = '" . (int)$data['fee_fuel'] . "', date_added = NOW(), date_execute = '". date('Y-m-d h:i', strtotime($data['date_execute'])) ."', state = 'draft'");
		$booking_id = $this->db->getLastId();
		if($data['state_receive']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET discount = '" . (int)$data['discount'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
		if(!empty($data['user_id'])){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET user_id = '" . (int)$data['user_id'] . "', state = 'sent' WHERE booking_id = '" . (int)$booking_id . "'");
			// gửi email
		}
	}
	
	public function editBooking($booking_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "booking SET schedule = '" . $this->db->escape($data['schedule']) . "', note = '" . $this->db->escape($data['note']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', money = '" . (int)$data['money'] . "', state_receive = '" . (int)$data['state_receive'] . "', fee_ticket = '" . (int)$data['fee_ticket'] . "', fee_fuel = '" . (int)$data['fee_fuel'] . "', date_execute = '". date('Y-m-d h:i', strtotime($data['date_execute'])) ."' WHERE booking_id = '" . (int)$booking_id . "'");

		if($data['state_receive']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET discount = '" . (int)$data['discount'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
		if(!empty($data['user_id'])){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET user_id = '" . (int)$data['user_id'] . "', state = 'sent' WHERE booking_id = '" . (int)$booking_id . "'");
			// gửi email
		}
	}

	public function deleteBooking($booking_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking WHERE booking_id = '" . (int)$booking_id . "'");
		$this->cache->delete('booking');
	}

	public function getBooking($booking_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "booking p WHERE p.booking_id = '" . (int)$booking_id . "'");

		return $query->row;
	}

	public function getBookings($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "booking b WHERE 1 ";

		if (!empty($data['filter_username'])) {
			$this->load->model('user/user');
			$user_info = $this->model_user_user->getUserByUsername($data['filter_username']);
			$sql .= " AND b.user_id = '" . $user_info['user_id'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND b.state = '" . $data['filter_status'] . "'";
		}

		$sort_data = array(
			'b.date_execute'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY b.date_execute";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalBookings($data = array()) {
		$sql = "SELECT COUNT(DISTINCT booking_id) AS total FROM " . DB_PREFIX . "booking b WHERE 1";
		if (!empty($data['filter_username'])) {
			$this->load->model('user/user');
			$user_info = $this->model_user_user->getUserByUsername($data['filter_username']);
			$sql .= " AND b.user_id = '" . $user_info['user_id'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND b.state = '" . $data['filter_status'] . "'";
		}
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalBookingsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
}

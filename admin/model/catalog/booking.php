<?php
class ModelCatalogBooking extends Model {
	public function addBooking($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "booking SET schedule = '" . $this->db->escape($data['schedule']) . "', note = '" . $this->db->escape($data['note']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', money = '" . (int)$data['money'] . "', state_receive = '" . (int)$data['state_receive'] . "', fee_ticket = '" . (int)$data['fee_ticket'] . "', fee_fuel = '" . (int)$data['fee_fuel'] . "', date_added = NOW(), date_execute = '". date('Y-m-d h:i', strtotime($data['date_execute'])) ."'");
		$booking_id = $this->db->getLastId();
		if($data['state_receive']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET discount = '" . (int)$data['discount'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
		if(!empty($data['user_id'])){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET user_id = '" . (int)$data['user_id'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
	}
	
	public function editBooking($booking_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "booking SET schedule = '" . $this->db->escape($data['schedule']) . "', note = '" . $this->db->escape($data['note']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', money = '" . (int)$data['money'] . "', state_receive = '" . (int)$data['state_receive'] . "', fee_ticket = '" . (int)$data['fee_ticket'] . "', fee_fuel = '" . (int)$data['fee_fuel'] . "', date_execute = '". date('Y-m-d h:i', strtotime($data['date_execute'])) ."' WHERE booking_id = '" . (int)$booking_id . "'");

		if($data['state_receive']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET discount = '" . (int)$data['discount'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
		if(!empty($data['user_id'])){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET user_id = '" . (int)$data['user_id'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
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
		$sql = "SELECT * FROM " . DB_PREFIX . "booking p WHERE 1 ";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.date_execute";
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
		$sql = "SELECT COUNT(DISTINCT booking_id) AS total FROM " . DB_PREFIX . "booking WHERE 1";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalBookingsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
}

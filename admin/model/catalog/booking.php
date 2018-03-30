<?php
class ModelCatalogBooking extends Model {
	public function addBooking($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "booking SET schedule = '" . $this->db->escape($data['schedule']) . "', note = '" . $this->db->escape($data['note']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', state_receive = '" . (int)$data['state_receive'] . "', fee_ticket = '" . (int)$data['fee_ticket'] . "', fee_fuel = '" . (int)$data['fee_fuel'] . "', date_added = NOW(), date_execute = '". $data['date_execute'] ."'");
		$booking_id = $this->db->getLastId();
		if($data['state_receive']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET discount = '" . (int)$data['discount'] . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}
	}
	
	public function editBooking($booking_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "booking SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "booking SET image = '" . $this->db->escape($data['image']) . "' WHERE booking_id = '" . (int)$booking_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_description WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($data['booking_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "booking_description SET booking_id = '" . (int)$booking_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_store WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_store'])) {
			foreach ($data['booking_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_to_store SET booking_id = '" . (int)$booking_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_attribute WHERE booking_id = '" . (int)$booking_id . "'");

		if (!empty($data['booking_attribute'])) {
			foreach ($data['booking_attribute'] as $booking_attribute) {
				if ($booking_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "booking_attribute WHERE booking_id = '" . (int)$booking_id . "' AND attribute_id = '" . (int)$booking_attribute['attribute_id'] . "'");

					foreach ($booking_attribute['booking_attribute_description'] as $language_id => $booking_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "booking_attribute SET booking_id = '" . (int)$booking_id . "', attribute_id = '" . (int)$booking_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($booking_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_option WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_option_value WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_option'])) {
			foreach ($data['booking_option'] as $booking_option) {
				if ($booking_option['type'] == 'select' || $booking_option['type'] == 'radio' || $booking_option['type'] == 'checkbox' || $booking_option['type'] == 'image') {
					if (isset($booking_option['booking_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "booking_option SET booking_option_id = '" . (int)$booking_option['booking_option_id'] . "', booking_id = '" . (int)$booking_id . "', option_id = '" . (int)$booking_option['option_id'] . "', required = '" . (int)$booking_option['required'] . "'");

						$booking_option_id = $this->db->getLastId();

						foreach ($booking_option['booking_option_value'] as $booking_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "booking_option_value SET booking_option_value_id = '" . (int)$booking_option_value['booking_option_value_id'] . "', booking_option_id = '" . (int)$booking_option_id . "', booking_id = '" . (int)$booking_id . "', option_id = '" . (int)$booking_option['option_id'] . "', option_value_id = '" . (int)$booking_option_value['option_value_id'] . "', quantity = '" . (int)$booking_option_value['quantity'] . "', subtract = '" . (int)$booking_option_value['subtract'] . "', price = '" . (float)$booking_option_value['price'] . "', price_prefix = '" . $this->db->escape($booking_option_value['price_prefix']) . "', points = '" . (int)$booking_option_value['points'] . "', points_prefix = '" . $this->db->escape($booking_option_value['points_prefix']) . "', weight = '" . (float)$booking_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($booking_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "booking_option SET booking_option_id = '" . (int)$booking_option['booking_option_id'] . "', booking_id = '" . (int)$booking_id . "', option_id = '" . (int)$booking_option['option_id'] . "', value = '" . $this->db->escape($booking_option['value']) . "', required = '" . (int)$booking_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "booking_recurring` WHERE booking_id = " . (int)$booking_id);

		if (isset($data['booking_recurring'])) {
			foreach ($data['booking_recurring'] as $booking_recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "booking_recurring` SET `booking_id` = " . (int)$booking_id . ", customer_group_id = " . (int)$booking_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$booking_recurring['recurring_id']);
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_discount WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_discount'])) {
			foreach ($data['booking_discount'] as $booking_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_discount SET booking_id = '" . (int)$booking_id . "', customer_group_id = '" . (int)$booking_discount['customer_group_id'] . "', quantity = '" . (int)$booking_discount['quantity'] . "', priority = '" . (int)$booking_discount['priority'] . "', price = '" . (float)$booking_discount['price'] . "', date_start = '" . $this->db->escape($booking_discount['date_start']) . "', date_end = '" . $this->db->escape($booking_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_special WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_special'])) {
			foreach ($data['booking_special'] as $booking_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_special SET booking_id = '" . (int)$booking_id . "', customer_group_id = '" . (int)$booking_special['customer_group_id'] . "', priority = '" . (int)$booking_special['priority'] . "', price = '" . (float)$booking_special['price'] . "', date_start = '" . $this->db->escape($booking_special['date_start']) . "', date_end = '" . $this->db->escape($booking_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_image WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_image'])) {
			foreach ($data['booking_image'] as $booking_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_image SET booking_id = '" . (int)$booking_id . "', image = '" . $this->db->escape($booking_image['image']) . "', sort_order = '" . (int)$booking_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_download WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_download'])) {
			foreach ($data['booking_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_to_download SET booking_id = '" . (int)$booking_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_category WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_category'])) {
			foreach ($data['booking_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_to_category SET booking_id = '" . (int)$booking_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_filter WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_filter'])) {
			foreach ($data['booking_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_filter SET booking_id = '" . (int)$booking_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE related_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_related'])) {
			foreach ($data['booking_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE booking_id = '" . (int)$booking_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_related SET booking_id = '" . (int)$booking_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE booking_id = '" . (int)$related_id . "' AND related_id = '" . (int)$booking_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_related SET booking_id = '" . (int)$related_id . "', related_id = '" . (int)$booking_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_reward WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_reward'])) {
			foreach ($data['booking_reward'] as $customer_group_id => $value) {
				if ((int)$value['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "booking_reward SET booking_id = '" . (int)$booking_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
				}
			}
		}
		
		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'booking_id=" . (int)$booking_id . "'");
		
		if (isset($data['booking_seo_url'])) {
			foreach ($data['booking_seo_url']as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'booking_id=" . (int)$booking_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_layout WHERE booking_id = '" . (int)$booking_id . "'");

		if (isset($data['booking_layout'])) {
			foreach ($data['booking_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "booking_to_layout SET booking_id = '" . (int)$booking_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('booking');
	}

	public function copyBooking($booking_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "booking p WHERE p.booking_id = '" . (int)$booking_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data['booking_attribute'] = $this->getBookingAttributes($booking_id);
			$data['booking_description'] = $this->getBookingDescriptions($booking_id);
			$data['booking_discount'] = $this->getBookingDiscounts($booking_id);
			$data['booking_filter'] = $this->getBookingFilters($booking_id);
			$data['booking_image'] = $this->getBookingImages($booking_id);
			$data['booking_option'] = $this->getBookingOptions($booking_id);
			$data['booking_related'] = $this->getBookingRelated($booking_id);
			$data['booking_reward'] = $this->getBookingRewards($booking_id);
			$data['booking_special'] = $this->getBookingSpecials($booking_id);
			$data['booking_category'] = $this->getBookingCategories($booking_id);
			$data['booking_download'] = $this->getBookingDownloads($booking_id);
			$data['booking_layout'] = $this->getBookingLayouts($booking_id);
			$data['booking_store'] = $this->getBookingStores($booking_id);
			$data['booking_recurrings'] = $this->getRecurrings($booking_id);

			$this->addBooking($data);
		}
	}

	public function deleteBooking($booking_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_attribute WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_description WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_discount WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_filter WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_image WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_option WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_option_value WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_related WHERE related_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_reward WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_special WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_category WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_download WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_layout WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_to_store WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "booking_recurring WHERE booking_id = " . (int)$booking_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE booking_id = '" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'booking_id=" . (int)$booking_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_booking WHERE booking_id = '" . (int)$booking_id . "'");

		$this->cache->delete('booking');
	}

	public function getBooking($booking_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "booking p LEFT JOIN " . DB_PREFIX . "booking_description pd ON (p.booking_id = pd.booking_id) WHERE p.booking_id = '" . (int)$booking_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

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

	public function getBookingsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking p LEFT JOIN " . DB_PREFIX . "booking_description pd ON (p.booking_id = pd.booking_id) LEFT JOIN " . DB_PREFIX . "booking_to_category p2c ON (p.booking_id = p2c.booking_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getBookingDescriptions($booking_id) {
		$booking_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_description WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $booking_description_data;
	}

	public function getBookingCategories($booking_id) {
		$booking_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_to_category WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_category_data[] = $result['category_id'];
		}

		return $booking_category_data;
	}

	public function getBookingFilters($booking_id) {
		$booking_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_filter WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_filter_data[] = $result['filter_id'];
		}

		return $booking_filter_data;
	}

	public function getBookingAttributes($booking_id) {
		$booking_attribute_data = array();

		$booking_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "booking_attribute WHERE booking_id = '" . (int)$booking_id . "' GROUP BY attribute_id");

		foreach ($booking_attribute_query->rows as $booking_attribute) {
			$booking_attribute_description_data = array();

			$booking_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_attribute WHERE booking_id = '" . (int)$booking_id . "' AND attribute_id = '" . (int)$booking_attribute['attribute_id'] . "'");

			foreach ($booking_attribute_description_query->rows as $booking_attribute_description) {
				$booking_attribute_description_data[$booking_attribute_description['language_id']] = array('text' => $booking_attribute_description['text']);
			}

			$booking_attribute_data[] = array(
				'attribute_id'                  => $booking_attribute['attribute_id'],
				'booking_attribute_description' => $booking_attribute_description_data
			);
		}

		return $booking_attribute_data;
	}

	public function getBookingOptions($booking_id) {
		$booking_option_data = array();

		$booking_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "booking_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.booking_id = '" . (int)$booking_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($booking_option_query->rows as $booking_option) {
			$booking_option_value_data = array();

			$booking_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) WHERE pov.booking_option_id = '" . (int)$booking_option['booking_option_id'] . "' ORDER BY ov.sort_order ASC");

			foreach ($booking_option_value_query->rows as $booking_option_value) {
				$booking_option_value_data[] = array(
					'booking_option_value_id' => $booking_option_value['booking_option_value_id'],
					'option_value_id'         => $booking_option_value['option_value_id'],
					'quantity'                => $booking_option_value['quantity'],
					'subtract'                => $booking_option_value['subtract'],
					'price'                   => $booking_option_value['price'],
					'price_prefix'            => $booking_option_value['price_prefix'],
					'points'                  => $booking_option_value['points'],
					'points_prefix'           => $booking_option_value['points_prefix'],
					'weight'                  => $booking_option_value['weight'],
					'weight_prefix'           => $booking_option_value['weight_prefix']
				);
			}

			$booking_option_data[] = array(
				'booking_option_id'    => $booking_option['booking_option_id'],
				'booking_option_value' => $booking_option_value_data,
				'option_id'            => $booking_option['option_id'],
				'name'                 => $booking_option['name'],
				'type'                 => $booking_option['type'],
				'value'                => $booking_option['value'],
				'required'             => $booking_option['required']
			);
		}

		return $booking_option_data;
	}

	public function getBookingOptionValue($booking_id, $booking_option_value_id) {
		$query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "booking_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.booking_id = '" . (int)$booking_id . "' AND pov.booking_option_value_id = '" . (int)$booking_option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getBookingImages($booking_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_image WHERE booking_id = '" . (int)$booking_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getBookingDiscounts($booking_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_discount WHERE booking_id = '" . (int)$booking_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getBookingSpecials($booking_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_special WHERE booking_id = '" . (int)$booking_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getBookingRewards($booking_id) {
		$booking_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_reward WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $booking_reward_data;
	}

	public function getBookingDownloads($booking_id) {
		$booking_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_to_download WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_download_data[] = $result['download_id'];
		}

		return $booking_download_data;
	}

	public function getBookingStores($booking_id) {
		$booking_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_to_store WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_store_data[] = $result['store_id'];
		}

		return $booking_store_data;
	}
	
	public function getBookingSeoUrls($booking_id) {
		$booking_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'booking_id=" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $booking_seo_url_data;
	}
	
	public function getBookingLayouts($booking_id) {
		$booking_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_to_layout WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $booking_layout_data;
	}

	public function getBookingRelated($booking_id) {
		$booking_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking_related WHERE booking_id = '" . (int)$booking_id . "'");

		foreach ($query->rows as $result) {
			$booking_related_data[] = $result['related_id'];
		}

		return $booking_related_data;
	}

	public function getRecurrings($booking_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "booking_recurring` WHERE booking_id = '" . (int)$booking_id . "'");

		return $query->rows;
	}

	public function getTotalBookings($data = array()) {
		$sql = "SELECT COUNT(DISTINCT booking_id) AS total FROM " . DB_PREFIX . "booking WHERE 1";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalBookingsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalBookingsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "booking_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}

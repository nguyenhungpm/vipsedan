<?php
class ControllerCatalogBooking extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('Lịch đặt xe');

		$this->load->model('catalog/booking');
		$this->load->model('catalog/manufacturer');
		$this->load->model('user/user');

		$this->load->language('catalog/booking');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/booking');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/booking');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_booking->addBooking($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/booking');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/booking');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_booking->editBooking($this->request->get['booking_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/booking');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/booking');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $booking_id) {
				$this->model_catalog_booking->deleteBooking($booking_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/booking');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/booking');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $booking_id) {
				$this->model_catalog_booking->copyBooking($booking_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/booking/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/booking/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['bookings'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$booking_total = $this->model_catalog_booking->getTotalBookings($filter_data);

		$results = $this->model_catalog_booking->getBookings($filter_data = array());

		foreach ($results as $result) {
			$data['bookings'][] = array(
				'booking_id' => $result['booking_id'],
				'date_execute'       => $result['date_execute'],
				'schedule'       => $result['schedule'],
				'money'       => number_format($result['money'],0,",","."),
				'manufacturer'       => $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id'])['name'],
				'user'     => $result['user_id'] != 0 ? $this->model_user_user->getUser($result['user_id'])['username'] : 'Chưa chọn tài xế',
				'state_receive'     => $result['state_receive'] != 0 ? 'Có thu <br />Cắt - '.number_format($result['discount'],0,",",".") : 'Không thu',
				'edit'       => $this->url->link('catalog/booking/edit', 'user_token=' . $this->session->data['user_token'] . '&booking_id=' . $result['booking_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $booking_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($booking_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($booking_total - $this->config->get('config_limit_admin'))) ? $booking_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $booking_total, ceil($booking_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/booking_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['booking_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['booking_id'])) {
			$data['action'] = $this->url->link('catalog/booking/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/booking/edit', 'user_token=' . $this->session->data['user_token'] . '&booking_id=' . $this->request->get['booking_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['booking_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$booking_info = $this->model_catalog_booking->getBooking($this->request->get['booking_id']);
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($booking_info)) {
			$data['manufacturer_id'] = $booking_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($booking_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($booking_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		$this->load->model('user/user');

		if (isset($this->request->post['user_id'])) {
			$data['user_id'] = $this->request->post['user_id'];
		} elseif (!empty($booking_info)) {
			$data['user_id'] = $booking_info['user_id'];
		} else {
			$data['user_id'] = 0;
		}

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($booking_info)) {
			$user_info = $this->model_user_user->getUser($booking_info['user_id']);

			if ($user_info) {
				$data['username'] = $user_info['username'];
			} else {
				$data['username'] = '';
			}
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['date_execute'])) {
			$data['date_execute'] = $this->request->post['date_execute'];
		} elseif (!empty($booking_info)) {
			$data['date_execute'] = ($booking_info['date_execute'] != '0000-00-00 00:00:00') ? date('d-m-Y h:i', strtotime($booking_info['date_execute'])) : '';
		} else {
			$data['date_execute'] = '';
		}

		if (isset($this->request->post['schedule'])) {
			$data['schedule'] = $this->request->post['schedule'];
		} elseif (!empty($booking_info)) {
			$data['schedule'] = $booking_info['schedule'];
		} else {
			$data['schedule'] = '';
		}

		if (isset($this->request->post['money'])) {
			$data['money'] = $this->request->post['money'];
		} elseif (!empty($booking_info)) {
			$data['money'] = $booking_info['money'];
		} else {
			$data['money'] = '';
		}

		if (isset($this->request->post['fee_ticket'])) {
			$data['fee_ticket'] = $this->request->post['fee_ticket'];
		} elseif (!empty($booking_info)) {
			$data['fee_ticket'] = $booking_info['fee_ticket'];
		} else {
			$data['fee_ticket'] = '';
		}

		if (isset($this->request->post['fee_fuel'])) {
			$data['fee_fuel'] = $this->request->post['fee_fuel'];
		} elseif (!empty($booking_info)) {
			$data['fee_fuel'] = $booking_info['fee_fuel'];
		} else {
			$data['fee_fuel'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$data['discount'] = $this->request->post['discount'];
		} elseif (!empty($booking_info)) {
			$data['discount'] = $booking_info['discount'];
		} else {
			$data['discount'] = '';
		}

		if (isset($this->request->post['note'])) {
			$data['note'] = $this->request->post['note'];
		} elseif (!empty($booking_info)) {
			$data['note'] = $booking_info['note'];
		} else {
			$data['note'] = '';
		}

		if (isset($this->request->post['state_receive'])) {
			$data['state_receive'] = $this->request->post['state_receive'];
		} elseif (!empty($booking_info)) {
			$data['state_receive'] = $booking_info['state_receive'];
		} else {
			$data['state_receive'] = 1;
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['booking_description'])) {
			$data['booking_description'] = $this->request->post['booking_description'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_description'] = $this->model_catalog_booking->getBooking($this->request->get['booking_id']);
		} else {
			$data['booking_description'] = array();
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/booking_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/booking')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// foreach ($this->request->post['booking_description'] as $language_id => $value) {
		// 	if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
		// 		$this->error['name'][$language_id] = $this->language->get('error_name');
		// 	}

		// 	if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
		// 		$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
		// 	}
		// }

		// if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
		// 	$this->error['model'] = $this->language->get('error_model');
		// }

		// if ($this->request->post['booking_seo_url']) {
		// 	$this->load->model('design/seo_url');
			
		// 	foreach ($this->request->post['booking_seo_url'] as $store_id => $language) {
		// 		foreach ($language as $language_id => $keyword) {
		// 			if (!empty($keyword)) {
		// 				if (count(array_keys($language, $keyword)) > 1) {
		// 					$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
		// 				}						
						
		// 				$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
		// 				foreach ($seo_urls as $seo_url) {
		// 					if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['booking_id']) || (($seo_url['query'] != 'booking_id=' . $this->request->get['booking_id'])))) {
		// 						$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
								
		// 						break;
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		// if ($this->error && !isset($this->error['warning'])) {
		// 	$this->error['warning'] = $this->language->get('error_warning');
		// }

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/booking')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/booking')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/booking');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_booking->getBookings($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$booking_options = $this->model_catalog_booking->getBookingOptions($result['booking_id']);

				foreach ($booking_options as $booking_option) {
					$option_info = $this->model_catalog_option->getOption($booking_option['option_id']);

					if ($option_info) {
						$booking_option_value_data = array();

						foreach ($booking_option['booking_option_value'] as $booking_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($booking_option_value['option_value_id']);

							if ($option_value_info) {
								$booking_option_value_data[] = array(
									'booking_option_value_id' => $booking_option_value['booking_option_value_id'],
									'option_value_id'         => $booking_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$booking_option_value['price'] ? $this->currency->format($booking_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $booking_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'booking_option_id'    => $booking_option['booking_option_id'],
							'booking_option_value' => $booking_option_value_data,
							'option_id'            => $booking_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $booking_option['value'],
							'required'             => $booking_option['required']
						);
					}
				}

				$json[] = array(
					'booking_id' => $result['booking_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

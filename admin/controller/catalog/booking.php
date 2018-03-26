<?php
class ControllerCatalogBooking extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('Lịch đặt xe');

		$this->load->model('catalog/booking');

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

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = '';
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = '';
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
		$data['copy'] = $this->url->link('catalog/booking/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/booking/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['bookings'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
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
			// if (is_file(DIR_IMAGE . $result['image'])) {
			// 	$image = $this->model_tool_image->resize($result['image'], 40, 40);
			// } else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			// }

			$special = false;

			// $booking_specials = $this->model_catalog_booking->getBookingSpecials($result['booking_id']);

			// foreach ($booking_specials  as $booking_special) {
			// 	if (($booking_special['date_start'] == '0000-00-00' || strtotime($booking_special['date_start']) < time()) && ($booking_special['date_end'] == '0000-00-00' || strtotime($booking_special['date_end']) > time())) {
			// 		$special = $this->currency->format($booking_special['price'], $this->config->get('config_currency'));

			// 		break;
			// 	}
			// }

			$data['bookings'][] = array(
				'booking_id' => $result['booking_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $this->currency->format($result['price'], $this->config->get('config_currency')),
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . '&sort=p.sort_order' . $url, true);

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

		$pagination = new Pagination();
		$pagination->total = $booking_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($booking_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($booking_total - $this->config->get('config_limit_admin'))) ? $booking_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $booking_total, ceil($booking_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
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

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['booking_description'])) {
			$data['booking_description'] = $this->request->post['booking_description'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_description'] = $this->model_catalog_booking->getBookingDescriptions($this->request->get['booking_id']);
		} else {
			$data['booking_description'] = array();
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($booking_info)) {
			$data['model'] = $booking_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($booking_info)) {
			$data['sku'] = $booking_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($booking_info)) {
			$data['upc'] = $booking_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($booking_info)) {
			$data['ean'] = $booking_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($booking_info)) {
			$data['jan'] = $booking_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($booking_info)) {
			$data['isbn'] = $booking_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($booking_info)) {
			$data['mpn'] = $booking_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($booking_info)) {
			$data['location'] = $booking_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['booking_store'])) {
			$data['booking_store'] = $this->request->post['booking_store'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_store'] = $this->model_catalog_booking->getBookingStores($this->request->get['booking_id']);
		} else {
			$data['booking_store'] = array(0);
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($booking_info)) {
			$data['shipping'] = $booking_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($booking_info)) {
			$data['price'] = $booking_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['booking_recurrings'])) {
			$data['booking_recurrings'] = $this->request->post['booking_recurrings'];
		} elseif (!empty($booking_info)) {
			$data['booking_recurrings'] = $this->model_catalog_booking->getRecurrings($booking_info['booking_id']);
		} else {
			$data['booking_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($booking_info)) {
			$data['tax_class_id'] = $booking_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($booking_info)) {
			$data['date_available'] = ($booking_info['date_available'] != '0000-00-00') ? $booking_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($booking_info)) {
			$data['quantity'] = $booking_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($booking_info)) {
			$data['minimum'] = $booking_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($booking_info)) {
			$data['subtract'] = $booking_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($booking_info)) {
			$data['sort_order'] = $booking_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($booking_info)) {
			$data['stock_status_id'] = $booking_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($booking_info)) {
			$data['status'] = $booking_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($booking_info)) {
			$data['weight'] = $booking_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($booking_info)) {
			$data['weight_class_id'] = $booking_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($booking_info)) {
			$data['length'] = $booking_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($booking_info)) {
			$data['width'] = $booking_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($booking_info)) {
			$data['height'] = $booking_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($booking_info)) {
			$data['length_class_id'] = $booking_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
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

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['booking_category'])) {
			$categories = $this->request->post['booking_category'];
		} elseif (isset($this->request->get['booking_id'])) {
			$categories = $this->model_catalog_booking->getBookingCategories($this->request->get['booking_id']);
		} else {
			$categories = array();
		}

		$data['booking_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['booking_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['booking_filter'])) {
			$filters = $this->request->post['booking_filter'];
		} elseif (isset($this->request->get['booking_id'])) {
			$filters = $this->model_catalog_booking->getBookingFilters($this->request->get['booking_id']);
		} else {
			$filters = array();
		}

		$data['booking_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['booking_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['booking_attribute'])) {
			$booking_attributes = $this->request->post['booking_attribute'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_attributes = $this->model_catalog_booking->getBookingAttributes($this->request->get['booking_id']);
		} else {
			$booking_attributes = array();
		}

		$data['booking_attributes'] = array();

		foreach ($booking_attributes as $booking_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($booking_attribute['attribute_id']);

			if ($attribute_info) {
				$data['booking_attributes'][] = array(
					'attribute_id'                  => $booking_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'booking_attribute_description' => $booking_attribute['booking_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['booking_option'])) {
			$booking_options = $this->request->post['booking_option'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_options = $this->model_catalog_booking->getBookingOptions($this->request->get['booking_id']);
		} else {
			$booking_options = array();
		}

		$data['booking_options'] = array();

		foreach ($booking_options as $booking_option) {
			$booking_option_value_data = array();

			if (isset($booking_option['booking_option_value'])) {
				foreach ($booking_option['booking_option_value'] as $booking_option_value) {
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
			}

			$data['booking_options'][] = array(
				'booking_option_id'    => $booking_option['booking_option_id'],
				'booking_option_value' => $booking_option_value_data,
				'option_id'            => $booking_option['option_id'],
				'name'                 => $booking_option['name'],
				'type'                 => $booking_option['type'],
				'value'                => isset($booking_option['value']) ? $booking_option['value'] : '',
				'required'             => $booking_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['booking_options'] as $booking_option) {
			if ($booking_option['type'] == 'select' || $booking_option['type'] == 'radio' || $booking_option['type'] == 'checkbox' || $booking_option['type'] == 'image') {
				if (!isset($data['option_values'][$booking_option['option_id']])) {
					$data['option_values'][$booking_option['option_id']] = $this->model_catalog_option->getOptionValues($booking_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['booking_discount'])) {
			$booking_discounts = $this->request->post['booking_discount'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_discounts = $this->model_catalog_booking->getBookingDiscounts($this->request->get['booking_id']);
		} else {
			$booking_discounts = array();
		}

		$data['booking_discounts'] = array();

		foreach ($booking_discounts as $booking_discount) {
			$data['booking_discounts'][] = array(
				'customer_group_id' => $booking_discount['customer_group_id'],
				'quantity'          => $booking_discount['quantity'],
				'priority'          => $booking_discount['priority'],
				'price'             => $booking_discount['price'],
				'date_start'        => ($booking_discount['date_start'] != '0000-00-00') ? $booking_discount['date_start'] : '',
				'date_end'          => ($booking_discount['date_end'] != '0000-00-00') ? $booking_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['booking_special'])) {
			$booking_specials = $this->request->post['booking_special'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_specials = $this->model_catalog_booking->getBookingSpecials($this->request->get['booking_id']);
		} else {
			$booking_specials = array();
		}

		$data['booking_specials'] = array();

		foreach ($booking_specials as $booking_special) {
			$data['booking_specials'][] = array(
				'customer_group_id' => $booking_special['customer_group_id'],
				'priority'          => $booking_special['priority'],
				'price'             => $booking_special['price'],
				'date_start'        => ($booking_special['date_start'] != '0000-00-00') ? $booking_special['date_start'] : '',
				'date_end'          => ($booking_special['date_end'] != '0000-00-00') ? $booking_special['date_end'] :  ''
			);
		}
		
		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($booking_info)) {
			$data['image'] = $booking_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($booking_info) && is_file(DIR_IMAGE . $booking_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($booking_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['booking_image'])) {
			$booking_images = $this->request->post['booking_image'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_images = $this->model_catalog_booking->getBookingImages($this->request->get['booking_id']);
		} else {
			$booking_images = array();
		}

		$data['booking_images'] = array();

		foreach ($booking_images as $booking_image) {
			if (is_file(DIR_IMAGE . $booking_image['image'])) {
				$image = $booking_image['image'];
				$thumb = $booking_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['booking_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $booking_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['booking_download'])) {
			$booking_downloads = $this->request->post['booking_download'];
		} elseif (isset($this->request->get['booking_id'])) {
			$booking_downloads = $this->model_catalog_booking->getBookingDownloads($this->request->get['booking_id']);
		} else {
			$booking_downloads = array();
		}

		$data['booking_downloads'] = array();

		foreach ($booking_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['booking_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['booking_related'])) {
			$bookings = $this->request->post['booking_related'];
		} elseif (isset($this->request->get['booking_id'])) {
			$bookings = $this->model_catalog_booking->getBookingRelated($this->request->get['booking_id']);
		} else {
			$bookings = array();
		}

		$data['booking_relateds'] = array();

		foreach ($bookings as $booking_id) {
			$related_info = $this->model_catalog_booking->getBooking($booking_id);

			if ($related_info) {
				$data['booking_relateds'][] = array(
					'booking_id' => $related_info['booking_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($booking_info)) {
			$data['points'] = $booking_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['booking_reward'])) {
			$data['booking_reward'] = $this->request->post['booking_reward'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_reward'] = $this->model_catalog_booking->getBookingRewards($this->request->get['booking_id']);
		} else {
			$data['booking_reward'] = array();
		}

		if (isset($this->request->post['booking_seo_url'])) {
			$data['booking_seo_url'] = $this->request->post['booking_seo_url'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_seo_url'] = $this->model_catalog_booking->getBookingSeoUrls($this->request->get['booking_id']);
		} else {
			$data['booking_seo_url'] = array();
		}

		if (isset($this->request->post['booking_layout'])) {
			$data['booking_layout'] = $this->request->post['booking_layout'];
		} elseif (isset($this->request->get['booking_id'])) {
			$data['booking_layout'] = $this->model_catalog_booking->getBookingLayouts($this->request->get['booking_id']);
		} else {
			$data['booking_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/booking_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/booking')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['booking_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if ($this->request->post['booking_seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['booking_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}						
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['booking_id']) || (($seo_url['query'] != 'booking_id=' . $this->request->get['booking_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
								
								break;
							}
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

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

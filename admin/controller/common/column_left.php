<?php
class ControllerCommonColumnLeft extends Controller {
	public function index() {
		if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ($this->request->get['user_token'] == $this->session->data['user_token'])) {
			$this->load->language('common/column_left');

			// Create a 3 level menu array
			// Level 2 can not have children
			
			// Menu
			$data['menus'][] = array(
				'id'       => 'menu-dashboard',
				'icon'	   => 'fa-dashboard',
				'name'	   => $this->language->get('text_dashboard'),
				'href'     => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
				'children' => array()
			);
			
			// Catalog
			$catalog = array();
			
			if ($this->user->hasPermission('access', 'catalog/booking')) {
				$catalog[] = array(
					'name'	   => 'Lịch đặt xe',
					'href'     => $this->url->link('catalog/booking', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/category')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_category'),
					'href'     => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/product')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_product'),
					'href'     => $this->url->link('catalog/product', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/download')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_download'),
					'href'     => $this->url->link('catalog/download', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/information')) {		
				$catalog[] = array(
					'name'	   => $this->language->get('text_information'),
					'href'     => $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);					
			}
			
			if ($catalog) {
				$data['menus'][] = array(
					'id'       => 'menu-catalog',
					'icon'	   => 'fa-tags', 
					'name'	   => $this->language->get('text_catalog'),
					'href'     => '',
					'children' => $catalog
				);		
			}
			
			// System
			$system = array();
			
			if ($this->user->hasPermission('access', 'setting/setting')) {
				$system[] = array(
					'name'	   => $this->language->get('text_setting'),
					'href'     => $this->url->link('setting/store', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);	
			}
		
			// Users
			$user = array();
			
			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'user/user_permission')) {	
				$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'user/api')) {		
				$user[] = array(
					'name'	   => $this->language->get('text_api'),
					'href'     => $this->url->link('user/api', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);	
			}
			
			if ($user) {
				$system[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => '',
					'children' => $user		
				);
			}
			
			// Tools	
			$maintenance = array();
				
			if ($this->user->hasPermission('access', 'tool/backup')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_backup'),
					'href'     => $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
					
			if ($this->user->hasPermission('access', 'tool/upload')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_upload'),
					'href'     => $this->url->link('tool/upload', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);	
			}
						
			if ($this->user->hasPermission('access', 'tool/log')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_log'),
					'href'     => $this->url->link('tool/log', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
		
			if ($maintenance) {
				$system[] = array(
					'id'       => 'menu-maintenance',
					'icon'	   => 'fa-cog', 
					'name'	   => $this->language->get('text_maintenance'),
					'href'     => '',
					'children' => $maintenance
				);
			}		
		
		
			if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog', 
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
				);
			}
			
			$this->load->model('catalog/booking');

			$data['draft'] = $this->model_catalog_booking->getTotalState(array('state'=>'draft'));
			$data['done'] = $this->model_catalog_booking->getTotalState(array('state'=>'done'));
			$data['pending'] = $this->model_catalog_booking->getTotalState(array('state'=>'pending'));
			$data['sent'] = $this->model_catalog_booking->getTotalState(array('state'=>'sent'));
			$total = $this->model_catalog_booking->getTotalState(array());

			if ((float)$data['draft'] && $total) {
				$data['process_draft'] = round(($data['draft'] / $total) * 100);
			} else {
				$data['process_draft'] = 0;
			}

			if ((float)$data['done'] && $total) {
				$data['process_done'] = round(($data['done'] / $total) * 100);
			} else {
				$data['process_done'] = 0;
			}

			if ((float)$data['pending'] && $total) {
				$data['process_pending'] = round(($data['pending'] / $total) * 100);
			} else {
				$data['process_pending'] = 0;
			}

			if ((float)$data['sent'] && $total) {
				$data['process_sent'] = round(($data['sent'] / $total) * 100);
			} else {
				$data['process_sent'] = 0;
			}
			
			/*// Stats
			$this->load->model('sale/order');
	
			$order_total = $this->model_sale_order->getTotalOrders();
			
			$this->load->model('report/statistics');
			
			$complete_total = $this->model_report_statistics->getValue('order_complete');
			
			if ((float)$complete_total && $order_total) {
				$data['complete_status'] = round(($complete_total / $order_total) * 100);
			} else {
				$data['complete_status'] = 0;
			}

			$processing_total = $this->model_report_statistics->getValue('order_processing');
	
			if ((float)$processing_total && $order_total) {
				$data['processing_status'] = round(($processing_total / $order_total) * 100);
			} else {
				$data['processing_status'] = 0;
			}
	
			$other_total = $this->model_report_statistics->getValue('order_other');
	
			if ((float)$other_total && $order_total) {
				$data['other_status'] = round(($other_total / $order_total) * 100);
			} else {
				$data['other_status'] = 0;
			}*/
			
			return $this->load->view('common/column_left', $data);
		}
	}
}
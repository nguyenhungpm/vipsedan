<?php
class ControllerCatalogAssign extends Controller {
	public function index() {
		$this->load->language('catalog/assign');
		
		$data['user_token'] = $this->session->data['user_token'];
		
		$data['assign_theme'] = $this->config->get('assign_theme');
		$data['assign_sass'] = $this->config->get('assign_sass');	
				
		$eval = false;
		
		$eval = '$eval = true;';

		eval($eval);		
		
		if ($eval === true) {
			$data['eval'] = true;
		} else {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('assign', array('assign_theme' => 1), 0);
		
			$data['eval'] = false;			
		}
	
		$this->response->setOutput($this->load->view('catalog/assign', $data));
	}
	
	public function edit() {
		$this->load->language('catalog/assign');

		$json = array();

		if (!$this->user->hasPermission('modify', 'catalog/assign')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('assign', $this->request->post, 0);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
		
	public function theme() {
		$this->load->language('catalog/assign');
		
		$json = array();
		
		if (!$this->user->hasPermission('modify', 'catalog/assign')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$directories = glob(DIR_CACHE . '*', GLOB_ONLYDIR);

			if ($directories) {
				foreach ($directories as $directory) {
					$files = glob($directory . '/*');
					
					foreach ($files as $file) { 
						if (is_file($file)) {
							unlink($file);
						}
					}
					
					if (is_dir($directory)) {
						rmdir($directory);
					}
				}
			}
						
			$json['success'] = sprintf($this->language->get('text_cache'), $this->language->get('text_theme'));
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));			
	}
		
	public function sass() {
		$this->load->language('catalog/assign');
		
		$json = array();
		
		if (!$this->user->hasPermission('modify', 'catalog/assign')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			// Before we delete we need to make sure there is a sass file to regenerate the css
			$file = DIR_APPLICATION  . 'view/stylesheet/bootstrap.css';
			
			if (is_file($file) && is_file(DIR_APPLICATION . 'view/stylesheet/sass/_bootstrap.scss')) {
				unlink($file);
			}
			 
			$files = glob(DIR_CATALOG  . 'view/theme/*/stylesheet/sass/_bootstrap.scss');
			 
			foreach ($files as $file) {
				$file = substr($file, 0, -21) . '/bootstrap.css';
				
				if (is_file($file)) {
					unlink($file);
				}
			}
			
			$json['success'] = sprintf($this->language->get('text_cache'), $this->language->get('text_sass'));
		}	
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));					
	}
}
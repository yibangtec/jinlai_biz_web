<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Identity_biz/IDB 企业认证类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Identity_biz extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'fullname_owner', 'fullname_auth', 'code_license', 'code_ssn_owner', 'code_ssn_auth', 'url_image_license', 'url_image_owner_id', 'url_image_auth_id', 'url_image_auth_doc', 'url_verify_photo', 'nation', 'province', 'city', 'county', 'bank_name',
            'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'status',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'name', 'fullname_owner', 'fullname_auth', 'code_license', 'code_ssn_owner', 'code_ssn_auth', 'url_image_license', 'url_image_owner_id', 'url_image_auth_id', 'url_image_auth_doc', 'url_verify_photo', 'nation', 'province', 'city', 'county', 'street', 'bank_name', 'bank_account',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'id',
			'name', 'fullname_owner', 'fullname_auth', 'code_license', 'code_ssn_owner', 'code_ssn_auth', 'url_image_license', 'url_image_owner_id', 'url_image_auth_id', 'url_image_auth_doc', 'url_verify_photo', 'nation', 'province', 'city', 'county', 'street', 'bank_name', 'bank_account',
		);

		public function __construct()
		{
			parent::__construct();

			// 未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '企业认证'; // 改这里……
			$this->table_name = 'identity_biz'; // 和这里……
			$this->id_name = 'identity_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录

			// 设置需要自动在视图文件中生成显示的字段
			$this->data_to_display = array(
				'name' => '名称',
				'description' => '描述',
			);
		} // end __construct

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '列表',
				'class' => $this->class_name.' index',
			);

			// 筛选条件
			$condition['time_delete'] = 'NULL';
			// （可选）遍历筛选条件
            foreach ($this->names_to_sort as $sorter):
                if ( !empty($this->input->get_post($sorter)) )
                    $condition[$sorter] = $this->input->get_post($sorter);
            endforeach;

			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
                $data['items'] = array();
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * 详情页
		 */
		public function detail()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

            // 从API服务器获取相应详情信息
            $url = api_url($this->class_name. '/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item'] = $result['content'];
                // 页面信息
                $data['title'] = $this->class_name_cn. $data['item'][$this->id_name];
                $data['class'] = $this->class_name.' detail';

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

		/**
		 * 回收站
		 */
		public function trash()
		{
			// 操作可能需要检查操作权限
			$role_allowed = array('管理员', '经理'); // 角色要求
			$min_level = 30; // 级别要求
			$this->permission_check($role_allowed, $min_level);

			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '回收站',
				'class' => $this->class_name.' trash',
			);

			// 筛选条件
			$condition['time_delete'] = 'IS NOT NULL';
			// （可选）遍历筛选条件
            foreach ($this->names_to_sort as $sorter):
                if ( !empty($this->input->get_post($sorter)) )
                    $condition[$sorter] = $this->input->get_post($sorter);
            endforeach;

			// 排序条件
			$order_by['time_delete'] = 'DESC';

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
                $data['items'] = array();
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/trash', $data);
			$this->load->view('templates/footer', $data);
		} // end trash

		/**
		 * 创建
		 */
		public function create()
		{
			// 操作可能需要检查操作权限
			// $role_allowed = array('管理员', '经理'); // 角色要求
// 			$min_level = 30; // 级别要求
// 			$this->basic->permission_check($role_allowed, $min_level);

			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' create',
				'error' => '', // 预设错误提示
			);

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
			$this->form_validation->set_rules('name', '主体名称', 'trim|required');
			$this->form_validation->set_rules('fullname_owner', '法人姓名', 'trim|required');
			$this->form_validation->set_rules('fullname_auth', '经办人姓名', 'trim|required');
			$this->form_validation->set_rules('code_license', '工商注册号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_owner', '法人身份证号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_auth', '经办人身份证号', 'trim|required');
			$this->form_validation->set_rules('url_image_license', '营业执照', 'trim|required');
			$this->form_validation->set_rules('url_image_owner_id', '法人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_id', '经办人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_doc', '经办人授权书', 'trim|required');
			$this->form_validation->set_rules('url_verify_photo', '经办人持身份证照片', 'trim|required');
			$this->form_validation->set_rules('nation', '国家', 'trim|');
			$this->form_validation->set_rules('province', '省', 'trim|required');
			$this->form_validation->set_rules('city', '市', 'trim|required');
			$this->form_validation->set_rules('county', '区', 'trim|required');
			$this->form_validation->set_rules('street', '具体地址', 'trim|required');
			$this->form_validation->set_rules('bank_name', '开户行名称', 'trim|required');
			$this->form_validation->set_rules('bank_account', '开户行账号', 'trim|required');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要创建的数据；逐一赋值需特别处理的字段
				$data_to_create = array(
					'user_id' => $this->session->user_id,
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'name', 'fullname_owner', 'fullname_auth', 'code_license', 'code_ssn_owner', 'code_ssn_auth', 'url_image_license', 'url_image_owner_id', 'url_image_auth_id', 'url_image_auth_doc', 'url_verify_photo', 'nation', 'province', 'city', 'county', 'street', 'bank_name', 'bank_account',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_create[$name] = $this->input->post($name);

				// 向API服务器发送待创建数据
				$params = $data_to_create;
				$url = api_url($this->class_name. '/create');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '创建成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'create';
					$data['id'] = $result['content']['id']; // 创建后的信息ID

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若创建失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/create', $data);
					$this->load->view('templates/footer', $data);

				endif;
				
			endif;
		} // end create

		/**
		 * 编辑单行
		 */
		public function edit()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
				$params['user_id'] = $this->session->user_id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 操作可能需要检查操作权限
			// $role_allowed = array('管理员', '经理'); // 角色要求
// 			$min_level = 30; // 级别要求
// 			$this->basic->permission_check($role_allowed, $min_level);

			// 页面信息
			$data = array(
				'title' => '修改'.$this->class_name_cn,
				'class' => $this->class_name.' edit',
				'error' => '', // 预设错误提示
			);

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				redirect( base_url('error/code_404') ); // 若未成功获取信息，则转到错误页
			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$this->form_validation->set_rules('name', '主体名称', 'trim|required');
			$this->form_validation->set_rules('fullname_owner', '法人姓名', 'trim|required');
			$this->form_validation->set_rules('fullname_auth', '经办人姓名', 'trim|required');
			$this->form_validation->set_rules('code_license', '工商注册号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_owner', '法人身份证号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_auth', '经办人身份证号', 'trim|required');
			$this->form_validation->set_rules('url_image_license', '营业执照', 'trim|required');
			$this->form_validation->set_rules('url_image_owner_id', '法人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_id', '经办人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_doc', '经办人授权书', 'trim|required');
			$this->form_validation->set_rules('url_verify_photo', '经办人持身份证照片', 'trim|required');
			$this->form_validation->set_rules('nation', '国家', 'trim|');
			$this->form_validation->set_rules('province', '省', 'trim|required');
			$this->form_validation->set_rules('city', '市', 'trim|required');
			$this->form_validation->set_rules('county', '区', 'trim|required');
			$this->form_validation->set_rules('street', '具体地址', 'trim|required');
			$this->form_validation->set_rules('bank_name', '开户行名称', 'trim|required');
			$this->form_validation->set_rules('bank_account', '开户行账号', 'trim|required');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/edit', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要编辑的数据；逐一赋值需特别处理的字段
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'id' => $id,
					//'name' => $this->input->post('name')),
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'name', 'fullname_owner', 'fullname_auth', 'code_license', 'code_ssn_owner', 'code_ssn_auth', 'url_image_license', 'url_image_owner_id', 'url_image_auth_id', 'url_image_auth_doc', 'url_verify_photo', 'nation', 'province', 'city', 'county', 'street', 'bank_name', 'bank_account',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_edit[$name] = $this->input->post($name);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '修改成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'edit';
					$data['id'] = $result['content']['id']; // 修改后的信息ID

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/edit', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end edit

		/**
		 * 修改单项
		 */
		public function edit_certain()
		{
			// 检查必要参数是否已传入
			$required_params = $this->names_edit_certain_required;
			foreach ($required_params as $param):
				${$param} = $this->input->post($param);
				if ( $param !== 'value' && empty( ${$param} ) ): // value 可以为空；必要字段会在字段验证中另行检查
					$data['error'] = '必要的请求参数未全部传入';
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/'.$op_view, $data);
					$this->load->view('templates/footer', $data);
					exit();
				endif;
			endforeach;

			// 操作可能需要检查操作权限
			// $role_allowed = array('管理员', '经理'); // 角色要求
// 			$min_level = 30; // 级别要求
// 			$this->basic->permission_check($role_allowed, $min_level);

			// 页面信息
			$data = array(
				'title' => '修改'.$this->class_name_cn. $name,
				'class' => $this->class_name.' edit-certain',
				'error' => '', // 预设错误提示
			);

			// 从API服务器获取相应详情信息
			$params['id'] = $id;
			$params['user_id'] = $this->session->user_id;
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				redirect( base_url('error/code_404') ); // 若未成功获取信息，则转到错误页
			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 动态设置待验证字段名及字段值
			$data_to_validate["{$name}"] = $value;
			$this->form_validation->set_data($data_to_validate);
			$this->form_validation->set_rules('name', '主体名称', 'trim|required');
			$this->form_validation->set_rules('fullname_owner', '法人姓名', 'trim|required');
			$this->form_validation->set_rules('fullname_auth', '经办人姓名', 'trim|required');
			$this->form_validation->set_rules('code_license', '工商注册号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_owner', '法人身份证号', 'trim|required');
			$this->form_validation->set_rules('code_ssn_auth', '经办人身份证号', 'trim|required');
			$this->form_validation->set_rules('url_image_license', '营业执照', 'trim|required');
			$this->form_validation->set_rules('url_image_owner_id', '法人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_id', '经办人身份证', 'trim|required');
			$this->form_validation->set_rules('url_image_auth_doc', '经办人授权书', 'trim|required');
			$this->form_validation->set_rules('url_verify_photo', '经办人持身份证照片', 'trim|required');
			$this->form_validation->set_rules('nation', '国家', 'trim|');
			$this->form_validation->set_rules('province', '省', 'trim|required');
			$this->form_validation->set_rules('city', '市', 'trim|required');
			$this->form_validation->set_rules('county', '区', 'trim|required');
			$this->form_validation->set_rules('street', '具体地址', 'trim|required');
			$this->form_validation->set_rules('bank_name', '开户行名称', 'trim|required');
			$this->form_validation->set_rules('bank_account', '开户行账号', 'trim|required');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/edit_certain', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要编辑的信息
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'id' => $id,
					'name' => $name,
					'value' => $value,
				);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit_certain');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '修改成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'edit_certain';
					$data['id'] = $id;

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/edit_certain', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end edit_certain

        /**
         * 删除
         *
         * 商家不可删除
         */
        public function delete()
        {
            exit('商家不可删除'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end delete

        /**
         * 找回
         *
         * 商家不可找回
         */
        public function restore()
        {
            exit('商家不可找回'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end restore
		
		/**
		 * 以下为工具类方法
		 */

	} // end class Identity_biz

/* End of file Identity_biz.php */
/* Location: ./application/controllers/Identity_biz.php */

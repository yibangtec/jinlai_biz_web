<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Ornament_biz 店铺装修类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Ornament_biz extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'biz_id', 'name', 'vi_color_first', 'vi_color_second', 'main_figure_url', 'member_logo_url', 'member_figure_url', 'member_thumb_url', 'template_id', 'home_slides', 'home_m0_ids', 'home_m1_ace_url', 'home_m1_ace_id', 'home_m1_ids', 'home_m2_ace_url', 'home_m2_ace_id', 'home_m2_ids', 'home_m3_ace_url', 'home_m3_ace_id', 'home_m3_ids', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'name', 'vi_color_first', 'vi_color_second', 'main_figure_url', 'member_logo_url', 'member_figure_url', 'member_thumb_url', 'home_json', 'home_html', 'template_id', 'home_slides', 'home_m0_ids', 'home_m1_ace_url', 'home_m1_ace_id', 'home_m1_ids', 'home_m2_ace_url', 'home_m2_ace_id', 'home_m2_ids', 'home_m3_ace_url', 'home_m3_ace_id', 'home_m3_ids',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'id', 'name',
		);
		
		/**
		 * 编辑单行特定字段时必要的字段名
		 */
		protected $names_edit_certain_required = array(
			'id', 'name', 'value',
		);

		/**
		 * 编辑多行特定字段时必要的字段名
		 */
		protected $names_edit_bulk_required = array(
			'ids', 'password',
		);

		public function __construct()
		{
			parent::__construct();

			// （可选）未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '店铺装修'; // 改这里……
			$this->table_name = 'ornament_biz'; // 和这里……
			$this->id_name = 'ornament_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录

			// 设置需要自动在视图文件中生成显示的字段
			$this->data_to_display = array(
				'name' => '装修方案名称',
			);
		}

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
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 排序条件
			$order_by = NULL;

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
				$params['user_id'] = $this->session->user_id;
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
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
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

            // 获取当前商家所有商品数据
            $data['comodities'] = $this->list_item();

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
            $this->form_validation->set_rules('name', '方案名称', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('vi_color_first', '第一识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('vi_color_second', '第二识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('main_figure_url', '主形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_logo_url', '会员卡LOGO', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_figure_url', '会员卡封图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_thumb_url', '会员卡列表图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_json', '首页JSON格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('home_html', '首页HTML格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('template_id', '装修模板', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_slides', '顶部模块轮播图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m0_ids[]', '顶部模块陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_url', '模块一形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_id', '模块一首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m1_ids[]', '模块一陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_url', '模块二形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_id', '模块二首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m2_ids[]', '模块二陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_url', '模块三形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_id', '模块三首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m3_ids[]', '模块三陈列商品', 'trim|max_length[255]');

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
                    'home_m0_ids' => !empty($this->input->post('home_m0_ids'))? implode(',', $this->input->post('home_m0_ids')): NULL,
                    'home_m1_ids' => !empty($this->input->post('home_m1_ids'))? implode(',', $this->input->post('home_m1_ids')): NULL,
                    'home_m2_ids' => !empty($this->input->post('home_m2_ids'))? implode(',', $this->input->post('home_m2_ids')): NULL,
                    'home_m3_ids' => !empty($this->input->post('home_m3_ids'))? implode(',', $this->input->post('home_m3_ids')): NULL,
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
                    'name', 'vi_color_first', 'vi_color_second', 'main_figure_url', 'member_logo_url', 'member_figure_url', 'member_thumb_url', 'home_json', 'home_html', 'template_id', 'home_slides', 'home_m1_ace_url', 'home_m1_ace_id', 'home_m2_ace_url', 'home_m2_ace_id', 'home_m3_ace_url', 'home_m3_ace_id',
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

            // 获取当前商家所有商品数据
            $data['comodities'] = $this->list_item();

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
            $this->form_validation->set_rules('name', '方案名称', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('vi_color_first', '第一识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('vi_color_second', '第二识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('main_figure_url', '主形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_logo_url', '会员卡LOGO', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_figure_url', '会员卡封图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_thumb_url', '会员卡列表图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_json', '首页JSON格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('home_html', '首页HTML格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('template_id', '装修模板', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_slides', '顶部模块轮播图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m0_ids[]', '顶部模块陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_url', '模块一形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_id', '模块一首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m1_ids[]', '模块一陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_url', '模块二形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_id', '模块二首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m2_ids[]', '模块二陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_url', '模块三形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_id', '模块三首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m3_ids[]', '模块三陈列商品', 'trim|max_length[255]');

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
                    'home_m0_ids' => !empty($this->input->post('home_m0_ids'))? implode(',', $this->input->post('home_m0_ids')): NULL,
                    'home_m1_ids' => !empty($this->input->post('home_m1_ids'))? implode(',', $this->input->post('home_m1_ids')): NULL,
                    'home_m2_ids' => !empty($this->input->post('home_m2_ids'))? implode(',', $this->input->post('home_m2_ids')): NULL,
                    'home_m3_ids' => !empty($this->input->post('home_m3_ids'))? implode(',', $this->input->post('home_m3_ids')): NULL,
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'name', 'vi_color_first', 'vi_color_second', 'main_figure_url', 'member_logo_url', 'member_figure_url', 'member_thumb_url', 'home_json', 'home_html', 'template_id', 'home_slides', 'home_m1_ace_url', 'home_m1_ace_id', 'home_m2_ace_url', 'home_m2_ace_id', 'home_m3_ace_url', 'home_m3_ace_id',
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
            $this->form_validation->set_rules('name', '方案名称', 'trim|max_length[30]');
            $this->form_validation->set_rules('vi_color_first', '第一识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('vi_color_second', '第二识别色', 'trim|min_length[3]|max_length[6]');
            $this->form_validation->set_rules('main_figure_url', '主形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_logo_url', '会员卡LOGO', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_figure_url', '会员卡封图', 'trim|max_length[255]');
            $this->form_validation->set_rules('member_thumb_url', '会员卡列表图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_json', '首页JSON格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('home_html', '首页HTML格式内容', 'trim|max_length[20000]');
            $this->form_validation->set_rules('template_id', '装修模板', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_slides', '顶部模块轮播图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m0_ids[]', '顶部模块陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_url', '模块一形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m1_ace_id', '模块一首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m1_ids[]', '模块一陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_url', '模块二形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m2_ace_id', '模块二首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m2_ids[]', '模块二陈列商品', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_url', '模块三形象图', 'trim|max_length[255]');
            $this->form_validation->set_rules('home_m3_ace_id', '模块三首推商品', 'trim|max_length[11]|is_natural_no_zero');
            $this->form_validation->set_rules('home_m3_ids[]', '模块三陈列商品', 'trim|max_length[255]');

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

	} // end class Ornament_biz

/* End of file Ornament_biz.php */
/* Location: ./application/controllers/Ornament_biz.php */

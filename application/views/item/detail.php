<style>


	/* 宽度在750像素以上的设备 */
	@media only screen and (min-width:751px)
	{
		
	}
	
	/* 宽度在960像素以上的设备 */
	@media only screen and (min-width:961px)
	{

	}

	/* 宽度在1280像素以上的设备 */
	@media only screen and (min-width:1281px)
	{

	}
</style>

<base href="<?php echo base_url('uploads/') ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php
	// 需要特定角色和权限进行该操作
	$current_role = $this->session->role; // 当前用户角色
	$current_level = $this->session->level; // 当前用户级别
	$role_allowed = array('管理员', '经理');
	$level_allowed = 30;
	if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
	?>
	<div class=btn-group role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create_quick') ?>"><i class="fa fa-bolt fa-fw" aria-hidden=true></i> 快速创建<?php echo $this->class_name_cn ?></a>
	</div>
	<?php endif ?>

	<ul class=list-unstyled>
		<?php
		// 需要特定角色和权限进行该操作
		if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
		?>
		<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-edit"></i> 编辑</a></li>
		<?php endif ?>
	</ul>

	<dl id=list-info class=dl-horizontal>
		<dt>主图</dt>
		<dd class=row>
			<figure class="col-xs-12 col-sm-6 col-md-4">
				<img src="<?php echo $item['url_image_main'] ?>">
			</figure>
		</dd>

		<?php if ( !empty($item['figure_image_urls']) ): ?>
		<dt>形象图</dt>
		<dd>
			<base href="http://s.handu.com/images/201703/goods_img/">
			<ul class=row>
				<?php
					$figure_image_urls = explode(',', $item['figure_image_urls']);
					foreach($figure_image_urls as $url):
				?>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?php echo $url ?>">
				</li>
				<?php endforeach ?>
			</ul>
		</dd>
		<?php endif ?>

		<?php if ( !empty($item['figure_video_urls']) ): ?>
		<dt>形象视频</dt>
		<dd><?php echo $item['figure_video_urls'] ?></dd>
		<?php endif ?>

		<dt>状态</dt>
		<dd><?php echo $item['status'] ?></dd>
		<?php if ( $item['figure_video_urls'] !== '待审核' && !empty($item['note_admin']) ): ?>
		<dt>审核意见</dt>
		<dd class="bg-info text-info"><?php echo $item['note_admin'] ?></dd>
		<?php endif ?>

		<dt>商品ID</dt>
		<dd><?php echo $item['item_id'] ?></dd>
		<dt>所属系统商品分类</dt>
		<dd><?php echo $category['name'] ?></dd>
		<dt>所属品牌</dt>
		<dd><?php echo $item['brand_id'] ?></dd>

		<?php if ( !empty($item['category_biz_id']) ): ?>
		<dt>所属商家商品分类</dt>
		<dd><?php echo $category_biz['name'] ?></dd>
		<?php endif ?>

		<?php if ( !empty($item['code_biz']) ): ?>
		<dt>商家自定义货号</dt>
		<dd><?php echo $item['code_biz'] ?></dd>
		<?php endif ?>

		<dt>商品名称</dt>
		<dd><strong><?php echo $item['name'] ?></strong></dd>
		<dt>商品宣传语/卖点</dt>
		<dd><?php echo !empty($item['slogan'])? $item['slogan']: '未设置'; ?></dd>
		<dt>标签价/原价（元）</dt>
		<dd><del>￥ <?php echo !empty($item['tag_price'])? $item['tag_price']: '未设置'; ?></del></dd>
		<dt>商城价/现价（元）</dt>
		<dd><strong>￥ <?php echo $item['price'] ?></strong></dd>
		
		<?php $unit_name = !empty($item['unit_name'])? $item['unit_name']: '份（默认单位）' ?>
		<dt>库存量</dt>
		<dd><strong><?php echo $item['stocks'].' '. $unit_name ?></strong></dd>
		<dt>销售单位</dt>
		<dd><?php echo $unit_name ?></dd>
		<dt>净重</dt>
		<dd><?php echo !empty($item['weight_net'])? $item['weight_net']: '未设置'; ?> KG</dd>
		<dt>毛重</dt>
		<dd><?php echo !empty($item['weight_gross'])? $item['weight_gross']: '未设置'; ?> KG</dd>
		<dt>体积重</dt>
		<dd><?php echo !empty($item['weight_volume'])? $item['weight_volume']: '未设置'; ?> KG</dd>
		<dt>每单最高限量</dt>
		<dd><?php echo !empty($item['quantity_max'])? $item['quantity_max']: '不限'; ?> 份</dd>
		<dt>每单最低限量</dt>
		<dd><?php echo !empty($item['quantity_min'])? $item['quantity_min']: 1; ?> 份</dd>
		<dt>是否可用优惠券</dt>
		<dd><?php echo ($item['coupon_allowed'] === '1')? '是': '否'; ?></dd>
		<dt>积分抵扣率</dt>
		<dd><?php echo $item['discount_credit'] * 100 ?>%</dd>
		<dt>佣金比例/提成率</dt>
		<dd><?php echo $item['commission_rate'] * 100 ?>%</dd>

		<?php if ( ! empty($item['time_to_publish']) ): ?>
		<dt>预定上架时间</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_to_publish']) ?></dd>
		<?php endif ?>

		<?php if ( ! empty($item['time_to_suspend']) ): ?>
		<dt>预定下架时间</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_to_suspend']) ?></dd>
		<?php endif ?>

		<dt>店内营销活动</dt>
		<?php if ( ! empty($item['promotion_id']) ): ?>
		<dd><?php echo $item['promotion_id'] ?></dd>
		<?php else: ?>
		<dd>不参与</dd>
		<?php endif ?>
	</dl>

	<section id=description>
	<h2>商品描述</h2>
	<?php if ( !empty($item['description']) ): ?>
		<div class="bg-info text-info">
			<p class="text-center">以下仅为内容及格式预览，实际样式请以前台相应页面为准。</p>
		</div>
		<div id=description-content class=row>
			<?php echo $item['description'] ?>
		</div>
	<?php else: ?>
		<p>该商品尚未填写商品描述。</p>
	<?php endif ?>
	</section>

	<dl id=list-record class=dl-horizontal>
		<dt>创建时间</dt>
		<dd>
			<?php echo $item['time_create'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['creator_id']) ?>" target=new>查看创建者</a>
		</dd>

		<?php if ( ! empty($item['time_delete']) ): ?>
		<dt>删除时间</dt>
		<dd><?php echo $item['time_delete'] ?></dd>
		<?php endif ?>

		<?php if ( ! empty($item['operator_id']) ): ?>
		<dt>最后操作时间</dt>
		<dd>
			<?php echo $item['time_edit'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['operator_id']) ?>" target=new>查看最后操作者</a>
		</dd>
		<?php endif ?>
	</dl>
</div>
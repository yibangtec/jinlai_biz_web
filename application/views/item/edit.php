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

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<fieldset>
			<p class="bg-info text-info text-center">带有“※”符号的为必填项</p>

			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class=form-group>
				<label for=item_id class="col-sm-2 control-label">商品ID</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo $item['item_id'] ?></p>
				</div>
			</div>
			<div class=form-group>
				<label for=category_id class="col-sm-2 control-label">系统商品分类</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo $category['name'] ?> *系统商品分类不可修改</p>
				</div>
			</div>

			<?php if ( !empty($brands) ): ?>
			<div class=form-group>
				<label for=brand_id class="col-sm-2 control-label">品牌</label>
				<div class=col-sm-10>
					<input class=form-control name=brand_id type=text value="<?php echo $item['brand_id'] ?>" placeholder="所属品牌ID">
				</div>
			</div>
			<?php endif ?>

			<?php if ( !empty($biz_categories) ): ?>
			<div class=form-group>
				<label for=category_biz_id class="col-sm-2 control-label">商家商品分类</label>
				<div class=col-sm-10>
					<?php $input_name = 'category_biz_id' ?>
					<select class=form-control name="<?php echo $input_name ?>">
						<option value="">请选择</option>
						<?php
							$options = $biz_categories;
							foreach ($options as $option):
						?>
						<option value="<?php echo $option['name'] ?>" <?php if ($option['name'] === $category_biz['name']) echo 'selected'; ?>><?php echo $option['name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<?php endif ?>

			<div class=form-group>
				<label for=name class="col-sm-2 control-label">商品名称※</label>
				<div class=col-sm-10>
					<input class=form-control name=name type=text value="<?php echo $item['name'] ?>" placeholder="最多30个字符，中英文、数字，不可为纯数字" required>
				</div>
			</div>
			<div class=form-group>
				<label for=slogan class="col-sm-2 control-label">商品宣传语/卖点</label>
				<div class=col-sm-10>
					<input class=form-control name=slogan type=text value="<?php echo $item['slogan'] ?>" placeholder="最多30个字符，中英文、数字，不可为纯数字">
				</div>
			</div>
			
			<div class=form-group>
				<label for=code_biz class="col-sm-2 control-label">商家自定义货号</label>
				<div class=col-sm-10>
					<input class=form-control name=code_biz type=text value="<?php echo $item['code_biz'] ?>" placeholder="最多20个英文大小写字母、数字">
				</div>
			</div>
			
			<div class=form-group>
				<label for=url_image_main class="col-sm-2 control-label">主图※</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_main']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_main'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<p class=help-block>请上传大小在2M以内，边长不超过2048px的jpg/png图片</p>
						<?php $name_to_upload = 'url_image_main' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-primary btn-lg col-xs-12 col-md-3" data-target-dir="item/image_main" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=figure_image_urls class="col-sm-2 control-label">形象图</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['figure_image_urls']) ): ?>
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
					<?php endif ?>
					
					<div>
						<p class=help-block>最多可上传4张，选择时按住“ctrl”或“⌘”键可选多张</p>
						<?php $name_to_upload = 'figure_image_urls' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file multiple>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-primary btn-lg col-xs-12 col-md-3" data-target-dir="item/image_figure" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<!--
			<div class=form-group>
				<label for=figure_video_urls class="col-sm-2 control-label">形象视频</label>
				<div class=col-sm-10>
					<input class=form-control name=figure_video_urls type=text value="<?php echo $item['figure_video_urls'] ?>" placeholder="形象视频">
				</div>
			</div>
			-->

			<div class=form-group>
				<label for=description class="col-sm-2 control-label">商品描述</label>
				<div class=col-sm-10>
					<p class=helper-block>可留空，建议在桌面电脑上编辑此部分以使用更全面的功能</p>
					<textarea id=detail_editior name=description rows=10 placeholder="商品描述"><?php echo $item['description'] ?></textarea>

					<!-- ueditor 1.4.3.3 -->
					<link rel="stylesheet" media=all href="<?php echo base_url('ueditor/themes/default/css/ueditor.min.css') ?>">
					<script src="<?php echo base_url('ueditor/ueditor.config.js') ?>"></script>
					<script src="<?php echo base_url('ueditor/ueditor.all.min.js') ?>"></script>
					<script>var ue = UE.getEditor('detail_editior');</script>
				</div>
			</div>
			<div class=form-group>
				<label for=tag_price class="col-sm-2 control-label">标签价/原价（元）</label>
				<div class=col-sm-10>
					<input class=form-control name=tag_price type=text value="<?php echo $item['tag_price'] ?>" placeholder="标签价/原价（元）">
				</div>
			</div>
			<div class=form-group>
				<label for=price class="col-sm-2 control-label">商城价/现价（元）※</label>
				<div class=col-sm-10>
					<input class=form-control name=price type=text value="<?php echo $item['price'] ?>" placeholder="商城价/现价（元）" required>
				</div>
			</div>
			<div class=form-group>
				<label for=stocks class="col-sm-2 control-label">库存量（份）※</label>
				<div class=col-sm-10>
					<input class=form-control name=stocks type=text value="<?php echo $item['stocks'] ?>" placeholder="库存量（份）" required>
				</div>
			</div>
			<div class=form-group>
				<label for=unit_name class="col-sm-2 control-label">销售单位</label>
				<div class=col-sm-10>
					<input class=form-control name=unit_name type=text value="<?php echo $item['unit_name'] ?>" placeholder="销售单位">
				</div>
			</div>
			<div class=form-group>
				<label for=weight_net class="col-sm-2 control-label">净重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_net type=text value="<?php echo $item['weight_net'] ?>" placeholder="净重（KG）">
				</div>
			</div>
			<div class=form-group>
				<label for=weight_gross class="col-sm-2 control-label">毛重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_gross type=text value="<?php echo $item['weight_gross'] ?>" placeholder="毛重（KG）">
				</div>
			</div>
			<div class=form-group>
				<label for=weight_volume class="col-sm-2 control-label">体积重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_volume type=text value="<?php echo $item['weight_volume'] ?>" placeholder="体积重（KG）">
				</div>
			</div>
			<div class=form-group>
				<label for=quantity_max class="col-sm-2 control-label">每单最高限量（份）</label>
				<div class=col-sm-10>
					<input class=form-control name=quantity_max type=text value="<?php echo $item['quantity_max'] ?>" placeholder="每单最高限量（份）">
				</div>
			</div>
			<div class=form-group>
				<label for=quantity_min class="col-sm-2 control-label">每单最低限量（份）</label>
				<div class=col-sm-10>
					<input class=form-control name=quantity_min type=text value="<?php echo $item['quantity_min'] ?>" placeholder="每单最低限量（份）">
				</div>
			</div>
			<div class=form-group>
				<label for=coupon_allowed class="col-sm-2 control-label">是否可用优惠券※</label>
				<div class=col-sm-10>
					<select class=form-control name=coupon_allowed>
						<option value=1 <?php echo ($item['coupon_allowed'] === '1')? 'selected': NULL; ?>>允许</option>
						<option value=0 <?php echo ($item['coupon_allowed'] === '0')? 'selected': NULL; ?>>不允许</option>
					</select>
				</div>
			</div>
			<div class=form-group>
				<label for=discount_credit class="col-sm-2 control-label">积分抵扣率</label>
				<div class=col-sm-10>
					<input class=form-control name=discount_credit type=number step=0.01 min=0.00 max=0.99 value="<?php echo $item['discount_credit'] ?>" placeholder="积分抵扣率">
				</div>
			</div>
			<div class=form-group>
				<label for=commission_rate class="col-sm-2 control-label">佣金比例/提成率</label>
				<div class=col-sm-10>
					<input class=form-control name=commission_rate type=number step=0.01 min=0.00 max=0.99 value="<?php echo $item['commission_rate'] ?>" placeholder="佣金比例/提成率">
				</div>
			</div>
			<div class=form-group>
				<label for=time_to_publish class="col-sm-2 control-label">预定上架时间</label>
				<div class=col-sm-10>
					<input class=form-control name=time_to_publish type=text value="<?php echo $item['time_to_publish'] ?>" placeholder="预定上架时间">
				</div>
			</div>
			<div class=form-group>
				<label for=time_to_suspend class="col-sm-2 control-label">预定下架时间</label>
				<div class=col-sm-10>
					<input class=form-control name=time_to_suspend type=text value="<?php echo $item['time_to_suspend'] ?>" placeholder="预定下架时间">
				</div>
			</div>
			
			<?php if ( !empty($biz_promotions) ): ?>
			<div class=form-group>
				<label for=promotion_id class="col-sm-2 control-label">店内营销活动</label>
				<div class=col-sm-10>
					<input class=form-control name=promotion_id type=text value="<?php echo $item['promotion_id'] ?>" placeholder="参与的营销活动ID">
				</div>
			</div>
			<?php endif ?>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>
	</form>

</div>
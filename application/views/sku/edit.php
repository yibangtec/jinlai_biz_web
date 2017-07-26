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
		<?php if ( !empty($comodity) ): ?>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create?item_id='.$comodity['item_id']) ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
		<?php endif ?>
	</div>
	<?php endif ?>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<fieldset>
			<p class="bg-info text-info text-center">必填项以“※”符号表示</p>

			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class="form-group well">
				<label for=item_id class="col-sm-2 control-label">所属商品</label>
				<div class=col-sm-10>
					<section id=item-info class=row>
						<figcaption><?php echo $comodity['name'] ?></figcaption>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $comodity['url_image_main'] ?>">
						</figure>
					</section>
				</div>
			</div>

			<div class=form-group>
				<label for=url_image class="col-sm-2 control-label">图片</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<p class=help-block>请上传大小在2M以内，边长不超过2048px的jpg/png图片</p>
						<?php $name_to_upload = 'url_image' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-primary btn-lg col-xs-12 col-md-3" data-target-dir="sku/image" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>
				</div>
			</div>

			<div class=form-group>
				<label for=name_first class="col-sm-2 control-label">一级规格※</label>
				<div class=col-sm-10>
					<input class=form-control name=name_first type=text value="<?php echo $item['name_first'] ?>" placeholder="一级规格" required>
				</div>
			</div>
			<div class=form-group>
				<label for=name_second class="col-sm-2 control-label">二级规格</label>
				<div class=col-sm-10>
					<input class=form-control name=name_second type=text value="<?php echo $item['name_second'] ?>" placeholder="二级规格">
				</div>
			</div>
			<div class=form-group>
				<label for=name_third class="col-sm-2 control-label">三级规格</label>
				<div class=col-sm-10>
					<input class=form-control name=name_third type=text value="<?php echo $item['name_third'] ?>" placeholder="三级规格">
				</div>
			</div>
			<div class=form-group>
				<label for=price class="col-sm-2 control-label">价格（元）※</label>
				<div class=col-sm-10>
					<input class=form-control name=price type=number step=0.01 max=99999.99 value="<?php echo $item['price'] ?>" placeholder="价格（元）" required>
				</div>
			</div>
			<div class=form-group>
				<label for=stocks class="col-sm-2 control-label">库存量（单位）※</label>
				<div class=col-sm-10>
					<input class=form-control name=stocks type=number step=1 max=65535 value="<?php echo $item['stocks'] ?>" placeholder="库存量（单位）" required>
				</div>
			</div>
		</fieldset>
	
		<fieldset>
			<p class="bg-info text-info text-center">以下择一填写即可；若填写多项，将以毛重为准进行运费计算</p>
		
			<div class=form-group>
				<label for=weight_net class="col-sm-2 control-label">净重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_net type=number step=0.01 max=999.99 value="<?php echo $item['weight_net'] ?>" placeholder="最高999.99">
				</div>
			</div>
			<div class=form-group>
				<label for=weight_gross class="col-sm-2 control-label">毛重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_gross type=number step=0.01 max=999.99 value="<?php echo $item['weight_gross'] ?>" placeholder="最高999.99">
				</div>
			</div>
			<div class=form-group>
				<label for=weight_volume class="col-sm-2 control-label">体积重（KG）</label>
				<div class=col-sm-10>
					<input class=form-control name=weight_volume type=number step=0.01 max=999.99 value="<?php echo $item['weight_volume'] ?>" placeholder="最高999.99">
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>
	</form>

</div>
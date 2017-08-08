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

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li class=active><?php echo $this->class_name_cn ?></li>
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
		<a class="btn btn-primary" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create_quick') ?>"><i class="fa fa-bolt fa-fw" aria-hidden=true></i> 快速创建<?php echo $this->class_name_cn ?></a>
	</div>
	<?php endif ?>

	<?php if ( empty($this->session->biz_id) ): ?>
	<blockquote>
		<p>您需要成为已入驻企业的员工，或者提交入驻申请，才可进行商品管理</p>
	</blockquote>
	
	<?php else: ?>

		<?php if ( $count['biz_freight_templates'] === 0 ): ?>
		<blockquote class=row>
			<p class=help-block>您目前没有运费模板，将为买家包邮。</p>
			<a class="col-xs-12 col-sm-6 col-md-3 btn btn-primary btn-lg" href="<?php echo base_url('freight_template_biz/create') ?>">创建运费模板</a>
		</blockquote>
		<?php endif ?>
	
		<?php if ( empty($items) ): ?>
		<blockquote class=row>
			<p>您的货架空空如也，快点添加商品吧！</p>
			<a class="col-xs-12 col-sm-6 col-md-3 btn btn-primary btn-lg" href="<?php echo base_url('item/create') ?>">创建一个</a>
		</blockquote>

		<?php else: ?>
		<form method=get target=_blank>
			<fieldset>
				<div class=btn-group role=group>
					<button formaction="<?php echo base_url($this->class_name.'/publish') ?>" type=submit class="btn btn-warning">上架</button>
					<button formaction="<?php echo base_url($this->class_name.'/suspend') ?>" type=submit class="btn btn-warning">下架</button>
					<button formaction="<?php echo base_url($this->class_name.'/delete') ?>" type=submit class="btn btn-danger">删除</button>
				</div>
			</fieldset>

			<table class="table table-condensed table-responsive table-striped sortable">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th><?php echo $this->class_name_cn ?>ID</th>
						<?php
							$thead = array_values($data_to_display);
							foreach ($thead as $th):
								echo '<th>' .$th. '</th>';
							endforeach;
						?>
						<th>商品规格/SKU</th>
						<th>操作</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach ($items as $item): ?>
					<tr>
						<td>
							<input name=ids[] class=form-control type=checkbox value="<?php echo $item[$this->id_name] ?>">
						</td>
						<td><?php echo $item[$this->id_name] ?></td>
						<?php
							$tr = array_keys($data_to_display);
							foreach ($tr as $td):
								echo '<td>' .$item[$td]. '</td>';
							endforeach;
						?>
						<td>
							<ul class=list-unstyled>
								<li><a title="SKU列表" href="<?php echo base_url('sku/index?item_id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-eye"></i> 规格列表</a></li>
								<li><a title="创建SKU" href="<?php echo base_url('sku/create?item_id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-plus"></i> 创建规格</a></li>
							</ul>
						</td>
						<td>
							<ul class=list-unstyled>
								<li><a title="查看" href="<?php echo base_url($this->view_root.'/detail?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-eye"></i> 查看</a></li>
								<?php
								// 需要特定角色和权限进行该操作
								if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
								?>
								<?php if ( !empty($item['time_suspend']) ): ?>
								<li><a title="上架" href="<?php echo base_url($this->class_name.'/publish?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-level-up"></i> 上架</a></li>
								<?php else: ?>
								<li><a title="下架" href="<?php echo base_url($this->class_name.'/suspend?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-level-down"></i> 下架</a></li>
								<?php endif ?>
								<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-edit"></i> 编辑</a></li>
								<li><a title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-trash"></i> 删除</a></li>
								<?php endif ?>
							</ul>
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
	
		</form>
		<?php endif ?>

	<?php endif ?>
</div>
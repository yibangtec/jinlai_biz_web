<link rel=stylesheet media=all href="<?php echo BASE_URL ?>/css/jquery.datetimepicker.css">

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

<!--<script defer src="/js/create.js"></script>-->

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/orderitemsexport', $attributes);
	?>
		<p class=help-block>必填项以“※”符号标示</p>

		<fieldset>
			<div class=form-group>
				<label for=brand_id class="col-sm-2 control-label">开始时间 ※</label>
				<div class=col-sm-10>
					<input class=form-control name=time_create_min id="time_create_min" type=text placeholder="选择订单开始时间" value="<?php echo set_value('time_create_min', date('Y-m-d H:00'), time() - 59) ?>" required>
				</div>
			</div>
			<div class=form-group>
				<label for=brand_id class="col-sm-2 control-label">结束时间 ※</label>
				<div class=col-sm-10>
					<input class=form-control name=time_create_max id="time_create_max" type="text" placeholder="选择订单开始时间" value="<?php echo set_value('time_create_min',date('Y-m-d H:i')) ?>" required>
				</div>
			</div>
			<div class=form-group>
				<label for=brand_id class="col-sm-2 control-label">商品id</label>
				<div class="col-sm-10">
					<input class=form-control name="item_id" type=number maxlength="11" value="<?php echo set_value('item_id') ?>" placeholder="商品id">
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
<script src="<?php echo BASE_URL ?>/js/jquery.datetimepicker.full.min.js"></script>
<script>
	$("#time_create_min").datetimepicker({
		format: 'Y-m-d H:i',
		step:10
	});
	$("#time_create_max").datetimepicker({
		format: 'Y-m-d H:i',
		step:10
	});
</script>
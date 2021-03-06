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

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<table class="table table-striped table-condensed table-responsive">
		<thead>
			<tr>
				<th><?php echo $this->class_name_cn ?>ID</th>
				<?php
					$thead = array_values($data_to_display);
					foreach ($thead as $th):
						echo '<th>' .$th. '</th>';
					endforeach;
				?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($items as $item): ?>
			<tr>
				<td><?php echo $item[$this->id_name] ?></td>
				<?php
					$tr = array_keys($data_to_display);
					foreach ($tr as $td):
						echo '<td>' .$item[$td]. '</td>';
					endforeach;
				?>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<div class="alert alert-warning" role=alert>
		<p>订单的应支付金额将减去您输入的折扣金额，确定要改价？</p>
	</div>

    <?php
    if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
    $attributes = array('class' => 'form-'.$this->class_name.'-'.$op_name.' form-horizontal', 'role' => 'form');
    echo form_open($this->class_name.'/'.$op_name, $attributes);
    ?>
    <fieldset>
        <input name=ids type=hidden value="<?php echo $ids ?>">

            <div class=form-group>
                <label for=note_stuff class="col-sm-2 control-label">备注</label>
                <div class=col-sm-10>
                    <textarea class=form-control name=note_stuff row=5 placeholder="如有必要，可备注改价原因，最多255个字符"><?php echo $item['note_stuff'] ?></textarea>
                </div>
            </div>

			<div class=form-group>
				<label for=discount_reprice class="col-sm-2 control-label">改价折扣金额</label>
				<div class=col-sm-10>
					<input class=form-control name=discount_reprice type=number step=0.01 min=0.01 max=99999.99 placeholder="请输入需要折抵的金额" autofocus required>
                    <p class="help-block">若订单待支付金额为100元，此处输入10元，则待支付金额将变更为90元（即100-10）。</p>
				</div>
			</div>

            <!--
            <div class=form-group>
                <label for=password class="col-sm-2 control-label">密码</label>
                <div class=col-sm-10>
                    <input class=form-control name=password type=password placeholder="请输入您的登录密码" autofocus required>
                </div>
            </div>
            -->
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-warning btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>

	</form>
</div>
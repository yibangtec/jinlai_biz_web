<style>
	section {background-color:#fff;margin-top:20px;border-radius:20px;overflow:hidden;}
		section li {overflow:hidden;border-right:2px solid #efefef;text-align:center;}
			section li img {width:60px;height:60px;margin:0 auto 18px;}
			section li>a {display:block;width:100%;height:100%;line-height:1;}
		span.count:before {content:"(";}
		span.count:after {content:")";}

	#biz-info {text-align:center;padding:60px 0 70px;position:relative;}
		#biz-status {color:#9fa0a0;position:absolute;top:30px;right:30px;}
		#biz-logo {background-color:#fff;width:150px;height:150px;border:2px solid #efefef;border-radius:50%;display:table-cell;vertical-align:middle;overflow:hidden;}
		#biz-info h2 {font-size:30px;margin:30px 0;}
		#biz-info p {font-size:26px;line-height:1;margin:0;}

	#frequent-list {padding:45px 0;}
		#frequent-list li:nth-child(4n+0) {border-right:0;}

	#function-list {margin-bottom:60px;}
		#function-list li {margin-top:-2px;border-top:2px solid #efefef;}
			#function-list li:nth-child(3n+0) {border-right:0;}
		#function-list a {padding:45px 0 50px;}

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

<div id=content class=container>
	<?php if ( empty($this->session->biz_id) ): ?>
	<div id=recruiting-tempt>
		<p class=help-block>这一部分将展示简单的平台介绍和招商信息，例如：</p>
		<section>
			<figure>
				<img alt="进来商家招商中" src="<?php echo base_url('/media/home/recruiting.jpg') ?>">
			</figure>
			<p class="text-center">加入「进来」，让首家品控网购平台上最有消费能力的消费者在你店里疯狂买买买！</p>
		</section>
	</div>

	<div id=prerequisite class=well>
		<p class=helper-block>准备好以下材料即可开始入驻申请：</p>
		<ul>
			<li>营业执照影印件（彩色原件的扫描件或数码照，下同）</li>
			<li>法人身份证影印件</li>
			<li>对公银行账户（基本户、一般户均可）</li>
		</ul>

		<p>如果负责日常业务对接的不是法人本人，则另需：</p>
		<ul>
			<li>经办人身份证影印件</li>
			<li>授权书 <small><a title="进来商城经办人授权书" href="<?php echo base_url('article/auth-doc-for-join-application') ?>" target=_blank><i class="fa fa-info-circle" aria-hidden=true></i> 授权书示例</a></small></li>
		</ul>
	</div>

	<a title="创建商家" class="btn btn-primary btn-block btn-lg" href="<?php echo base_url('biz/create') ?>">准备好了</a>

	<?php elseif ( empty($biz) ): ?>
	<p>员工关系状态异常，请尝试重新登录</p>
	<a class="btn btn-primary btn-block btn-lg" href="<?php echo base_url('logout') ?>">重新登录</a>

	<?php else: ?>
	<section id=biz-info>
		<span id=biz-status><i class="fa fa-info-circle" aria-hidden=true></i> <?php echo $biz['status'] ?></span>

		<a title="商家详情" href="<?php echo base_url('biz/detail?id='.$this->session->biz_id) ?>">
			<?php if ( ! empty($biz['url_logo']) ): ?>
			<figure id=biz-logo>
				<img src="<?php echo MEDIA_URL.'biz/'.$biz['url_logo'] ?>">
			</figure>
			<?php endif ?>

			<h2><?php echo $biz['brief_name'] ?></h2>
			<p><?php echo $biz['tel_public'] ?></p>
		</a>
	</section>

		<?php if ($biz['status'] !== '冻结'): ?>
	<!--
	<section id=order-status>
		<ul class=row>
			<li class="col-xs-4 col-md-2">
				<a title="待付款" href="<?php echo base_url('order?status=待付款') ?>">待付款</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="待确认" href="<?php echo base_url('order?status=待接单') ?>">待接单</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="待发货" href="<?php echo base_url('order?status=待发货') ?>">待发货</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="待收货" href="<?php echo base_url('order?status=待收货') ?>">待收货</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="待评价" href="<?php echo base_url('order?status=待评价') ?>">待评价</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="已完成" href="<?php echo base_url('order?status=待评价') ?>">待评价</a>
			</li>
		</ul>
	</section>
	-->
	<section id=frequent-list>
		<ul class=row>
			<li class="col-xs-3 col-md-2">
				<a title="待接单订单" href="<?php echo base_url('order?status=待接单') ?>">
					<img src="/media/home/daijiedan@3x.png">
					待接单<span class=count><?php echo $count['order'] ?></span>
				</a>
			</li>
			<li class="col-xs-3 col-md-2">
				<a title="待发货订单" href="<?php echo base_url('order?status=待发货') ?>">
					<img src="/media/home/daifahuo@3x.png">
					待发货<span class=count><?php echo $count['order'] ?></span>
				</a>
			</li>
			<li class="col-xs-3 col-md-2">
				<img src="/media/home/shouhou@3x.png">
				<a title="退款处理" href="<?php echo base_url('refund') ?>">退款/售后</a>
			</li>
			<li class="col-xs-3 col-md-2">
				<img src="/media/home/pingjia@3x.png">
				<a title="商品评价" href="<?php echo base_url('comment_item') ?>">商品评价</a>
			</li>
		</ul>
	</section>

	<section id=function-list>
		<ul class=row>
			<li class="col-xs-4 col-md-2">
				<a title="商品管理" href="<?php echo base_url('item') ?>">
					<img src="/media/home/shangpin@3x.png">
					商品<span class=count><?php echo $count['item'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="店内分类" href="<?php echo base_url('item_category_biz') ?>">
					<img src="/media/home/fenlei@3x.png">
					分类<span class=count><?php echo $count['item_category_biz'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="团队管理" href="<?php echo base_url('stuff') ?>">
					<img src="/media/home/tuandui@3x.png">
					团队<span class=count><?php echo $count['stuff'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="门店管理" href="<?php echo base_url('branch') ?>">
					<img src="/media/home/mendian@3x.png">
					门店/仓库<span class=count><?php echo $count['branch'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="平台活动" href="<?php echo base_url('promotion') ?>">
					<img src="/media/home/huodong-platform@3x.png">
					平台活动<span class=count><?php echo $count['promotion'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="店内活动" href="<?php echo base_url('promotion_biz') ?>">
					<img src="/media/home/huodong-biz@3x.png">
					店内活动<span class=count><?php echo $count['promotion_biz'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="运费模板" href="<?php echo base_url('freight_template_biz') ?>">
					<img src="/media/home/moban@3x.png">
					运费模板<span class=count><?php echo $count['freight_template_biz'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="优惠券" href="<?php echo base_url('coupon_template') ?>">
					<img src="/media/home/coupon@3x.png">
					优惠券<span class=count><?php echo $count['coupon_template'] ?></span>
				</a>
			</li>
			<li class="col-xs-4 col-md-2">
				<a title="优惠券包" href="<?php echo base_url('coupon_combo') ?>">
					<img src="/media/home/combo@3x.png">
					优惠券包<span class=count><?php echo $count['coupon_combo'] ?></span>
				</a>
			</li>
		</ul>
	</section>
		<?php endif //if ($biz['status'] !== '冻结'): ?>

	<?php endif ?>
</div>
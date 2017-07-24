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

<div id=content class=container>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<p class="bg-info text-info text-center">必填项以“※”符号标示；部分需通过品类管理员修改的信息以“✪”符号标示</p>

		<fieldset>
			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">
			
			<div class=form-group>
				<label for=tel_protected_biz class="col-sm-2 control-label">商务联系手机号✪</label>
				<div class=col-sm-10>
					<p class="form-control-static">
						<?php echo $this->session->mobile ?>
					</p>
				</div>
			</div>
			<div class=form-group>
				<label for=name class="col-sm-2 control-label">商家名称✪</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo $item['name'] ?></p>
				</div>
			</div>
			<div class=form-group>
				<label for=brief_name class="col-sm-2 control-label">简称✪</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo $item['brief_name'] ?></p>
				</div>
			</div>
			<div class=form-group>
				<label for=url_name class="col-sm-2 control-label">店铺域名✪</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo !empty($item['url_name'])? $item['url_name']: '未设置' ?></p>
				</div>
			</div>

			<div class=form-group>
				<label for=url_logo class="col-sm-2 control-label">LOGO</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_main']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_logo'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<p class=help-block>请上传大小在2M以内，边长不超过2048px的jpg/png图片</p>
						<?php $name_to_upload = 'url_logo' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-primary btn-lg col-xs-12 col-md-3" data-target-dir="biz/logo" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=slogan class="col-sm-2 control-label">宣传语</label>
				<div class=col-sm-10>
					<input class=form-control name=slogan type=text value="<?php echo $item['slogan'] ?>" placeholder="宣传语">
				</div>
			</div>
			<div class=form-group>
				<label for=description class="col-sm-2 control-label">简介</label>
				<div class=col-sm-10>
					<textarea class=form-control name=description rows=5 placeholder="最多200个字符"><?php echo $item['description'] ?></textarea>
				</div>
			</div>
			<div class=form-group>
				<label for=notification class="col-sm-2 control-label">店铺公告</label>
				<div class=col-sm-10>
					<textarea class=form-control name=description rows=5 placeholder="最多100个字符"><?php echo $item['notification'] ?></textarea>
				</div>
			</div>

			<div class=form-group>
				<label for=tel_public class="col-sm-2 control-label">消费者服务电话※</label>
				<div class=col-sm-10>
					<p class=helper-block>即消费者可以联系到商家的电话号码</p>
					<input class=form-control name=tel_public type=tel value="<?php echo $item['tel_public'] ?>" placeholder="400/800、手机号、带区号的固定电话号码均可" required>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>资质信息</legend>

			<div class=form-group>
				<label for=code_license class="col-sm-2 control-label">统一社会信用代码</label>
				<div class=col-sm-10>
					<input class=form-control name=code_license type=number step=1 size=18 value="<?php echo $item['code_license'] ?>" placeholder="统一社会信用代码" required>
				</div>
			</div>
			<div class=form-group>
				<label for=code_ssn_owner class="col-sm-2 control-label">法人身份证号</label>
				<div class=col-sm-10>
					<input class=form-control name=code_ssn_owner type=text value="<?php echo $item['code_ssn_owner'] ?>" placeholder="法人身份证号" required>
				</div>
			</div>
			<div class=form-group>
				<label for=code_ssn_auth class="col-sm-2 control-label">经办人身份证号</label>
				<div class=col-sm-10>
					<input class=form-control name=code_ssn_auth type=text value="<?php echo $item['code_ssn_auth'] ?>" placeholder="经办人身份证号">
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>资质及授权证明</legend>
			<p class=helper-block>以下资料需要彩色原件的扫描件或数码照</p>

			<div class=form-group>
				<label for=url_image_license class="col-sm-2 control-label">营业执照</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_license']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_license'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<p class=help-block>请上传大小在2M以内，边长不超过2048px的jpg/png图片</p>
						<?php $name_to_upload = 'url_image_license' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>" required>

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/license" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=url_image_owner_id class="col-sm-2 control-label">法人身份证</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_owner_id']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_owner_id'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<?php $name_to_upload = 'url_image_owner_id' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>" required>

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/owner_id" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=url_image_auth_id class="col-sm-2 control-label">经办人身份证</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_auth_id']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_auth_id'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<?php $name_to_upload = 'url_image_auth_id' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/auth_id" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=url_image_auth_doc class="col-sm-2 control-label">授权书</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_auth_doc']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_auth_doc'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<?php $name_to_upload = 'url_image_auth_doc' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/auth_doc" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>财务信息</legend>

			<div class=form-group>
				<label for=bank_name class="col-sm-2 control-label">对公账户开户行</label>
				<div class=col-sm-10>
					<input class=form-control name=bank_name type=text value="<?php echo $item['bank_name'] ?>" placeholder="基本户、一般户均可">
				</div>
			</div>
			<div class=form-group>
				<label for=bank_account class="col-sm-2 control-label">对公账户账号</label>
				<div class=col-sm-10>
					<input class=form-control name=bank_account type=number step=1 value="<?php echo $item['bank_account'] ?>" placeholder="基本户、一般户均可">
				</div>
			</div>
			<div class=form-group>
				<label for=tel_protected_fiscal class="col-sm-2 control-label">财务联系手机号</label>
				<div class=col-sm-10>
					<input class=form-control name=tel_protected_fiscal type=tel size=11 value="<?php echo $item['tel_protected_fiscal'] ?>" placeholder="财务联系手机号">
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>形象展示</legend>
			<p class=helper-block>您可根据自身情况提供合适的照片，向消费者展现企业形象</p>

			<div class=form-group>
				<label for=url_image_product class="col-sm-2 control-label">产品</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_product']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_product'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<p class=help-block>最多可上传4张</p>
						<?php $name_to_upload = 'url_image_product' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/product" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=url_image_produce class="col-sm-2 control-label">工厂/产地</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_produce']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_produce'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<?php $name_to_upload = 'url_image_produce' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/produce" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>

			<div class=form-group>
				<label for=url_image_retail class="col-sm-2 control-label">门店/柜台</label>
				<div class=col-sm-10>
					<?php if ( !empty($item['url_image_retail']) ): ?>
					<div class=row>
						<figure class="col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo $item['url_image_retail'] ?>">
						</figure>
					</div>
					<?php endif ?>

					<div>
						<?php $name_to_upload = 'url_image_retail' ?>
					
						<input id=<?php echo $name_to_upload ?> class=form-control type=file>
						<input name=<?php echo $name_to_upload ?> type=hidden value="<?php echo $item[$name_to_upload] ?>">

						<button class="file-upload btn btn-default btn-lg col-xs-12 col-md-3" data-target-dir="biz/retail" data-selector-id=<?php echo $name_to_upload ?> data-input-name=<?php echo $name_to_upload ?> type=button><i class="fa fa-upload" aria-hidden=true></i> 上传</button>

						<ul class="upload_preview list-inline row"></ul>
					</div>

				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>物流信息</legend>
			
			<div class=form-group>
				<label for=tel_protected_order class="col-sm-2 control-label">订单通知手机号</label>
				<div class=col-sm-10>
					<input class=form-control name=tel_protected_order type=tel size=11 value="<?php echo $item['tel_protected_order'] ?>" placeholder="订单通知手机号">
				</div>
			</div>
			<div class=form-group>
				<label for=min_order_subtotal class="col-sm-2 control-label">最低小计金额（元）</label>
				<div class=col-sm-10>
					<input class=form-control name=min_order_subtotal type=number step=0.01 min=1 max=99999.99 value="<?php echo $item['min_order_subtotal'] ?>" placeholder="最低小计金额（元）">
				</div>
			</div>
			<div class=form-group>
				<label for=delivery_time_start class="col-sm-2 control-label">配送起始时间（时）</label>
				<div class=col-sm-10>
					<input class=form-control name=delivery_time_start type=number step=1 min=0 max=22 value="<?php echo $item['delivery_time_start'] ?>" placeholder="24小时制，例如上午8时请填写“8”">
				</div>
			</div>
			<div class=form-group>
				<label for=delivery_time_end class="col-sm-2 control-label">配送结束时间（时）</label>
				<div class=col-sm-10>
					<input class=form-control name=delivery_time_end type=number step=1 min=1 max=23 value="<?php echo $item['delivery_time_end'] ?>" placeholder="24小时制，例如下午10时请填写“22”">
				</div>
			</div>
			<div class=form-group>
				<label for=country class="col-sm-2 control-label">国家</label>
				<div class=col-sm-10>
					<p class="form-control-static"><?php echo $item['country'] ?></p>
				</div>
			</div>
			<div class=form-group>
				<label for=province class="col-sm-2 control-label">省</label>
				<div class=col-sm-10>
					<input class=form-control name=province type=text value="<?php echo $item['province'] ?>" placeholder="省">
				</div>
			</div>
			<div class=form-group>
				<label for=city class="col-sm-2 control-label">市</label>
				<div class=col-sm-10>
					<input class=form-control name=city type=text value="<?php echo $item['city'] ?>" placeholder="市">
				</div>
			</div>
			<div class=form-group>
				<label for=county class="col-sm-2 control-label">区/县</label>
				<div class=col-sm-10>
					<input class=form-control name=county type=text value="<?php echo $item['county'] ?>" placeholder="区">
				</div>
			</div>

			<div class=form-group>
				<label for=detail class="col-sm-2 control-label">详细地址</label>
				<div class=col-sm-10>
					<input class=form-control name=detail type=text value="<?php echo $item['detail'] ?>" placeholder="详细地址">
				</div>
			</div>

			<div class=form-group>
				<figure class="col-sm-10 col-sm-offset-2">
					<figcaption>
						<p class="bg-info text-info text-center">您可拖动地图完善位置信息</p>
						<div id="tip"></div>
					</figcaption>
					<div id=map class="col-xs-12" style="height:300px;background-color:#aaa"></div>
				</figure>
				<input name=longitude type=hidden value="<?php echo $item['longitude'] ?>">
				<input name=latitude type=hidden value="<?php echo $item['latitude'] ?>">
			</div>

			<script src="https://webapi.amap.com/maps?v=1.3&key=d698fd0ab2d88ad11f4c6a2c0e83f6a8"></script>
			<script src="https://webapi.amap.com/ui/1.0/main.js"></script>
			<script>
			    var map = new AMap.Map('map',{
					<?php if ( !empty($item['longitude']) && !empty($item['latitude']) ): ?>
					center: [<?php echo $item['longitude'] ?>, <?php echo $item['latitude'] ?>],
					<?php endif ?>
					zoom: 16,
		            scrollWheel: false,
					mapStyle: 'amap://styles/2daddd87cfd0fa58d0bc932eed31b9d8', // 自定义样式，通过高德地图控制台管理
			    });

				<?php if ( empty($item['longitude']) || empty($item['latitude']) ): ?>
				// 若未设置过经纬度信息，默认获取并定位到当前位置
				map.plugin('AMap.Geolocation', function() {
			        var geolocation = new AMap.Geolocation({
			            enableHighAccuracy: true,//是否使用高精度定位，默认:true
			            timeout: 10000,          //超过10秒后停止定位，默认：无穷大
			            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
			            zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
			            buttonPosition:'RB'
			        });
			        map.addControl(geolocation);
			        geolocation.getCurrentPosition();
			        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
			        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
			    });
			    //解析定位结果
			    function onComplete(data)
				{
					// 提示用户确定修改
					var user_confirm = confirm("是否修改位置为图中地点");
				    if (user_confirm == true)
				    {
						document.getElementsByName('longitude')[0].value = data.position.getLng();
						document.getElementsByName('latitude')[0].value = data.position.getLat();
					}
			    }
				//解析定位错误信息
			    function onError(data)
				{
			        alert('定位失败');
			    }
				<?php endif ?>

				// 为BasicControl设置DomLibrary，jQuery
				AMapUI.setDomLibrary($);
				AMapUI.loadUI(['control/BasicControl', 'misc/PositionPicker'], function(BasicControl, PositionPicker) {
					// 缩放控件
				    map.addControl(new BasicControl.Zoom({
				        position: 'rb', // 右下角
				    }));

				    var positionPicker = new PositionPicker({
				        mode: 'dragMap',//设定为拖拽地图模式，可选'dragMap'、'dragMarker'，默认为'dragMap'
				        map: map//依赖地图对象
				    });

				    // 获取定位点经纬度并写入相应字段
					positionPicker.on('success', function(positionResult){
						// 忽略首次拖拽选址（即防止页面载入时提示修改定位点）
						if (times_picked != 0){
							// 提示用户确定修改
							var user_confirm = confirm("是否修改位置为图中地点");
						    if (user_confirm == true)
						    {
								document.getElementsByName('longitude')[0].value = positionResult.position.lng;
								document.getElementsByName('latitude')[0].value = positionResult.position.lat;
							}
						}

						times_picked++;
					});
					positionPicker.on('fail', function(positionResult) {
					    // 海上或海外无法获得地址信息
					    document.getElementsByName('longitude')[0].value = '';
					    document.getElementsByName('latitude')[0].value = '';
					});

					// 忽略首次拖拽选址（即防止页面载入时提示修改定位点）
			    	times_picked = 0;

			        positionPicker.start();
			        //map.panBy(0, 1);

					// 根据详细地址获取经纬度
					document.getElementsByName('detail')[0].onchange =
						function(){
							// 忽略首次拖拽选址（即防止页面载入时提示修改定位点）
							times_picked = 0;

							var address_text =
								document.getElementsByName('province')[0].value +
								document.getElementsByName('city')[0].value +
								document.getElementsByName('county')[0].value +
								document.getElementsByName('detail')[0].value;
							address_to_lnglat(address_text);
						};

					function address_to_lnglat(address_text) {

						AMap.service('AMap.Geocoder',function(){//回调函数
					        var geocoder = new AMap.Geocoder({
					            radius: 1000 //范围，默认：500
					        });

					        // 返回经纬度，并将地图中心重置
							geocoder.getLocation(address_text, function(status, result){
							    if (status === 'complete' && result.info === 'OK') {
									console.log(result.geocodes[0].formattedAddress);
									document.getElementsByName('longitude')[0].value = result.geocodes[0].location.lng;
									document.getElementsByName('latitude')[0].value = result.geocodes[0].location.lat;
									//map.setFitView();
									map.setCenter(
										[result.geocodes[0].location.lng, result.geocodes[0].location.lat]
									);
							    }
							});
						});
						
				    }
				});
			</script>
		</fieldset>

		<fieldset>
			<legend>更多……</legend>
			
			<div class=form-group>
				<label for=url_web class="col-sm-2 control-label">官方网站</label>
				<div class=col-sm-10>
					<input class=form-control name=url_web type=text value="<?php echo $item['url_web'] ?>" placeholder="官方网站">
				</div>
			</div>
			<div class=form-group>
				<label for=url_weibo class="col-sm-2 control-label">官方微博</label>
				<div class=col-sm-10>
					<input class=form-control name=url_weibo type=text value="<?php echo $item['url_weibo'] ?>" placeholder="官方微博">
				</div>
			</div>
			<div class=form-group>
				<label for=url_wechat class="col-sm-2 control-label">微信二维码</label>
				<div class=col-sm-10>
					<input class=form-control name=url_wechat type=text value="<?php echo $item['url_wechat'] ?>" placeholder="服务号、订阅号、个人号均可">
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
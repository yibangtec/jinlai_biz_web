$(function(){
	/*
	 * 获取通过attr属性传入的参数
	 */
	function get_attr(attr_name)
	{
		var data_name = 'data-' + attr_name; // 完整属性名
        var attr_carrier = $('script['+ data_name + ']').eq(0); // 使用eq方法获取jQuery对象，以使用attr方法
        var attr_value = attr_carrier.attr(data_name);

        console.log(attr_carrier);
        console.log(attr_value);

        return attr_value;
	}

	// 是否需要验证图片验证码
	var captcha_assess = get_attr('captcha_assess');
    //console.log(captcha_assess);

	// 图片验证码URL
	var url_captcha = 'https://biz.517ybang.com/captcha?';

	// 短信验证码URL
	var url_sms = 'https://api.517ybang.com/sms/create';

	// 清空cookie中的sms_id记录
	Cookies.remove('sms_id');

	// 更新图片验证码
	$('#captcha-image img').click(function(){
		// 获取当前时间戳以确保重新生成验证码图片
		var timestamp = Date.parse(new Date()) / 1000;
		$(this).attr('src', url_captcha + timestamp);
        $('[name=captcha_verify]').val('').focus(); // 重置图片验证码输入框

		//console.log('captcha regenerated');
	});

    /**
	 * 检查图片验证码格式
     * @param captcha_verify 需要检查的图片验证码内容
     * @returns {boolean}
     */
	function check_verify_captcha(captcha_verify) {
        //console.log('checking captcha');

        if (captcha_verify.length != 4 || isNaN(captcha_verify))
        {
            alert('请正确填写图片验证码');
            $('[name=captcha_verify]').val('').focus(); // 重置图片验证码输入框
            return false;
        } else {
        	return true;
		}
    }

	/**
	 * 检查手机号格式
	 *
	 * @param string mobile 需要接收短信的手机号
	 * @returns {boolean}
	 */
	function check_mobile(mobile)
	{
		console.log('checking mobile');

		// 检查字符串长度是否有效
		function is_valid_length()
		{
            if (mobile.length != 11)
            {
                console.log('not exactly 11 characters');
                return false;
            } else {
                return true;
            }
		}

		// 检查第一个字符是否为1
		function start_with_one()
		{
            var first_char = mobile.substring(0, 1);
            if (first_char != 1)
            {
                console.log('not start with "1"');
                return false;
            } else {
                return true;
            }
		}

        // 检查是否为数字
        function is_number()
        {
            if (isNaN(mobile))
            {
                console.log('NaN');
                return false;
            } else {
                return true;
            }
        }

        // TODO 号段检查

        if (is_valid_length() && start_with_one() && is_number())
        {
            $('a#sms-send').removeAttr('disabled'); // 重置发送按钮
        }
        else
		{
            alert('请填写有效手机号');
            $('[name=mobile]').val('').focus(); // 重置手机号输入框
            return false;
		}
	}

	// 点击短信发送按钮后的业务流程
	var handler = function(){
		// 检查图片验证码是否已填写
		if (captcha_assess == true)
		{
            console.log('captcha to be checked');
            var captcha_verify = $.trim( $('[name=captcha_verify]').val() );
            if (check_verify_captcha(captcha_verify) == false)
            {
                return false;
            }
		}

		// 获取当前时间戳及日期（日）
		var timestamp = Date.parse(new Date()) / 1000;
		var today = new Date();
		today = today.getDate();
		// 检查当日是否已发送超过5条短信
		if (Cookies.get('sms_today') == today && Cookies.get('sms_today_sent') === 5)
 		{
 			alert('今天短信获取过多，请明天再试');
 			return false;
 		}
 		if ((timestamp - Cookies.get('sms_last_sent')) < 59)
 		{
 			alert('短信发送过于频繁，请稍候再试');
 			return false;
 		}

		// 获取mobile字段值，验证该字段是否为有效手机号，设置sms_send按钮为不可用状态
		var mobile = $.trim( $('[name=mobile]').val() );
		if (check_mobile(mobile) == false)
		{
			return false;
		}

		var params = {
			'app_type' : 'client',
			'platform' : 'web',
			'mobile' : mobile,
			'captcha_verify' : captcha_verify
		};

		// 尝试发送短信并获取发送状态
		$.post(
			url_sms, // API URL
			params, // API参数
	        function(data){
				api_callback(data);
	        }, // 对返回数据进行处理
			"json" // 对返回数据以JSON格式进行解析
		); 
		return false;
	}
	
	// 发送验证码短信
	$('a#sms-send').click(handler);

	// 对API返回数据进行处理
	function api_callback(data)
	{
		if (data.status == 200) // 若成功，激活并将焦点移到captcha字段，激活确认按钮
		{
			alert(data.content.message);

			// 记录短信ID并赋值到相应字段
			Cookies.set('sms_id', data.content.id);
			$('[name=sms_id]').val(data.content.id);

			var timestamp = Date.parse(new Date()) / 1000;
			// 记录最后成功发送短信时间、本日日期，以及本日已发短信数
			Cookies.set('sms_last_sent', timestamp);
			var today = new Date();
			today = today.getDate();
			if (Cookies.get('sms_today') != today)
			{
				Cookies.set('sms_today', today);
				Cookies.set('sms_today_sent', 1);
			} else {
				Cookies.set('sms_today_sent', Cookies.get('sms_today_sent') + 1);
			}

			// 倒计时60秒后重新激活发送按钮
			$('a#sms-send').unbind('click').text('60');
		    var interval_id = setInterval(countdown, 1000);
			// 倒计时并更新短信发送按钮HTML
			function countdown()
			{
				var current_second = $('a#sms-send').text();
				console.log('from '+current_second+' to');
				if (current_second < 1)
				{
					clearInterval(interval_id);
					$('a#sms-send').text('获取验证码').bind('click', handler);
				} else {
					current_second = current_second - 1;
					$('a#sms-send').text(current_second);
				}
			}

			$('[name=captcha],button[type=submit]').removeAttr('disabled');
			$('[name=captcha]').focus();
		}
		else // 若失败，提示
		{
			alert(data.content.error.message);
		}
	}

});

// 验证数字格式
function validate_number(value, allow_zero, allow_minus)
{
    // 转换为数字格式
    value = parseFloat(value);

    // 默认允许为0
    var allow_zero = allow_zero || 'yes';

    // 默认不允许为负数
    var allow_minus = allow_minus || 'no';

    // 初始化返回结果
    var result = true;

    // 检查是否为数字
    if (value.toString() === 'NaN')
    {
        console.log('不是数字');
        result = false;
    }

    // 检查是否为0
    if (result === true && allow_zero === 'no' && value === 0)
    {
        console.log('不应为0');
        result = false;
    }

    // 检查是否为负数
    if (result === true && allow_minus === 'no' && value < 0)
    {
        console.log('不应为负数');
        result = false;
    }

    return result;
} // end validate_number
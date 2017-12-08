/* 详情页通用JavaScript */

$(function(){
    // 根据菜单项数量调整各菜单项宽度
    action_menu();
    function action_menu()
    {
        var actions = $('#item-actions>li');
        var action_count = actions.length;
        var percentage = 1 / action_count * 100;
        console.log(percentage);

        actions.css('width', percentage + '%');
    } // end action_menu

    // 生成二维码
    function qrcode_generate(string, dom_id)
    {
        var dom_id = '#' + (dom_id || 'qrcode');
        // 创建二维码并转换为图片格式，以使微信能识别该二维码
        $(dom_id).qrcode(string);

        // 将canvas转换为Base64格式的图片内容
        function convertCanvasToImage(canvas)
        {
            // 新Image对象，可以理解为DOM
            var image = new Image();
            // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
            // 指定格式 PNG
            image.src = canvas.toDataURL("image/png");
            return image;
        }

        // 获取网页中的canvas对象
        var mycanvas = document.getElementsByTagName('canvas')[0];

        // 将转换后的img标签插入到html中
        var img = convertCanvasToImage(mycanvas);
        $(dom_id).append(img);
        $(dom_id + ' canvas').remove(); // 移除canvas格式的二维码
    }
});
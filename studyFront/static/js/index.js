/**
 * Created by xwk on 2017/4/12.
 */
$(function () {

    //搜索
    $('.search_mh').keyup(function(){
        if($(this).val()!=''){
            $.ajax({
                url:'http://localhost:80/studyApi/PhalApi/Public/?service=Course.searchCourse',
                type:'get',
                data:{'key':$(this).val()},
                success:function(data){
                    $('.search_pp ul li').remove();

                    var d=data.data;
                    for(var i=0;i<d.length;i++){
                        var href="http://localhost/studyFront/dist/about.html?c_no="+d[i].c_no;
                        var li=$('<li><a href='+href+'>'+d[i].c_name+'</a></li>');
                        $('.search_pp ul').append(li);
                    }
                    $('.search_pp').show();
                }
            });
        }else {
            $('.search_pp').hide();
            $('.search_pp ul li').remove();
        }
    });



    //navbar 按钮
    var toggleFlag;
    $('.toggleButton').click(function () {
        if ($(this).find('span').attr('class').indexOf('sh') != -1) {
            toggleFlag = 'cha';
            $(this).find('span').removeClass('sh').addClass('cha');
            $(this).css('right', '229px');
            $('#header .navbar-default .navbar-nav').css('width', '215px');
            setTimeout(function () {
                $(' #header .search_hid').show()
            }, 400)
        } else {
            toggleFlag = 'shu';
            $(this).find('span').removeClass('cha').addClass('sh')
            $(this).css('right', '32px');
            $('#header .navbar-default .navbar-nav').css('width', '0');
            $(' #header .search_hid').hide();
        }
    });

    //是否显示隐藏注册登录按钮
    var user = sessionStorage.getItem('user');
    var tx_url = '';
    if (user) {
        user = JSON.parse(user);
        $('.navbar-nav').hide();
        $('.toggleButton').hide();
        if (user.tx_url == null) {
            tx_url = 'http://localhost/studyApi/PhalApi/upload/wtu/2017/03/21/1490067030.jpg';
        } else {
            tx_url = user.tx_url;
        }
        $('.userinfo').find('img').attr('src', tx_url);
        $('.userinfo').find('span').html(user.name);

        //学生身份不显示该入口
        if(user.role==3){  //显示教师入口
            $('.teacher_course').show();
            $('.teacher_course_a').click(function(){
                window.location.href='http://localhost/studyFront/dist/teacher.html';
            });
        }else if(user.role==2){  ////显示学生入口
            $('.student_course').show();
        }
        else {
            $('.teacher_course').hide();
        }

    } else {
        $('.basic_sign').hide();
        $('.search_input').hide();
        $('.search').hide();
        $('#header .head_wrap .right').css('display','none');

    }
    //下拉菜单
    $('.userinfo').click(function () {
        $('.dropMenu').slideToggle();
    });

    //退出登录
    $('.exit').click(function () {
        sessionStorage.removeItem('user');
        window.location.reload();
    });

    //上传头像
    $('.upload-tx').click(function () {
        var fd = new FormData($("#uploadForm")[0]);
        $.ajax(
            {
                type: 'POST',
                url: 'http://localhost:80/studyApi/PhalApi/Public/?service=User.uploadTx&name=' + user.name,
                data: fd ,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data['data'] != 0) {
                        var user = sessionStorage.getItem('user');
                        user = JSON.parse(user);
                        user.tx_url = data['data'];
                        sessionStorage.setItem('user', JSON.stringify(user));
                        $('.userinfo img').attr('src',data['data']);
                    }
                },
                error: function () {
                    alert('ajax error');
                }
            }
        );
        $('#myTx').modal('hide')
    });


    //检测浏览器窗口变化
    $(window).resize(function () {
        if ($(window).width() <= 768) {
            $('#header .search_input').css('display', 'list-item');
//                 $('#header .navbar-default .navbar-nav').css('width','0');
            if (toggleFlag == 'cha') {
                $('#header .navbar-default .navbar-nav').css('width', '215px');
                $('.toggleButton').css('right', '229px');
            }
            else {
                $('#header .navbar-default .navbar-nav').css('width', '0');
                $('.toggleButton').css('right', '32px');
            }

        }
        else {
            $('#header .navbar-default .navbar-nav').css('width', '385px');
            $('.toggleButton').css('right', '229px');
            $(' #header .search_hid').hide();
        }
    });
})
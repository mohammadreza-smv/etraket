const app_url=document.querySelector('meta[name="app_url"]').getAttribute('content');
const site_url=app_url+'/';
$(document).ready(function () {
    $("#catBox").click(function (event) {
        const width=$(window).width();
        const clientX=parseInt(event.clientX);
        if((width-clientX)>270)
        {
            document.getElementById('mySideNav').style.right='-270px';
            setTimeout(function () {
                $("#catBox").hide();
            },300);
        }
    });
    $('#mySideNav .child_cat').click(function () {
        $(this).parent().parent().find('li ul').hide();
        $(this).parent().parent().find('li a').find('.fa-minus-circle').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        if($(this).find('.fa').hasClass('fa-plus-circle'))
        {
            $(this).find('.fa').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $(this).parent().find('ul').show();
        }
        else {
            $(this).find('.fa').addClass('fa-plus-circle').removeClass('fa-minus-circle');
        }
    });
    $(document).on('click','.color_li',function () {
        const color_id=$(this).attr('data');
        const product_id=$("#product_id").val();
        change_color(color_id,product_id);
    });

    set_mobile_data_right_value();

    $(document).on('click','.mobile_data_box .header a',function () {
        set_mobile_data_right_value();
        $('body').css('overflow-y','auto');
    });
    $("#show_more_item_product").click(function () {
        $("#product_items").show();
        setTimeout(function () {
            $("#product_items").css('right','0px');
        },20);
        $('body').css('overflow-y','hidden');
    });
    $('.add_product_link').click(function () {
        $("#add_cart_form").submit();
    });
    $('.advanced_search_box').click(function () {
        $("#filter_box").show();
        setTimeout(function () {
            $("#filter_box").css('right','0px');
        },50);
        $('body').css('overflow-y','hidden');
    });
    $('.title_box').click(function () {
        const el=$(this).parent().find('.filter_box');
        if(el.css('display')=='none'){
            el.slideDown();
            $('.fa-plus-circle',this).removeClass('fa-plus-circle').addClass('fa-minus-circle');
        }
        else{
            el.slideUp();
            $('.fa-minus-circle',this).removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }
    });
    $('.sort_btn').click(function () {
        $("#sort_dialog_box").modal('show');
    });
    $('.item_slider').on('input',function () {

        const newValue=this.value;
        const left=(100 - (newValue)*25)+'%';
        $(this).parent().find('.rang_slider_div .active_rang_slider').css('left',left);

        const Array=['slider_step_two','slider_step_three','slider_step_four','slider_step_five','slider_step_six'];

        $(this).parent().find('.rang_slider_div .js-slider-step').removeClass('active_rang_step');
        for (let i=0;i<newValue;i++)
        {
            $(this).parent().find('.rang_slider_div .'+Array[i]).addClass('active_rang_step');
        }

        const title=$(this).parent().find('.rang_slider_div .'+Array[newValue]).attr('data-rate-title');
        $(this).parent().find('.rang_slider_div').attr('data-rate-title',title);
    });
    $(document).on('click','.score_comment_form .item_list  .fa-close',function () {
        $(this).parent().remove();
    });
    $("#comment_form").submit(function (event)
    {
        const comment_title=$("#comment_title").val();
        const comment_content=$("#comment_content").val();

        const check_title=check_comment_title(comment_title);

        const check_content=check_comment_content(comment_content);

        if (!check_title || !check_content)
        {
            event.preventDefault();
        }
    });
    $('.input_add_point input[type="text"]').keyup(function () {
        const value=$(this).val();
        if(value.trim().length>2)
        {
            $(this).parent().find('button').css('display','block');
        }
        else {
            $(this).parent().find('button').css('display','none');
        }
    });

    $('.input_add_point button').click(function () {
        const value=$(this).parent().find('input[type="text"]').val();
        const name=$(this).parent().find('input[type="text"]').attr('id');
        if(value.trim().length>2)
        {
            const html='<div><span>'+value+'</span>' +
                '<span class="fa fa-close"></span>' +
                '<input type="hidden" value="'+value+'" name="'+name+'[]">' +
                '</div>';
            $("#"+name+"_input_box").append(html);
            $(this).parent().find('input[type="text"]').val('');
            $(this).hide();
        }
    });


    const Legal_box=$("#Legal_box");
    if(Legal_box.length==1){
        const w=$(window).width();
        if(w<500){
            $('.form_cover').remove();
            $("#Legal_box").hide();
        }
        else {
            $("#Legal_title").show()
        }
    }

    $(".fa-share-alt").click(function () {
        $('#share_div').show();
        setTimeout(function () {
            document.getElementById('share_box').style.bottom='0px';
        },50);
    });
    $("#share_div").click(function (event) {
        const height=$(window).height();
        const clientY=parseInt(event.clientY);
        if((height-clientY)>280)
        {
            document.getElementById('share_box').style.bottom='-280px';
            setTimeout(function () {
                $("#share_div").hide();
            },300);
        }
    });
    $(document).on('change','#priceItem',function(){
        const  color_id=$(this).val();
        const product_id=$("#product_id").val();
        change_color(color_id,product_id,true);
    });
});

function change_color(color_id,product_id) {
    $.ajaxSetup(
        {
            'headers':{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
    const url=site_url+"site/change_color";
    $.ajax({
        url: url,
        type:"POST",
        data:"color_id="+color_id+"&product_id="+product_id,
        success:function (response) {
            if(response)
            {
                $("#warranty_box").html(response);
                $("#offers_time").click();
            }
        }
    });
}
function set_mobile_data_right_value() {
    const width=$(window).width();
    $(".mobile_data_box").css('right','-'+width+'px');
}
check_comment_title=function (title) {
    if(title.trim()==""){
        $("#comment_title_error_message").show().text('عنوان نظر را وارد نمایید');
        $("#comment_title").addClass('validate_error_border');
        return false;
    }
    else {
        $("#comment_title_error_message").hide();
        $("#comment_title").removeClass('validate_error_border');
        return true;
    }
};
check_comment_content=function (content) {
    if(content.trim().length==0){
        $("#comment_content_error_message").show().text('متن نظر را وارد نمایید');
        $("#comment_content").addClass('validate_error_border');
        return false;
    }
    else {
        $("#comment_content_error_message").hide();
        $("#comment_content").removeClass('validate_error_border');
        return true;
    }
};


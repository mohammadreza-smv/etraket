const app_url=document.querySelector('meta[name="app_url"]').getAttribute('content');
const site_url=app_url+'/';
let promo_single_count=0;
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $(".cat_item").mouseover(function () {
        const li_width=$(this).css('width');
        const ul_width=$(".index-cat-list ul").width();
        const a=li_width.replace('px','');
        const right=ul_width-$(this).offset().left-a+15;
        $('.cat_hover').css('width',li_width);
        $('.cat_hover').css('right',right);
        $('.cat_hover').css('transform','scaleX(1)');
        $('.li_div').hide();
        $('.li_div',this).show();
    });
    $('.index-cat-list').mouseleave(function () {
        $('.cat_hover').css('transform','scaleX(0)');
        $('.li_div').hide();
    });

    $(".discount_left_item div").click(function () {
        $(".discount_left_item div").removeClass('active');
        const id=$(this).attr('data-id');
        $('.discount-box-content .item').hide();
        $("#discount_box_link_"+id).show();
        $(this).addClass('active');
    });
    $(".discount_box_footer .slide-amazing").click(function () {
        const id=$(this).attr('data-id');
        $('.discount-box-content .item').hide();
        $("#discount_box_link_"+id).show();
        $(".discount_box_footer .slide-amazing").removeClass('active');
        $(this).addClass('active');
    });
    let discount_slider_count=0;
    let discount_slider_number=0;
    const discount_box_footer=$('.discount_box_footer').css('display');
    if(discount_box_footer=='none')
    {
        discount_slider_count=$('.discount_left_item div').length;
       const discount_slider=setInterval(function () {
           const discount_box_footer=$('.discount_box_footer').css('display');
           if(discount_box_footer=='none'){
               discount_slider_number++;
               $(".discount_left_item div").removeClass('active');
               $('.discount-box-content .item').hide();

               if(discount_slider_number>=discount_slider_count)
               {
                   discount_slider_number=0;
               }
               $("#item_number_"+discount_slider_number).addClass('active');
               const id=$("#item_number_"+discount_slider_number).attr('data-id');
               $("#discount_box_link_"+id).show();
           }
           else{
               clearInterval(discount_slider);
           }

        },5000);

    }

    $('.send_btn').hover(function () {
        $('.send_btn .line').addClass('line2');
    },function () {
        $('.send_btn .line').removeClass('line2');
    });
    $('.show_more_important_item').click(function () {
        const more_important_item=$('.more_important_item').css('display');
        if(more_important_item=='none')
        {
            $(".more_important_item").slideDown();
            $('.show_more_important_item').text('موارد کمتر');
            $('.show_more_important_item').addClass('minus_important_item');
        }
        else{
            $(".more_important_item").slideUp();
            $('.show_more_important_item').text('موارد بیشتر');
            $('.show_more_important_item').removeClass('minus_important_item');
        }
    });
    $('.shipping_data_box .header_box').click(function () {
        const el=$(this).parent().find('.ordering_product_list');
        const height=el.css('height');
        if(height=='0px')
        {
            el.css('height','auto');
        }
        else{
            el.css('height','0');
        }
    });
    $('.title_box').click(function () {
        const el=$(this).parent().find('.filter_box');
        if(el.css('display')=='none'){
            el.slideDown();
            $('.fa-angle-down',this).removeClass('fa-angle-down').addClass('fa-angle-up');
        }
        else{
            el.slideUp();
            $('.fa-angle-up',this).removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });
    let search=new window.URLSearchParams(window.location.search);
    if(document.getElementById('product_status')){
        if(search.get('has_product')!=null)
        {
            if(search.get('has_product')==1){
                $("#product_status").toggles({
                    type:'Light',
                    text:{'on':'','off':''},
                    width:50,
                    direction:'rtl',
                    on:false
                });
            }
        }
        if(search.get('has_ready_to_shipment')!=null)
        {
            if(search.get('has_ready_to_shipment')==1){
                $("#send_status").toggles({
                    type:'Light',
                    text:{'on':'','off':''},
                    width:50,
                    direction:'rtl',
                    on:false
                });
            }
        }
    }

    $("#brand_search").on('keyup',function () {
        const input=$(this).val().toLowerCase();
        const li=$(this).parent().find('.product_cat_ul li');
        for (let i=0;i<li.length;i++)
        {
            if(li[i].innerText.toLowerCase().indexOf(input)>-1)
            {
                li[i].style.display='block';
            }
            else {
                li[i].style.display='none';
            }
        }
    });
    check_has_compare_list();
    $(".logout").click(function () {
        $("#logout_form").submit();
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

    const promo_single=$(".promo_single a");
    if(promo_single.length>0)
    {
        promo_single_count=promo_single.length;
        startPromoSingleSlide();
    }

    $(".cart-header-box .dropdown-menu").on({
        "click":function (e) {
            e.stopPropagation();
        }
    });

    const rangElement=document.getElementById('image_zoom_rang');
    if(rangElement!=null)
    {
        rangElement.addEventListener('input',function(){
            zoom_image();
        });
    }


    $('.cat_list_box .parent_list .cat_list li').mouseover(function () {
        const index=$(this).attr('data-index');
        $('.child_list_div').css('display','none');
        $('.category-list-'+index).css('display','block');
        $('.cat_list li').removeClass('active');
        $(this).addClass('active');
    });
});


$(document).ready(function () {
    const url = window.location.href.split('?')[0];
    if ($('.profile_menu_ul li a[href="' + url + '"]').parent().length==1){
        $('.profile_menu_ul li a[href="' + url + '"]').parent().addClass('active_li');
    }
});

check_has_compare_list=function() {
    const check_has_compare_list=document.getElementsByClassName('compare_product_gallery');
    if(check_has_compare_list.length>0)
    {
        $(window).scroll(function (e) {
            if($(document).scrollTop()>200)
            {
                $('.compare_product_gallery').css('border-bottom','3px solid #2196F3');
                $('.compare_product_gallery .btn-primary').hide();
                $('.compare_product_gallery .btn-dark').hide();
                $('.gallery_box').css('height','300px');
                $('.compare_add').css('height','300px');
                $('.gallery_box img').css('width','80%');
            }
            else{
                $('.compare_product_gallery').css('border-bottom','0px');
                $('.compare_product_gallery .btn-primary').show();
                $('.compare_product_gallery .btn-dark').show();
                $('.gallery_box').css('height','360px');
                $('.compare_add').css('height','360px');
                $('.gallery_box img').css('width','90%');
            }
        });
    }
};

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


let promo_index=0;
startPromoSingleSlide=function () {
    $('.promo_single_header').addClass('promo-single-bar');
    setInterval(function () {
        promo_index++;
        if(promo_index>(promo_single_count-1))
        {
            promo_index=0;
        }
        $('.promo_single a').removeClass('active');
        $("a[data-swiper-slide-index='"+promo_index+"']").addClass('active');
    },7000);
};



const app_url=document.querySelector('meta[name="app_url"]').getAttribute('content');
const site_url=app_url+'/';
add_price_variation_input=function(){
    const id = document.getElementsByClassName('item_input').length + 1;
    const html = '<div class="form-group item_groups" id="price_variation_-' + id + '">' +
        '<input type="text" class="form-control item_input" name="price_variation[-' + id + ']" placeholder="مقدار"> ' +
        '</div>';
    $("#price_variation_box").append(html);
}
$(".show_filter_box").click(function () {

    const el = $(this).parent().find('.item_filter_box ul');
    const display = el.css('display');
    if (display == 'block') {
        el.slideUp();
    }
    else {
        el.slideDown();
    }
});
const month = [
    'فروردین',
    'اردیبهشت',
    'خرداد',
    'تیر',
    'مرداد',
    'شهریور',
    'مهر',
    'آبان',
    'آذر',
    'دی',
    'بهمن',
    'اسفند'
];
getMonthName = function (key) {
    if (month[key] != undefined) {
        return month[key];
    }
    else {
        return '';
    }
}
logout=function () {
    $("#logout_form").submit();
}

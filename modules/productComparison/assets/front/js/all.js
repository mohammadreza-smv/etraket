$('.remove_product_of_compare_list').click(function () {
    const product_id=$(this).attr('data-id');
    let url=window.location.href;
    url=url.replace('/dkp-'+product_id,'');
    if(site_url+"compare"==url){
        window.location=site_url;
    }
    else{
        window.location=url;
    }
});

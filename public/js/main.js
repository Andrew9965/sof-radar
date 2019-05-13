var token = document.head.querySelector('meta[name="csrf-token"]').content;

$(function(){

    window.popupShow = function(header){
        if(header==undefined) header = 1;
        $('.popup_titles_my').hide();
        Popups.openById('add-review');
        $('#popup_title_'+header).show();
    };

    window.loginShow = function(){
        var pForm = $('.popup__form')

        pForm.find('._title').html('Add review');
        pForm.find('.popup__container--small').find('p').html("Do you want to add product review? It's fine!<br>" +
                                                              "Log in with Facebook or Google account, and do it now!");

        Popups.openById('add-review');
    };

    var ins_to = $('.page-search__menu-inner'),
        $overlay = $('.overlay-bg');

    var init_result = function(result, val){
        ins_to.html('');
        var prods = '';
        $.each(result.products, function(key,val){
            prods += '<div class="similar__item">';
            prods += '<div class="_logo"><a href="'+val.url+'"><img src="'+val.logo+'" alt="" width="35"></a></div>';
            prods += '<div class="_title"><a href="'+val.url+'">'+val.title+'</a></div>';
            prods += '<div class="_title" style="text-align: right;display: contents;"><b>Product</b></div>';
            prods += '</div>';
        });
        $.each(result.news, function(key,val){
            prods += '<div class="similar__item">';
            prods += '<div class="_logo"><a href="'+val.url+'"><img src="'+val.logo+'" alt="" width="35"></a></div>';
            prods += '<div class="_title"><a href="'+val.url+'">'+val.title+'</a></div>';
            prods += '<div class="_title" style="text-align: right;display: contents;"><b>New</b></div>';
            prods += '</div>';
        });
        if(val=='') prods = '';

        $.each(result.categories, function(key,el_val){
            prods += '<div class="similar__item">';
            prods += '<div class="_logo"><a href="'+el_val.url+'"><img src="'+el_val.logo+'" alt="" width="35"></a></div>';
            prods += '<div class="_title"><a href="'+el_val.url+'">'+el_val.title+'</a></div>';
            prods += '<div class="_title" style="text-align: right;display: contents;"><b>Category</b></div>';
            prods += '</div>';
        });

        var $searchBox = $('#live_search').closest('.page-search');
        if (!$searchBox.hasClass('active')) {
            $searchBox.addClass('active');
            $overlay.show();
        }
        if(prods=='') ins_to.html('<div style="margin: 0 auto;"><b>No results were found for your search!</b></div>');
        else ins_to.append('<div class="similar__list" style="margin: 15px; margin-top: -30px; margin-right: 30px;">'+prods+'</div><div style="width: 100%;clear: both"></div>');
    };

    $('#live_search').on('keyup', function(){
        var search_obj = $(this);
        var val = search_obj.val();

        if(val.length>2){
            ins_to.html('<div style="margin: 0 auto;"><img src="/spinner.gif" width="50" /></div>');
            $.get('/search', {q:val}, function(result){
                init_result(result, val);
            });
        }
    });

    $('.js-open-search').on('click', function () {
        var that = $(this),
            $searchBox = that.closest('.page-search');

        if ($searchBox.hasClass('active')) {
            $searchBox.removeClass('active');
            that.removeClass('active');
            $overlay.hide();

        } else {
            ins_to.html('<div style="margin: 0 auto;"><img src="/spinner.gif" width="50" /></div>');
            $.get('/search', {q:$('#live_search').val()}, function(result){
                init_result(result, $('#live_search').val());
            });
        }
    });

    var counter = function(obj){
        var len = $(obj).val() ? $(obj).val().replace(/ /g,'').length : 0;
        var pObj = $(obj).parent('div');
        pObj.find('.popup__form-symbol span').html(len);
        var val_obj = $(obj).parent('div').find('.popup__form-symbol');
        var max = parseInt(val_obj.html().replace('<span>'+len+'</span>/',''));
        if(len>max || !len){
            pObj.find('.required span').css('color', '#ed3b59');
            pObj.removeClass('success');
            pObj.addClass('error');
        }else{
            pObj.find('.required span').css('color', '#43bb76');
            pObj.addClass('success');
            pObj.removeClass('error');
        }
    };

    $('.counter').each(function(){
        $(this).on('keyup', function(){
            counter(this);
        });
        if($(this).val()!='') counter(this);
    });

    $('.submit_review').on('submit', function(){
        var error = false;
        var count_no_review = 0;
        $('.popup__rating-inner').find('.rate').each(function(){
            count_no_review += Number($(this).val()) ? 1 : 0;
        });

        $('.counter_required').each(function(){
            var val = $(this).val();
            if(val==null || val==undefined || val==''){
                $('#add-review').animate({
                    scrollTop: parseInt($(this).position().top)
                });
                toastr.error('First you need to choose a product!');
                error = true;
            }
        });

        if(error)
            return false;

        $('.counter').each(function(){
            counter(this);
            var pObj = $(this).parent('div');
            if(!pObj.hasClass('success') && !error){
                if(count_no_review==5) $('#add-review').animate({
                    scrollTop: parseInt(pObj.position().top)
                });
                error = true;
            }
        });

        if(count_no_review!=5){
            $('#add-review').animate({
                scrollTop: parseInt($('.rating-all').position().top)
            });
            toastr.error('You need to put your assessment!');
            return false;
        }
        if(!error)
            $(this).submit();
        return false;
    });

    $('[data-uses]').each(function(){
        $(this).on('change', function(){
            var usesId = $(this).data('uses');
            var cat = $(this).data('cat-slug');
            var title = $(this).data('prod-title');
            var obj = $(this);
            var prodId = obj.data('prod-id');
            if(cat!=undefined) $('[name="category_id_for_selection_product"]').val(cat).trigger('change');
            $.get('/app/'+usesId+'/use', {ch:obj.is(':checked')}, function(result){
                if(result.status==undefined) alert('Server ERROR!');
                if(result.status=='success' && obj.is(':checked')) {
                    console.log(result.reviews);
                    if(result.reviews == 0) {
                        popupShow(1);
                        if(cat != undefined) {
                            var newOption = new Option(title, prodId, false, true);
                            $('[name="product_id"]').append(newOption).trigger('change');
                        }
                    }else
                        toastr.success('You have already left a review for this product!');
                }
                if(result.status=='error') {
                    obj.prop( "checked", false );
                    var add_params = '';
                    if(cat!=undefined)
                        add_params += '&cat_slug='+cat+'&prod_id='+obj.data('prod-id');
                    $('.facebook_auth').attr('href', $('.facebook_auth').attr('href')+add_params);
                    $('.google_auth').attr('href', $('.google_auth').attr('href')+add_params);
                    var pForm = $('.popup__form');
                    pForm.find('._title').html('Excellent!');
                    pForm.find('.popup__container--small').find('p').html("Would you like to add review about "+title+"? <br>"+
                    "Log in with Facebook or Google account, and do it now!");

                    popupShow(0);
                }
            });
        });
    });

    $('[name="product_id"]').on('change', function(){
        var obj = $(this);
        var cat_id = obj.val()!=null ? obj.val() : 0;
        $('#cat_product_title').html('<img src="/spinner.gif" alt="" width="35">');
        $.get('/category/'+cat_id+'/ajax', function(result){
            if(result.status!=undefined && result.status == 'null')
                $('#cat_product_title').html("");
            else
                $('#cat_product_title').html(result.title);
        });
    });

    $('[href="#add_to_compare"]').each(function(){
        var btn = $(this);
        btn.on('click', function(){
            Popups.openById('add-review');
            toastr.error('First you need to login!');
            return false;
        });
    });

    $('[data-like]').each(function(){
        var likeId = $(this).data('like');
        var obj = $(this);

        var setVar = function(data, btn){
            if(data=='ok') {
                var likes = Cookies.get('likes');
                if(likes===undefined) {
                    likes = {};
                    Cookies.set('likes', JSON.stringify(likes));
                }
                else likes = JSON.parse(likes);

                var num = Number(btn.html().replace(/\n| |<\/?[^>]+(>|$)/g, ''));
                btn.html(btn.html().replace(num, ++num));

                likes[likeId] = likeId;
                Cookies.set('likes', JSON.stringify(likes));
                toastr.success('Your vote is counted!');
            }else{
                toastr.error(data, 'Error!')
            }
        };

        $(this).find('.like__up').on('click', function(){
            var upBtn = $(this);
            if(obj.attr('data-like')!=undefined && obj.attr('data-like')!='') {
                obj.removeAttr('data-like');
                $.post('/app/' + likeId + '/reviews/like', {'_token': token, method: "up"}, function (data) {
                    setVar(data, upBtn);
                });
            }else
                toastr.error('You have already voted');
        });

        $(this).find('.like__down').on('click', function(){
            var downBtn = $(this);
            if(obj.attr('data-like')!=undefined && obj.attr('data-like')!='') {
                obj.removeAttr('data-like');
                $.post('/app/' + likeId + '/reviews/like', {'_token': token, method: "down"}, function (data) {
                    setVar(data, downBtn);
                });
            }else
                toastr.error('You have already voted');

        });
    });
});
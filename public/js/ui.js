(function ($) {
    'use strict';

    var App = {
        overlay: function () {
            var $overlay = $('<div/>').addClass('overlay-bg').appendTo('body');
            $overlay.hide();
        },
        openMenu: function () {

            var $menuBox = $('.header__nav'),
                $overlay = $('.overlay-bg');

            $('.js-open-menu').on('click', function () {
                if ($menuBox.hasClass('active')) {
                    $menuBox.removeClass('active');
                    $overlay.hide();
                } else {
                    $menuBox.addClass('active');
                    $overlay.show();
                }
            });

            $overlay.on('click', function () {
                $menuBox.removeClass('active');
                $overlay.hide();
            });
        },

        openSearch: function () {

            var $searchBox = $('.page-search'),
                $overlay = $('.overlay-bg');

            $('.js-close-search').on('click', function () {
                $searchBox.removeClass('active');
                $overlay.hide();
            });

            $overlay.on('click', function () {
                $searchBox.removeClass('active');
                $('.js-open-search').removeClass('active');
                $overlay.hide();
            });
        },

        navSelect: function () {
            var $block = $('.page-nav');
            var $header = $block.find('.page-nav__header');
            var $listLink = $block.find('.page-nav__toggle a');
            var headerText = $header.find('span').text();

            $header.on('click', function () {
                $block.toggleClass('active');
                $(this).next().slideToggle();
            });

            $listLink.on('click', function () {
                $block.removeClass('active');
                $header.next().slideUp();
                headerText = $header.find('span').text();
                $header.find('span').text($(this).text());
                $(this).text(headerText);
            });
        },

        mediaSlider: function () {

            $('.js-media-slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                asNavFor: '.js-media-slider-nav'
            });

            $('.js-media-slider-nav').slick({
                slidesToShow: 10,
                slidesToScroll: 1,
                asNavFor: '.js-media-slider-for',
                dots: false,
                arrows: false,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1250,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: "unslick"
                    }
                ]
            });

            $('.js-media-slider-nav .media-slider__nav-item').on('click', function () {
                var num = $(this).index();
                $('.js-media-slider-for').slick('slickGoTo', num);
            });
        },

        customScroll: function () {
            if ($(window).width() > 767) {
                return false;
            }

            $('.js-custom-scroll').mCustomScrollbar({
                scrollInertia: 100
            });
        },

        openReviewStar: function () {
            var $btnOpen = $('.js-review-rating-open'),
                $btnClose = $('.js-review-rating-close');

            $btnOpen.on('click', function () {
                var $container = $(this).closest('.review-item__inner').find('.review-item__main');

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $container.slideUp();

                } else {
                    $(this).addClass('active');
                    $container.slideDown();
                }
            });

            $btnClose.on('click', function () {
                $(this).closest('.review-item__inner').find('.review-item__main').slideUp();
                $(this).closest('.review-item__inner').find('.js-review-rating-open').removeClass('active');
            });
        },

        openFilter: function () {
            var $btn = $('.js-open-filter'),
                $filter = $('.js-filter-box'),
                $btnReset = $('.js-filter-reset'),
                $input = $filter.find('input');


            $btn.on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $filter.removeClass('opened');
                } else {
                    $(this).addClass('active');
                    $filter.addClass('opened');
                }
            });

            $input.on("change", function () {
                var qty = 0;

                for (var i = 0; i < $input.length; i++) {
                    if ($input.eq(i).prop('checked')) {
                        qty += 1;
                    }
                }
                ;

                if (qty > 0) {
                    $btn.addClass('btn-apply');
                    $btnReset.addClass('active');
                } else {
                    $btn.removeClass('btn-apply');
                    $btnReset.removeClass('active');
                }
            });

            $btnReset.on('click', function () {
                $(this).removeClass('active');
                $btn.removeClass('btn-apply');
            });
        },

        callCenterOpen: function () {
            $('.js-open-call-center').on('click', function () {
                if ($(this).hasClass('active')) {
                    $('.js-text-call-center').slideUp();
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                    $('.js-text-call-center').slideDown();
                }
            });
        },

        readMore: function () {
            $('.js-read-more-btn').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('.js-read-more-box').removeClass('active').addClass('box-gradient');

                } else {
                    $(this).addClass('active');
                    $('.js-read-more-box').addClass('active').removeClass('box-gradient');
                }
            });
        },


        moreList: function () {
            $('.js-list-more-btn').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).closest('.js-list-more').find('.js-list-more-box').removeClass('active');
                } else {
                    $(this).addClass('active');
                    $(this).closest('.js-list-more').find('.js-list-more-box').addClass('active');
                }
            });
        },

        selectReview: function () {
            $('.js-select').select2({
                placeholder: ''
            });

            var formatRepo = function(val) {
                var markup = "";
                markup += '<div class="similar__item">';
                if(!val.logo) val.logo = '/spinner.gif';
                markup += '<div class="_logo"><img src="'+val.logo+'" alt="" width="35"></div>';
                markup += '<div class="_title">'+val.text+'</div>';
                markup += '</div>';
                return markup;
            }

            $('.js-select-product').select2({
                allowClear: true,
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                ajax: {
                    url: '/search/product',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        },

        ratingStar: function() {
          var $starContainer = $('.popup .rating-star'),
              $starFill = $starContainer.find('.rating-star__fill');

            $starContainer.on('click', function(e) {
                var perc = e.offsetX/ $(this).width() * 100;
               $(this).find($starFill).css('width', perc + '%');
               var stars = Math.round((perc / 2) / 10);
               $(this).parent().find('.rating__value').text(stars + '/5');
               if($(this).parent().find('[type="hidden"]').length)
                   $(this).parent().find('[type="hidden"]').val(stars);
            });
        },

        chart: function () {
            var ctx = $("#myChart");
            var myRadarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Easy-of-use', 'Functionality', 'Product Quality', 'Customer Support', 'Value for Money'],
                    datasets: [
                        {
                            backgroundColor: 'rgba(255, 255, 255, 0)',
                            borderColor: 'rgb(255, 204, 26)',
                            data: [6, 8, 4, 9, 8]
                        },
                        {
                            backgroundColor: 'rgba(148, 35, 43, 0.129)',
                            borderColor: 'rgb(255, 27, 43)',
                            data: [10, 6, 8, 7, 8]
                        }
                    ],
                    options: {
                        title: {}
                    }
                }
            });
        },

        fixedCompareHeader: function() {
            if($('.compare-table__inner').length>1){
                var $header = $('.compare-table__fixed'),
                    $container = $('.compare-table__inner'),
                    height = $container.height(),
                    offsetTop = $container.offset().top;

                $(window).on('scroll', function(){
                    if ($(window).scrollTop() > offsetTop + 100 && $(window).scrollTop() < offsetTop + height) {
                        $header.css({
                            width: $container.find('.compare-table__row--head ._inner').width(),
                            left: $container.find('.compare-table__row--head ._inner').offset().left
                        });
                        $header.addClass('show');
                    } else {
                        $header.removeClass('show');
                    }
                });

                $(window).on('resize', function() {
                    $header.removeClass('show').attr('style', '');
                });
            }
        },

        init: function () {
            this.overlay();
            this.openMenu();
            this.openSearch();
            this.navSelect();
            this.mediaSlider();
            this.customScroll();
            this.openReviewStar();
            this.openFilter();
            this.callCenterOpen();
            this.readMore();
            this.moreList();
            this.selectReview();
            this.ratingStar();
            this.fixedCompareHeader();
            // this.chart();

        }
    };

    $(function () {
        $(window).on("load", function () {
            App.init();
            Popups.Init();
        });

        document.documentElement.addEventListener('touchstart', function (event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, false);
    });
})(jQuery);
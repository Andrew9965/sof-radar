(function ($) {
    "use strict";

    function Dropdown($elem, options) {
        var that = this;

        var hasScroll = $elem.attr('data-scroll');

        this.$elem = $elem;

        this.prefix = 'prefix' in options ? options.prefix : '';
        this.placeholder = 'placeholder' in options ? options.placeholder : $elem.data('placeholder');
        this.scroll = 'scroll' in options ? options.scroll : $elem.data('scroll');
        this.className = 'scroll' in options ? options.className : $elem.data('class');

        this.$container = null;
        this.$header = null;
        this.$cityLabel = null;
        this.$dropDown = null;
        this.$dropDownInner = null;

        this.options = {};

        this.activeValue = null;
        this.activeLabel = null;

        var dropdownOpened = false;
        
        this.$elem.on('change', function () {
            that.setActiveValue($(this).val(), false);
        });


        this.buildHtml = function () {

            if(this.$container){
                this.$container.remove();
            }

            this.$container = $('<div>').addClass('dropdown-container').height(that.$elem.height());

            this.$header = $('<div>').addClass('dropdown-header').text(that.prefix ? that.prefix + ' ' : '');
            this.$header.append('<a href="#" class="dropdown-arrow"></a>');
            this.$cityLabel = $('<span>').appendTo(this.$header);

            this.$dropDown = $('<div>').addClass('dropdown-box');
            this.$dropDownInner = $('<div class="dropdown-box__inner"></div>').appendTo(this.$dropDown);

            if (this.$elem.find('optgroup').length !== 0) {
                this.$elem.find('optgroup').each(function () {
                    var label = $(this).attr('label');
                    that.$dropDownInner.append('<div class="group-label">' + label + '</div>');

                    $(this).find('option').each(function () {
                        that.options[$(this).val()] = $(this).text();
                        that.$dropDownInner.append('<span><a href="#" data-value="' + $(this).val() + '">' + $(this).text() + '</a></span>');
                    });
                });
            } else {
                this.$elem.find('option').each(function () {
                    that.options[$(this).val()] = $(this).text();
                    that.$dropDownInner.append('<span><a href="#" data-value="' + $(this).val() + '">' + $(this).text() + '</a></span>');
                });
            }

            this.$container.append(this.$header);
            this.$container.append(this.$dropDown);

            this.$elem.hide();

            this.$container.insertAfter(this.$elem);
        };


        this.setActiveValue = function (value, forceTrigger) {
            forceTrigger = typeof forceTrigger === 'undefined' ? true : !!forceTrigger;
            this.$header.removeClass('dropdown-header--placeholder');

            this.activeValue = value;
            this.activeLabel = this.options[value];

            this.$cityLabel.text(this.activeLabel);
            
            if (forceTrigger) {
                this.$elem.val(this.activeValue).trigger('change');
            }
        };

        this.showDropdown = function () {
            this.$dropDown.show();
            this.$container.addClass('dropdown-opened');
            dropdownOpened = true;

            if (hasScroll) {
                this.$dropDown.addClass(this.scroll).jScrollPane();
            }
        };

        this.hideDropdown = function () {
            this.$dropDown.hide();
            this.$container.removeClass('dropdown-opened');
            dropdownOpened = false;
        };

        this.bindEvents = function () {

            this.$container.find('.dropdown-header span, .dropdown-arrow').on('click', function () {
                if (dropdownOpened === false) {
                    $('.dropdown-box').hide();
                    that.showDropdown();
                }
                else {
                    that.hideDropdown();
                }
                return false;
            });

            $(document).on('click', function (e) {
                if (!dropdownOpened) {
                    return;
                }

                var $target = $(e.target);

                if ($target.hasClass('dropdown-box') || $target.parents('.dropdown-box').length) {
                    return;
                }

                that.hideDropdown();
            });

            this.$dropDown.find('a').on('click', function () {
                that.setActiveValue($(this).data('value'));
                that.hideDropdown();

                return false;
            });
        };

        this.buildHtml();
        this.bindEvents();

        if (this.placeholder) {
            this.activeLabel = this.placeholder;
            this.$cityLabel.text(this.activeLabel);
            this.$header.addClass('dropdown-header--placeholder');
        }
        else {
            var value = this.$elem.val() ? this.$elem.val() : this.$elem.find('option').first().val();
            this.setActiveValue(value);
        }


        if ($elem.attr('data-class')) {
            this.$header.addClass(this.className);
        }

        this.update = function(){
            that.buildHtml();
            that.bindEvents();

            if (that.placeholder) {
                that.activeLabel = that.placeholder;
                that.$cityLabel.text(that.activeLabel);
                that.$header.addClass('dropdown-header--placeholder');
            }
            else {
                var value = that.$elem.val() ? that.$elem.val() : that$elem.find('option').first().val();
                that.setActiveValue(value);
            }
        };

        return this;
    }

    var dropdowns = [];
    $.fn.dropdown = function (options) {

        if(typeof options === 'string'){
            var dropdownId = $(this).data('dropdown-guid');
            if(dropdownId in dropdowns){
                var dropdown = dropdowns[dropdownId];
                dropdown[options]();
            }
            return;
        }

        $(this).each(function () {
            var dropdownId = Math.floor((1 + Math.random()) * 0x10000).toString(16) + Math.floor((1 + Math.random()) * 0x10000).toString(16) + Math.floor((1 + Math.random()) * 0x10000).toString(16);
            dropdowns[dropdownId] = new Dropdown($(this), options);
            $(this).data('dropdown-guid', dropdownId);
        });
    };
})(jQuery);
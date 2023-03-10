jQuery(document).ready(function ($) {
    if (!$('.content-index-ob').length) return;
    let { user_login, user_name, user_email, admin_ajax_url,subcription_form,feedback_form,new_to_index } = ob_settings;

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }

    function loadDataContent(id) {
        const _popupDetail = $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper');
        _popupDetail.addClass('is-loading');
        $.ajax({
            type: "post",
            dataType: "json",
            url: admin_ajax_url,
            data: {
                action: "getChapter",
                dataId: id,
            },
            context: this,
            success: function (response) {
                if (response.success) {
                    _popupDetail.html(response.data);
                }
                _popupDetail.removeClass('is-loading')
            },
        })
    }  
    
    function getUserInfo(user_email) {
        $.ajax({
            type: "get",
            dataType: "json",
            url: '/wp-json/theme/v1/get-user-info-by-email',
            data: {
                user_email: user_email,
            },
            success: function (response) {
                if (response) {
                    const {user_email,user_name,hash} = response.data;
                    setCookie('ob_user_name',user_name,14);
                    setCookie('ob_user_email',user_email,14);
                    $(".container-popup-form").removeClass('is-active');
                    $("#popup5").addClass('is-active');
                    let url = location.protocol + '//' + location.host + location.pathname;
                    url += '?activeToken=' + hash;
                    $("#popup5").find('.js-asset-text').attr('href',url)
                }
            },
        })
    }
    
    function downloadURI(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
        $.ajax({
            type: "post",
            dataType: "json",
            url: '/wp-json/theme/v1/save-user-download-file',
            data: {
                user_name: user_name,
                user_email: user_email,
            },
            success: function (response) {
                console.log(response);
            },
        })
    }

    if (window.location.hash) {
        if(user_login) {
            let hash = window.location.hash.substring(1);
            const _this = $('[href="#' + hash + '"]');
            if(!_this.length) return;
            const id = _this.attr('data-id');
            history.pushState({}, "", _this.attr('href'));
            $("#popup-detail").addClass('is-active');
            const sidebar_row_active = $('.js-active-content-row[data-id="' + id + '"]')
            sidebar_row_active.addClass('is-active');
            sidebar_row_active.parent().siblings().children('.js-active-content-row').removeClass('is-active');
            loadDataContent(id);
        }
        else{
            let hash = window.location.hash;
            // console.log(hash.includes('contentIdRow'));
            if(hash.includes('contentIdRow')) {
                const _popup1 = $("#popup1");
                if (_popup1.find('form').length) {
                    $("#popup1").addClass('is-active');
                } else {
                    $("#popup4").addClass('is-active');
                }
            }
        }
    }


    const form = $('.wpforms-form');
    form.on('wpformsAjaxSubmitSuccess', (event) => {
        $(".container-popup-form").removeClass('is-active');
        $("#popup4").addClass('is-active');
    });

    $('.btn-attend-campfire-click').on('click', function () {
        let id_campfire = $(this).data('id');
        let data = {
            action: 'user_attend_campfire',
            id_campfire: id_campfire,
        };
        $.post(ajax_object.ajaxurl, data, function (response) {
            if (response['code'] == '200') {
                $('.btn-attend-campfire-' + response['id_campfire']).addClass('attended');
                $('.btn-attend-campfire-' + response['id_campfire']).text('Attending');
            }
        });
    });

    $(document).on('click', '.container-popup-form.is-active', (e) => {
        // e.preventDefault();
        if ($(e.target).hasClass('is-active') && $(e.target).hasClass('container-popup-form')) {
            $(".container-popup-form").removeClass('is-active');
        }
    })

    $(document).on('click', '.ob-extension-detail__close', (e) => {
        e.preventDefault();
        $(".container-popup-form").removeClass('is-active');
    })
    $(document).on('click', '.file-download-content', function (e) {
        e.preventDefault();
        const download_button = $(this);
        downloadURI(download_button.attr('href'), 'PageIndex.pdf');
    })

    $('.content-index-ob--button').on('click', (e) => {
        e.preventDefault();
        $(".container-popup-form").removeClass('is-active');
        if (user_login) {
            const download_button = $('.file-download-content');
            downloadURI(download_button.attr('href'), 'PageIndex.pdf');
        } else {
            const _popup1 = $("#popup1");
            if (_popup1.find('form').length) {
                $("#popup1").addClass('is-active');
            } else {
                $("#popup4").addClass('is-active');
            }
        }
    });

    $('.content-index-ob--button2').on('click', (e) => {
        e.preventDefault();
        $(".container-popup-form").removeClass('is-active');
        const _popup1 = $("#popup3");
        if (!_popup1.find('form').length) {
            $("#popup5").addClass('is-active');
        }else{
            $("#popup3").addClass('is-active');
        }
    });

    $(document).on('change', '.js-ob-extension-select', function (e) {
        const id = $(this).val();
        loadDataContent(id);
    });

    $(document).on('click', '.js-content-index-row', function (e) {
        e.preventDefault();
        if(!user_login) {
            const _popup1 = $("#popup1");
            if (_popup1.find('form').length) {
                $("#popup1").addClass('is-active');
            } else {
                $("#popup4").addClass('is-active');
            }
            return;
        }
        const _this = $(this);
        const id = $(this).attr('data-id');
        history.pushState({}, "", _this.attr('href'));
        $("#popup-detail").addClass('is-active');
        const sidebar_row_active = $('.js-active-content-row[data-id="' + id + '"]')
        sidebar_row_active.addClass('is-active');
        sidebar_row_active.parent().siblings().children('.js-active-content-row').removeClass('is-active');
        loadDataContent(id);
    });

    $(document).on('click', '#wpforms-submit-' + subcription_form, function (e) {
        const form_data = $(this).parents('form').serializeArray();
        let check = false;
        form_data.map((v, i) => {
            if (v.name == 'wpforms[fields][0][first]') {
                user_name = v.value + ' ' + form_data[i + 1].value;
                setCookie('ob_user_name',v.value,14);
                check = true;
            }
            if (v.name == 'wpforms[fields][1]') {
                user_email = v.value;
                setCookie('ob_user_email',v.value,14);
                check = true;
            }
        });
        // const form = $(this).parents('.wpforms-form');
        // form.on('wpformsAjaxSubmitSuccess', (event) => {
        //     $(".container-popup-form").removeClass('is-active');
        //     $("#popup4").addClass('is-active');
        //     console.log('wpformsAjaxSubmitSuccess');
        // });
    });

    $('#wpforms-' + subcription_form).bind("DOMSubtreeModified", function(e){
        const _this = $(this);
        if(!_this.find('form').length && !_this.find('#wpforms-confirmation-' + subcription_form).length) {
            $(".container-popup-form").removeClass('is-active');
            $("#popup4").addClass('is-active');
        }
    });
    
    $(document).on('click', '#wpforms-submit-' + new_to_index, function (e) {
        const form_data = $(this).parents('form').serializeArray();
        let check = false;
        form_data.map((v, i) => {
            if (v.name == 'wpforms[fields][2]') {
                user_email = v.value;
                setCookie('ob_user_email',v.value,14);
                check = true;
            }
        });
    });
    
    $('#wpforms-' + new_to_index).bind("DOMSubtreeModified", function(e){
        const _this = $(this);
        if(!_this.find('form').length) {
            $("#popup5").addClass('is-active');
        }
        if(!_this.find('form').length && !_this.find('#wpforms-confirmation-' + new_to_index).length) {
            getUserInfo(user_email);
        }
    });

    $(window).on("scroll", function (e) {
        const scrollTop = $(this).scrollTop();
        const content_offset_top = $(".content-index-ob").offset().top;
        const content_height = $(".content-index-ob").outerHeight();
        const subscribe_container = $(".subscribe-container").outerHeight();
        if (scrollTop > 500 && scrollTop < $(".content-index-ob").offset().top - content_height) {
            $(".scroll-down-button-sub").addClass("is-active");
        } else {
            $(".scroll-down-button-sub").removeClass("is-active");
        }
        if (scrollTop > screen.height) {
            $(".subscribe-container").addClass('is-active');
            $(".ob-extension-scrollToList").addClass('is-remove');
        } else {
            $(".subscribe-container").removeClass('is-active');
            $(".ob-extension-scrollToList").removeClass('is-remove');
        }
        if (scrollTop + screen.height > content_offset_top + content_height + (subscribe_container * 1.5)) {
            $(".subscribe-container").addClass('fix-active-active');
        } else {
            $(".subscribe-container").removeClass('fix-active-active');
        }
    })

    $(document).on('click', '.js-scroll-to-list', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: $(".content-index-ob").offset().top
        }, 'slow');
    })
});
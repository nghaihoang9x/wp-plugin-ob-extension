jQuery(document).ready(function ($) {
    if (!$('.content-index-ob').length) return;
    let { user_login, user_name, user_email, admin_ajax_url } = ob_settings;

    const form = $('form.wpforms-form');

    if (window.location.hash) {
        let hash = window.location.hash.substring(1);
        const _this = $('[href="#' + hash + '"]');
        if(!_this.length) return;
        const id = _this.attr('data-id');
        history.pushState({}, "", _this.attr('href'));
        $("#popup-detail").addClass('is-active');
        const sidebar_row_active = $('.js-active-content-row[data-id="' + id + '"]')
        sidebar_row_active.addClass('is-active');
        sidebar_row_active.parent().siblings().children('.js-active-content-row').removeClass('is-active');

        $.ajax({
            type: "post",
            dataType: "json",
            url: admin_ajax_url,
            data: {
                action: "getChapter", //Tên action
                dataId: id,

            },
            context: this,
            beforeSend: function () {
                //Làm gì đó trước khi gửi dữ liệu vào xử lý
            },
            success: function (response) {
                //Làm gì đó khi dữ liệu đã được xử lý
                if (response.success) {
                    $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper').html(response.data);
                }
                else {
                    console.log('Đã có lỗi xảy ra');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //Làm gì đó khi có lỗi xảy ra
                console.log('The following error occured: ' + textStatus, errorThrown);
            }
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

    form.on('wpformsAjaxSubmitSuccess', (event) => {
        $(".container-popup-form").removeClass('is-active');
        $("#popup4").addClass('is-active');
        console.log('wpformsAjaxSubmitSuccess');
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
        $("#popup3").addClass('is-active');
    });

    $(document).on('change', '.js-ob-extension-select', function (e) {
        const id = $(this).val();
        $.ajax({
            type: "post",
            dataType: "json",
            url: admin_ajax_url,
            action: "getChapter",
            dataId: id,
            context: this,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.success) {
                    $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper').html(response.data);
                }
                else {
                    console.log('Đã có lỗi xảy ra');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('The following error occured: ' + textStatus, errorThrown);
            }
        });
    });

    $(document).on('click', '.js-content-index-row', function (e) {
        e.preventDefault();
        const _this = $(this);
        const id = $(this).attr('data-id');
        history.pushState({}, "", _this.attr('href'));
        $("#popup-detail").addClass('is-active');
        const sidebar_row_active = $('.js-active-content-row[data-id="' + id + '"]')
        sidebar_row_active.addClass('is-active');
        sidebar_row_active.parent().siblings().children('.js-active-content-row').removeClass('is-active');

        $.ajax({
            type: "post", //Phương thức truyền post hoặc get
            dataType: "json", //Dạng dữ liệu trả về xml, json, script, or html
            url: admin_ajax_url, //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
            data: {
                action: "getChapter", //Tên action
                dataId: id,

            },
            context: this,
            beforeSend: function () {
                //Làm gì đó trước khi gửi dữ liệu vào xử lý
            },
            success: function (response) {
                //Làm gì đó khi dữ liệu đã được xử lý
                if (response.success) {
                    $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper').html(response.data);
                }
                else {
                    console.log('Đã có lỗi xảy ra');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //Làm gì đó khi có lỗi xảy ra
                console.log('The following error occured: ' + textStatus, errorThrown);
            }
        })
    });

    // $(document).on('click', '#wpforms-submit-76', function(e) {
    //     $("#popup1").removeClass('is-active');
    //     $("#popup2").addClass('is-active');
    // })
    $(document).on('click', '#wpforms-submit-7989', function (e) {
        $(".container-popup-form").removeClass('is-active');
        const form_data = $(this).parents('form').serializeArray();
        form_data.map((v, i) => {
            if (v.name == 'wpforms[fields][0][first]') {
                user_name = v.value + ' ' + form_data[i + 1].value;
            }
            if (v.name == 'wpforms[fields][1]') {
                user_email = v.value;
            }
        });
        $("#popup4").addClass('is-active');
    })
    // document.addEventListener('DOMContentLoaded', function () {

    // })
    // $(document).on('click', '.js-active-content-row', function(e){
    //     const data_download = $(this).attr('data-download-report');
    //     $('.js-download-file').attr('href',data_download);
    // });

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
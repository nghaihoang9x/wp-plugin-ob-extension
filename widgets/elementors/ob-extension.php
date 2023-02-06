<?php
class Elementor_Ob_Extension_Widget extends \Elementor\Widget_Base
{
    public function get_title()
    {
        return 'Ob Extension';
    }

    public function get_name()
    {
        return 'Ob Extension';
    }

    public function get_categories()
    {
        return ['basic'];
    }
    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'file_link',
            [
                'label' => esc_html__( 'File download', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $file_link = isset( $settings['file_link'] ) ? $settings['file_link'] : null;
        $file_download_url = !empty($file_link) ? $file_link['url'] : '';
        // if(isset($_GET['debug'])) {
        $terms = get_terms( array(
            'taxonomy' => 'taxonomy_table_of_content',
            'hide_empty' => false,
        ) );
        // }
        ?>
        <div class="content-index-ob">
            <div class="wrapper">
                <div class="content-index-ob__table">
                    <div class="content-index-ob__row content-index-ob__row--primary">
                        <div class="content-index-ob__title">
                            Content
                        </div>
                        <div class="content-index-ob__theme">
                            Theme
                        </div>
                        <div class="content-index-ob__author">
                            Author
                        </div>
                    </div>
                    <div class="content-index-ob__row-table">
                        <?php 
                        $count = is_user_logged_in() ? -1 : 0;
                        foreach($terms as $term) :
                        ?>
                            <?php 
                            $author = get_field('author', $term->taxonomy . '_' . $term->term_id);
                            ?>
                            <div class="content-index-ob__row js-content-index-row" data-id="<?php echo $term->term_id; ?>">
                                <div class="content-index-ob__title">
                                    <?php echo $term->name; ?>
                                </div>
                                <div class="content-index-ob__theme">
                                    <?php echo $term->description; ?>
                                </div>
                                <div class="content-index-ob__author">
                                    <?php echo $author; ?>
                                </div>
                            </div>
                        <?php 
                            endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribe-container">
            <div class="wrapper subscribe-container-wrapper">
                <?php if (is_user_logged_in()) : ?>
                    <div class="subscribe-title text-20-bold">
                        Download to access the report.
                    </div>
                <?php else : ?>
                    <div class="subscribe-title text-20-bold">
                        Access the report for free
                    </div>
                <?php endif; ?>
                <div class="subscribe-form">
                    <form>
                        <div class="form-control-inline">
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?= $file_download_url ?>" class="btn btn-black file-download-content" download>Download now</a>
<!--                                <a href="#" class="btn btn-black btn-outline content-index-ob--button3">Feedback</a>-->
                            <?php else : ?>
                                <a href="#" class="btn btn-black content-index-ob--button">Access now</a>
<!--                                <a href="#" class="btn btn-black btn-outline content-index-ob--button2">Already subscribe </a>-->
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="popup1" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>Get free access to the Index</h2>
                                <?php
                                    echo do_shortcode('[wpforms id="7989"]');
                                ?>
                                <div style="text-align: center;margin-top: 15px;">
                                    <a href="#" style="color: #FEBF10;display: block;margin-bottom: 10px;" class="content-index-ob--button2">Already Subscribe?</a>
                                    <p>This information is stored in our CRM database and is used only to contact you. We never share your data with third parties. For details, see our Privacy Policy.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup2" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>Thanks for subscribing!</h2>
                                <div style="text-align: center;margin-top: 15px;">
                                    <p>The link to access this report has been sent to your email. If you did not receive the email, check the spam box.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup3" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>Final step to get your documents</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>Enter the email address you use to subscribe to Index.</p>
                                </div>
                                <?php
                                echo do_shortcode('[wpforms id="7994"]');
                                ?>
                                <div style="text-align: center;margin-top: 15px;width: 100%">
                                    <p>New to Index? <a href="#" style="color: #FEBF10;" class="content-index-ob--button">Subscribe?</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup4" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>You're all set!!!</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>A must-have report to stay in the know with open finance index. Click at the button below and enjoy.</p>
                                </div>
                                <div style="display: flex;justify-content: center;align-items: center;width: 100%;">
                                    <a href="<?= $file_download_url ?>" class="btn btn-black file-download-content" download>Download now</a>
                                </div>                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup5" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                    <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>Just check your email again</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>The link to access this report has been sent to your email if a subscribe is associated with it. If you did not receive the email, check the spam box.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup-detail" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="ob-extension__wrapper" style="position: relative;">
                    <a href="#" class="ob-extension-detail__close"></a>
                    <div class="ob-extension-detail">
                        <div class="ob-extension-sidebar">
                            <div class="ob-extension-sidebar__inner">
                                <h2>Content</h2>
                                <ul>
                                    <?php
                                    $file_download = [];
                                    foreach($terms as $term) :
                                        $file = get_field('download_report_url', $term->taxonomy . '_' . $term->term_id);
                                        if(empty($file_download)) $file_download = $file;
                                        ?>
                                        <li>
                                            <a href="#active-<?php echo get_the_ID(); ?>" class="js-active-content-row js-content-index-row" data-id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?= $file_download_url ?>" style="margin-top: 20px;width: 100%;" class="btn btn-primary js-download-file" download>Download this report</a>
                            <?php endif; ?>
                        </div>
                        <div class="ob-extension-content">
                            <select class="ob-extension-select js-ob-extension-select">
                                <?php
                                    $file_download = [];
                                    foreach($terms as $term) :
                                        $file = get_field('download_report_url', $term->taxonomy . '_' . $term->term_id);
                                        if(empty($file_download)) $file_download = $file;
                                        ?>
                                        <option value="<?php echo $term->term_id; ?>">
                                            <?php echo $term->name; ?>
                                        </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="ob-extension-content__wrapper">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        <a href="#" class="ob-extension-scrollToList js-scroll-to-list">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"><path fill="#212121" d="M9.008 12.121v-.288c0-3.544 0-7.088-.002-10.632 0-.286.032-.555.205-.79A.976.976 0 0 1 10.28.04c.408.127.69.493.714.936.006.107.005.214.005.32v10.891c.1-.097.16-.152.216-.212 1.01-1.065 2.018-2.132 3.028-3.196.352-.37.77-.462 1.176-.27.584.28.772 1.066.38 1.603-.057.078-.125.148-.19.218l-4.79 5.04c-.541.57-1.09.57-1.629.003-1.618-1.704-3.238-3.406-4.854-5.112-.496-.523-.434-1.296.126-1.678.416-.283.912-.214 1.299.193.824.866 1.644 1.735 2.465 2.603.242.256.482.513.722.77l.06-.028ZM10.004 19.999h-8.93c-.762 0-1.262-.703-1.007-1.415.154-.427.464-.646.89-.69.077-.008.156-.004.234-.004 5.875 0 11.75 0 17.626.002.17 0 .347.012.508.063.465.15.734.639.664 1.163a1.024 1.024 0 0 1-.915.878c-.086.006-.171.003-.258.003h-8.812Z"/></svg>-->
<!--        </a>-->
        
        <script>
            const user_login = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;
            <?php
                $current_user = wp_get_current_user();
                $user_data = isset($current_user->data) ? $current_user->data : [];
                $user_name = isset($user_data) ? $user_data->display_name : [];
                $user_email = isset($user_data) ? $user_data->user_email : [];
            ?>
            let user_name = `<?php echo isset($user_name) ? $user_name : ''; ?>`;
            let user_email = `<?php echo isset($user_email) ? $user_email : ''; ?>`;
            // setTimeout(function (e){
            //     jQuery(document).ready(function($) {
            //         const form = $('form.wpforms-form');
            //         form.on('wpformsAjaxSubmitSuccess', (event) => {
            //             $(".container-popup-form").removeClass('is-active');
            //             $("#popup4").addClass('is-active');
            //             console.log('wpformsAjaxSubmitSuccess');
            //         })
            //     })
            // },1000)
            jQuery(document).ready(function($) {
                $('.btn-attend-campfire-click').on('click', function() {
                    let id_campfire = $(this).data('id');
                    let data = {
                        action: 'user_attend_campfire',
                        id_campfire: id_campfire,
                    };
                    $.post(ajax_object.ajaxurl, data, function(response) {
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
                function downloadURI(uri, name) {
                    var link = document.createElement("a");
                    link.download = name;
                    link.href = uri;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    delete link;
                    $.ajax({
                        type : "post", 
                        dataType : "json", 
                        url : '/wp-json/theme/v1/save-user-download-file', 
                        data : {
                            user_name: user_name,
                            user_email: user_email, 
                        },
                        success: function(response) {
                            console.log(response);
                        },
                    })
                }

                $(document).on('click','.file-download-content',function(e) {
                    e.preventDefault();
                    const download_button = $(this);
                    downloadURI(download_button.attr('href'),'PageIndex.pdf');
                })
                
                $('.content-index-ob--button').on('click', (e) => {
                    e.preventDefault();
                    $(".container-popup-form").removeClass('is-active');
                    if(user_login) {
                        const download_button = $('.file-download-content');
                        downloadURI(download_button.attr('href'),'PageIndex.pdf');
                    }else{
                        const _popup1 = $("#popup1");
                        if(_popup1.find('form').length) {
                            $("#popup1").addClass('is-active');
                        }else {
                            $("#popup4").addClass('is-active');
                        }
                    }
                });

                $('.content-index-ob--button2').on('click', (e) => {
                    e.preventDefault();
                    $(".container-popup-form").removeClass('is-active');
                    $("#popup3").addClass('is-active');
                });

                $(document).on('change','.js-ob-extension-select',function(e) {
                    const id = $(this).val();
                    $.ajax({
                        type : "post", //Phương thức truyền post hoặc get
                        dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                        url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                        data : {
                            action: "getChapter", //Tên action
                            dataId: id,
                        },
                        context: this,
                        beforeSend: function(){
                            //Làm gì đó trước khi gửi dữ liệu vào xử lý
                        },
                        success: function(response) {
                            //Làm gì đó khi dữ liệu đã được xử lý
                            if(response.success) {
                                $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper').html(response.data);
                            }
                            else {
                                console.log('Đã có lỗi xảy ra');
                            }
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            //Làm gì đó khi có lỗi xảy ra
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    })
                });

                $(document).on('click','.js-content-index-row', function(e) {
                    e.preventDefault();
                    // $(".container-popup-form").removeClass('is-active');
                    // if(!user_login) {
                    //     $(".container-popup-form").removeClass('is-active');
                    //     const _popup1 = $("#popup1");
                    //     if(_popup1.find('form').length) {
                    //         $("#popup1").addClass('is-active');
                    //     }else {
                    //         $("#popup4").addClass('is-active');
                    //     }
                    //     return false;
                    // }
                    const id = $(this).attr('data-id');
                    $("#popup-detail").addClass('is-active');
                    const sidebar_row_active = $('.js-active-content-row[data-id="' + id + '"]')
                    sidebar_row_active.addClass('is-active');
                    sidebar_row_active.parent().siblings().children('.js-active-content-row').removeClass('is-active');

                    $.ajax({
                        type : "post", //Phương thức truyền post hoặc get
                        dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                        url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                        data : {
                            action: "getChapter", //Tên action
                            dataId: id,

                        },
                        context: this,
                        beforeSend: function(){
                            //Làm gì đó trước khi gửi dữ liệu vào xử lý
                        },
                        success: function(response) {
                            //Làm gì đó khi dữ liệu đã được xử lý
                            if(response.success) {
                                $('#popup-detail').find('.ob-extension-detail').find('.ob-extension-content__wrapper').html(response.data);
                            }
                            else {
                                console.log('Đã có lỗi xảy ra');
                            }
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            //Làm gì đó khi có lỗi xảy ra
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    })
                });

                // $(document).on('click', '#wpforms-submit-76', function(e) {
                //     $("#popup1").removeClass('is-active');
                //     $("#popup2").addClass('is-active');
                // })
                $(document).on('click', '#wpforms-submit-7989', function(e) {
                    $(".container-popup-form").removeClass('is-active');
                    const form_data = $(this).parents('form').serializeArray();
                    form_data.map((v,i) => {
                        if(v.name == 'wpforms[fields][0][first]') {
                            user_name = v.value + ' ' + form_data[ i + 1].value;
                        }
                        if(v.name == 'wpforms[fields][1]') {
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
            });
            jQuery(document).ready(function(e) {
                $(window).on("scroll",function(e){
                    const scrollTop = $(this).scrollTop();
                    const content_offset_top = $(".content-index-ob").offset().top;
                    const content_height = $(".content-index-ob").outerHeight();
                    const subscribe_container = $(".subscribe-container").outerHeight();
                    if(scrollTop > 500 && scrollTop < $(".content-index-ob").offset().top - content_height) {
                        $(".scroll-down-button-sub").addClass("is-active");
                    }else{
                        $(".scroll-down-button-sub").removeClass("is-active");
                    }
                    if(scrollTop > screen.height) {
                        $(".subscribe-container").addClass('is-active');
                        $(".ob-extension-scrollToList").addClass('is-remove');
                    }else{
                        $(".subscribe-container").removeClass('is-active');
                        $(".ob-extension-scrollToList").removeClass('is-remove');
                    }
                    if(scrollTop + screen.height > content_offset_top + content_height + (subscribe_container * 1.5)) {
                        $(".subscribe-container").addClass('fix-active-active');
                    }else{
                        $(".subscribe-container").removeClass('fix-active-active');
                    }
                })

                $(document).on('click','.js-scroll-to-list',function(e) {
                    e.preventDefault();
                    $('html,body').animate({
                        scrollTop: $(".content-index-ob").offset().top
                    }, 'slow');
                })
            });
        </script>
<?php
    }

    protected function _content_template()
    {
    }
}
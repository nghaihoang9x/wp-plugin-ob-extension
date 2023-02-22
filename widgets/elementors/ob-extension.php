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
                'label' => esc_html__('File download', 'textdomain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'subcription_form',
            [
                'label' => esc_html__('Subcription form', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => "7994",
            ]
        );

        $this->add_control(
            'feedback_form',
            [
                'label' => esc_html__('Feedback form', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => "",
            ]
        );

        $this->add_control(
            'new_to_index',
            [
                'label' => esc_html__('New to Index form', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => "7994",
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $file_link = isset($settings['file_link']) ? $settings['file_link'] : null;

        // Get form id
        $subcription_form = isset($settings['subcription_form']) ? $settings['subcription_form'] : null;
        $feedback_form = isset($settings['feedback_form']) ? $settings['feedback_form'] : null;
        $new_to_index = isset($settings['new_to_index']) ? $settings['new_to_index'] : null;

        $file_link = isset($settings['file_link']) ? $settings['file_link'] : null;
        $file_download_url = !empty($file_link) ? $file_link['url'] : '';

        $current_user = wp_get_current_user();
        $user_data = isset($current_user->data) ? $current_user->data : [];
        $user_name = isset($user_data) ? $user_data->display_name : [];
        $user_email = isset($user_data) ? $user_data->user_email : [];

        $user_login = is_user_logged_in();

        if(isset($_COOKIE['ob_user_email'])) {
            $user_email = $_COOKIE['ob_user_email'];
        };

        $activeToken = isset($_GET['activeToken']) ? $_GET['activeToken'] : '';
        if(!empty($activeToken)) {
            $hash = hash_hmac('sha256',  $user_email ,'obextensiontokenactive');
            if($hash == $activeToken) {
                $user_login = true;
            }
        };

        $terms = get_terms(array(
            'taxonomy' => 'taxonomy_table_of_content',
            'hide_empty' => false,
        ));
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
                        $count = $user_login ? -1 : 0;
                        foreach ($terms as $term) :
                            ?>
                            <?php
                            $author = get_field('author', $term->taxonomy . '_' . $term->term_id);
                            ?>
                            <a href="#contentIdRow<?php echo $term->term_id; ?>" class="content-index-ob__row js-content-index-row" data-id="<?php echo $term->term_id; ?>">
                                <div class="content-index-ob__title">
                                    <?php echo $term->name; ?>
                                </div>
                                <div class="content-index-ob__theme">
                                    <?php echo $term->description; ?>
                                </div>
                                <div class="content-index-ob__author">
                                    <?php echo $author; ?>
                                </div>
                            </a>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribe-container">
            <div class="wrapper subscribe-container-wrapper">
                <?php if ($user_login) : ?>
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
                            <?php if ($user_login) : ?>
                                <a href="<?= $file_download_url ?>" class="btn btn-black file-download-content" download>Download now</a>
                                <!--                                <a href="#" class="btn btn-black btn-outline content-index-ob--button3">Feedback</a>-->
                            <?php else : ?>
                                <a href="#" class="btn btn-black content-index-ob--button">Access now</a>
                                <a href="#" class="btn btn-black btn-outline content-index-ob--button2" style="margin-left: 15px">Already subscribe?</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if (!empty($subcription_form)) : ?>
        <div id="popup1" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                    <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>Get free access to the Index</h2>
                                <?php
                                echo do_shortcode('[wpforms id="' . $subcription_form . '"]');
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
    <?php endif; ?>
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
        <?php if (!empty($new_to_index)) : ?>
        <div id="popup3" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                    <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>One final step</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>Enter the email address you used to subscribe.</p>
                                </div>
                                <?php
                                echo do_shortcode('[wpforms id="' . $new_to_index .'"]');
                                ?>
                                <div style="text-align: center;margin-top: 15px;width: 100%">
                                    <p><a href="#" style="color: #FEBF10;" class="content-index-ob--button">Back to the subscribe form</a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <div id="popup4" class="container-popup-form">
            <div class="wrapper-signup wpforms-container-full">
                <div class="wpforms-form">
                    <a href="#" class="ob-extension-detail__close"></a>
                    <div class="sign-up-form">
                        <div class="wrapper-form">
                            <div class="form-control form-control-inline ">
                                <h2>You're all set!!!</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>Click the button bellow to access the digital version of the index. You'll also be able to <br> download the pdf report without filling in form again.</p>
                                </div>
                                <div style="display: flex;justify-content: center;align-items: center;width: 100%;">
                                    <!-- <a href="<?= $file_download_url ?>" class="btn btn-black file-download-content" download>Download now</a> -->
                                    <a href="#" class="btn btn-black btn-outline content-index-ob--button2" style="margin-left: 15px">Access now</a>
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
                                <h2>You're all set!!!</h2>
                                <div style="text-align: center;margin-top: 15px;margin-bottom: 15px;width: 100%">
                                    <p>Click the button bellow to access the digital version of the index. You'll also be able to download the pdf report without filling in the form again.</p>
                                    <a href="<?php echo get_permalink( get_the_ID() ); ?>" class="btn btn-black btn-black js-asset-text"
                                       style="background-color: #FEBF10;width: 100%;text-align: center;border-color: transparent;width: 120px !important;height: 40px !important;display: flex;margin: 0 auto;justify-content: center;align-items: center;color: #000;margin-top: 15px;">Access now</a>
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
                                    foreach ($terms as $term) :
                                        $file = get_field('download_report_url', $term->taxonomy . '_' . $term->term_id);
                                        if (empty($file_download)) $file_download = $file;
                                        ?>
                                        <li>
                                            <a href="#contentIdRow<?php echo $term->term_id; ?>" class="js-active-content-row js-content-index-row" data-id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <?php if ($user_login) : ?>
                                <a href="<?= $file_download_url ?>" style="margin-top: 20px;width: 100%;" class="btn btn-primary js-download-file" download>Download this report</a>
                            <?php endif; ?>
                        </div>
                        <div class="ob-extension-content">
                            <select class="ob-extension-select js-ob-extension-select">
                                <?php
                                $file_download = [];
                                foreach ($terms as $term) :
                                    $file = get_field('download_report_url', $term->taxonomy . '_' . $term->term_id);
                                    if (empty($file_download)) $file_download = $file;
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

        <script>
            var ob_settings = {
                user_login: <?php echo $user_login ? 'true' : 'false'; ?>,
                user_name: `<?php echo isset($user_name) ? $user_name : ''; ?>`,
                user_email: `<?php echo isset($user_email) ? $user_email : ''; ?>`,
                admin_ajax_url: `<?php echo admin_url('admin-ajax.php'); ?>`,
                subcription_form: `<?php echo $subcription_form; ?>`,
                feedback_form: `<?php echo $feedback_form; ?>`,
                new_to_index: `<?php echo $new_to_index; ?>`,
            }

        </script>
        <?php
    }

    protected function _content_template()
    {
    }
}
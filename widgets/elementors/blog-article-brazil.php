<?php
class Elementor_BlogArticleBrazil_Widget extends \Elementor\Widget_Base
{
    public function get_title()
    {
        return 'BlogArticleBrazil';
    }

    public function get_name()
    {
        return 'BlogArticleBrazil';
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

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="wrapper-blog-article" id="example">
            <input type="hidden" id="site_url" value="<?= site_url() ?>" />
            <div class="wrapper">
                <h3>Recent articles</h3>
                <div class="wrapper-filter">
                    <form class="form-control-inline" @submit="search">
                        <input class="search-input" type="text" name="search" placeholder="Search articles" v-model="filter.s">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon.svg" alt="">
                    </form>
                    <div class="wrapper-option">
                        <div class="title text-16-bold">Filter by </div>
                        <div class="wrapper-select">
                            <select-custom v-if="listCategories.length" :options="listCategories" class="select" @input="changeCategory" />
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-bottom.svg" alt="">
                        </div>
                        <div class="wrapper-select">
                            <select-custom v-if="listRegions.length" :options="listRegions" class="select" @input="changeRegion" />
                        </div>
                        <div class="wrapper-select">
                            <select-custom v-if="listEssentials.length" :options="listEssentials" class="select" @input="changeEssential" />
                        </div>
                    </div>
                    <div class="wrapper-option-mobile">
                        <button class="btn filter-mobile">
                            Filter
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/filter_icon.svg" alt="">
                        </button>
                        <div class="list-select">
                            <div class="wrapper-select">
                                <select @change="changeCategory">
                                    <!-- <option value="">All categories</option> -->
                                    <option v-for="cate in listCategories" :value="cate.value">{{cate.name}}</option>
                                </select>
                            </div>
                            <div class="wrapper-select">
                                <select @change="changeRegion">
                                    <!-- <option value="hide">All regions</option> -->
                                    <option v-for="region in listRegions" :value="region.value">{{region.name}}</option>
                                </select>
                            </div>
                            <div class="wrapper-select">
                                <select @change="changeEssential">
                                    <!-- <option value="hide">All essentials</option> -->
                                    <option v-for="essential in listEssentials" :value="essential.value">{{essential.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-item minus-m16-lr">
                    <div class="wrapper-item m16-lr" v-for="blog in listBlogs">
                        <div class="item-slide">
                            <div class="wrapper-img-slide">
                                <a :href="blog.link">
                                    <img class="img-slide" :src="blog.thumbnail" alt="">
                                </a>
                            </div>
                            <div class="description-slide">
                                <div class="date-time-slide text-12-normal">
                                    <h4>{{blog.the_date}}<br></h4>{{blog.the_time}}
                                </div>
                                <div class="info-slide">
                                    <a :href="blog.link" class="title-slide text-16-normal --fade-in">
                                        {{blog.post_title}}
                                    </a>
                                    <div class="blog-category text-14-normal">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/article_black.svg" alt="">
                                        <span >
                                            <span class="author-slide">
                                                <a v-for="cate in blog.categories" :href="cate.link" class="item-cate-blog">
                                                    <span v-html="cate.name"></span> 
                                                </a>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button v-if="maxPage != filter.page && listBlogs.length" class="btn-border" @click="loadMore">Load more</button>
            </div>
        </div>
        <script>
            var vm = new Vue({
                el: '#example',
                data: function() {
                    return {
                        listBlogs: [],
                        listCategories: [],
                        listRegions: [],
                        listEssentials: [],
                        filter: {
                            page: 1,
                            size: 9,
                            s: '',
                            category: 'blog',
                            region: '',
                            essential: '',
                            brazil: true
                        },
                        maxPage: 2,
                        siteUrl: ''
                    }
                },
                created: function() {
                    this.siteUrl = document.getElementById('site_url').value;
                    this.getCategories();
                    this.getBlogs();
                    this.getRegions();
                    this.getEssentials();
                    console.log('this.siteUrl', this.siteUrl)
                },
                methods: {
                    changeCategory: function(item) {
                        if (item.target && typeof item.target.value !== 'undefined') {
                            item = this.listCategories.find(function(c) {
                                return c.value == item.target.value;
                            })
                        }

                        this.filter.category = item.value;
                        this.getBlogs(true);
                    },
                    parseToText: function(encodedStr) {
                        var parser = new DOMParser;
                        var dom = parser.parseFromString(
                            '<!doctype html><body>' + encodedStr,
                            'text/html');
                        var decodedString = dom.body.textContent;
                        return decodedString;
                    },
                    changeRegion: function(item) {
                        if (item.target && typeof item.target.value !== 'undefined') {
                            item = this.listRegions.find(function(c) {
                                return c.value === item.target.value;
                            })
                        }

                        this.filter.region = item.value;
                        this.getBlogs(true);
                    },
                    changeEssential: function(item) {
                        if (item.target && typeof item.target.value !== 'undefined') {
                            item = this.listEssentials.find(function(c) {
                                return c.value === item.target.value;
                            })
                        }

                        this.filter.essential = item.value;
                        this.getBlogs(true);
                    },
                    search: function($event) {
                        $event.preventDefault();
                        this.getBlogs(true);
                    },
                    loadMore: function() {
                        this.filter.page++;
                        this.getBlogs();
                    },
                    buildSearchQuery: function() {
                        let query = new URLSearchParams(this.filter).toString();
                        return this.siteUrl + "/wp-json/theme/v1/get-recent-posts?" + query;
                    },
                    getBlogs: async function(isResetPage = false) {
                        if (isResetPage) {
                            this.filter.page = 1;
                            this.listBlogs = [];
                        }
                        const searchUrl = this.buildSearchQuery();
                        const response = await fetch(searchUrl);
                        const data = await response.json();
                        this.maxPage = data.maxPage;
                        this.listBlogs = [...this.listBlogs, ...data.data];
                    },
                    getCategories: async function() {
                        const response = await fetch(this.siteUrl + "/wp-json/theme/v1/get-list-categories");
                        const data = await response.json();
                        let arrCate = [{
                            name: 'All Categories',
                            value: 'blog'
                        }];
                        for (let index = 0; index < data.length; index++) {
                                arrCate.push({
                                    name: this.parseToText(data[index].name),
                                    value: data[index].term_id
                                });
                        }
                        this.listCategories = arrCate;
                    },
                    getRegions: async function() {
                        const response = await fetch(this.siteUrl + "/wp-json/theme/v1/get-list-regions");
                        const data = await response.json();
                        this.listRegions = [{
                            name: 'All Regions',
                            value: ''
                        }, ...Object.keys(data).map(function(key) {
                            return {
                                name: data[key],
                                value: key
                            }
                        })];
                    },
                    getEssentials: async function() {
                        const response = await fetch(this.siteUrl + "/wp-json/theme/v1/get-list-essentials");
                        const data = await response.json();
                        this.listEssentials = [{
                            name: 'All essentials',
                            value: ''
                        }, ...Object.keys(data).map(function(key) {
                            return {
                                name: data[key],
                                value: key
                            }
                        })];
                    },
                    filterArticles: async function() {
                        const response = await fetch(this.siteUrl + "/wp-json/wp/v2/post?category=&region=&essential=");
                        const data = await response.json();
                    }
                },
                filters: {
                    getDay: function(value) {
                        let date = new Date(value).toDateString();
                        return date.split(' ')[2];
                    },
                    getDate: function(value) {
                        let date = new Date(value).toDateString();
                        return date.split(' ')[1] + ', ' + date.split(' ')[3];
                    }
                }
            })

            $('.filter-mobile').click(function() {
                $('.wrapper-option-mobile .list-select').toggleClass('hide-dropdown-filter');
            })

            // var scroll = $('.author-slide');
            // console.log(scroll.length);

            // for (let index = 0; index < scroll.length; index++) {
            //     console.log(scroll[index].scrollWidth);
            //     // console.log($(scroll[index]).innerWidth());
            //     if (scroll[index].scrollWidth > $(scroll[index]).innerWidth()) {
            //         $(scroll[index]).parent().addClass('three-dots');
            //     }
            // }
        </script>
<?php
    }

    protected function _content_template()
    {
    }
}

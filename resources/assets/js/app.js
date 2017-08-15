
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tabs', {
    template: `
<div>
<section class="inner-tabs">
    <div class="container">
    <ul>
    <li v-for="tab in tabs">
    <a :href="tab.href" @click="selectTab(tab)" :class="{ 'active': tab.isActive }">{{ tab.name }}</a>
</li>
</ul>
</div>
</section>
<div class="tabs-details">
    <slot></slot>
    </div>
    </div>
`,
data() {
    return {
        tabs: []
    }
},
created() {
    this.tabs = this.$children
},
methods: {
    selectTab(selectedTab) {
        this.tabs.forEach(tab => {
            tab.isActive = (tab.href == selectedTab.href);
    });
}
}
});

Vue.component('tab', {
    template: `
<div v-if="isActive">
    <section class="inner-tab-content">
    <div class="container">
    <div id="top" class="detail-wrapper">
        <!--Article block-->
    <div v-for="article in articles" class="well">
    <div class="media">
    <div class="media-body">
    <h2><a :href="article.source_url" target="_blank">{{ article.title }}</a></h2>
<div v-if="article.picture" class="image-box"><img :src="article.picture" />
    </div>
    <p v-html="article.description">...</p>
<div class="article-footer">
    <a :href="article.source_url" target="_blank" class="read">Read</a>
    </div>
    </div>
    </div>
    </div>
    <!--//Article block-->
    <div v-if="hasMoreArticles" class="show-more" @click="loadMoreArticles">Show More
</div>
<div v-if="errorMessage" class="show-more">{{ errorMessage }}
</div>
</div>
</div>
</section>
</div>
`,
props: {
    name: { required: true },
    selected: { default: false }
},
data() {
    return {
        isActive: true,
        articles: [],
        errorMessage: '',
        hasMoreArticles: false,
        page: 1
    };
},
computed: {
    href() {
        return '#' + this.name.toLowerCase().replace(/ /g, '-');
    }
},
mounted() {
    this.isActive = this.selected;
    this.prepareComponent();
},
methods: {
    /**
     * Prepare the component.
     */
    prepareComponent() {
        this.getArticles();
    },
    /**
     * Get articles.
     */
    getArticles() {
        const postId = $("#special-article span").text()
        const articleType = this.name.toLowerCase().replace(/ /g, '-')
        axios.get('/posts/' + postId + '/articles', {params:  {type: articleType}} )
            .then(response => {
            const responseData = response.data;
        this.articles = responseData.data
        this.hasMoreArticles = responseData.meta.paginator.hasMore
    })
    .catch(e => {
        this.errorMessage = "No records found"
    })
},
/**
 * Ajax loading articles
 */
loadMoreArticles() {
    this.page += 1
    const postId = $("#special-article span").text()
    console.log(postId)
    axios.get('/posts/' + postId + '/articles', {params:  {type: this.name.toLowerCase().replace(/ /g, '-'), page: this.page}} )
        .then(response => {
            const responseData = response.data;
            for (var i = 0; i < responseData.data.length; i++) {
                this.articles.push(responseData.data[i]);
            }
            if(responseData.data.length == 0) {
                this.hasMoreArticles = false
                this.errorMessage = "No records found"
            }
        }).catch(e => {
            this.errorMessage = "No records found"
        })
    },
}
});

const app = new Vue({
    el: '#app',
    data: {
        formInputs: {},
        formErrors: {},
        successMessage: '',
        disabledButton: false
    },
});

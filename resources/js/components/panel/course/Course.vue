<template>
    <transition name = "route" mode = "out-in" appear>
        <section class = "" v-if = "data" style = "text-align: justify">
            <div class = "row index_image">
                <div class = "col-xl-5 mb-3 h-100 index_image ">
                    <img class = "img-fluid mb-2" :src = "data.image" alt = "">
                    <div class = "label">
                       <span class = "badge bg-danger">
                           <i class = "bi bi-tags-fill ms-2"></i>
                           <b v-if = "data.category">  {{ data.category.title}}</b>
                       </span>
                    </div>


                    <div class = "d-inline-block">
                        <h3 class = "mb-2 fw-bold d-block">{{data.title}}</h3>
                    </div>
                    <router-link :to = "'/panel/edit/course/'+data.id" class = "text-dark">
                <span title = "ویرایش محصول" class = "mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class = "bi bi-pencil p-0 edit-pen"></i>
                </span>
                    </router-link>
                </div>
                <div class = "col-xl-12 mb-3 ">
                    <div class = "card ">
                        <div class = "card-body p-md-5">
                            <div id = "text" class = "mb-5"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <div v-else><p class = "fw-bold">این دوره موجود نیست</p></div>

    </transition>


</template>

<script>
    import App from '../App';

    export default {
        data: function () {
            return {
                data: {},
                id: this.$route.params.id,
                features: [],

            }
        },
        mounted() {
            this.loadِData();
        },
        methods: {
            async loadِData() {
                await axios.get('/api/panel/course/' + this.id)
                    .then((response) => {
                        this.data = response.data;
                        document.getElementById('text').innerText = this.data.description;
                    })
            },

        }
    }
</script>
<style>
    .color-span {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-bottom: -5px;
    }

    #content p {
        text-align: justify !important;
        line-height: 30px !important;
        padding-left: 10px;

    }

    #content figure {
        text-align: center !important;
        display: block !important;
    }

    #content figure figcaption {
        text-align: center !important;
    }

    .index_image .label {
        display: block;
        font-size: 20px;
        margin: -50px 20px 50px 20px;
    }

    #content figure img {
        max-width: 100%;
    }

    /*.index_image span{*/
    /*    display: inline-block;*/
    /*    right:20px;*/
    /*    bottom: 20px;*/
    /*}*/
    .edit-pen {
        font-size: 12px;
        margin: 0 6px !important;
    }
</style>

<template>
    <transition name = "route" mode = "out-in" appear>
        <section class = "" v-if = "data">
            <div class = "index_image">
             <img class = "img-fluid mb-2" :src = "data.image" width="350" alt = "">
<!--                <div class = "label">-->
<!--                   <span class = "badge bg-danger">-->
<!--                       <i class = "bi bi-tags-fill ms-2"></i>-->
<!--&lt;!&ndash;                       <b v-if = "data.category">  {{ // data.category.title}}</b>&ndash;&gt;-->
<!--               </span>-->
<!--                </div>-->
            </div>

                <h3 class = "mb-2 fw-bold d-inline-block ">{{data.article?.title}}</h3>

            <router-link :to = "'/panel/edit/food/slide/'+data.id" class = "text-dark">
                <span title = "ویرایش اسلاید" class = "mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class = "bi bi-pencil p-0 edit-pen"></i>
                </span>
            </router-link>


            <div class = "row mt-3">
                <div class = "col-lg-12 mb-3">
                    <div class = "card">
                        <div class = "card-body p-md-5">
<!--                            <h3  class="mb-5">دستور پخت:</h3>-->
                          <h3 class="mb-5">دستور پخت:</h3>

                          <router-link :to="'/panel/article/'+data.article?.id" >
                            <h3 v-if="data.article">{{ data.article?.title }}</h3>
                          </router-link>
                             <img v-if="data.article" class = "img-fluid mb-2" :src = "data.article?.image" width="350" alt = "">

                          <div id = "text" style="font-size: 18px;white-space: pre-line; text-align: right !important" class = "mb-5">
                            {{ data.article?.text }}
                          </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <div v-else><p class = "fw-bold">این اسلاید موجود نیست</p></div>

    </transition>


</template>

<script>
    import App from '../App';

    export default {
        data: function () {
            return {
                data: {},
                id: this.$route.params.id,
                tags: [],

            }
        },
        mounted() {
            this.loadSlide();
        },
        methods: {
           async loadSlide() {
               await axios.get('/api/panel/foodSlide/' + this.id)
                            .then((response) => {
                                this.data = response.data;
                                console.log(this.data)
                            })
                            .catch();
            },

        }
    }
</script>
<style>
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
    .edit-pen {
        font-size: 12px;
        margin: 0 6px !important;
    }
</style>

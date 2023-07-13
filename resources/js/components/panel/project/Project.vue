<template>
    <transition name = "route" mode = "out-in" appear>
        <section class = "" v-if = "data">
            <div class = "index_image">
             <img class = "w-50 mb-2" :src = "data.image" alt = "">
            </div>

                <h3 class = "mb-2 fw-bold d-inline-block ">{{data.title}}</h3>
                <p class = "mb-2 fw-bold d-inline-block ">{{data.sub_title}}</p>
            <router-link :to = "'/panel/edit/project/'+data.id" class = "text-dark">
                <span title = "ویرایش پروژه" class = "mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class = "bi bi-pencil p-0 edit-pen"></i>
                </span>
            </router-link>
            <div id="text" class="mt-5" ></div>

        </section>
        <div v-else><p class = "fw-bold">این پروژه موجود نیست</p></div>

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
            this.loadData();
        },
        methods: {
           async loadData() {

               await axios.get('/api/panel/project/' + this.id)
                            .then((response) => {
                                this.data = response.data;
                                document.getElementById('text').innerText = this.data.text;

                                if (this.data.tags) {
                                    for (let i = 0; i < JSON.parse(this.data.tags).length; i++) {
                                        this.tags.push(JSON.parse(this.data.tags)[i]);
                                    }
                                }
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

    /*.index_image .label {*/
    /*    display: block;*/
    /*    font-size: 20px;*/
    /*    margin: -50px 20px 50px 20px;*/
    /*}*/

    #content figure img {
        max-width: 100%;
    }
    .edit-pen {
        font-size: 12px;
        margin: 0 6px !important;
    }
</style>

<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ویرایش مطلب</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <!--                    <div class = "card" v-if = "isDefined" @click = "e => enableClick && makeImageArrays()">-->
                    <div class="card" v-if="isDefined" @click="e => enableClick">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">تصویر</label><br/>
                                        <image-cropper :isPng="isPng" name="" caption="" :hasCaption="hasCaption"
                                                       :isRequired="imgRequired"
                                                       :aspect="aspect" :src="data.image"/>
                                        <div id="imageHelp" class="form-text error"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xl-6 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input type="text" :class="{hasError: errors.title}" class="form-control"
                                               id="title"
                                               :value="data.title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-12 col-xl-6 mb-3">
                                        <label for="title_en" class="form-label">عنوان انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.title_en}" class="form-control en"
                                               id="title_en"
                                               :value="data.title_en" aria-describedby="titleHelp" required>
                                        <div id="title_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title_en">{{ e }}</p>

                                    </div>
                                    <div class="col-md-6 col-xl-4 mb-3">
                                        <label for="category" class="form-label">دسته بندی</label>
                                        <select class="form-select" id="category" aria-describedby="categoryHelp"
                                                aria-label="category"
                                                required>
                                            <option value=""></option>
                                            <!--                                          -->
                                            <option :selected="data.category.id == category.id"
                                                    v-for="category in categories"
                                                    :key="category.id" :value="category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>
                                    </div>


                                    <div class="col-md-12 col-xl-4 mb-3">
                                        <label for="subTitle_en" class="form-label">زیرنویس انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.subTitle_en}"
                                               class="form-control en" id="subTitle_en"
                                               :value="data.subTitle_en" aria-describedby="subTitle_enHelp" required>
                                        <div id="subTitle_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.subTitle_en">{{ e }}</p>

                                    </div>
                                    <div class="col-md-12 col-xl-4 mb-3">
                                        <label for="products_en" class="form-label">نام محصولات انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.products_en}"
                                               class="form-control en" id="products_en"
                                               :value="data.products_en" aria-describedby="products_enHelp" required>
                                        <div id="products_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.products_en">{{ e }}</p>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">مواد لازم</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.ingredients}"
                                                  aria-describedby="ingredientsHelp" class="form-control text-start"
                                                  id="ingredients">{{ data.ingredients }}</textarea>
                                        <div id="ingredientsHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.ingredients">{{ e }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">دستور پخت</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.text}"
                                                  aria-describedby="textHelp"
                                                  class="form-control text-start" id="text">{{ data.text}}</textarea>
                                        <!--                                        <editor mode = "edit" :content = "data.text" :id = "data.id" />-->

                                        <div id="textHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.text">{{ e }}</p>

                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-3">
                                        <label class="form-label">محصولات مرتبط</label>
                                        <Multiselect
                                            v-model="value"
                                            :mode="'tags'"
                                            :options="allProducts"
                                            :object="true"
                                            label="title"
                                            :searchable="true"
                                            :create-option="true"
                                        />

                                    </div>

                                </div>
                                <!--      ******************************************** زبان عربی ************************************     -->
                                <div class="row">
                                    <div class="col-md-12 col-xl-6 mb-3">
                                        <label for="title_ar" class="form-label">عنوان عربی</label>
                                        <input type="text" :class="{hasError: errors.title_ar}" class="form-control" id="title_ar"
                                               :value="data.title_ar"  aria-describedby="title_arHelp">
                                        <div id="title_arHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title_ar">{{ e }}</p>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">مواد لازم عربی</label>
                                        <!--                                       <div id="editor"></div>-->

                                        <!--                                        <editor mode = "new" />-->
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.ingredients_ar}"
                                                  aria-describedby="ingredients_arHelp" class="form-control text-start"
                                                  id="ingredients_ar">{{ data.ingredients_ar }}</textarea>
                                        <div id="ingredients_arHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.ingredients_ar">{{ e }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">دستور پخت عربی</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.text_ar}"
                                                  aria-describedby="text_arHelp" class="form-control text-start"
                                                  id="text_ar">{{ data.text_ar }}</textarea>
                                        <div id="text_arHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.text_ar">{{ e }}</p>
                                    </div>
                                </div>
                                <!--*****************************************************************************************-->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit @click.prevent="updateInfo">
                                            ویرایش
                                        </BtnSubmit>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </transition>


</template>

<script>
import ImageCropper from '../../components/ImageCropper';
import Editor from "../../components/Editor";
import BtnSubmit from "../../components/BtnSubmit";
import Multiselect from '@vueform/multiselect'


export default {
    components: {ImageCropper, BtnSubmit, Multiselect},
    data() {
        return {
            id: this.$route.params.id,
            data: {},
            categories: [],
            productCategories: [],
            products: [],
            errors: [],
            imgRequired: false,
            hasCaption: false,
            aspect: 1 / 1,
            isDefined: false,
            enableClick: true,
            // tags: [],
            articles: [],
            isPng: true,
            value: [],
            allProducts: []
        }
    },

    created() {
        this.loadCategories();
        this.loadArticle();
        this.loadProducts();

    },

    methods: {
        async loadArticle() {
            await axios.get('/api/panel/article/' + this.id)
                .then((response) => {

                    this.data = response.data;
                })
                .then(() => {
                    this.isDefined = true;
                })
                .then(() => {
                    this.value = this.data.related_products;
                })
                .then(() => {
                    this.watchTextAreas();
                })
                .catch();
        },
        loadProducts() {

            axios.get('/api/panel/product?page=1&perPage=1000&search=')
                .then((response) => {
                    this.allProducts = response.data.data;
                })
                .catch()
        },
        loadCategories() {
            axios.get('/api/panel/category/article?page=1&perPage=100000')
                .then((response) => {
                    this.categories = response.data.data;
                })
                .catch();
            // axios.get('/api/panel/category/product?page=1&perPage=100000')
            //     .then((response) => {
            //       this.productCategories = response.data.data;
            //     })
            //     .then(() => {
            //       setTimeout(()=>{
            //           this.showProducts();
            //       },1000)
            //     })
            //     .catch();
            // axios.get('/api/panel/article?page=1&perPage=100000')
            //     .then((response) => {
            //       this.articles = response.data.data;
            //     })
            //     .catch();
        },
        showProducts() {

            axios.get('/api/panel/product/by/category/' + document.getElementById('productCategory').value)
                .then((response) => {
                    this.products = response.data.data;
                    console.log(response.data.data)
                })
                .catch();
        },
        async updateInfo() {
            this.errors = [];
            let emptyFieldsCount = 0;
            let req = document.querySelectorAll('[required]');
            req.forEach((element) => {
                if (element.value === "") {
                    element.classList.add('hasError');
                    element.nextSibling.innerHTML = "فیلد اجباری";
                    emptyFieldsCount++;
                } else {
                    element.classList.remove('hasError');
                    element.nextSibling.innerHTML = "";
                }
            });
            let selectedProducts = [];
            this.value.forEach((element) => {
                selectedProducts.push(element.value)
            });

            if (emptyFieldsCount === 0) {

                await axios.post('/api/panel/article/' + this.$route.params.id,
                    {
                        id: this.$route.params.id,
                        image: document.getElementById('Image__code').value,
                        title: document.getElementById('title').value,
                        title_en: document.getElementById('title_en').value,
                        subTitle_en: document.getElementById('subTitle_en').value,
                        products_en: document.getElementById('products_en').value,
                        article_category_id: document.getElementById('category').value,
                        ingredients: document.getElementById('ingredients').value,
                        text: document.getElementById('text').value,
                        related_products: selectedProducts,

                        title_ar: document.getElementById('title_ar').value,
                        ingredients_ar: document.getElementById('ingredients_ar').value,
                        text_ar: document.getElementById('text_ar').value,
                    })
                    .then((response) => {
                        console.log(response)
                        if (response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/article/' + this.id});
                            }, 1000);
                        }
                    })
                    .catch((error) => {
                        if (error.response && error.response.status === 422) {
                            let errorList = Array(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors = errorList[i];
                            }
                        } else if (error.response.status === 500) {
                            if (error.response.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                async function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.response.data.message);
                                    }, 200);
                                }

                                showAlertSql();
                            } else {
                                async function showAlert500() {
                                    setTimeout(() => {
                                        alert(error.message + ' '
                                            + error.response.data.message);
                                    }, 200);
                                }

                                showAlert500();
                            }

                        } else {
                            async function showAlert() {
                                setTimeout(() => {
                                    alert(error.message);
                                }, 200);
                            }

                            showAlert();

                        }
                    });
            }
        },
        watchTextAreas() {
            let txt = document.querySelector("#text");
            txt?.setAttribute("style", "height:" + (txt.scrollHeight + 20) + "px;overflow-y:hidden;");
            txt?.addEventListener("input", changeHeight, false);

            function changeHeight() {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            }
        },



    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
span i {
    cursor: pointer;
}

.tagElement .uri {
    text-align: left !important;
    font-weight: lighter !important;

}


/*@media (min-width: 1200px) {*/
/*    .modal-xl {*/
/*        max-width: 1140px;*/
/*    }*/
/*}*/

/*@media (min-width: 992px) {*/
/*    .modal-lg, .modal-xl {*/
/*        max-width: 800px;*/
/*    }*/
/*}*/

/*@media (min-width: 576px) {*/
/*    .modal-dialog {*/
/*        max-width: 500px;*/
/*        margin: 1.75rem auto;*/
/*    }*/
/*}*/

.multiselect-tags-search {
    background-color: transparent !important;
}

.multiselect-tag {
    background-color: #0d6efd !important;
}

.multiselect.is-active {
    box-shadow: none !important;
}

</style>

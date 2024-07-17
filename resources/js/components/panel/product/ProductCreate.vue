<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت محصول جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">تصویر</label><br/>
                                        <image-cropper :isPng="isPng" name="" caption="" :hasCaption="hasCaption"
                                                       :isRequired="imgRequired" :aspect="aspect"/>
                                        <div id="imageHelp" class="form-text error"></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input type="text" :class="{hasError: errors.title}" class="form-control"
                                               id="title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="title_en" class="form-label">عنوان انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.title_en}" class="en form-control"
                                               id="title_en" aria-describedby="title_enHelp">
                                        <div id="title_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title_en">{{ e }}</p>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subTitle" class="form-label">زیرنویس</label>
                                        <input type="text" :class="{hasError: errors.subTitle}" class="form-control"
                                               id="subTitle" aria-describedby="subTitleHelp">
                                        <div id="subTitleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.subTitle">{{ e }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="color" class="form-label">رنگ</label>
                                        <input type="text" :class="{hasError: errors.color}" class="form-control en"
                                               id="color" aria-describedby="colorHelp" >
                                        <div id="colorHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.color">{{ e }}</p>
                                    </div>

                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="flavor" class="form-label">باطعم</label>
                                        <input type="text" :class="{hasError: errors.flavor}"
                                               class=" form-control text-start" id="flavor">
                                        <div id="flavorHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.flavor">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="flavor_en" class="form-label">باطعم انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.flavor_en}"
                                               class="en form-control text-start" id="flavor_en">
                                        <div id="flavor_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.flavor_en">{{ e }}</p>

                                    </div>

                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="category" class="form-label">دسته</label>
                                        <select class="form-select" id="category" aria-describedby="categoryHelp"
                                                aria-label="category" required>
                                            <option value=""></option>
                                            <option v-for="category in categories" :key="category.id"
                                                    :value="category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>

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

                                    <div class="col-md-12 col-lg-12 mb-3">
                                        <label for="link" class="form-label">لینک خرید</label>
                                        <input type="text" :class="{hasError: errors.link}"
                                               class="en form-control text-start" id="link">
                                        <div id="linkHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.link">{{ e }}</p>

                                    </div>

<!--                                    <div class="col-md-12 mb-3">-->
<!--                                        <label class="form-label" for="ingredients">ترکیبات</label>-->
<!--                                        <textarea @input="watchTextAreas" :class="{hasError: errors.ingredients}" aria-describedby="ingredientsHelp" class="form-control text-start" id="ingredients"></textarea>-->
<!--                                        <div id="ingredientsHelp" class="form-text error"></div>-->
<!--                                        <p class="form-text error m-0" v-for="e in errors.ingredients">{{ e }}</p>-->
<!--                                    </div>-->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="text">متن</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.text}"
                                                  aria-describedby="textHelp" class="form-control text-start"
                                                  id="text"></textarea>
                                        <div id="textHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.text">{{ e }}</p>
                                    </div>
                                    <!--      ******************************************** زبان عربی ************************************     -->
                                    <div class="row">
                                        <div class="col-md-12 col-xl-6 mb-3">
                                            <label for="title_ar" class="form-label">عنوان عربی</label>
                                            <input type="text" :class="{hasError: errors.title_ar}" class="form-control" id="title_ar"
                                                   aria-describedby="title_arHelp">
                                            <div id="title_arHelp" class="form-text error"></div>
                                            <p class="form-text error m-0" v-for="e in errors.title_ar">{{ e }}</p>

                                        </div>
                                        <div class="col-md-12 col-xl-6 mb-3">
                                            <label for="flavor_ar" class="form-label">باطعم عربی</label>
                                            <input type="text" :class="{hasError: errors.flavor_ar}"
                                                   class="en form-control text-start" id="flavor_ar">
                                            <div id="flavor_arHelp" class="form-text error"></div>
                                            <p class="form-text error m-0" v-for="e in errors.flavor_ar">{{ e }}</p>
                                        </div>

                                    </div>


                                    <div class="row">
<!--                                        <div class="col-md-12 mb-3">-->
<!--                                            <label class="form-label">ترکیبات</label>-->
<!--                                            &lt;!&ndash;                                       <div id="editor"></div>&ndash;&gt;-->

<!--                                            &lt;!&ndash;                                        <editor mode = "new" />&ndash;&gt;-->
<!--                                            <textarea @input="watchTextAreas" :class="{hasError: errors.ingredients_ar}"-->
<!--                                                      aria-describedby="ingredients_arHelp" class="form-control text-start"-->
<!--                                                      id="ingredients_ar"></textarea>-->
<!--                                            <div id="ingredients_arHelp" class="form-text error"></div>-->
<!--                                            <p class="form-text error m-0" v-for="e in errors.ingredients_ar">{{ e }}</p>-->
<!--                                        </div>-->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">متن عربی</label>
                                            <textarea @input="watchTextAreas" :class="{hasError: errors.text_ar}"
                                                      aria-describedby="text_arHelp" class="form-control text-start"
                                                      id="text_ar"></textarea>
                                            <div id="text_arHelp" class="form-text error"></div>
                                            <p class="form-text error m-0" v-for="e in errors.text_ar">{{ e }}</p>
                                        </div>
                                    </div>
                                    <!--*****************************************************************************************-->

                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit @click.prevent="createInfo">
                                            ثبت
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
import App from '../App';
import BtnSubmit from "../../components/BtnSubmit";
import Multiselect from '@vueform/multiselect'


export default {
    components: {ImageCropper, BtnSubmit, App, Multiselect},
    data: function () {
        return {
            id: '',
            blog: [],
            categories: [],
            errors: [],
            image_codes: [],
            image_names: [],
            imgRequired: true,
            hasCaption: false,
            aspect: false,
            isPng: true,
            features: [{"label": "", "value": "", "unit": ""}],
            sizes: [{"size": "", "dimensions": "", "color_name": "", "color_code": "", "stock": ""}],
            images: [['', '']],
            value: [],
            allProducts: []

        }
    },
    mounted() {
        this.loadCategories();
        this.loadProducts();
    },
    methods: {
        async loadCategories() {

            await axios.get('/api/panel/category/product?page=1&perPage=100000')
                .then((response) => {
                    this.categories = response.data.data;
                }).catch();
        },
        loadProducts() {

            axios.get('/api/panel/product?page=1&perPage=1000&search=')
                .then((response) => {
                    this.allProducts = response.data.data;
                })
                .catch()
        },

        async createInfo() {
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
            if (emptyFieldsCount === 0) {
                // let features = [];
                // for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                //     features.push('{"label": "' + document.getElementsByName('featureLabel')[i].value + '",' + ' "value": "' + document.getElementsByName('featureValue')[i].value + '", "unit": "' + document.getElementsByName('featureUnit')[i].value + '"}');
                //
                // }
                // if (document.getElementsByName('featureLabel').length === 0) {
                //     features = '[]';
                // } else {
                //     features = '[' + features.toString() + ']';
                // }
                let selectedProducts = [];
                this.value.forEach((element)=>{
                    selectedProducts.push(element.value)
                });

                await axios.post('/api/panel/product', {
                    // image: document.getElementById('Image_index_code').value,
                    image: document.getElementById('Image__code').value,
                    title: document.getElementById('title').value,
                    subTitle: document.getElementById('subTitle').value,
                    title_en: document.getElementById('title_en').value,
                    flavor: document.getElementById('flavor').value,
                    flavor_en: document.getElementById('flavor_en').value,
                    // ingredients: document.getElementById('ingredients').value,
                    product_category_id: document.getElementById('category').value,
                    text: document.getElementById('text').value,
                    color: document.getElementById('color').value,
                    // features: features,
                    link: document.getElementById('link').value,
                    related_products: selectedProducts,

                    title_ar: document.getElementById('title_ar').value,
                    flavor_ar: document.getElementById('flavor_ar').value,
                    text_ar: document.getElementById('text_ar').value,

                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/products'});
                            }, 1000);

                            console.log(response)
                        }
                    })
                    .catch((error) => {
                        // console.log(error);
                        // console.log(error.message);
                        // console.log(error.response.data);

                        if (error.status === 422) {
                            let errorList = Array(error.response.data);
                            // console.log(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                //  console.log('i',errorList[i]);
                                this.errors = errorList[i];
                            }
                            console.log(this.errors.toString());
                        } else if (error.status === 500) {
                            if (error.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                async function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.data.message);
                                    }, 200);
                                }

                                showAlertSql();
                            } else {
                                async function showAlert500() {
                                    setTimeout(() => {
                                        alert(error.message + ' '
                                            + error.data.message);
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

                    })
            }

            if (error && error.status && error.status === 401) {
                window.location = '/panel/login'
                App.methods.logout();
            }



        },
        watchTextAreas() {
            let txt = document.querySelector("#text");
            txt.setAttribute("style", "height:" + (txt.scrollHeight + 20) + "px;overflow-y:hidden;");
            txt.addEventListener("input", changeHeight, false);

            function changeHeight() {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            }
        },
        addFeature() {

            this.features.push('{"label": "", "value": "", "unit": ""}');
        },
        removeFeature(index) {

            this.features.splice(index, 1)
        },
        updateFeatures() {
            this.features = [];
            for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                this.features.push({
                    "label": document.getElementsByName('featureLabel')[i].value.toString(),
                    "value": document.getElementsByName('featureValue')[i].value.toString(),
                    "unit": document.getElementsByName('featureUnit')[i].value.toString()
                });
            }
        },

        addSize() {

            this.sizes.push('{}');
        },
        removeSize(index) {

            this.sizes.splice(index, 1)
        },
        async updateSizes() {
            let a = [];
            for (let i = 0; i < document.getElementsByName('size').length; i++) {
                await a.push({
                    "size": document.getElementsByName('size')[i].value.toString(),
                    "dimensions": document.getElementsByName('dimensions')[i].value.toString(),
                    "color_name": document.getElementsByName('color_name')[i].value.toString(),
                    "color_code": document.getElementsByName('color_code')[i].value.toString(),
                    "stock": document.getElementsByName('stock')[i].value,
                });
            }
            this.sizes = a;

        },
        removeImage(index) {
            this.images.splice(index, 1);

        },
        addImage() {
            this.images.push(['', '']);

        },
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

<style>
span i {
    cursor: pointer;
}

.en {
    direction: ltr !important;
    text-align: left !important;
}

.multiselect-tags-search{
    background-color: transparent !important;
}
.multiselect-tag{
    background-color: #0d6efd !important;
}
.multiselect.is-active
{
    box-shadow: none !important;
}
</style>

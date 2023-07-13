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
                                        <image-cropper    :isPng="isPng"  name="" caption="" :hasCaption="hasCaption" :isRequired="imgRequired" :aspect="aspect"/>
                                        <div id="imageHelp" class="form-text error"></div>
                                    </div>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="col-12 mb-3">-->
<!--                                        <label class="form-label">تصاویر</label><br/>-->
<!--                                        <span @click="addImage" class="px-2 d-inline-block align-middle"><i-->
<!--                                            class="bi bi-plus-circle-fill p-0 mt-2 m-0"-->
<!--                                            style="font-size: 15px"></i></span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="imgSection">-->
<!--                                    <div class="row" v-for="(item, index) in images" :key="index">-->
<!--                                        &lt;!&ndash;                                    <div class="row">&ndash;&gt;-->
<!--                                        <div class="col-auto pt-3">-->
<!--                                            <span @click="removeImage(index)"><i class="bi bi-x-circle-fill m-0 "-->
<!--                                                                                 style="font-size: 15px"></i></span>-->
<!--                                        </div>-->
<!--                                        <div class="col-10">-->
<!--                                            <input type="text" class="d-none" :value="item" :id="'prev_image_'+index">-->
<!--                                            <image-cropper :name="index" caption="" :hasCaption="hasCaption"-->
<!--                                                           :isRequired="imgRequired" :aspect="aspect"/>-->
<!--                                            <div id="imageHelp" class="form-text error"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <div class="row">

                                    <div class="col-md-9 col-lg-10 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input type="text" :class="{hasError: errors.title}" class="form-control"
                                               id="title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-3 col-lg-2 mb-3">
                                        <label for="color" class="form-label">تم رنگ محصول</label>
                                        <input type="text" :class="{hasError: errors.color}" class="form-control en"
                                               id="color" aria-describedby="colorHelp" required>
                                        <div id="colorHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.color">{{ e }}</p>
                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="title_en" class="form-label">عنوان انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.title_en}" class="en form-control"
                                               id="title_en" aria-describedby="title_enHelp" required>
                                        <div id="title_enHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title_en">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="subTitle" class="form-label">زیرنویس انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.subTitle}"
                                               class="en form-control text-start" id="subTitle" required>
                                        <div id="subTitleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.subTitle">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="flavor" class="form-label">باطعم انگلیسی</label>
                                        <input type="text" :class="{hasError: errors.flavor}"
                                               class="en form-control text-start" id="flavor">
                                        <div id="flavorHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.flavor">{{ e }}</p>

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
                                    <div class="col-md-4 col-lg-4 mb-3">
                                    <label for="tag1" class="form-label">تگ 1</label>
                                    <input type="text" :class="{hasError: errors.tag1}" class="form-control"
                                           id="tag1" aria-describedby="tag1Help" >
                                    <div id="tag1Help" class="form-text error"></div>
                                    <p class="form-text error m-0" v-for="e in errors.tag1">{{ e }}</p>

                                </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="tag2" class="form-label">تگ 2</label>
                                        <input type="text" :class="{hasError: errors.tag2}"
                                               class="form-control text-start" id="tag2" >
                                        <div id="tag2Help" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.tag2">{{ e }}</p>

                                    </div>
                                  <div class="col-md-12 col-lg-12 mb-3">
                                    <label for="link" class="form-label">لینک خرید</label>
                                    <input type="text" :class="{hasError: errors.link}"
                                           class="en form-control text-start" id="link">
                                    <div id="linkHelp" class="form-text error"></div>
                                    <p class="form-text error m-0" v-for="e in errors.link">{{ e }}</p>

                                  </div>

<!--                                    <div class="col-md-4 col-lg-2 mb-3">-->
<!--                                        <label for="price" class="form-label">قیمت (ریال)</label>-->
<!--                                        <input type="number" min="1000" :class="{hasError: errors.price}"-->
<!--                                               class="form-control text-start" id="price" required>-->
<!--                                        <div id="priceHelp" class="form-text error"></div>-->
<!--                                        <p class="form-text error m-0" v-for="e in errors.price">{{ e }}</p>-->

<!--                                    </div>-->
<!--                                    <div class="col-md-4 col-lg-1 mb-3">-->
<!--                                        <label for="off" class="form-label">%تخفیف</label>-->
<!--                                        <input type="number" :class="{hasError: errors.off}"-->
<!--                                               class="form-control text-start" id="off">-->
<!--                                        <div id="offHelp" class="form-text error"></div>-->
<!--                                        <p class="form-text error m-0" v-for="e in errors.off">{{ e }}</p>-->

<!--                                    </div>-->

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="text">ویژگی</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.text}"
                                                  aria-describedby="textHelp" class="form-control text-start"
                                                  id="text"></textarea>
                                        <div id="textHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.text">{{ e }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3" id="features">
                                        <div>
                                            <label class="form-label mb-1 align-middle">ارزش غذایی</label>
                                            <span @click="addFeature" class="px-3 d-inline-block align-middle"><i
                                                class="bi bi-plus-circle-fill p-0 mt-2 m-0" style="font-size: 15px"></i></span>
                                        </div>

                                        <div v-for="(item, index) in features" :key="index" class="row tagElement">
                                            <div class="col-4 col-md-3 mb-3">
                                                <input type="text" name="featureLabel" class="form-control"
                                                       @input="updateFeatures" :value="item.label" placeholder="عنوان"
                                                       required>
                                                <div class="form-text error"></div>
                                            </div>
                                            <div class="col-3 col-md-3 mb-3">
                                                <input type="text" name="featureValue" class="form-control"
                                                       @input="updateFeatures" :value="item.value" placeholder="مقدار"
                                                       required>
                                                <div class="form-text error"></div>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <input type="text" name="featureUnit" class="form-control"
                                                       @input="updateFeatures" :value="item.unit" placeholder="واحد اندازه گیری"
                                                       required>
                                                <div class="form-text error"></div>
                                            </div>
                                            <div class="col-auto mb-3 pt-2">
                                                <span @click="removeFeature(index)"><i class="bi bi-x-circle-fill m-0 "
                                                                                       style="font-size: 15px"></i></span>
                                            </div>
                                        </div>
                                    </div>

<!--                                    <div class="col-md-12 mb-3" id="sizes">-->
<!--                                        <div>-->
<!--                                            <label class="form-label mb-1 align-middle">سایز و رنگ</label>-->
<!--                                            <span @click="addSize" class="px-3 d-inline-block align-middle"><i-->
<!--                                                class="bi bi-plus-circle-fill p-0 mt-2 m-0" style="font-size: 15px"></i></span>-->
<!--                                        </div>-->

<!--                                        <div v-for="(item, index) in sizes" :key="index" id="sizeSection"-->
<!--                                             class="row sizeElement">-->
<!--                                            <div class="col-6 col-md-2 mb-3">-->
<!--                                                <input type="text" name="size" class="form-control" @input="updateSizes"-->
<!--                                                       value="" placeholder="سایز" required>-->
<!--                                                <div class="form-text error"></div>-->
<!--                                            </div>-->
<!--                                            <div class="col-6 col-md-4 mb-3">-->
<!--                                                <input type="text" name="dimensions" class="form-control"-->
<!--                                                       @input="updateSizes" value="" placeholder="ابعاد" required>-->
<!--                                                <div class="form-text error"></div>-->
<!--                                            </div>-->
<!--                                            <div class="col-6 col-md-2 mb-3">-->
<!--                                                <input type="text" name="color_name" class="form-control"-->
<!--                                                       @input="updateSizes" value="" placeholder="رنگ" required>-->
<!--                                                <div class="form-text error"></div>-->
<!--                                            </div>-->
<!--                                            <div class="col-6 col-md-2 mb-3">-->
<!--                                                <input type="text" name="color_code" class="form-control" dir="ltr"-->
<!--                                                       @input="updateSizes" value="" placeholder="(#fffff) کد رنگ"-->
<!--                                                       required>-->
<!--                                                <div class="form-text error"></div>-->
<!--                                            </div>-->
<!--                                            <div class="col-10 col-md-1 mb-3">-->
<!--                                                <input type="number" name="stock" class="form-control" min="0" dir="ltr"-->
<!--                                                       @input="updateSizes" value="" placeholder="موجودی" required>-->
<!--                                                <div class="form-text error"></div>-->
<!--                                            </div>-->
<!--                                            <div class="col-1 mb-3 pt-2">-->
<!--                                                <span @click="removeSize(index)"><i class="bi bi-x-circle-fill m-0 "-->
<!--                                                                                    style="font-size: 15px"></i></span>-->
<!--                                            </div>-->
<!--                                        </div>-->

<!--                                    </div>-->
                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit  @click.prevent="createInfo">
                                            ثبت
                                        </BtnSubmit>
<!--                                        <button class="btn btn-primary" @click.prevent="createInfo" type="submit">-->
<!--                                            ثبت-->
<!--                                        </button>-->
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


export default {
    components: {ImageCropper, BtnSubmit, App},
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
            images: [['','']],

        }
    },
    mounted() {
        this.loadCategories();
    },
    methods: {
        async loadCategories() {

            await axios.get('/api/panel/category/product?page=1&perPage=100000')
                .then((response) => {
                this.categories = response.data.data;
            }).catch();
        },

        async createInfo() {
            // console.log('beforePost', document.getElementById('content_text_area'));
            //  App.methods.checkToken();
            //    Editor.methods.updatePreview();
            //   console.log(document.getElementById('editor').innerHTML);
            // axios.post('/api/panel/check/user/token', {id: JSON.parse(localStorage.getItem('user')).id})
            //     .then((response) => {
            //         console.log(response);
            //         if (response.status === 200) {
            //             localStorage.setItem('expire', response.data.expire);
            //             console.log(localStorage);
            //         }
            //     })
            //     .then(() => {

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
            // let images = [];
            // for (let i = 0; i < this.images.length; i++) {
            //     if (document.getElementById('prev_image_' + i).value || document.getElementById('Image_' + i + '_code').value) {
            //         images.push([
            //             document.getElementById('prev_image_' + i).value,
            //             document.getElementById('Image_' + i + '_code').value,
            //         ]);
            //     }
            //
            // }

            if (emptyFieldsCount === 0) {
                let features = [];
                for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                    features.push('{"label": "' + document.getElementsByName('featureLabel')[i].value + '",' + ' "value": "' + document.getElementsByName('featureValue')[i].value  + '", "unit": "' + document.getElementsByName('featureUnit')[i].value + '"}');

                }
                if (document.getElementsByName('featureLabel').length === 0) {
                    features = '[]';
                } else {
                    features = '[' + features.toString() + ']';
                }

                await axios.post('/api/panel/product', {
                    // image: document.getElementById('Image_index_code').value,
                    image: document.getElementById('Image__code').value,
                    title: document.getElementById('title').value,
                    subTitle: document.getElementById('subTitle').value,
                    title_en: document.getElementById('title_en').value,
                    flavor: document.getElementById('flavor').value,
                    tag1: document.getElementById('tag1').value,
                    tag2: document.getElementById('tag2').value,
                    product_category_id: document.getElementById('category').value,
                    text: document.getElementById('text').value,
                    features: features,
                    color: document.getElementById('color').value,
                  link: document.getElementById('link').value
                    // sizes: this.sizes,
                    // off: document.getElementById('off').value,
                    // price: document.getElementById('price').value,

                    // stock: document.getElementById('stock').value,
                    // image_codes: this.image_codes,
                    // image_names: this.image_names,
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
            // })
            // .catch((error) => {
            //     console.log(error);

            if (error && error.status && error.status === 401) {
                window.location = '/panel/login'
                App.methods.logout();
            }
            // });


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
            //    App.methods.checkToken();
            // axios.post('/api/panel/check/user/token', {id: JSON.parse(localStorage.getItem('user')).id})
            //     .then((response) => {
            //         if (response.status === 200) {
            //             localStorage.setItem('expire', response.data.expire);
            //             console.log(localStorage);
            //         }
            //     })
            //     .then(() => {
                    this.features = [];
                    for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                        this.features.push({
                            "label": document.getElementsByName('featureLabel')[i].value.toString(),
                            "value": document.getElementsByName('featureValue')[i].value.toString(),
                            "unit": document.getElementsByName('featureUnit')[i].value.toString()
                        });
                    }
                // })
                // .catch((error) => {
                //     if (error.response.status === 401) {
                //         window.location = '/panel/login'
                //         App.methods.logout();
                //     }
                // });


        },

        addSize() {

            this.sizes.push('{}');
        },
        removeSize(index) {

            this.sizes.splice(index, 1)
        },
        async updateSizes() {



            // this.sizes = [];
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
        removeImage(index){
            this.images.splice(index, 1);

        },
        addImage(){
            this.images.push(['','']);

        }

    }
}
</script>
<style>
span i {
    cursor: pointer;
}
.en{
    direction: ltr !important;
    text-align: left !important;
}
</style>

<template>
    <transition name = "route" mode = "out-in" appear>
        <section>
            <h3 class = "mb-5">ثبت دوره جدید</h3>

            <div class = "row mt-3">
                <div class = "col-12 mb-3">
                    <div class = "card">
                        <div class = "card-body">
                            <form id = "editForm">
                                <div class = "row">
                                    <div class = "col-12 mb-3">
                                        <label class = "form-label">تصویر</label><br/>
                                        <image-cropper name = "index" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>
                                        <div id = "imageHelp" class = "form-text error"></div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "title" class = "form-label">عنوان</label>
                                        <input type = "text" :class = "{hasError: errors.title}" class = "form-control" id = "title" aria-describedby = "titleHelp">
                                        <div id = "titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "category" class = "form-label">دسته</label>
                                        <select class = "form-select" id = "category" aria-describedby = "categoryHelp" aria-label = "category" required>
                                            <option value = ""></option>
                                            <option v-for = "category in categories" :key = "category.id" :value = "category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id = "categoryHelp" class = "form-text error"></div>

                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "teacher" class = "form-label">استاد</label>
                                        <select class = "form-select" id = "teacher" aria-describedby = "teacherHelp" aria-label = "teacher">
                                            <option value = ""></option>
                                            <option v-for = "teacher in teachers" :key = "teacher.id" :value = "teacher.id">
                                                {{ teacher.name }}
                                            </option>
                                        </select>
                                        <div id = "teacherHelp" class = "form-text error"></div>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "capacity" class = "form-label">ظرفیت</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.capacity}" class = "form-control text-start" id = "capacity" >
                                        <div id = "capacityHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.capacity">{{ e }}</p>
                                    </div>


                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "time" class = "form-label">زمان</label>
                                        <input type = "time" min = "1000" :class = "{hasError: errors.price}" class = "form-control text-start" id = "time" >
                                        <div id = "timeHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.price">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "start" class = "form-label">تاریخ شروع</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.start}" class = "form-control text-start" id = "start" >
                                        <div id = "startHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.start">{{ e }}</p>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "end" class = "form-label">تاریخ پایان</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.end}" class = "form-control text-start" id = "end" >
                                        <div id = "endHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.end">{{ e }}</p>
                                    </div>
                                    <div class = "col-md-4 col-lg-2 mb-3">
                                        <label for = "price" class = "form-label">قیمت (ریال)</label>
                                        <input type = "number" min = "1000" :class = "{hasError: errors.price}" class = "form-control text-start" id = "price" required>
                                        <div id = "priceHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.price">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-1 mb-3">
                                        <label for = "off" class = "form-label">%تخفیف</label>
                                        <input type = "number" :class = "{hasError: errors.off}" class = "form-control text-start" id = "off">
                                        <div id = "offHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.off">{{ e }}</p>

                                    </div>

                                    <div class = "col-md-12 mb-3">
                                        <label class = "form-label" for = "text">توضیحات</label>
                                        <textarea @input = "watchTextAreas" :class = "{hasError: errors.text}" aria-describedby = "textHelp" class = "form-control text-start" id = "text"></textarea>
                                        <div id = "textHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.text">{{ e }}</p>
                                    </div>

                                    <div class = "col-md-12 mb-3">
                                        <button class = "btn btn-primary" @click.prevent = "createInfo" type = "submit">
                                            ثبت
                                        </button>
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

    export default {
        components: {ImageCropper},
        data: function () {
            return {
                id: '',
                blog: [],
                categories: [],
                errors: [],
                image_codes: [],
                image_names: [],
                imgRequired: false,
                hasCaption: false,
                aspect: 13 / 10,
                features: [{"label": "", "value": ""}],
                sizes: [{"size": "", "dimensions": "", "color_name": "", "color_code": "", "stock": ""}],

            }
        },
        mounted() {
            this.loadCategories();
        },
        methods: {
            async loadCategories() {
                await App.methods.checkToken();
                await axios.get('/api/panel/category/course?page=1&perPage=100000')
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
                await App.methods.checkToken();

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
                    let features = [];
                    for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                        features.push('{"label": "' + document.getElementsByName('featureLabel')[i].value + '", "value": "' + document.getElementsByName('featureValue')[i].value + '"}');
                    }
                    if (document.getElementsByName('featureLabel').length === 0) {
                        features = '[]';
                    } else {
                        features = '[' + features.toString() + ']';
                    }

                    await axios.post('/api/panel/course', {
                            title: document.getElementById('title').value,
                            course_category_id: document.getElementById('category').value,
                            course_teacher_id: document.getElementById('teacher').value,
                            start: document.getElementById('start').value,
                            end: document.getElementById('end').value,
                            time: document.getElementById('time').value,
                            price: document.getElementById('price').value,
                            off: document.getElementById('off').value,
                            capacity: document.getElementById('capacity').value,
                            description: document.getElementById('text').value,
                        }
                    )
                        .then((response) => {
                            console.log(response.data)
                            if (response.status === 201 || response.status === 200) {
                                // localStorage.removeItem('draft_new');
                                // localStorage.removeItem('draft_new_img_codes');
                                // localStorage.removeItem('draft_new_img_names');


                                setTimeout(() => {
                                    this.$router.push({path: '/panel/courses'});
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
                                setTimeout(() => {
                                }, 1000);
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

                this.features.push('{"label": "", "value": ""}');
            },
            removeFeature(index) {

                this.features.splice(index, 1)
            },
            updateFeatures() {
                //    App.methods.checkToken();
                axios.post('/api/panel/check/user/token', {id: JSON.parse(localStorage.getItem('user')).id})
                    .then((response) => {
                        if (response.status === 200) {
                            localStorage.setItem('expire', response.data.expire);
                            console.log(localStorage);
                        }
                    })
                    .then(() => {
                        this.features = [];
                        for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                            this.features.push({
                                "label": document.getElementsByName('featureLabel')[i].value.toString(),
                                "value": document.getElementsByName('featureValue')[i].value.toString()
                            });
                        }
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            window.location = '/panel/login'
                            App.methods.logout();
                        }
                    });


            },

            addSize() {

                this.sizes.push('{}');
            },
            removeSize(index) {

                this.sizes.splice(index, 1)
            },
            async updateSizes() {
                await App.methods.checkToken();


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

        }
    }
</script>
<style>
    span i {
        cursor: pointer;
    }
</style>

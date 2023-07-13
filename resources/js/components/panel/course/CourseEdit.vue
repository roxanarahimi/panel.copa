<template>
    <transition name = "route" mode = "out-in" appear>
        <section>
            <h3 class = "mb-5">ویرایش دوره</h3>
            <div class = "row mt-3">
                <div class = "col-12 mb-3">
                    <div class = "card" v-if = "isDefined">
                        <div class = "card-body">
                            <form id = "editForm">
                                <div class = "row">
                                    <div class = "col-12 mb-3">
                                        <label class = "form-label">تصویر</label><br/>
                                        <image-cropper name = "index" :src = "data.image" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>
                                        <div id = "imageHelp" class = "form-text error"></div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "title" class = "form-label">عنوان</label>
                                        <input type = "text" :class = "{hasError: errors.title}" :value = "data.title" class = "form-control" id = "title" aria-describedby = "titleHelp">
                                        <div id = "titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.title">{{ e }}</p>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "category" class = "form-label">دسته</label>
                                        <select class = "form-select" id = "category" aria-describedby = "categoryHelp" aria-label = "category" required>
                                            <option value = ""></option>
                                            <option v-for = "category in categories" :selected = "data.category.id == category.id" :key = "category.id" :value = "category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id = "categoryHelp" class = "form-text error"></div>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "teacher" class = "form-label">استاد</label>
                                        <select class = "form-select" id = "teacher" aria-describedby = "teacherHelp" aria-label = "teacher">
                                            <option value = ""></option>
                                            <option v-for = "teacher in teachers" :selected = "data.teacher?.id == teacher.id" :key = "teacher.id" :value = "teacher.id">
                                                {{ teacher.name }}
                                            </option>
                                        </select>
                                        <div id = "teacherHelp" class = "form-text error"></div>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "capacity" class = "form-label">ظرفیت</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.capacity}" :value = "data.capacity" class = "form-control text-start" id = "capacity">
                                        <div id = "capacityHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.capacity">{{ e }}</p>
                                    </div>


                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "time" class = "form-label">زمان</label>
                                        <input type = "time" min = "1000" :class = "{hasError: errors.price}" :value = "data.price" class = "form-control text-start" id = "time">
                                        <div id = "timeHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.price">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "start" class = "form-label">تاریخ شروع</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.start}" :value = "data.start" class = "form-control text-start" id = "start">
                                        <div id = "startHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.start">{{ e }}</p>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "end" class = "form-label">تاریخ پایان</label>
                                        <input type = "text" min = "1000" :class = "{hasError: errors.end}" :value = "data.end" class = "form-control text-start" id = "end">
                                        <div id = "endHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.end">{{ e }}</p>
                                    </div>
                                    <div class = "col-md-4 col-lg-2 mb-3">
                                        <label for = "price" class = "form-label">قیمت (ریال)</label>
                                        <input type = "number" min = "1000" :class = "{hasError: errors.price}" :value = "data.price" class = "form-control text-start" id = "price" required>
                                        <div id = "priceHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.price">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-1 mb-3">
                                        <label for = "off" class = "form-label">%تخفیف</label>
                                        <input type = "number" :class = "{hasError: errors.off}" :value = "data.off" class = "form-control text-start" id = "off">
                                        <div id = "offHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.off">{{ e }}</p>

                                    </div>

                                    <div class = "col-md-12 mb-3">
                                        <label class = "form-label" for = "text">توضیحات</label>
                                        <textarea @input = "watchTextAreas" :class = "{hasError: errors.text}" :value = "data.description" aria-describedby = "textHelp" class = "form-control text-start" id = "text"></textarea>
                                        <div id = "textHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.text">{{ e }}</p>
                                    </div>


                                    <div class = "col-md-12 mb-3">
                                        <button class = "btn btn-primary" @click.prevent = "updateInfo" type = "submit">
                                            <!--                                        <button class = "btn btn-primary" type = "submit">-->
                                            ویرایش
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
        data() {
            return {
                id: this.$route.params.id,
                data: {},
                categories: [],
                errors: [],
                image_codes: [],
                image_names: [],
                imgRequired: false,
                hasCaption: false,
                aspect: 13 / 10,
                isDefined: false,
                enableClick: true,
                features: [],
                sizes: [{"size": "", "dimensions": "", "color_name": "", "color_code": "", "stock": ""}],
            }
        },
        mounted() {
            this.loadCategories();
            this.loadData();
        },
        methods: {
            async loadData() {

                await axios.get('/api/panel/course/' + this.id)
                    .then((response) => {
                        console.log(response.data);
                        this.data = response.data;
                    })
                    .then(() => {
                        this.isDefined = true;
                    })
                    .then(() => {
                        this.watchTextAreas();
                    })
                    .catch();


            },
            loadCategories() {
                 axios.get('/api/panel/category/course?page=1&perPage=100000')
                    .then((response) => {
                        this.categories = response.data.data;
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

                if (emptyFieldsCount === 0) {

                    await axios.post('/api/panel/course/' + this.$route.params.id,
                        {
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
                        })
                        .then((response) => {
                            if (response.status === 200) {
                                setTimeout(() => {
                                    this.$router.push({path: '/panel/course/' + this.id});
                                }, 1000);
                            }
                        })
                        .catch((error) => {
                            if (error.response.status === 422) {
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
            async updateFeatures() {

                this.features = [];
                for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                    this.features.push({
                        "label": document.getElementsByName('featureLabel')[i].value.toString(),
                        "value": document.getElementsByName('featureValue')[i].value.toString()
                    });
                }

            },

        }
    }
</script>
<style>
    span i {
        cursor: pointer;
    }

</style>

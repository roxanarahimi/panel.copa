<template>
    <transition name = "route" mode = "out-in" appear>
        <section>
            <h3 class = "mb-5">ویرایش دوره</h3>
            <div class = "row mt-3">
                <div class = "col-12 mb-3">
                    <div class = "card" v-if = "isDefined">
                        <div class = "card-body">
                            <form id = "editForm">
<!--                                <div class = "row">-->
<!--                                    <div class = "col-12 mb-3">-->
<!--                                        <label class = "form-label">تصویر</label><br/>-->
<!--                                        <image-cropper name = "index" :src = "data.image" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>-->
<!--                                        <div id = "imageHelp" class = "form-text error"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class = "row">
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "name" class = "form-label">نام</label>
                                        <input type = "text" :class = "{hasError: errors.name}" :value = "data.name" class = "form-control" id = "name" aria-describedby = "nameHelp">
                                        <div id = "nameHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.name">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "national_code" class = "form-label">کد ملی</label>
                                        <input type = "text" :class = "{hasError: errors.national_code}" :value = "data.national_code" class = "form-control" id = "national_code"  aria-describedby = "national_codeHelp">
                                        <div id = "national_codeHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.national_code">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-3 mb-3">
                                        <label for = "gender" class = "form-label">جنسیت</label>
                                        <select class = "form-select" id = "gender" aria-describedby = "genderHelp" aria-label = "gender" required = "">
                                            <option value = ""></option>
                                            <option :selected = "data.gender === 'خانم'" value = "female">خانم</option>
                                            <option :selected = "data.gender === 'آقا'" value = "male">آقا</option>
                                        </select>
                                        <div id = "genderHelp" class = "form-text error"></div>
                                    </div>
                                    <div class = "col-md-4 col-lg-3 mb-3">
                                        <label for = "birth" class = "form-label">تاریخ تولد</label>
                                        <input type = "text" :class = "{hasError: errors.birth}" :value = "data.birth" class = "form-control text-start" id = "birth">
                                        <div id = "birthHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.birth">{{ e }}</p>
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
    // import {toArray} from "../../../public/cropperjs/src/js/utilities";

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
            }
        },

        mounted() {
            this.loadData();
        },

        methods: {
            async loadData() {

                await axios.get('/api/panel/teacher/' + this.id)
                    .then((response) => {
                        console.log(response.data);
                        this.data = response.data;
                    })
                    .then(() => {
                        this.isDefined = true;
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

                    await axios.post('/api/panel/teacher/' + this.$route.params.id,
                        {
                            name: document.getElementById('name').value,
                            national_code: document.getElementById('national_code').value,
                            gender: document.getElementById('gender').value,
                            birth: document.getElementById('birth').value,

                        })
                        .then((response) => {
                            if (response.status === 200) {
                                setTimeout(() => {
                                    this.$router.push({path: '/panel/teacher/' + this.id});
                                }, 1000);
                            }
                        })
                        .catch((error) => {
                            if (error.response.status === 422) {
                                let errorList = Array(error.response.data);
                                for (var i = 0; i < errorList.length; i++) {
                                    this.errors = errorList[i];
                                }
                                setTimeout(() => {
                                }, 1000);

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


        }
    }
</script>
<style>
    span i {
        cursor: pointer;
    }

</style>

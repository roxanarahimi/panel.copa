<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت دوره جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <!--                                    <div class = "col-12 mb-3">-->
                                    <!--                                        <label class = "form-label">تصویر</label><br/>-->
                                    <!--                                        <image-cropper name = "index" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>-->
                                    <!--                                        <div id = "imageHelp" class = "form-text error"></div>-->
                                    <!--                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-lg-3 mb-3">
                                        <label for="name" class="form-label">نام</label>
                                        <input type="text" :class="{hasError: errors.name}" class="form-control"
                                               id="name" aria-describedby="titleHelp">
                                        <div id="nameHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.name">{{ e }}</p>

                                    </div>

                                    <div class="col-md-4 col-lg-3 mb-3">
                                        <label for="national_code" class="form-label">کد ملی</label>
                                        <input type="text" :class="{hasError: errors.national_code}"
                                               class="form-control" id="national_code"
                                               aria-describedby="national_codeHelp">
                                        <div id="national_codeHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.national_code">{{ e }}</p>

                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="gender" class="form-label">جنسیت</label>
                                        <select class="form-select" id="gender" aria-describedby="genderHelp"
                                                aria-label="category" required="">
                                            <option value=""></option>
                                            <option value="female">خانم</option>
                                            <option value="male">آقا</option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>
                                    </div>

                                    <div class="col-md-4 col-lg-3 mb-3">
                                        <label for="birth" class="form-label">تاریخ تولد</label>
                                        <input type="text" :class="{hasError: errors.birth}"
                                               class="form-control text-start" id="birth">
                                        <div id="birthHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.birth">{{ e }}</p>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <button class="btn btn-primary" @click.prevent="createInfo" type="submit">
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

        }
    },
    mounted() {
    },
    methods: {
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

                await axios.post('/api/panel/teacher', {
                    name: document.getElementById('name').value,
                    national_code: document.getElementById('national_code').value,
                    gender: document.getElementById('gender').value,
                    birth: document.getElementById('birth').value,

                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {


                            setTimeout(() => {
                                this.$router.push({path: '/panel/teachers'});
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

    }
}
</script>
<style>
span i {
    cursor: pointer;
}
</style>

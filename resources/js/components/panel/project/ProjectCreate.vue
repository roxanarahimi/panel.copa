<template>
    <transition name = "route" mode = "out-in" appear>
        <section>
            <h3 class = "mb-5">ثبت پروژه جدید</h3>

            <div class = "row mt-3">
                <div class = "col-12 mb-3">
                    <div class = "card">
                        <div class = "card-body">
                            <form id = "editForm">
                                <div class = "row">
                                    <div class = "col-12 mb-3">
                                        <label class = "form-label">تصویر</label><br/>
                                         <image-cropper name = "main" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>
                                        <div id = "imageHelp" class = "form-text error"></div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-3 mb-3">
                                        <label for = "title" class = "form-label">عنوان</label>
                                        <input type = "text" :class = "{hasError: errors.title}" class = "form-control" id = "title" aria-describedby = "titleHelp" required>
                                        <div id = "titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-3 mb-3">
                                        <label for = "sub_title" class = "form-label">زیرنویس</label>
                                        <input type = "text" :class = "{hasError: errors.sub_title}" class = "form-control" id = "sub_title" aria-describedby = "sub_titleHelp" required>
                                        <div id = "sub_titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.sub_title">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-12 mb-3">
                                        <label class = "form-label" for = "text">متن</label>
                                        <textarea @input = "watchTextAreas" :class = "{hasError: errors.text}" aria-describedby = "textHelp" class = "form-control text-start" id = "text"></textarea>
                                        <div id = "textHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.text">{{ e }}</p>
                                    </div>

                                    <div class = "col-md-12 mb-3">
                                        <button class = "btn btn-primary" @click.prevent = "createInfo" type = "submit">
                                            <!--                                        <button class = "btn btn-primary" type = "submit">-->
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
                errors: [],
                image_codes: [],
                image_names: [],
                imgRequired: true,
                hasCaption: false,
                aspect: 16 / 9,

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
                    await axios.post('/api/panel/project', {
                        image: document.getElementById('Image__code').value,
                        title: document.getElementById('title').value,
                        sub_title: document.getElementById('sub_title').value,
                        text: document.getElementById('text').value,
                    })
                        .then((response) => {
                            console.log(response.data)
                            if (response.status === 201 || response.status === 200) {
                                setTimeout(() => {
                                    this.$router.push({path: '/panel/projects'});
                                }, 1000);

                            }
                        })
                        .catch((error) => {
                            if (error.status === 422) {
                                let errorList = Array(error.response.data);
                                for (var i = 0; i < errorList.length; i++) {
                                    this.errors = errorList[i];
                                }
                                console.log(this.errors.toString());
                                setTimeout(() => {
                                }, 1000);
                            } else if (error.status === 500) {
                                if (error.response.data.message.includes("SQLSTATE")) {
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
            addTag() {

                this.tags.push('{"label": "", "uri": ""}');
            },
            removeTag(index) {

                this.tags.splice(index, 1)
            },
            async updateTags() {

                this.tags = [];
                for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
                    await this.tags.push({
                        "label": document.getElementsByName('tagLabel')[i].value.toString(),
                        "uri": document.getElementsByName('tagUri')[i].value.toString()
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

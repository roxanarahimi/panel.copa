<template>
    <transition name = "route" mode = "out-in" appear>
        <section>
            <h3 class = "mb-5">ویرایش پروژه</h3>

            <div class = "row mt-3">
                <div class = "col-12 mb-3">
                    <div class = "card" v-if = "isDefined">
                        <div class = "card-body">
                            <form id = "editForm">
                                <div class = "row">
                                    <div class = "col-12 mb-3">
                                        <label class = "form-label">تصویر</label><br/>
                                        <image-cropper name = "" caption = "" :hasCaption = "hasCaption" :isRequired = "imgRequired" :aspect = "aspect"/>
                                        <div id = "imageHelp" class = "form-text error"></div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-3 mb-3">
                                        <label for = "title" class = "form-label">عنوان</label>
                                        <input type = "text" :class = "{hasError: errors.title}" class = "form-control" id = "title" :value = "data.title" aria-describedby = "titleHelp" required>
                                        <div id = "titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-3 mb-3">
                                        <label for = "sub_title" class = "form-label">عنوان</label>
                                        <input type = "text" :class = "{hasError: errors.sub_title}" class = "form-control" id = "sub_title" :value = "data.sub_title" aria-describedby = "sub_titleHelp" required>
                                        <div id = "sub_titleHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.sub_title">{{ e }}</p>

                                    </div>
                                    <div class = "col-md-12 mb-3">
                                        <label class = "form-label" for = "text">متن</label>
                                        <textarea @input = "watchTextAreas" :class = "{hasError: errors.text}" aria-describedby = "textHelp" class = "form-control text-start" id = "text">{{ data.text}}</textarea>
                                        <div id = "textHelp" class = "form-text error"></div>
                                        <p class = "form-text error m-0" v-for = "e in errors.text">{{ e }}</p>

                                    </div>


                                    <div class = "col-md-12 mb-3">
                                        <button class = "btn btn-primary" @click.prevent = "updateInfo" type = "submit">
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
                errors: [],
                image_codes: [],
                image_names: [],
                imgRequired: false,
                hasCaption: false,
                aspect: 16 / 9,
                isDefined: false,
                enableClick: true,
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

                        if (this.data.tags) {
                            for (let i = 0; i < JSON.parse(this.data.tags).length; i++) {
                                this.tags.push(JSON.parse(this.data.tags)[i]);
                            }
                        }

                    })
                    .then(() => {
                        this.isDefined = true;
                    })
                    .then(() => {
                        this.watchTextAreas();
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
                    let tags = [];
                    for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
                        tags.push('{"label": "' + document.getElementsByName('tagLabel')[i].value + '", "uri": "' + document.getElementsByName('tagUri')[i].value + '"}');
                    }
                    if (document.getElementsByName('tagLabel').length === 0) {
                        tags = '[]';
                    } else {
                        tags = '[' + tags.toString() + ']';
                    }

                    await axios.post('/api/panel/project/' + this.$route.params.id,
                        {
                            image: document.getElementById('Image__code').value,
                            title: document.getElementById('title').value,
                            sub_title: document.getElementById('sub_title').value,
                            text: document.getElementById('text').value,
                        })
                        .then((response) => {
                            if (response.status === 200) {
                                setTimeout(() => {
                                    this.$router.push({path: '/panel/project/' + this.id});
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
                txt.setAttribute("style", "height:" + (txt.scrollHeight + 20) + "px;overflow-y:hidden;");
                txt.addEventListener("input", changeHeight, false);

                function changeHeight() {
                    this.style.height = "auto";
                    this.style.height = (this.scrollHeight) + "px";
                }
            },
            addTag() {
                this.tags.push('{"uri": "", "label": ""}');
            },
            removeTag(index) {
                this.tags.splice(index, 1)
            },
            updateTags() {
                this.tags = [];
                for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
                    this.tags.push({
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

    /*.tagElement .uri {*/
    /*    text-align: left !important;*/
    /*    font-weight: lighter !important;*/

    /*}*/


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


</style>

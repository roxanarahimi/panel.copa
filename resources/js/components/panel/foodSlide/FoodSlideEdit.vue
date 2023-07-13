<template>
  <transition name="route" mode="out-in" appear>
    <section>
      <h3 class="mb-5">ویرایش دستور پخت</h3>

      <div class="row mt-3">
        <div class="col-12 mb-3">
          <!--                    <div class = "card" v-if = "isDefined" @click = "e => enableClick && makeImageArrays()">-->
          <div class="card" v-if="isDefined" @click="e => enableClick">
            <div class="card-body">
              <form id="editForm">
                <div class="row">
                  <div class="col-12 mb-3">
                    <label class="form-label">تصویر</label><br/>
                    <image-cropper :isPng="isPng" name="" caption="" :hasCaption="hasCaption" :isRequired="imgRequired"
                                   :aspect="aspect" :src="data.image"/>
                    <div id="imageHelp" class="form-text error"></div>
                  </div>
                </div>
                <div class="row">

                  <div class="col-md-4 col-xl-4 mb-3">
                    <label for="article_id" class="form-label">دستور پخت</label>
                    <select class="form-select" id="article_id" aria-describedby="article_idHelp"
                            aria-label="article_id" required>
                      <!--                                          -->
                      <option :selected="data.article?.id == article.id" v-for="article in articles"
                              :key="article.id" :value="article.id">
                        {{ article.title }}
                      </option>
                    </select>
                    <div id="article_idHelp" class="form-text error"></div>
                  </div>

                </div>
                <div class="col-md-12 mb-3">
                  <BtnSubmit @click.prevent="updateInfo">
                    ویرایش
                  </BtnSubmit>
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

export default {
  components: {Editor, ImageCropper, BtnSubmit},
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
      aspect: 20/13,
      isDefined: false,
      enableClick: true,
      articles: [],
      isPng: true,

    }
  },

  mounted() {

    this.loadCategories();
    this.loadArticle();
  },

  methods: {
    async loadArticle() {
      await axios.get('/api/panel/foodSlide/' + this.id)
          .then((response) => {

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
      axios.get('/api/panel/category/foodSlide?page=1&perPage=100000')
          .then((response) => {
            this.categories = response.data.data;
          })
          .catch();
      axios.get('/api/panel/article?page=1&perPage=100000')
          .then((response) => {
            this.articles = response.data.data;
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

        await axios.post('/api/panel/foodSlide/' + this.$route.params.id,
            {
              image: document.getElementById('Image__code').value,
              article_id: document.getElementById('article_id').value,
            })
            .then((response) => {
              console.log(response)
              if (response.status === 200) {
                setTimeout(() => {
                  this.$router.push({path: '/panel/food/slide/' + this.id});
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
    addTag() {
      // this.tags.push('{"uri": "", "label": ""}');
    },
    removeTag(index) {
      // this.tags.splice(index, 1)
    },
    updateTags() {
      // this.tags = [];
      // for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
      //     this.tags.push({
      //         "label": document.getElementsByName('tagLabel')[i].value.toString(),
      //         "uri": document.getElementsByName('tagUri')[i].value.toString()
      //     });
      // }

    },


  }
}
</script>
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


</style>

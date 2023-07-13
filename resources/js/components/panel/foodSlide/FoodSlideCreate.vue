<template>
  <transition name="route" mode="out-in" appear>
    <section>
      <h3 class="mb-5">ثبت دستور پخت جدید</h3>

      <div class="row mt-3">
        <div class="col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <form id="editForm" @click="e => enableClick">
                <div class="row">
                  <div class="col-12 mb-3">
                    <label class="form-label">تصویر</label><br/>
                    <image-cropper :isPng="isPng" name="" caption="" :hasCaption="hasCaption"
                                   :isRequired="imgRequired" :aspect="aspect"/>
                    <div id="imageHelp" class="form-text error"></div>
                  </div>
                </div>
                <div class="row">


                  <div class="col-md-4 col-xl-4 mb-3">
                    <label for="article_id" class="form-label">دستور پخت</label>
                    <select class="form-select" id="article_id" aria-describedby="article_idHelp"
                            aria-label="article_id" required>
                      <!--                                          -->
                      <option v-for="article in articles"  :key="article.id" :value="article.id">
                        {{ article.title }}
                      </option>
                    </select>
                    <div id="article_tag_idHelp" class="form-text error"></div>
                  </div>


                </div>


                <div class="row">
                  <div class="col-md-12 mb-3">
                    <BtnSubmit  @click.prevent="createInfo">
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
import BtnSubmit from "../../components/BtnSubmit";
import Editor from "../../components/Editor";

export default {
  components: {Editor, ImageCropper,BtnSubmit},
  data: function () {
    return {
      id: '',
      blog: [],
      categories: [],
      productCategories: [],
      products: [],
      errors: [],
      imgRequired: true,
      hasCaption: false,
      aspect: 20/13,
      isPng: true,
      articles: [],

      // tags: [{"label": "", "uri": ""}],
    }
  },
  mounted() {
    this.loadCategories();
  },
  methods: {

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
        await axios.post('/api/panel/foodSlide', {
          image: document.getElementById('Image__code').value,
          article_id: document.getElementById('article_id').value,
        })
            .then((response) => {
              console.log(response.data)
              if (response.status === 201 || response.status === 200) {
                setTimeout(() => {
                  this.$router.push({path: '/panel/food/slides'});
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


  }
}
</script>
<style>
span i {
  cursor: pointer;
}
</style>

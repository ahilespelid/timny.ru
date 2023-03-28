<template>
  <div>
    <header class="header-categories">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div
              class="
                d-flex
                justify-content-center
                align-items-center
                flex-column
              "
            >
              <h2 class="fw-bold text-white text-center head">
                {{$t('categories_banner_section.heading')}}
              </h2>
              <p class="text-white text-center mt-3">
                {{$t('categories_banner_section.paragraph')}}

              </p>
            </div>
          </div>
        </div>
        <div class="search-topic p-5 shadow">
          <div class="row">
            <div class="col-lg-7 col-md-6">
              <h2 class="fw-bold text-primary">
                {{$t('categories_label_section.heading')}}

              </h2>
              <p class="mb-0 text-dark p-0 fw-400">
                {{$t('categories_label_section.sub_heading')}}

              </p>
            </div>
            <div class="col-lg-5 col-md-6">
              <div class="d-flex align-items-center h-100 py-3 py-md-0 w-100">
                <!-- <form action="" class="w-100"> -->
                  <!-- <input
                    type="text"
                    name=""
                    id=""
                    placeholder="Search your keyword here"
                    v-model="search_mentor"
                        @change="searchMentors"
                    class="form-control border-secondary p-3"
                  />
                  <div class="search-icon">
                    <h3 class="text-primary fw-bold d-flex"
                    v-on:click="searchMentors"
                    role="button"
                    >
                      Search<i
                        class="fa-solid fa-arrow-right-long text-secondary align-baseline ms-1 pt-1"
                      ></i>
                    </h3>
                  </div> -->
                   <div class="input-group border border-secondary"
                                >
                                    <input
                                        type="text"
                    name=""
                    id=""
                        :placeholder="$t('categories_label_section.place_holder')"
                                       v-model="search_mentor"
                        @change="searchMentors"
                                        class="form-control border-0 rounded-0 p-3"
                                    />
                                    <span
                                        class="input-group-text bg-white text-primary border-0 fw-bold fs-3 rounded-0 d-flex align-items-center"
                                        id="basic-addon2"
                                        v-on:click="searchMentors"
                    role="button"
                                        >{{
                                            $t(
                                                "all_categories.fields.btn_label"
                                            )
                                        }}
                                        <i
                                            class="fa-solid fa-arrow-right-long text-secondary align-baseline ms-1"
                                        ></i
                                    ></span>
                                </div>
                <!-- </form> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <section class="consultant-section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-3 col-md-4 mb-md-0 mb-3">
            <div class="accordion filter" id="accordionPanelsStayOpenExample">
              <div class="accordion-item border-0 bg-transparent">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                  <button
                    class="accordion-button bg-primary border-0 text-white w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseOne"
                    aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne"
                  >
                    <i class="fa-solid fa-filter me-2"></i>
                    {{$t('categories_sidebar_section.filter')}}
                  </button>
                </h2>
                <div
                  id="panelsStayOpen-collapseOne"
                  class="accordion-collapse collapse show"
                  aria-labelledby="panelsStayOpen-headingOne"
                >
                  <div class="accordion-body bg-white p-0">
                    <ul class="list-unstyled p-4 mb-0">
                          <li class="mb-2 h6 text-dark">
                    {{$t('categories_sidebar_section.price')}}

                          </li>
                          <vue-slider
                            :min="100"
                            :max="10000"
                            :clickable="true"
                            :drag-on-click="true"
                            :min-range="10"
                            v-model="value"
                            ref="slider"
                            :duration="0.5"
                          >
                            <template
                              v-slot:process="{ start, end, style, index }"
                            >
                              <div class="vue-slider-process" :style="style">
                                <div
                                  :class="[
                                    'merge-tooltip',
                                    'vue-slider-dot-tooltip-inner',
                                    'vue-slider-dot-tooltip-inner-top',
                                  ]"
                                >
                                  {{ value[index] }} - {{ value[index + 1] }}
                                </div>
                              </div>
                            </template>
                          </vue-slider>
                          <div class="d-flex justify-content-between mt-5">
 <button type="button" class="btn btn-primary" @click="getRangeValue">
                    {{$t('categories_sidebar_section.apply')}}

 </button>
                          <button type="button" class="btn btn-danger" @click="clearRangeFilter">
                    {{$t('categories_sidebar_section.clear')}}

                          </button>
                          </div>

                        </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 sidebar bg-white shadow accordion-2 mt-3">
                  <div class="accordion bg-transparent" id="accordionExample">
                    <div class="accordion-item border-0">
                      <div
                        v-for="category in mentorCategories"
                        :key="category.id"
                        class="mb-3 border-bottom"

                      >
                        <h6
                          v-if="category.sub_categories.length > 0"
                          class="accordion-header align-items-center d-flex mb-3"
                          id="headingTwo"
                        >
                          <a
                            class="text-decoration-none" :class="`${category.slug==slug ? 'text-success' : 'text-dark'}`"
                            :href="`${url + '/categories/' + category.slug}`"
                            >{{ category.name }}</a
                          >
                          <button
                            class="accordion-button collapsed ps-2 py-0 pe-0 bg-transparent"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#cat' + category.id"
                            aria-expanded="false"
                            aria-controls="collapseTwo"
                          ></button>
                        </h6>

                        <h6
                          class=""
                          v-if="
                            category.parent_id == 0 &&
                            category.sub_categories.length == 0
                          "
                        >
                          <strong>
                            <a
                              class="text-decoration-none text-dark"
                              :href="`${url + '/categories/' + category.slug}`"
                              >{{ category.name }}</a
                            >
                          </strong>
                        </h6>
                        <div
                          :id="'cat' + category.id"
                          class="accordion-collapse collapse"
                          aria-labelledby="headingTwo"
                          data-bs-parent="#accordionExample"
                          :class="
                            'cat' + category.id === 'cat' + selectedCatID
                              ? 'show'
                              : ''
                          "

                        >
                          <div class="ps-4 sidebar bg-transparent mt-4">
                            <sidebar-categories-list
                              :url="url"
                              :categories="category.sub_categories"
                              :slug="slug"
                              :selectedCatID="selectedCatID"
                              v-if="
                                !categoriesLoading && category.sub_categories
                              "
                            ></sidebar-categories-list>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
          <div class="col-lg-9 col-md-8 mb-5">
            <div class="row h-100">
              <div class="col-lg-4 col-md-6"

              v-for="mentor in allMentorsFilter"
                :key="mentor.id"
              >
                <div class="">
                  <div class="guiders-card position-relative">
                    <div class="verified position-absolute">
                      <img src="/assets/images/verified-icon.png" alt="" />
                    </div>
                    <div class="guiders-img">
                      <img
                        v-if="mentor.user.image_path"
                        :src="mentor.user.image_path"
                        alt="Team Image"
                        class="img-fluid"
                      />
                      <img
                        v-else
                        src="/assets/images/profile_placeholder.png"
                        alt="Team Image"
                        class="img-fluid"
                      />
                    </div>
                    <div class="guiders-content">
                      <div class="title d-flex flex-column">
                        <button
                          class="btn btn-secondary text-white fw-500"
                          type="button"
                          v-on:click="checkLogin(mentor.user_id)"
                          >Запишитесь на прием</button
                        >
                      </div>
                    </div>
                  </div>
                  <div
                    class="
                      guider-info
                      d-flex
                      justify-content-center
                      align-items-center
                    "
                  >
                    <div
                      class="card border-0 shadow py-3 px-4 text-center text-capitalize"
                    >
                      <a :href="url+'/consultant-profile/'+mentor.user.id">
                      <h5 class="text-primary fw-bold mb-0 text-ca">{{mentor.user.first_name + ' ' + mentor.user.last_name}}</h5>
                      </a>
                      <h6 class="mb-0 text-muted mt-1">{{mentor.category.name}}</h6>
                      <div class="text-secondary">
                        <i class="fa-solid fa-star me-1" v-for="(rate,index) in mentor.rating" :key="index" ></i>
                      </div>
                      <div class="no-rating" v-if=" mentor.rating == 0">
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                        </div>
                    </div>
                  </div>
                </div>
              </div>



            </div>
            <div class="row">
                <div class="col-md-12">
      <div class="text-center mt-5">
                  <v-page
                    :total-row="mentors.length"
                    align="left"
                    v-model="current"
                    @page-change="mentorsChange"
                    :page-size-menu="[10, 20, 30]"
                    v-if="!loading"
                  ></v-page>
                </div>
                </div>
            </div>

          </div>
        </div>
      </div>
    </section>

  </div>
</template>
<script>
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";
export default {
  props: ["url", "slug"],
  components: {
    VueSlider,
  },
  data() {
    return {
      value: [100, 10000],
      process: (val) => [[val[0], val[1]]],
      mentors: [],
      loading: true,
      mentorCategories: [],
      categoriesLoading: true,
      search_mentor: "",
      allMentorsFilter: [],
      selectedCatID: "",
      allCat:"",
      current: 0,
      pagination: {
        pageNumber: 1,
        pageSize: 10,
      },
    };
  },
  watch: {
    search_mentor: {
      handler(val) {
        if (val) {
        } else {
          this.searchMentors();
        }
      },
      deep: true,
      immediate: true,
    },
  },
  methods: {
      checkLogin(mentor_id)
      {
        //   this.appointment_type = type
          var User = JSON.parse(localStorage.getItem("User"));
          if(!User)
            {
                window.location.href = this.url + "/login";
                this.$toasted.error("Пожалуйста, Сначала Войдите В Систему");
            }
            else
            {
                if(User.role == "Mentee")
            {
                window.location.href = this.url + '/appointment-schedule/' + mentor_id;
            }
            else if(User.role == "Mentor")
            {
                this.$toasted.error("Пожалуйста, войдите в систему как пользователь");
            }
            }


      },
    async fetchMentors() {
      this.loading = true;
      const params = {
        token: 123,
        slug: this.slug,
        country: localStorage.getItem("country"),
        city: localStorage.getItem("city"),
      };
      const res = await axios.get("/api/mentors/with/slug", { params });
      if (res.data && res.data.Status == true) {
        // this.allMentorsFilter = res.data.data.mentors;
        this.mentors = res.data.data.mentors;
        this.loading = false;
      } else {
        this.loading = false;
      }
    },
    async fetchMentorCategories() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/mentorCategoriesListWeb", { params });
      if (res.data && res.data.Status == true) {
        this.mentorCategories = res.data.data.mentorCategories;
        this.allCat=res.data.data.allcat;
        var obj = this.allCat.find((category) => {

          if (category.slug === this.slug) {

            return category;
          }
        });

        this.categoriesLoading = false;
        this.selectedCatID = obj.parent_id;
        console.log(this.selectedCatID );
      } else {
        this.categoriesLoading = false;
      }
    },
    mentorsChange(pInfo) {
      this.allMentorsFilter.splice(0, this.allMentorsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.mentors.length) end = this.mentors.length;
      for (let i = start; i < end; i++) {
        this.allMentorsFilter.push(this.mentors[i]);
      }
    },
    async searchMentors() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_mentor,
        slug: this.slug,
        country: localStorage.getItem("country"),
        city: localStorage.getItem("city"),
      };
      const res = await axios.get("/api/search-mentor-web", { params });
      if (res.data && res.data.Status) {
        this.mentors = res.data.data.results;
        this.loading = false;
      }
    },
    async getRangeValue() {
      var value = this.$refs.slider.getValue();
      var min_value = value[0];
      var max_value = value[1];
      this.loading = true;
      const params = {
        token: 123,
        slug: this.slug,
        country: localStorage.getItem("country"),
        city: localStorage.getItem("city"),
        minPrice: min_value,
        maxPrice: max_value,
      };
      const res = await axios.get("/api/mentors/price/range", { params });
      if (res.data && res.data.Status) {
        this.mentors = res.data.data.mentors;
        this.loading = false;
      }
    },
    clearRangeFilter() {
      this.value = [];
      this.value = [100, 10000];
      this.fetchMentors();
    },
  },
  created() {
    //   let info={pageNumber: 1, pageSize: 20};

    this.fetchMentors();
    this.fetchMentorCategories();
    // this.mentorsChange(info);
  },
};
</script>

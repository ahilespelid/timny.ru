<template>
<div>
  <div v-if="loading">Загрузка.....</div>
  <div v-else>
    <section class="consultant-profile">
      <div class="container">
        <div class="row">
          <div class="col-md-5 pe-lg-5">
            <div class="position-relative mt-5">
              <div class="shape"></div>
              <div class="profile-img position-relative w-100 pe-5">
                <div class="img-wrap">
                  <img
                    v-if="this.mentorDetails.image_path"
                    :src="this.mentorDetails.image_path"
                    alt=""
                    class="img-fluid"
                  />
                  <img
                    v-else
                    :src="url + '/assets/images/profile_placeholder.png'"
                    alt=""
                    class="img-fluid"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
              <div class="row">
<div class="col-md-6">
            <div class="border-end-c">
              <h3 class="text-primary mt-3 fw-600">
                {{
                  this.mentorDetails.first_name +
                  " " +
                  this.mentorDetails.last_name
                }}
              </h3>
              <p
                class="fw-600 mb-2"
                v-for="category in this.mentorDetails.mentor.categories"
                :key="category.id"
              >
                {{ category.name }}
              </p>
              <span class="text-secondary mb-0">
                <i class="fa-solid fa-location-dot text-muted me-2"></i
                >{{ this.mentorDetails.city }}
              </span>
              <div class="info">
                <p class="mt-3 mb-2 text-primary fw-600">Дата регистрации</p>
                <span>{{
                  new Date(this.mentorDetails.created_at).toLocaleString('ru-RU')
                }}</span>
              </div>
              <div class="info">
                <p class="mt-3 mb-2 text-primary fw-600">Статус участника</p>
                <span>Активный статус</span>
              </div>
              <div class="info">
                <p class="mt-3 mb-2 text-primary fw-600">Пол</p>
                <span>{{ this.mentorDetails.gender }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 scroll-detail">
            <div class="">
              <h4 class="text-primary mt-3 fw-600">Сведения об образовании</h4>
              <div
                class="info-mentee mt-4 d-flex flex-column"
                v-for="education in educations"
                :key="education.id"
              >
                <label class="mentor-name fw-600 text-primary">{{
                  education.institute
                }}</label>
                <span class="mentor-i-customer mt-2 mb-2">
                  {{ education.degree }} - {{ education.period }}
                </span>
              </div>

              <h4 class="text-primary mt-3 fw-600">Подробности опыта</h4>
              <div
                class="info-mentee mt-4 d-flex flex-column"
                v-for="experience in experiences"
                :key="experience.id"
              >
                <label class="mentor-name fw-600 text-primary">{{
                  experience.company
                }}</label>
                <span class="mentor-i-customer mt-2 mb-2">
                  {{ experience.from }} - {{ experience.to }}
                </span>
              </div>


            </div>
          </div>
          <div class="col-md-12 d-flex justify-content-lg-center justify-content-md-end justify-content-start">
                <a
                href="javascript:void(0)"
                v-on:click="checkLogin(mentorDetails.id)"
                class="btn btn-secondary mt-lg-3 mt-4 text-white"
                >Запишитесь на прием</a
              >
          </div>
              </div>
          </div>

        </div></div>
        </section>
        <section class="bg-primary profile-info py-5">
            <div class="container">
                <div class="row d-flex justify-content-end">

                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center mb-md-0 mb-5 d-flex flex-column">
                                    <i class="fa-solid fa-check mb-3"></i>
                                    <h3 class="text-white" v-if="this.mentorDetails.mentor.status==1">Проверенный</h3>
                                        <h3 class="text-white" v-else>Непроверенный</h3>
                                    <!--<span class="text-white">By Nictus</span>-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-md-0 mb-5 d-flex flex-column">
                                    <i class="fa-solid fa-star mb-3"></i>
                                    <h3 class="text-white">{{this.mentorDetails.appointmentCount}}+</h3>
                                    <span class="text-white"
                                        >Довольные Клиенты</span
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center d-flex flex-column">
                                    <i class="fa-solid fa-award mb-3"></i>
                                    <!-- <h3 class="text-white" v-if="this.mentorDetails.experience_work.days>0">{{this.mentorDetails.experience_work.days}} Days</h3> -->
                                    <!-- <h3 class="text-white" v-if="this.mentorDetails.experience_work.months>0">{{this.mentorDetails.experience_work.months}} Months</h3> -->
                                    <h3 class="text-white" v-if="this.mentorDetails.experience_work.years>0">{{this.mentorDetails.experience_work.years}} лет</h3>
                                    <span class="text-white"> опыта</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>

    </section>
    <section class="about-profile">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-primary text-center fw-bold">
              О консультанте
              <span class="text-secondary">
                {{
                  this.mentorDetails.first_name +
                  " " +
                  this.mentorDetails.last_name
                }}
              </span>
            </h1>
            <p class="mb-0 mt-4 text-center">
              {{ this.mentorDetails.about }}
            </p>

          </div>
        </div>
      </div>
    </section>
    <customer-reviews-section
      v-if="!loading && ratings.length > 0"
      :mentorDetail="mentorDetails"
      :ratings="ratings"
      :url="url"
    ></customer-reviews-section>
  </div>
</div>
</template>
<script>
export default {
  props: ["url", "id"],
  data() {
    return {
      mentor_id: this.id,
      mentorDetails: {},
      educations: [],
      experiences: [],
      ratings: [],
      loading: true,
    };
  },
  methods: {
    checkLogin(mentor_id) {
      var User = JSON.parse(localStorage.getItem("User"));
      if (!User) {
        window.location.href = this.url + "/login";
        this.$toasted.error("Пожалуйста, Сначала Войдите В Систему");
      } else {
        if (User.role == "Mentee") {
          window.location.href =
            this.url + "/appointment-schedule/" + mentor_id;
        } else if (User.role == "Mentor") {
          this.$toasted.error("Пожалуйста, войдите в систему как пользователь");
        }
      }
    },
    async fetchMentorDetails() {
      const params = {
        token: 123,
        user_id: this.mentor_id,
      };
      const res = await axios.get("/api/getUserById", { params });
      if (res.data && res.data.Status) {
        this.mentorDetails = res.data.data.userDetail;
        this.educations = res.data.data.userDetail.educations;
        this.experiences = res.data.data.userDetail.experiences;
        this.ratings = res.data.data.userDetail.ratings;
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchMentorDetails();
  },
};
</script>

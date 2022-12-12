<template>
    <section class="signup pt-0 pb-0">
        <div class="container-fluid">
            <div class="row mx-0">
                <div class="col-sm-12 col-md-6">
                    <div class="
              h-100
              d-flex
              justify-content-center
              align-content-center
              flex-column
              signup-section
              py-5
            ">
                        <a href="/">
                            <img :src="url + '/assets/images/sign-up-logo.png'" class="logo" alt="" /></a>

                        <h1 class="fw-bold my-4 text-primary">
                            Забыли пароль <img src="/assets/images/arrow.png" alt="" class="ps-3">
                        </h1>


                        <div>

                            <div class="form-signup">
                                <input type="email" name="mentee_email" id="mentee_email" v-model="email"
                                    placeholder="Email address here" class="form-control mt-2"
                                    :class="errors && errors.email ? 'border-danger' : ''" />
                                <p v-if="errors && errors.email" class="text-danger">

                                    {{errors.email[0]}}

                                </p>


                                <button class="btn btn-secondary text-white w-100 mt-5" @click="forgetPassword">
                                    Сбросить пароль
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 px-0">
                    <img :src="url + '/assets/images/sign-up-side-img.png'" alt=""
                        class="img-fluid signup-wrapper w-100 d-md-block d-none" />
                </div>
            </div>
        </div>
    </section>
  </template>

  <script>
  import axios from "axios";
  export default {
    props: ["url"],
    data() {
        return {
            email: '',
            errors: {}
        };
    },
    methods: {

        forgetPassword() {
            var toast = this.$toasted;

            // console.log(email,password);
            const params = {
                email: this.email,
            };
            //   console.log(params);
            axios
                .post("/api/forget-password", params)
                .then((response) => {
                    if (response.data.Status) {
                        toast.success(response.data.msg);
                    } else if (!response.data.Status && response.data.errors) {
                        this.errors = response.data.errors;
                        // console.log('this.errors', this.errors);
                        for (const property in response.data.errors) {
                            toast.error(response.data.errors[property][0]);
                        }
                    } else {
                        toast.error(response.data.msg);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    toast.error(error);
                });
        },

    },
    created() {

    },
    mounted() {

    },
  };
  </script>

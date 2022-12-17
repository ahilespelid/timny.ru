<template>
    <div class="row">
        <div class="col-md-12 ps-4" v-if="showAppointmentSection">
            <h5 class="text-primary mt-5 mt-md-0">Задайте вопрос</h5>
            <div class="form-ask">
                <form @submit="submitForm" enctype="multipart/form-data">


                    <img v-if="formData.image_view" :src="formData.image_view" height="80px" width="80px" class="mt-2"
                         @click="openFile"/>
                    <i class="fas fa-trash text-danger ms-3" v-if="formData.image_view" @click="removeImage"></i>
                    <div class="upload-btn-wrapper w-100 mt-3">
                        <button class="btn btn-upload w-100 d-flex">
                            <span v-if="formData.file_name"> {{ formData.file_name }}</span>
                            <span v-else>Прикрепите файл</span>
                        </button>
                        <input type="file" id="book_file" ref="book_file" @change="processFile($event)"
                               name="book_file"/>
                    </div>

                    <textarea name="" id="" rows="5" class="form-control w-100 border p-2 mt-3"
                              :placeholder="$t('book_appointment.question.text_placeholder')"
                              v-model="formData.questions" :class="errors && errors.questions ? 'border-danger' : ''"></textarea>
                    <p v-if="errors && errors.questions" class="text-danger">

                        {{ errors.questions[0] }}

                    </p>

                    <div class="d-flex pt-5 justify-content-end align-items-center">
                        <button class="btn btn-graish me-2 text-white" @click="$emit('cancelAppointment')">
                            <i class="fa-solid fa-angles-left me-1"></i>
                            Назад
                        </button>
                        <button class="btn btn-primary me-2 text-uppercase" v-if="appointmentid" type="submit">
                            Обновить
                            <i class="fa-solid fa-angles-right me-1"></i>
                        </button>

                        <button v-else class="btn btn-secondary text-white" type="submit">
                            Забронировать
                            <i class="fa-solid fa-angles-right ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 ps-4" v-if="showPayment && !loading">
            <h5 class="text-primary mt-lg-0 mt-5">Выберите метод оплаты</h5>
            <div class="payment-card mt-3">
                <ul class="d-inline-flex ps-0" type="none" v-if="payment_methods.length > 0">
                    <li v-for="pm in payment_methods" class="pe-2">
                        <div class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              ">
                            <label class="h-100">
                                <input type="radio" v-model="payment_method" :value="pm.code"/>
                                <img :src="`${url + '/' + pm.image_path}`"/></label>
                        </div>
                    </li>
                    <!-- <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="razorpay"
                          />
                            <img

                src="/assets/images/razorpay.png"

              /></label
                          >
            </div>
          </li>
            <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="jazzcash"
                          />
                            <img

                src="/assets/images/jazzcash.jpg"

              /></label
                          >
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
             <label  class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="easypaisa"
                          />
                            <img

                src="/assets/images/easypaisa.jpg"

              /></label
                          >
            </div>
          </li>
             <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="wave" >
              <img

                src="/assets/images/wave.png"

              />
            </label>
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="braintree" >
              <img

                src="/assets/images/braintree.png"

              />
            </label>
            </div>
          </li> -->

                    <!-- <li class="pe-2">
            <div
              class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="paypal">
              <img
                src="/assets/images/paypal-icon.png"
                alt=""
                class="img-fluid"
              />
            </label>
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              "
            >

              <label class="h-100">
  <input type="radio" v-model="payment_method" name="payment_method" value="stripe">
              <img
                src="/assets/images/strip.png"
                alt=""
                class="img-fluid"
              />
              </label>
            </div>
          </li>-->
                    <li class="">
                        <div class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              ">
                            <label class="h-100">
                                <input type="radio" v-model="payment_method" name="payment_method" value="wallet">
                                <img src="/assets/images/wallet.png" alt="" class="img-fluid"/>
                            </label>
                        </div>
                    </li>

                    <li class="">
                        <div class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center px-2
              ">
                            <label class="h-100">
                                <input type="radio" v-model="payment_method" name="payment_method" value="moneta">
                                <img src="/assets/images/payment/SafetlyPayment.png" alt="" class="img-fluid" style="object-fit: contain;"/>
                            </label>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="form-card" v-if="payment_method == 'ukassa'">
                <h6 class="text-muted pt-3">Оплатить через Юкасса</h6>
                <p>Вы можете сможете оплатить любой банковской картой</p>
            </div>
            <div class="form-card" v-if="payment_method == 'moneta'">
                <h6 class="text-muted pt-3">Безопасная сделка</h6>
                <p>Средства будут заморожены на транзитном счёте и переведены консультанту только по окончании встречи</p>
            </div>
            <!--<div class="form-card" v-if="payment_method == 'jazzcash'">
                <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter Jazzcash Mobile Number"
                       v-model="jazzcash.mobile_no" aria-label="default input example"/>
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter Last 6 Digit of CNIC"
                       maxlength="6" v-model="jazzcash.cnic_digit"/>

            </div>
            <div class="form-card" v-if="payment_method == 'paytm'">
                <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter  Mobile Number"
                       v-model="paytm.mobile_no" aria-label="default input example"/>
                <input class="form-control py-2 mb-3" type="text" placeholder="Enter Email" v-model="paytm.email"/>

            </div>-->

            <!--
            <div class="form-card"
                 v-if="payment_method && (payment_method != 'wallet' && payment_method != 'wave' && payment_method != 'jazzcash' && payment_method != 'easypaisa' && payment_method != 'paytm')">
                <h6 class="text-muted pt-3">Enter Card Details</h6>
                <input type="text" name="" id="" class="form-control border mt-3" placeholder="Card Holder Name"/>
                <input type="number" name="" v-model="payment_details.card_number" id=""
                       class="form-control border mt-3" placeholder="Card Number"/>
                <div class="row">
                    <div class="col-md-4">
                        <datetime input-class="form-control border mt-3" type="date" :flow="['year']" :format="'yy'"
                                  placeholder="Year" v-model="payment_details.exp_year"></datetime>
                    </div>
                    <div class="col-md-4">
                        <datetime input-class="form-control border mt-3" type="date" :flow="['month']" :format="'MM'"
                                  placeholder="Month" v-model="payment_details.exp_month"></datetime>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="" id="" class="form-control border mt-3" placeholder="CVV Code"
                               v-model="payment_details.cvc"/>
                    </div>
                </div>
            </div>
            -->
            <iframe v-show="moneta.visible" width="600" height="800" :src="moneta.src"></iframe>
            <div class="d-flex pt-5 justify-content-end align-items-center">
                <button class="btn btn-graish me-2 text-white" @click="$emit('cancelAppointment')">
                    <i class="fa-solid fa-angles-left me-1"></i>
                    Назад
                </button>
                <!-- data-bs-toggle="modal"
          data-bs-target="#exampleModal" -->
                <button class="btn btn-secondary text-white" @click="makePayment">
                    Оплатить
                    <i class="fa-solid fa-angles-right ms-1"></i>
                </button>
            </div>
        </div>
        <div class="col-md-12 ps-4" v-if="loading">
            Загрузка ....
        </div>
    </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";

export default {
    props: [
        "url",
        "selected_new_date",
        "type",
        "appointment_id",
        "appointment_fee",
        "user_selected_slot",
        "mentor_id",
        "mentor_number",
        "route",
        "appointmentid"
    ],
    mixins: [loginMixin],
    data() {
        return {
            formData: {
                token: 123,
                mentee_id: "",
                mentor_id: this.mentor_id,
                payment: this.appointment_fee,
                payment_id: 1,
                book_file: {},
                questions: "",
                image_view: "",
                file_name: "",
                file_type: "",

            },
            payment_details: {
                card_number: '',
                exp_month: '',
                exp_year: '',
                cvc: ''
            },
            jazzcash: {
                mobile_no: "",
                cnic_digit: "",
            },
            paytm: {
                mobile_no: "",
                email: ""
            },
            ukassa: {

            },
            moneta:{
                src: '',
                visible: false,
            },
            payment_method: '',
            appointmentNo: "",
            old_appointment: "",
            loading: false,
            showPayment: false,
            showAppointmentSection: true,
            errors: {},
            payment_methods: []
        };
    },
    methods: {
        async fetchAppointmentDetails() {
            var params = {
                token: 123,
                appointment_id: this.appointmentid,
                user_id: this.User.user_id
            };
            var toast = this.$toasted;
            const res = await axios
                .get("/api/appointmentDetails", {params})
                .then((res) => {
                    console.log(res.data.msg);
                    if (res.data.Status) {
                        this.loading = false;
                        this.formData.questions = res.data.data.appointment.questions;
                        this.formData.book_file = res.data.data.appointment.file;
                        this.formData.file_type = res.data.data.appointment.file_type;
                        this.formData.payment = res.data.data.appointment.payment;
                    }
                    if (!res.data.Status) {
                        this.loading = false;
                    }
                });
        },
        removeImage() {
            this.formData.image_view = "";
            this.formData.file_name = "";
        },
        processFile(event) {
            this.formData.book_file = event.target.files[0];
            if (event.target.files[0].type.includes("image")) {
                this.formData.image_view = URL.createObjectURL(event.target.files[0]);
                this.formData.file_name = event.target.files[0].name;
            } else {
                this.formData.image_view = "";
                this.formData.file_name = event.target.files[0].name;
            }
        },
        openFile() {
            window.open(this.formData.image_view, '_blank');
        },
        async submitForm(e) {
            var self = this;
            var toast = this.$toasted;
            e.preventDefault();
            const headers = {
                "Content-Type": "multipart/form-data",
            };

            let formData = new FormData();
            formData.append("book_file", this.formData.book_file);
            formData.append("token", this.formData.token);
            formData.append("mentee_id", this.formData.mentee_id);
            formData.append("mentor_id", this.formData.mentor_id);
            formData.append("payment", this.formData.payment);
            formData.append("payment_id", this.formData.payment_id);
            formData.append("questions", this.formData.questions);
            formData.append("type", "question");
            formData.append("appointment_type_string", this.type);
            formData.append("appointment_type_id", this.appointment_id);
            formData.append("date", this.selected_new_date);
            formData.append("time", this.user_selected_slot);
            formData.append("bookAppointmentId", this.appointmentid);
            const res = await axios
                .post("/api/bookAppointment", formData, {
                    headers: headers,
                })
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        self.appointmentNo = res.data.data.appointmentNo;
                        self.sendBookedAppointmentNotification();
                        self.sendBookedAppointmentSms();
                        if (this.appointmentid) {
                            this.showPayment = false;
                            this.showAppointmentSection = true;
                            window.location.href = this.url + "/mentee/appointment-log"
                        } else {
                            this.showPayment = true;
                            this.showAppointmentSection = false;
                            this.fetchPaymentMethods();
                        }
                        $("#exampleModalToggle2").modal("show");
                        self.formData.questions = [];
                        self.formData.book_file = {};
                        $("#book_file").val("");
                    }
                    if (!res.data.Status) {
                        // toast.error(res.data.errors.questions[0]);
                        this.errors = res.data.errors;
                        console.log('errors', this.errors);
                    }
                });
        },
        async makePayment() {
            let moneta = this.moneta;
            var toast = this.$toasted;
            // this.loading = true;
            let total = this.appointment_fee;
            let appointmentID = this.appointmentNo;
            let expMonth = new Date(this.payment_details.exp_month).getUTCMonth() + 1;
            if (expMonth.toString().length == 1) {
                expMonth = '0' + expMonth
            }
            let body = {
                "mentee_id": this.formData.mentee_id,
                "total": total,
                "payment_method_code": this.payment_method,
                "cardInfo": {
                    "number": this.payment_details.card_number,
                    "exp_month": expMonth,
                    "exp_year": new Date(this.payment_details.exp_year).getFullYear(),
                    "cvc": this.payment_details.cvc
                },

                "shipping_address": {
                    "id": "",
                    "first_name": "shahzad",
                    "last_name": "Tariq",
                    "email": "fharshad842@gmail.com",
                    "city_id": 85335,
                    "state_id": 3176,
                    "country_id": 167,
                    "zip_code": "38000",
                    "address": "Bismillah General Store Back Saira Mall Plaza Dogar Basti\nPeople Colony # 1 D Ground Faisalabad",
                    "phone": "034677992777"
                },
                "shipping_id": 1,
                "plateForm": "web",
                "paytm_mode": "",
                "bookAppointmentId": appointmentID
            };
            const headers = {
                "Accept": "application/json",
                "Content-Type": "application/json",
            };
            if (this.payment_method == 'paytm') {
                this.paymentLoading = true;
                var self = this;
                var toast = this.$toasted;

                window.location.href = this.route + "/" + appointmentID + "/" + this.paytm.mobile_no + "/" + this.paytm.email

            }
            if (this.payment_method == 'jazzcash') {
                this.paymentLoading = true;
                var self = this;
                var toast = this.$toasted;
                var params = {
                    token: 123,
                    mobile_no: this.jazzcash.mobile_no,
                    cnic: this.jazzcash.cnic_digit,
                    amount: total,
                    bookAppointmentId: appointmentID,
                    mobile_account: 1,
                };
                const res = await axios
                    .post("/api/makeJazzcashPayment", params)
                    .then((res) => {
                        if (res.data.Status) {
                            this.loading = false;
                            toast.success(res.data.msg);
                            window.location.href = "/mentee/appointment/log";
                        }
                        if (!res.data.Status) {
                            this.loading = false;
                            toast.error(res.data.msg);
                        }
                        if (res.data.errors) {
                            this.loading = false;
                            for (const property in res.data.errors) {
                                toast.error(res.data.errors[property][0]);
                            }
                        }
                    });
            }
            if (this.payment_method == 'easypaisa') {
                window.open(
                    "/easypaisa?amount=" +
                    this.formData.payment +
                    "&bookAppointmentId=" +
                    this.appointmentNo,
                    "_blank"
                );
                this.loading = false;
                window.location.href = "/mentee/appointment-log";
            }
            if (this.payment_method == 'wave') {
                console.log(1);
                let base_url = window.location.origin;
                window.location = '/pay?bookAppointmentId=' + appointmentID + '&total=' + total + '&mentee_id=' + this.formData.mentee_id;
            } else if (this.payment_method == 'razorpay') {


                //   console.log(body);
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';


                        } else if (!res.data.Status) {

                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method == 'stripe') {
                //   console.log(body);
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';
                        } else if (!res.data.Status && res.data.authorization_url) {
                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method == 'wallet') {

                var self = this;

                var params = {
                    token: 123,
                    from_user_id: this.User.user_id,
                    to_user_id: this.mentor_id,
                    amount: total,
                    bookAppointmentId: appointmentID,
                };
                const res = await axios
                    .post("/api/wallet-credit-transfer", params)
                    .then((res) => {
                        if (res.data.Status) {
                            this.loading = false;
                            toast.success(res.data.msg);
                            window.location.href = "/mentee/appointment-log";
                        }
                        if (!res.data.Status) {
                            this.loading = false;
                            toast.error(res.data.msg);
                        }
                    });
            } else if (this.payment_method == 'braintree') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';


                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method == 'paypal') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        console.log(res.data);
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';


                        } else if (!res.data.Status) {
                            localStorage.setItem('appointmentID', this.appointmentNo);
                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method == 'braintree') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';


                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method == 'ukassa') {
                body.redirectAfterConfirm = 'https://timny.ru/mentee/appointment-log';
                const res = await axios
                    .post("/api/execute-payment-ukassa", body, {
                        headers: headers,
                    }).then((res) => {

                        if (res.data.status == 'pending') {

                            this.loading = false;

                            window.location.href = res.data.confirmation_url;

                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            } else if (this.payment_method === 'moneta') {
                body.redirectAfterConfirm = 'https://timny.ru/mentee/appointment-log';
                const res = await axios
                    .post("/api/Moneta/getPaymentFormLink", body, {
                        headers: headers,
                    }).then((res) => {
                        console.log(res.data);
                            this.loading = false;
                            //moneta.src = res.data;
                            //moneta.visible = true;
                            //window.location.href = res.data;
                        var assistant = new Assistant.Builder();
                        assistant.build(res.data);

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }


                    });
            }


        },
        async sendBookedAppointmentNotification() {
            const params = {
                token: 123,
                user_id: this.mentor_id,
                body: "Click here to See your Appointment",
                title: "New Appointment for You.",
                link: "/mentor/appointment/log/",
            };
            const res = await axios
                .post("/api/send-web-notification", params)
                .then((res) => {
                });
        },
        async sendBookedAppointmentSms() {
            const params = {
                token: 123,
                phone: this.mentor_number,
                message: "New Appointment for You.",
            };
            const res = await axios.post("/api/send-sms", params).then((res) => {
            });
        },
        async fetchPaymentMethods() {
            this.loading = true
            const res = await axios.get("/api/payment_methods", {
                params: {token: 123, platform: 'web'},
            });
            if (res.data) {
                /*
                this.payment_methods = res.data.data;
                 */
                let current_method =  res.data.data.find(m => m.is_default == 1 )
                //console.log(current_method);
                this.payment_method = current_method.code;
                this.payment_methods.push(current_method);

                console.log(this.payment_methods);

                this.loading = false
            }
            // else{
            //     toast.error(res.data.errors);
            // }
        },
    },
    created() {
        console.log(
            "selected_new_date" + this.route,
            "user_selected_slot" + this.user_selected_slot
        );
        this.checkLoggedIn();
        if (this.is_loggedIn && this.User.role == "Mentee") {
        } else if (this.is_loggedIn && this.User.role == "Mentor") {
            this.$toasted.error("Please Login as a User");
        } else {
            window.location.href = this.url + "/login";
            this.$toasted.error("Пожалуйста, Сначала Войдите В Систему");
        }
        if (this.appointmentid) {
            this.fetchAppointmentDetails();
        }
    },
    mounted() {
        this.formData.mentee_id = this.User.user_id;
    },
};
</script>

<template>
    <div>
        <section class="wallet">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-secondary ps-4 p-2">
                            <div class="row me-1">
                                <div class="col-md-6">
                                    <p
                                        class="mb-0 text-white d-flex align-items-center"
                                    >
                                        {{
                                            $t(
                                                "wallet_log.current_wallet_balance"
                                            )
                                        }}:<span class="fw-bold ps-md-3"
                                            >{{
                                                $t("wallet_log.price_symbol")
                                            }}
                                            {{ current_balance }}</span
                                        >
                                    </p>
                                </div>
                                <Withdraws :available_balance="current_balance"></Withdraws>
                                <div class="col-md-6">
                                    <div
                                        class="d-flex justify-content-md-end align-items-center h-100"
                                    >
                                        <!--
                                        <button
                                            class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-if="this.User.role == 'Mentor'"
                                            type="button"
                                            id="withdraw"
                                            :disabled="current_balance == 0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#withdrawModel"
                                        >
                                            {{
                                                $t(
                                                    "wallet_log.btn_label_withdraw"
                                                )
                                            }}
                                        </button>

                                        <button
                                            class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-else
                                            data-bs-toggle="modal"
                                            data-bs-target="#topUpModel"
                                        >
                                            {{
                                                $t("wallet_log.btn_label_topup")
                                            }}
                                        </button>
                                        -->

                                        <!-- <button
                      class="btn btn-primary fw-bold mt-md-0 mt-3 h-100 py-2"
                    >
                      + Add Money to Wallet
                    </button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Withdraw -->
                <div
                    class="modal fade"
                    id="withdrawModel"
                    tabindex="-1"
                    aria-labelledby="withdrawModelLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="withdrawModelLabel"
                                    style="color: black"
                                >
                                    {{ $t("wallet_log.withdraw_amount.title") }}
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close text-white"
                                    data-bs-dismiss="modal"
                                    style="color: white"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body form-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    required
                                    v-model="withdraw_amount"
                                    :placeholder="
                                        $t(
                                            'wallet_log.withdraw_amount.placeholder.amount'
                                        )
                                    "
                                />
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    id="withdraw_close"
                                >
                                    {{ $t("wallet_log.button.close") }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    v-on:click="withDrawAmount"
                                >
                                    {{ $t("wallet_log.button.submit") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Model Top Up-->
                <div
                    class="modal fade"
                    id="topUpModel"
                    tabindex="-1"
                    aria-labelledby="topUpModelLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-primary text-white">
                                <h5
                                    class="modal-title"
                                    id="addModelLabel"
                                    style="color: white"
                                >
                                    {{ $t("wallet_log.btn_label_topup") }}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close text-white"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                    style="color: white"
                                ></button>
                            </div>
                            <div v-if="!loading" class="modal-body form-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    required
                                    v-model="amount"
                                    :placeholder="
                                        $t('wallet_log.placeholder_amount')
                                    "
                                />
                                <!--<div class="col-md-12">
                                    <h6 class="text-primary mt-3 fw-bold">
                                        {{ $t("wallet_log.label_method") }}
                                    </h6>
                                    <div class="payment-card mt-3">
                                        <ul
                                            class="d-inline-flex flex-wrap ps-0"
                                            type="none"
                                        >
                                            <li
                                                v-for="pm in payment_methods"
                                                class="pe-2 mb-2 "
                                            >
                                                <div
                                                    class="card border-0 d-md-flex h-100 bg-transparent align-items-center justify-content-center border-0"
                                                >
                                                    <label class="h-100">
                                                        <input
                                                            type="radio"
                                                            name="payment_method"
                                                            :value="pm.code"
                                                            checked
                                                        />
                                                        <img
                                                            :src="`${url + '/' + pm.image_path}`"
                                                            alt=""
                                                            class="img-fluid"
                                                        />
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="form-card">
                                        <h6 class="text-primary fw-bold">
                                            {{ $t("wallet_log.label_detail") }}
                                        </h6>
                                        <input
                                            type="text"
                                            name=""
                                            id=""
                                            class="form-control border mt-3"
                                            :placeholder="
                                                $t(
                                                    'wallet_log.placeholder_name'
                                                )
                                            "
                                        />
                                        <input
                                            type="number"
                                            name=""
                                            v-model="
                                                payment_details.card_number
                                            "
                                            id=""
                                            class="form-control border mt-3"
                                            :placeholder="
                                                $t(
                                                    'wallet_log.placeholder_number'
                                                )
                                            "
                                        />
                                        <div class="row">
                                            <div class="col-md-4">
                                                <datetime
                                                    input-class="form-control border mt-3"
                                                    type="date"
                                                    :flow="['year']"
                                                    :format="'yy'"
                                                    :placeholder="
                                                        $t(
                                                            'wallet_log.placeholder_year'
                                                        )
                                                    "
                                                    v-model="
                                                        payment_details.exp_year
                                                    "
                                                ></datetime>
                                            </div>
                                            <div class="col-md-4">
                                                <datetime
                                                    input-class="form-control border mt-3"
                                                    type="date"
                                                    :flow="['month']"
                                                    :format="'MM'"
                                                    :placeholder="
                                                        $t(
                                                            'wallet_log.placeholder_month'
                                                        )
                                                    "
                                                    v-model="
                                                        payment_details.exp_month
                                                    "
                                                ></datetime>
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="number"
                                                    name=""
                                                    id=""
                                                    class="form-control border mt-3"
                                                    :placeholder="
                                                        $t(
                                                            'wallet_log.placeholder_code'
                                                        )
                                                    "
                                                    v-model="
                                                        payment_details.cvc
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <div v-else class="modal-body form-group">
                                Загрузка....
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    id="add_ammount"
                                >
                                    {{ $t("wallet_log.button.close") }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    v-on:click="AddAmountToWallet"
                                    :disabled="loading"
                                >
                                    {{ $t("wallet_log.button.submit") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white mt-4">
                            <div class="py-3 border-bottom">
                                <div class="bg-light pe-3">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div
                                                class="p-3 d-flex align-items-center h-100"
                                            >
                                                <p
                                                    class="text-primary mb-0 fw-bold head ps-lg-2"
                                                >
                                                    {{
                                                        $t(
                                                            "wallet_log.table_heading"
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4">
                      <div class="p-3">
                        <div class="d-flex align-items-center h-100">
                          <div class="w-31">
                            <label for="filter" class="pe-2 text-dark fw-bold"
                              >Filter By:</label
                            >
                          </div>
                          <div class="w-100">
                            <form action="">
                              <div class="">
                                <div class="custom-select2">
                                  <select
                                    class="form-select border"
                                    aria-label="Default select example"
                                  >
                                    <option selected>
                                      Open this select menu
                                    </option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div> -->
                                        <!-- <div class="col-lg-4">
                      <div class="p-3">
                        <div class="d-flex align-items-center h-100">
                          <div class="w-25">
                            <label for="filter" class="pe-2 text-dark fw-bold"
                              >Search:</label
                            >
                          </div>
                          <div class="w-100">
                            <form action="">
                              <input
                                type="text"
                                name=""
                                id=""
                                class="form-control border"
                                placeholder="Type Here"
                              />
                              <div class="search-icon position-relative">
                                <i
                                  class="
                                    fa-solid fa-magnifying-glass
                                    text-primary
                                  "
                                ></i>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <tbody class="text-dark">
                                        <tr>
                                            <td class="py-3 ps-4">
                                                {{
                                                    $t("wallet_log.column.date")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t("wallet_log.column.time")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t(
                                                        "wallet_log.column.amount"
                                                    )
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t("wallet_log.column.type")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t(
                                                        "wallet_log.column.status"
                                                    )
                                                }}
                                            </td>
                                            <!-- <td class="py-3">{{ $t("wallet_log.column.payment_method") }}</td> -->
                                        </tr>
                                        <tr
                                            v-for="t in transactions"
                                            :key="t.id"
                                        >
                                            <td class="ps-4">{{ t.date }}</td>
                                            <td class="text-uppercase">
                                                {{ t.time }}
                                            </td>
                                            <td>{{ t.amount }}</td>
                                            <td class="text-success">
                                                {{ t.type }}
                                            </td>
                                            <td v-if="t.confirmed">
                                                <i
                                                    class="fa-solid fa-check pe-2 text-success"
                                                ></i
                                                >{{
                                                    $t(
                                                        "wallet_log.button.success"
                                                    )
                                                }}
                                            </td>
                                            <td v-else>
                                                <i
                                                    class="fa-solid fa-times pe-2 text-danger"
                                                ></i
                                                >{{
                                                    $t(
                                                        "wallet_log.button.decline"
                                                    )
                                                }}
                                            </td>
                                            <!-- <td>
                        <img
                                    :src="url + '/assets/images/jazz-cash.png'"
                                    alt=""
                                    class="img-fluid"
                                  />
                      </td> -->
                    </tr>

                    <tr v-if="transactions.length == 0">
                        <td colspan="5" class="text-center">
                            Записей не найдено
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <a class="btn btn-secondary text-white px-4" type="button">
                Load More
                <i class="fa-solid fa-angles-right ps-2"></i>
              </a>
            </div> -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import Withdraws from "./Withdraws";

export default {
    components: {Withdraws},
    props: ["url"],
    mixins: [loginMixin],
    data() {
        return {
            current_balance: 0,
            loading: false,
            transactions: [],
            withdraw_amount: "",
            amount: "",
            payment_method: "",
            payment_details: {
                card_number: "",
                exp_month: "",
                exp_year: "",
                cvc: "",
            },
            payment_methods: [],
        };
    },
    methods: {
        async fetchCurrentBalance() {
            const params = {
                token: 123,
                user_id: this.User.user_id,
            };
            const res = await axios.get("/api/check-balance", { params });
            if (res.data && res.data.Status) {
                this.current_balance = res.data.data.userBalance;
            }
        },
        async fetchTransactionHistory() {
            const params = {
                token: 123,
                user_id: this.User.user_id,
            };
            const res = await axios.get("/api/wallet-history", { params });
            if (res.data && res.data.Status) {
                this.transactions = res.data.data.transactions;
                this.loading = false;
            }
        },
        async AddAmountToWallet() {
            console.log(this.payment_details.exp_month);
            let toast = this.$toasted;
            let expMonth =
                new Date(this.payment_details.exp_month).getUTCMonth() + 1;
                if (expMonth.toString().length == 1) {
                expMonth = '0' + expMonth
            }
            let body = {
                mentee_id: this.User.user_id,
                total: this.amount,
                payment_method_code: this.payment_method,
                /*
                cardInfo: {
                    number: this.payment_details.card_number,
                    exp_month: expMonth,
                    exp_year: new Date(
                        this.payment_details.exp_year
                    ).getFullYear(),
                    cvc: this.payment_details.cvc,
                },
                shipping_address: {
                    id: "",
                    first_name: "shahzad",
                    last_name: "Tariq",
                    email: "fharshad842@gmail.com",
                    city_id: 85335,
                    state_id: 3176,
                    country_id: 167,
                    zip_code: "38000",
                    address:
                        "Bismillah General Store Back Saira Mall Plaza Dogar Basti\nPeople Colony # 1 D Ground Faisalabad",
                    phone: "034677992777",
                },
                paytm_mode: "",
                wallat_desposit: true,
                shipping_id: 1,
                */
                plateForm: "web",
            };
            console.log(body);
            const headers = {
                Accept: "application/json",
                "Content-Type": "application/json",
            };
            //   console.log(body);
            this.loading = true;
            const res = await axios
                .post("/api/execute-payment", body, {
                    headers: headers,
                })
                .then((res) => {
                    console.log(res);
                    if (res.data.status == 400) {
                        toast.error(res.data.data.message);
                    }
                    if (res.data.original && res.data.original.Status) {
                        $("#add_ammount").click();
                        toast.success(res.data.original.msg);
                        this.fetchCurrentBalance();
                        this.fetchTransactionHistory();
                        this.payment_method = "";
                        this.payment_details.card_number = "";
                        this.payment_details.exp_month = "";
                        this.payment_details.exp_year = "";
                        this.payment_details.cvc = "";
                        this.amount = "";

                        // window.location = "/mentee/appointment-log";
                    }
                    this.loading = false;
                })
                .catch((error) => {
                    if (error.response) {
                        for (const property in error.response.data.errors) {
                            toast.error(error.response.data.errors[property]);
                        }
                    }
                    this.loading = false;
                });
        },
        async withDrawAmount() {
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                user_id: this.User.user_id,
                amount: this.withdraw_amount,
            };
            const res = await axios
                .post("/api/withdraw-request", params)
                .then((res) => {
                    if (res.data.Status) {
                        document.getElementById("withdraw_close").click();
                        toast.success(res.data.msg);
                    } else {
                        toast.error(res.data.msg);
                    }
                });
        },
        async fetchAppointmentDetails() {
            var params = {
                token: 123,
                appointment_id: this.appointmentid,
                user_id: this.User.user_id,
            };
            var toast = this.$toasted;
            const res = await axios
                .get("/api/appointmentDetails", { params })
                .then((res) => {
                    console.log(res.data.msg);
                    if (res.data.Status) {
                        this.loading = false;
                        this.formData.questions =
                            res.data.data.appointment.questions;
                        this.formData.book_file =
                            res.data.data.appointment.file;
                        this.formData.file_type =
                            res.data.data.appointment.file_type;
                        this.formData.payment =
                            res.data.data.appointment.payment;
                    }
                    if (!res.data.Status) {
                        this.loading = false;
                    }
                });
        },
        async fetchPaymentMethods() {
            const res = await axios.get("/api/payment_methods", {
                params: { token: 123, platform:'web' },
            });
            if (res.data) {
                // this.payment_methods = res.data.data;
                let current_method =  res.data.data.find(m => m.is_default == 1 )
                //console.log(current_method);
                this.payment_method = current_method.code;
                this.payment_methods.push(current_method)
            }
        },
    },
    created() {
        this.checkLoggedIn();
        // console.log(this.User.role);
    },
    mounted() {
        if (this.is_loggedIn) {
        } else {
            window.location.href = this.url + "/login";
            this.$toasted.error("Пожалуйста, Сначала Войдите В Систему");
        }
        this.fetchCurrentBalance();
        this.fetchTransactionHistory();
        this.fetchPaymentMethods();
    },
};
</script>

<style>
     .payment-card img{
    max-width: 60px;
    height: 40px;
    }
</style>

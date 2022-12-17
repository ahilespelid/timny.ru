<template>
    <div v-if="true" class="row">
        <div class="col-lg-8 mb-5">
            <h5>
                <svg v-show="confirmationProcess || (condition.identification_status !== null && condition.identification_status === 'processing')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                </svg>
                <b class="mt-1">  Регистрация электронного кошелька</b>
            </h5>
            <small v-show="!confirmationProcess && ( condition.identification_status === 'no_identified' || condition.identification_status == null)" class="text-muted" style="font-size: 0.7em;line-height: normal;display:block;width: 80%;">Для вывода полученного вознаграждения, необходима регистрация электронного кошелька. Электронный кошелёк будет зарегистрирован в НКО “Монета” на основании Соглашения. Продолжая регистрацию, Вы соглашаетесь с его условиями и Лимитами на проведение операции.</small>
            <div v-show="!confirmationProcess && ( condition.identification_status === 'no_identified' || condition.identification_status == null)" class="row mt-3 g-3">
                <div class="col-md-5">
                    <h5 class="block w-100"><b>Данные паспорта</b></h5>
                    <div class="row g-2 justify-content-start mt-1">
                        <div class="col-5 d-flex flex-column">
                            <small class="mt-2 text-muted ml-1">Серия</small>
                            <input :readonly="StepTwo" v-model="moneta.passport_series" class="px-3 py-2 fs-4 text-gray-600 ml-2 text-center" maxlength="4" style="border-radius: .5em;background:#EFEFEF;color:#575757;border: 0;width: 4em;">
                        </div>
                        <div class="col-7 d-flex flex-column" style="width: max-content;">
                            <small class="mt-2 text-muted ml-1">Номер</small>
                            <input :readonly="StepTwo" v-model="moneta.passport_number" class="px-3 py-2 fs-4 text-gray-600 text-center" maxlength="6" style="border-radius: .5em;background:#EFEFEF;color:#575757;border: 0;width: 6em;">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h5 v-if="!StepTwo" @click="StepTwo = true" class="mb-0"><b>Контактный телефон</b></h5>
                    <h5 v-if="StepTwo" class="mb-0"><b>Код подтверждения</b></h5>
                    <small v-if="!StepTwo" class="text-muted">на него поступит SMS-сообщение с кодом</small>
                    <small v-if="StepTwo" class="text-muted">введите код, отправленный на номер {{moneta.phone}}</small>
                    <div class="row g-3 mt-1">
                        <div class="col-md-8">
                            <input v-if="!StepTwo" type="tel" data-inputmask="'mask': '+7 999 999 99 99'" v-model="moneta.phone" class="px-3 py-2 fs-4 text-gray-600 ml-2" style="border-radius: .5em;background:#EFEFEF;color:#575757;border: 0;">
                            <input @input="checkCode($event)" v-show="StepTwo" data-inputmask="'mask': '999999'" v-model="moneta.code" :class="{'animate-pulse':loading, 'input-success': success, 'input-regular': !success}" class="px-3 py-2 fs-4 ml-2" style="border-radius: .5em;border: 0;">
                        </div>
                        <div class="col-md-4">
                            <button v-if="!StepTwo" @click="createMonetaAccount" class="px-3 py-2 text-center" style="border-radius: .5em; height:100%;background:#D6CFE5;color:#260076;border: 0;"><b>Подтвердить</b></button>
                        </div>
                    </div>
                </div>
            </div>
            <small v-show="confirmationProcess || (condition.identification_status !== null && condition.identification_status === 'processing') " class="text-muted mt-4" style="font-size: 1.2em;line-height: normal;display:block;width: 80%;">
                Мы проверяем Ваши данные. После подтверждения Вы сможете получить доступ к кошельку. Об окончании проверки мы сообщим по электронной почте.
            </small>
            <small v-show="condition.identification_status !== null && condition.identification_status === 'identification_failed'" class="text-danger mt-4" style="font-size: 1.2em;line-height: normal;display:block;width: 80%;">
                {{condition.error_str}}
            </small>
        </div>
    </div>
</template>

<script>
import Inputmask from 'inputmask';
export default {
    name: "CreateMonetaProfile",
    props:{
      User:Object,
    },
    mounted() {
        Inputmask().mask(document.querySelectorAll("input"));
        let self = this;
        axios.get('/api/Moneta/getCondition')
            .then(function (data) {
               self.condition = data.data;
               console.log(data.data);
            });
        },
    data(){
        return {
            moneta:{
                passport_series:null,
                passport_number:null,
                phone:null,
            },
            UM:null,
            StepTwo: false,
            loading: false,
            success: false,
            confirmationProcess:false,
            condition: {
                unit_id: null,
                document_added: false,
                phone_confirmed: false,
                identification_status: 'no_identified',
                error_str: null,
                account_id: null,
                asyncId: null,
                profile_id: null,
            }
        }
    },
    methods:{
        getUM(){
            this.UM = Inputmask.unmask(this.moneta.phone, { mask: "+9 999 999 99 99" });
        },
        checkCode(e){
            console.log(e.target);
          if(e.target.inputmask.isComplete()){
              let self = this;
              console.log('Код заполнен. Отравляем на проверку.');
              this.loading = true;
              axios.post('/api/Moneta/checkPhoneCode', {
                //  user_id: this.User.user_id,
                  code: e.target.value,
              })
                  .then(function (data){
                      console.log(data.data);
                      if(data.data.success === 1){
                          self.loading = false;
                          self.success = true;
                          setTimeout(function (){
                              self.confirmationProcess = true;
                          }, 2000)
                      }
                  })
                  .catch(function (data){
                      console.log(data.data);
                  });

          }
        },
        createMonetaAccount(){
            let self = this;
            console.log('Нажата кнопка подтверждения');
            axios.post('/api/Moneta/createProfile', {
               // user_id: this.User.user_id,
                passport_series: this.moneta.passport_series,
                passport_number: this.moneta.passport_number,
                phone: Inputmask.unmask(this.moneta.phone, { mask: "+9 999 999 99 99" }),
            })
                .then(function (data){
                    console.log(data.data);
                    if(data.data.success === 1){
                        self.StepTwo = true;
                    }
                })
                .catch(function (data){
                    console.log(data.data);
                });
        },
    }
}
</script>

<style scoped>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;

    }
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }

    .input-regular {
        background:#EFEFEF;
        color:#575757;
    }
    .input-success {
        background: #d1eab7;
        color: #54b01c;
    }
</style>

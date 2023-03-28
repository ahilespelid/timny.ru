<template>
    <div v-if="condition.identification_status === 'no_identified' || condition.identification_status === 'identification_failed'" class="flex flex-col gap-3 bg-gray-100 rounded-2xl lg:w-1/2 p-6">
        <div class="flex flex-col gap-3">
            <div class="flex flex-col">
                <span class="text-xl text-gray-700 font-semibold mb-1">Регистрация электронного кошелька</span>
                <span class="text-xs text-gray-500">
            Для вывода полученного вознаграждения, необходима регистрация электронного кошелька. Электронный кошелёк будет зарегистрирован в НКО “Монета” на основании <a class="text-blue-500 hover:text-blue-600 duration-200" href="#">Соглашения</a>. Продолжая регистрацию, Вы соглашаетесь с его условиями и <a class="text-blue-500 hover:text-blue-600 duration-200" href="#">Лимитами на проведение операции</a>.
          </span>
            </div>
            <span v-if="!condition.document_added" class="text-lg text-gray-700 font-semibold -mb-1">Данные паспорта</span>

            <div v-if="condition.document_added" class="flex flex-row gap-2 items-center">
                <div class="w-5 h-5 text-green-500 rounded-full flex justify-center items-center">
                    <svg class="stroke-current w-full" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.5 16L20.5 34L43 4" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="text-md font-semibold text-gray-600">Паспорт добавлен</span>
            </div>
            <div v-else class="flex flex-col md:flex-row gap-3">
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs mb-1">Серия</span>
                    <input v-model="moneta.passport_series" class="px-2 max-w-full py-1 rounded-lg text-lg font-semibold outline-1 outline-transparent focus-visible:outline-blue-500 duration-200" maxlength="4">
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs mb-1">Номер</span>
                    <input v-model="moneta.passport_number" class="px-2 max-w-full py-1 rounded-lg text-lg font-semibold outline-1 outline-transparent focus-visible:outline-blue-500 duration-200" maxlength="6">
                </div>
            </div>

            <div v-if="condition.phone_confirmed !== 'confirmed'" class="flex flex-col gap-2">
                <div v-if="condition.phone_confirmed != 'sms_send'" class="flex flex-col">
                    <span class="text-lg text-gray-700 font-semibold -mb-1">Номер телефона</span>
                    <span class="text-gray-500 text-xs mb-2">отправим на него SMS с кодом {{moneta.code}}</span>
                    <div class="flex flex-col md:flex-row gap-3">
                        <input v-model="moneta.phone" type="tel" data-inputmask="'mask': '+7 999 999 99 99'" class="px-2 max-w-full py-1 rounded-lg text-lg font-semibold outline-1 outline-transparent focus-visible:outline-blue-500 duration-200 md:w-min">
                        <button @click="createMonetaAccount" class="w-full md:w-max h-max justify-center rounded-lg bg-gray-200 px-2 py-2 text-gray-500 text-sm font-semibold flex items-center hover:bg-blue-200 duration-200">Подтвердить</button>
                    </div>
                </div>
                <div v-else class="flex flex-col">
                    <span class="text-lg text-gray-700 font-semibold -mb-1">Код подтверждения</span>
                    <span class="text-gray-500 text-xs mb-2">введите код, отправленный на номер {{moneta.phone}}</span>
                    <div class="flex flex-col md:flex-row gap-3 items-center">
                        <input @input="checkCode" :class="{'animate-pulse bg-gray-50':loading, 'bg-green-100': success, 'bg-white': !success}" data-inputmask="'mask': '9 9 9 9 9 9'" class="px-2 py-1 md:mt-0 mt-2 rounded-lg text-2xl max-w-full font-semibold outline-1 outline-transparent focus-visible:outline-blue-500 duration-200 text-center w-[6em]">
                        <button @click="createMonetaAccount(true)" v-if="timer.is_expired" class="px-2 py-1 text-blue-500 text-xs flex items-center hover:text-blue-700 duration-200 md:w-min">Отправить повторно</button>
                        <div v-else class="w-32 text-xs text-gray-500 md:text-left text-center">Отправить повторно можно будет через {{timer.minute}}:{{timer.second.length === 1 ? '0'+timer.second : timer.second}}</div>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-row gap-2 items-center">
                <div class="w-5 h-5 text-green-500 rounded-full flex justify-center items-center">
                    <svg class="stroke-current w-full" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.5 16L20.5 34L43 4" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="text-md font-semibold text-gray-600">Телефон подтверждён</span>
            </div>

            <span class="text-red-500 text-xs mt-1 w-max mx-auto md:mx-0">{{error}}</span>
            <button v-if="condition.document_added && condition.phone_confirmed === 'confirmed'" @click="identificationRequest({})" class="w-full md:w-max h-max justify-center rounded-lg bg-gray-200 px-2 py-2 md:py-1 text-gray-500 text-sm font-semibold flex items-center hover:bg-blue-200 duration-200">Отправить на проверку</button>
        </div>
    </div>
    <div v-else-if="condition.identification_status === 'processing'" class="flex flex-row gap-3 items-center bg-gray-100 rounded-2xl md:w-1/2 p-6">
        <div class="h-5 w-5 shrink-0 md:w-16 md:h-16 md:p-2">
            <svg class="w-full animate-spin ease-out" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.857 26.3495C25.3255 24.6085 27.1887 22.1401 28.1863 19.289C29.184 16.4378 29.2663 13.3463 28.4218 10.4461C27.5772 7.54587 25.8481 4.98183 23.4757 3.112C21.1033 1.24217 18.2062 0.15992 15.189 0.0163879L14.9597 4.83735C16.9726 4.93311 18.9054 5.65512 20.4881 6.90257C22.0708 8.15001 23.2244 9.8606 23.7878 11.7955C24.3512 13.7303 24.2963 15.7928 23.6308 17.6949C22.9652 19.5971 21.7222 21.2438 20.0753 22.4053L22.857 26.3495Z" fill="#D9D9D9"/>
                <path d="M6.14297 2.65054C3.67447 4.39148 1.81131 6.85989 0.813663 9.71104C-0.183979 12.5622 -0.266288 15.6537 0.578233 18.5539C1.42275 21.4541 3.15194 24.0182 5.5243 25.888C7.89667 27.7578 10.7938 28.8401 13.811 28.9836L14.0403 24.1627C12.0274 24.0669 10.0946 23.3449 8.51192 22.0974C6.92921 20.85 5.7756 19.1394 5.21218 17.2046C4.64876 15.2697 4.70368 13.2072 5.36925 11.3051C6.03482 9.40295 7.27782 7.75617 8.92466 6.59471L6.14297 2.65054Z" fill="#D9D9D9"/>
            </svg>

        </div>
        <div class="flex flex-col">
            <span class="text-sm md:text-xl text-gray-700 font-semibold mb-1">Заявка отправлена на подтверждение</span>
            <span class="text-xs text-gray-500">
          Регистрация кошелька займет некоторое время. Мы проверяем данные. Эту страницу можно закрыть.
        </span>
        </div>
    </div>
    <div v-else-if="condition.identification_status === 'identified'" class="flex flex-row gap-3 items-center bg-gray-100 rounded-2xl md:w-1/2 p-6">
        <div class="h-5 w-5 shrink-0 md:w-16 md:h-16 text-green-500 rounded-full flex justify-center items-center">
            <svg class="stroke-current w-full md:p-3" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.5 16L20.5 34L43 4" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-sm md:text-xl text-gray-700 font-semibold mb-1">Кошелёк зарегистрирован</span>
            <span class="text-xs text-gray-500">
          Для Вас доступны функции принятия оплат и вывод вознаграждения.
        </span>
        </div>
    </div>
</template>

<script>
import Inputmask from 'inputmask';
import axios from "axios";
export default {
    name: "CreateMonetaProfile",
    props:{
        //User:Object,
    },
    mounted() {
        this.User = localStorage.getItem('User');
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
            },
            timer:{
              minute:2,
              second:60,
              is_expired:true,
            },
            error:null,
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
                this.identificationRequest({
                    //  user_id: this.User.user_id,
                    code: Inputmask.unmask(e.target.value, { mask: "9 9 9 9 9 9" }),
                });
            }
        },
        identificationRequest(req){
            let self = this;
            this.loading = true;
            axios.post('/api/Moneta/checkPhoneCode', req)
                .then(function (data){
                    console.log(data.data);
                    self.loading = false;
                    if(data.data.condition !== null) self.condition = data.data.condition;
                })
                .catch(function (error){
                    self.error = error.response.data.message;
                });
        },
        createMonetaAccount(again = false){
            let self = this;
            axios.post('/api/Moneta/createProfile', {
                // user_id: this.User.user_id,
                passport_series: this.moneta.passport_series,
                passport_number: this.moneta.passport_number,
                phone: again ? null : Inputmask.unmask(this.moneta.phone, { mask: "+9 999 999 99 99" }),
            })
                .then(function (data){
                    console.log(data.data);
                    self.timer.is_expired = false;
                    self.timer.minute = 2;
                    self.timer.second = 60;
                    if(data.data.condition !== null) self.condition = data.data.condition;
                    let refreshId;
                    refreshId = setInterval(function() {
                        self.timer.second--;
                        if (self.timer.second === 0) {
                            self.timer.minute --;
                            self.timer.second = 60;
                            if (self.timer.minute === 0) {
                                clearInterval(refreshId);
                                self.is_expired = true;
                            }
                        }
                    }, 1000);
                })
                .catch(function (error){
                    self.error = error.response.data.message;
                });
        },
    }
}
</script>

<style scoped>
*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.m-8{margin:2rem}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:.25rem}.-mb-1{margin-bottom:-.25rem}.mb-2{margin-bottom:.5rem}.mt-2{margin-top:.5rem}.mt-1{margin-top:.25rem}.flex{display:flex}.h-5{height:1.25rem}.h-max{height:-moz-max-content;height:max-content}.w-5{width:1.25rem}.w-full{width:100%}.w-\[6em\]{width:6em}.w-32{width:8rem}.w-max{width:-moz-max-content;width:max-content}.max-w-full{max-width:100%}.shrink-0{flex-shrink:0}@keyframes pulse{50%{opacity:.5}}.animate-pulse{animation:pulse 2s cubic-bezier(.4,0,.6,1) infinite}@keyframes spin{to{transform:rotate(360deg)}}.animate-spin{animation:spin 1s linear infinite}.flex-row{flex-direction:row}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-center{justify-content:center}.gap-3{gap:.75rem}.gap-2{gap:.5rem}.rounded-2xl{border-radius:1rem}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:.5rem}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-gray-200{--tw-bg-opacity: 1;background-color:rgb(229 231 235 / var(--tw-bg-opacity))}.bg-gray-50{--tw-bg-opacity: 1;background-color:rgb(249 250 251 / var(--tw-bg-opacity))}.bg-green-100{--tw-bg-opacity: 1;background-color:rgb(220 252 231 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.stroke-current{stroke:currentColor}.p-6{padding:1.5rem}.px-2{padding-left:.5rem;padding-right:.5rem}.py-1{padding-top:.25rem;padding-bottom:.25rem}.py-2{padding-top:.5rem;padding-bottom:.5rem}.text-center{text-align:center}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:.75rem;line-height:1rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-2xl{font-size:1.5rem;line-height:2rem}.font-semibold{font-weight:600}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-blue-500{--tw-text-opacity: 1;color:rgb(59 130 246 / var(--tw-text-opacity))}.text-green-500{--tw-text-opacity: 1;color:rgb(34 197 94 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-red-500{--tw-text-opacity: 1;color:rgb(239 68 68 / var(--tw-text-opacity))}.outline-1{outline-width:1px}.outline-transparent{outline-color:transparent}.duration-200{transition-duration:.2s}.ease-out{transition-timing-function:cubic-bezier(0,0,.2,1)}.hover\:bg-blue-200:hover{--tw-bg-opacity: 1;background-color:rgb(191 219 254 / var(--tw-bg-opacity))}.hover\:text-blue-600:hover{--tw-text-opacity: 1;color:rgb(37 99 235 / var(--tw-text-opacity))}.hover\:text-blue-700:hover{--tw-text-opacity: 1;color:rgb(29 78 216 / var(--tw-text-opacity))}.focus-visible\:outline-blue-500:focus-visible{outline-color:#3b82f6}@media (min-width: 768px){.md\:mx-0{margin-left:0;margin-right:0}.md\:mt-0{margin-top:0}.md\:h-16{height:4rem}.md\:w-min{width:-moz-min-content;width:min-content}.md\:w-max{width:-moz-max-content;width:max-content}.md\:w-1\/2{width:50%}.md\:w-16{width:4rem}.md\:flex-row{flex-direction:row}.md\:p-2{padding:.5rem}.md\:p-3{padding:.75rem}.md\:py-1{padding-top:.25rem;padding-bottom:.25rem}.md\:text-left{text-align:left}.md\:text-xl{font-size:1.25rem;line-height:1.75rem}}@media (min-width: 1024px){.lg\:w-1\/2{width:50%}}
</style>

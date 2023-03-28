<template>
    <div v-if="!cardAdded && isIdentified" class="w-full mx-auto mt-5 p-6 rounded-2xl bg-orange-50 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-5 items-center">
            <div class="w-16 h-16 text-orange-50 rounded-full bg-orange-400 flex justify-center items-center">
                <svg class="fill-current w-full p-3" viewBox="0 0 63 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47715 0 0 4.47715 0 10L63 10C63 4.47715 58.5228 0 53 0H10ZM63 18H0V34C0 39.5228 4.47715 44 10 44H53C58.5228 44 63 39.5228 63 34V18Z"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-xl text-orange-400">Карта не привязана</span>
                <span class="text-sm mt-1 text-zinc-500">Чтобы получать выплаты, нужно привязать карту. Для этого мы спишем и сразу вернём незначительную сумму.</span>
            </div>
        </div>
        <button @click="addCard" class="h-max text-white rounded-lg px-2 py-2 bg-indigo-700 font-semibold text-sm hover:bg-indigo-500 duration-200">Привязать</button>
    </div>
    <div v-else-if="!isIdentified" class="w-full mx-auto mt-5 p-6 rounded-2xl bg-red-50 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-5 items-center">
            <div class="w-16 h-16 text-red-50 rounded-full bg-red-400 flex justify-center items-center">
                <svg class="stroke-current w-full p-3" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4L38 38M38 4L4 38" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-xl text-red-400">Для вывода вознаграждения нужен подтверждённый аккаунт</span>
                <span class="text-sm mt-1 text-zinc-500">Пройдите идентификацию в разделе "Реквизиты Банковского Счета" Вашего профиля.</span>
            </div>
            <a href="/mentor-profile" class="h-max text-white rounded-lg px-2 py-2 bg-red-600 font-semibold text-sm hover:bg-red-400 duration-200">В профиль</a>
        </div>
    </div>
    <div v-else-if="!createWithdrawOrderFailed && !withdrawIsOrdered" class="w-full mx-auto mt-5 p-6 rounded-2xl bg-indigo-50 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-5 items-center">
            <div class="w-16 h-16 text-indigo-50 rounded-full bg-indigo-400 flex justify-center items-center">
                <svg class="fill-current w-full p-3" viewBox="0 0 63 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47715 0 0 4.47715 0 10L63 10C63 4.47715 58.5228 0 53 0H10ZM63 18H0V34C0 39.5228 4.47715 44 10 44H53C58.5228 44 63 39.5228 63 34V18Z"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-xl text-indigo-400">Заказ выплаты</span>
                <span class="text-sm mt-1 text-zinc-500">Доступно к выплате: {{ available_balance }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs text-zinc-600">Сумма выплаты</span>
                <input @change="checkWithdrawSum" class="p-2 rounded-lg outline-1 outline-transparent focus-visible:outline-indigo-400 duration-300" v-model="withdrawSum">
            </div>
        </div>
        <div class="flex flex-col gap-1">
            <button @click="createWithdrawOrder" :class="{'placeholder':load}" class="h-max text-white rounded-lg px-2 py-2 bg-indigo-700 font-semibold text-sm hover:bg-indigo-500 duration-200">Заказать</button>
            <button @click="cardAdded = false">Изменить карту</button>
        </div>
    </div>
    <div v-else-if="withdrawIsOrdered" class="w-full mx-auto mt-5 p-6 rounded-2xl bg-green-50 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-5 items-center">
            <div class="w-16 h-16 text-green-50 rounded-full bg-green-400 flex justify-center items-center">
                <svg class="stroke-current w-full p-3" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.5 16L20.5 34L43 4" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-xl text-green-400">Заказ успешно создан</span>
                <span class="text-sm mt-1 text-zinc-500">Ожидайте выплаты</span>
            </div>
        </div>
        <button @click="tryAgain" class="h-max text-white rounded-lg px-2 py-2 bg-green-600 font-semibold text-sm hover:bg-green-400 duration-200">Заказать ещё</button>
    </div>
    <div v-else-if="createWithdrawOrderFailed" class="w-full mx-auto mt-5 p-6 rounded-2xl bg-red-50 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-5 items-center">
            <div class="w-16 h-16 text-red-50 rounded-full bg-red-400 flex justify-center items-center">
                <svg class="stroke-current w-full p-3" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4L38 38M38 4L4 38" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-xl text-red-400">Не удалось провести выплату</span>
                <span class="text-sm mt-1 text-zinc-500">{{error}}</span>
            </div>
        </div>
        <button @click="tryAgain" class="h-max text-white rounded-lg px-2 py-2 bg-red-600 font-semibold text-sm hover:bg-red-400 duration-200">Попробовать ещё раз</button>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Withdraws",
    props:{
           available_balance:Number,
    },
    data(){
        return{
            cardAdded: false,
            withdrawSum: 0,
            //available_balance: 300, // удалить на проде
            withdrawIsOrdered: false,
            createWithdrawOrderFailed: false,
            accountId:0,
            error:'Попробуйте позже',
            load: false,
            isIdentified: false,
        }
    },
    mounted() {
        let self = this;
        axios.get('/api/Moneta/getCondition')
            .then(function (data){
                self.cardAdded = data.data.operation_id !== null;
                self.accountId = data.data.account_id;
                self.isIdentified = data.data.identification_status === 'identified';
            });
    },
    methods:{
        addCard(){
            let self = this;
            let options = {
                account: this.accountId,
                amount: 10,
                testMode: 0,
                customParams:{
                    addCardMode: 1,
                },
            };
            var assistant = new Assistant.Builder();
            assistant.build(options);
            assistant.setOnSuccessCallback(function(operationId, transactionId) {
                self.cardAdded = true;
            });
        },
        checkWithdrawSum(){
            if(this.withdrawSum > this.available_balance){
                this.withdrawSum = this.available_balance;
            }
        },
        createWithdrawOrder(){
            let self = this;
            this.load = true;
            axios.post('/api/Moneta/createWithdrawOrder', {
                withdrawSum: self.withdrawSum,
            })
                .then(function (data) {
                    if(data.data === 'SUCCESS') self.withdrawIsOrdered = true;
                    self.load = false;
                })
                .catch(function (error) {
                    console.log(error.toJSON());
                    self.createWithdrawOrderFailed = true;
                    self.error = error.response.data.message;
                    self.load = false;
                })
        },
        tryAgain(){
            this.withdrawSum = 0;
            this.withdrawIsOrdered = false;
            this.createWithdrawOrderFailed = false;
        },
    },
}
</script>
<style scoped>
*[data-v-e0f28340],[data-v-e0f28340]:before,[data-v-e0f28340]:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}[data-v-e0f28340]:before,[data-v-e0f28340]:after{--tw-content: ""}html[data-v-e0f28340]{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body[data-v-e0f28340]{margin:0;line-height:inherit}hr[data-v-e0f28340]{height:0;color:inherit;border-top-width:1px}abbr[data-v-e0f28340]:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1[data-v-e0f28340],h2[data-v-e0f28340],h3[data-v-e0f28340],h4[data-v-e0f28340],h5[data-v-e0f28340],h6[data-v-e0f28340]{font-size:inherit;font-weight:inherit}a[data-v-e0f28340]{color:inherit;text-decoration:inherit}b[data-v-e0f28340],strong[data-v-e0f28340]{font-weight:bolder}code[data-v-e0f28340],kbd[data-v-e0f28340],samp[data-v-e0f28340],pre[data-v-e0f28340]{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small[data-v-e0f28340]{font-size:80%}sub[data-v-e0f28340],sup[data-v-e0f28340]{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub[data-v-e0f28340]{bottom:-.25em}sup[data-v-e0f28340]{top:-.5em}table[data-v-e0f28340]{text-indent:0;border-color:inherit;border-collapse:collapse}button[data-v-e0f28340],input[data-v-e0f28340],optgroup[data-v-e0f28340],select[data-v-e0f28340],textarea[data-v-e0f28340]{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button[data-v-e0f28340],select[data-v-e0f28340]{text-transform:none}button[data-v-e0f28340],[type=button][data-v-e0f28340],[type=reset][data-v-e0f28340],[type=submit][data-v-e0f28340]{-webkit-appearance:button;background-color:transparent;background-image:none}[data-v-e0f28340]:-moz-focusring{outline:auto}[data-v-e0f28340]:-moz-ui-invalid{box-shadow:none}progress[data-v-e0f28340]{vertical-align:baseline}[data-v-e0f28340]::-webkit-inner-spin-button,[data-v-e0f28340]::-webkit-outer-spin-button{height:auto}[type=search][data-v-e0f28340]{-webkit-appearance:textfield;outline-offset:-2px}[data-v-e0f28340]::-webkit-search-decoration{-webkit-appearance:none}[data-v-e0f28340]::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary[data-v-e0f28340]{display:list-item}blockquote[data-v-e0f28340],dl[data-v-e0f28340],dd[data-v-e0f28340],h1[data-v-e0f28340],h2[data-v-e0f28340],h3[data-v-e0f28340],h4[data-v-e0f28340],h5[data-v-e0f28340],h6[data-v-e0f28340],hr[data-v-e0f28340],figure[data-v-e0f28340],p[data-v-e0f28340],pre[data-v-e0f28340]{margin:0}fieldset[data-v-e0f28340]{margin:0;padding:0}legend[data-v-e0f28340]{padding:0}ol[data-v-e0f28340],ul[data-v-e0f28340],menu[data-v-e0f28340]{list-style:none;margin:0;padding:0}textarea[data-v-e0f28340]{resize:vertical}input[data-v-e0f28340]::-moz-placeholder,textarea[data-v-e0f28340]::-moz-placeholder{opacity:1;color:#9ca3af}input[data-v-e0f28340]::placeholder,textarea[data-v-e0f28340]::placeholder{opacity:1;color:#9ca3af}button[data-v-e0f28340],[role=button][data-v-e0f28340]{cursor:pointer}[data-v-e0f28340]:disabled{cursor:default}img[data-v-e0f28340],svg[data-v-e0f28340],video[data-v-e0f28340],canvas[data-v-e0f28340],audio[data-v-e0f28340],iframe[data-v-e0f28340],embed[data-v-e0f28340],object[data-v-e0f28340]{display:block;vertical-align:middle}img[data-v-e0f28340],video[data-v-e0f28340]{max-width:100%;height:auto}[hidden][data-v-e0f28340]{display:none}*[data-v-e0f28340],[data-v-e0f28340]:before,[data-v-e0f28340]:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }[data-v-e0f28340]::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.absolute[data-v-e0f28340]{position:absolute}.mx-auto[data-v-e0f28340]{margin-left:auto;margin-right:auto}.mt-5[data-v-e0f28340]{margin-top:1.25rem}.mt-1[data-v-e0f28340]{margin-top:.25rem}.flex[data-v-e0f28340]{display:flex}.h-16[data-v-e0f28340]{height:4rem}.h-max[data-v-e0f28340]{height:-moz-max-content;height:max-content}.w-full[data-v-e0f28340]{width:100%}.w-16[data-v-e0f28340]{width:4rem}.flex-row[data-v-e0f28340]{flex-direction:row}.flex-col[data-v-e0f28340]{flex-direction:column}.items-center[data-v-e0f28340]{align-items:center}.justify-center[data-v-e0f28340]{justify-content:center}.justify-between[data-v-e0f28340]{justify-content:space-between}.gap-6[data-v-e0f28340]{gap:1.5rem}.gap-5[data-v-e0f28340]{gap:1.25rem}.gap-1[data-v-e0f28340]{gap:.25rem}.rounded-2xl[data-v-e0f28340]{border-radius:1rem}.rounded-full[data-v-e0f28340]{border-radius:9999px}.rounded-lg[data-v-e0f28340]{border-radius:.5rem}.border[data-v-e0f28340]{border-width:1px}.bg-orange-50[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(255 247 237 / var(--tw-bg-opacity))}.bg-orange-400[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(251 146 60 / var(--tw-bg-opacity))}.bg-indigo-700[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(67 56 202 / var(--tw-bg-opacity))}.bg-indigo-50[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(238 242 255 / var(--tw-bg-opacity))}.bg-indigo-400[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(129 140 248 / var(--tw-bg-opacity))}.bg-green-50[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(240 253 244 / var(--tw-bg-opacity))}.bg-green-400[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(74 222 128 / var(--tw-bg-opacity))}.bg-green-600[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(22 163 74 / var(--tw-bg-opacity))}.bg-red-50[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-red-400[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(248 113 113 / var(--tw-bg-opacity))}.bg-red-600[data-v-e0f28340]{--tw-bg-opacity: 1;background-color:rgb(220 38 38 / var(--tw-bg-opacity))}.fill-current[data-v-e0f28340]{fill:currentColor}.stroke-current[data-v-e0f28340]{stroke:currentColor}.p-6[data-v-e0f28340]{padding:1.5rem}.p-3[data-v-e0f28340]{padding:.75rem}.p-2[data-v-e0f28340]{padding:.5rem}.px-2[data-v-e0f28340]{padding-left:.5rem;padding-right:.5rem}.py-2[data-v-e0f28340]{padding-top:.5rem;padding-bottom:.5rem}.text-xl[data-v-e0f28340]{font-size:1.25rem;line-height:1.75rem}.text-sm[data-v-e0f28340]{font-size:.875rem;line-height:1.25rem}.text-xs[data-v-e0f28340]{font-size:.75rem;line-height:1rem}.font-semibold[data-v-e0f28340]{font-weight:600}.text-orange-50[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(255 247 237 / var(--tw-text-opacity))}.text-orange-400[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(251 146 60 / var(--tw-text-opacity))}.text-zinc-500[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(113 113 122 / var(--tw-text-opacity))}.text-white[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.text-indigo-50[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(238 242 255 / var(--tw-text-opacity))}.text-indigo-400[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(129 140 248 / var(--tw-text-opacity))}.text-zinc-600[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(82 82 91 / var(--tw-text-opacity))}.text-green-50[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(240 253 244 / var(--tw-text-opacity))}.text-green-400[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(74 222 128 / var(--tw-text-opacity))}.text-red-50[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(254 242 242 / var(--tw-text-opacity))}.text-red-400[data-v-e0f28340]{--tw-text-opacity: 1;color:rgb(248 113 113 / var(--tw-text-opacity))}.outline-1[data-v-e0f28340]{outline-width:1px}.outline-transparent[data-v-e0f28340]{outline-color:transparent}.duration-200[data-v-e0f28340]{transition-duration:.2s}.duration-300[data-v-e0f28340]{transition-duration:.3s}.hover\:bg-indigo-500[data-v-e0f28340]:hover{--tw-bg-opacity: 1;background-color:rgb(99 102 241 / var(--tw-bg-opacity))}.hover\:bg-green-400[data-v-e0f28340]:hover{--tw-bg-opacity: 1;background-color:rgb(74 222 128 / var(--tw-bg-opacity))}.hover\:bg-red-400[data-v-e0f28340]:hover{--tw-bg-opacity: 1;background-color:rgb(248 113 113 / var(--tw-bg-opacity))}.focus-visible\:outline-indigo-400[data-v-e0f28340]:focus-visible{outline-color:#818cf8}*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.absolute{position:absolute}.mx-auto{margin-left:auto;margin-right:auto}.mt-5{margin-top:1.25rem}.mt-1{margin-top:.25rem}.flex{display:flex}.table{display:table}.hidden{display:none}.h-16{height:4rem}.h-max{height:-moz-max-content;height:max-content}.w-11\/12{width:91.666667%}.w-16{width:4rem}.w-full{width:100%}.flex-row{flex-direction:row}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-6{gap:1.5rem}.gap-5{gap:1.25rem}.gap-1{gap:.25rem}.rounded-2xl{border-radius:1rem}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:.5rem}.border{border-width:1px}.bg-orange-50{--tw-bg-opacity: 1;background-color:rgb(255 247 237 / var(--tw-bg-opacity))}.bg-orange-400{--tw-bg-opacity: 1;background-color:rgb(251 146 60 / var(--tw-bg-opacity))}.bg-indigo-700{--tw-bg-opacity: 1;background-color:rgb(67 56 202 / var(--tw-bg-opacity))}.bg-indigo-50{--tw-bg-opacity: 1;background-color:rgb(238 242 255 / var(--tw-bg-opacity))}.bg-indigo-400{--tw-bg-opacity: 1;background-color:rgb(129 140 248 / var(--tw-bg-opacity))}.bg-green-50{--tw-bg-opacity: 1;background-color:rgb(240 253 244 / var(--tw-bg-opacity))}.bg-green-400{--tw-bg-opacity: 1;background-color:rgb(74 222 128 / var(--tw-bg-opacity))}.bg-green-600{--tw-bg-opacity: 1;background-color:rgb(22 163 74 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity: 1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-red-400{--tw-bg-opacity: 1;background-color:rgb(248 113 113 / var(--tw-bg-opacity))}.bg-red-600{--tw-bg-opacity: 1;background-color:rgb(220 38 38 / var(--tw-bg-opacity))}.fill-current{fill:currentColor}.stroke-current{stroke:currentColor}.p-6{padding:1.5rem}.p-3{padding:.75rem}.p-2{padding:.5rem}.px-2{padding-left:.5rem;padding-right:.5rem}.py-2{padding-top:.5rem;padding-bottom:.5rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-xs{font-size:.75rem;line-height:1rem}.font-semibold{font-weight:600}.text-orange-50{--tw-text-opacity: 1;color:rgb(255 247 237 / var(--tw-text-opacity))}.text-orange-400{--tw-text-opacity: 1;color:rgb(251 146 60 / var(--tw-text-opacity))}.text-zinc-500{--tw-text-opacity: 1;color:rgb(113 113 122 / var(--tw-text-opacity))}.text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.text-indigo-50{--tw-text-opacity: 1;color:rgb(238 242 255 / var(--tw-text-opacity))}.text-indigo-400{--tw-text-opacity: 1;color:rgb(129 140 248 / var(--tw-text-opacity))}.text-zinc-600{--tw-text-opacity: 1;color:rgb(82 82 91 / var(--tw-text-opacity))}.text-green-50{--tw-text-opacity: 1;color:rgb(240 253 244 / var(--tw-text-opacity))}.text-green-400{--tw-text-opacity: 1;color:rgb(74 222 128 / var(--tw-text-opacity))}.text-red-50{--tw-text-opacity: 1;color:rgb(254 242 242 / var(--tw-text-opacity))}.text-red-400{--tw-text-opacity: 1;color:rgb(248 113 113 / var(--tw-text-opacity))}.outline-1{outline-width:1px}.outline-transparent{outline-color:transparent}.duration-200{transition-duration:.2s}.duration-300{transition-duration:.3s}.hover\:bg-indigo-500:hover{--tw-bg-opacity: 1;background-color:rgb(99 102 241 / var(--tw-bg-opacity))}.hover\:bg-green-400:hover{--tw-bg-opacity: 1;background-color:rgb(74 222 128 / var(--tw-bg-opacity))}.hover\:bg-red-400:hover{--tw-bg-opacity: 1;background-color:rgb(248 113 113 / var(--tw-bg-opacity))}.focus-visible\:outline-indigo-400:focus-visible{outline-color:#818cf8}@media (min-width: 768px){.md\:flex-row{flex-direction:row}}
</style>

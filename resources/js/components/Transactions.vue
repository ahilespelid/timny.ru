<template>
    <div class="max-w-6xl mx-auto mt-6">
        <h2 class="text-3xl font-semibold">История операций</h2>
        <div class="flex flex-col bg-slate-200 rounded-2xl max-w-5xl py-3 px-10 mt-6 divide-y divide-slate-300">
            <div class="flex flex-row gap-2 justify-between items-center py-4" v-for="transaction in transactions">
                <div class="flex flex-row gap-12 w-1/2 items-center">
                    <div class="flex flex-col w-1/3">
                        <span class="text-xs text-slate-600">{{getDate(transaction.created_at)}}</span>
                        <span v-if="transaction.type === 'payment'" class="text-slate-700 text-sm">Платёж</span>
                        <span v-else-if="transaction.type === 'withdraw'" class="text-slate-700 text-sm">Выплата</span>
                        <span class="text-slate-500 text-sm">{{transaction.public_comment}}</span>
                    </div>
                    <span class="text-xl" :class="{'test-red-500':transaction.amount < 0, 'text-green-500': transaction.amount > 0}">{{transaction.amount}} ₽</span>
                </div>

                <a v-if="transaction.book_appointment_id" :href="'https://timny.ru/mentor/appointment-log-detail/'+transaction.book_appointment_id" class="flex text-blue-500 flex-row gap-1 items-center">
                    <svg class="w-4 h-4 fill-current mt-0.5" width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.96415 8.56284L3.64564 10.8814C3.36493 11.1523 2.99003 11.3037 2.59992 11.3037C2.2098 11.3037 1.8349 11.1523 1.5542 10.8814C1.41652 10.7442 1.30728 10.5813 1.23274 10.4018C1.1582 10.2224 1.11983 10.0299 1.11983 9.83563C1.11983 9.64132 1.1582 9.44891 1.23274 9.26946C1.30728 9.09001 1.41652 8.92704 1.5542 8.78991L3.87271 6.4714C3.98523 6.35888 4.04844 6.20627 4.04844 6.04714C4.04844 5.88801 3.98523 5.7354 3.87271 5.62288C3.76018 5.51035 3.60757 5.44714 3.44844 5.44714C3.28931 5.44714 3.1367 5.51035 3.02418 5.62288L0.70567 7.94736C0.238595 8.45576 -0.0140122 9.12494 0.000600385 9.81517C0.015213 10.5054 0.295916 11.1633 0.784088 11.6515C1.27226 12.1396 1.93016 12.4203 2.62038 12.4349C3.31061 12.4496 3.97979 12.197 4.48819 11.7299L6.81267 9.41137C6.86839 9.35565 6.91258 9.28951 6.94274 9.21671C6.97289 9.14392 6.98841 9.0659 6.98841 8.9871C6.98841 8.90831 6.97289 8.83029 6.94274 8.75749C6.91258 8.6847 6.86839 8.61856 6.81267 8.56284C6.75696 8.50713 6.69081 8.46293 6.61802 8.43278C6.54522 8.40263 6.4672 8.38711 6.38841 8.38711C6.30962 8.38711 6.23159 8.40263 6.1588 8.43278C6.086 8.46293 6.01986 8.50713 5.96415 8.56284ZM11.0912 1.34439C10.5885 0.844837 9.90858 0.564453 9.1999 0.564453C8.49122 0.564453 7.81132 0.844837 7.30864 1.34439L4.98416 3.6629C4.92844 3.71861 4.88425 3.78476 4.85409 3.85755C4.82394 3.93035 4.80842 4.00837 4.80842 4.08716C4.80842 4.16595 4.82394 4.24398 4.85409 4.31677C4.88425 4.38957 4.92844 4.45571 4.98416 4.51142C5.03987 4.56714 5.10602 4.61133 5.17881 4.64149C5.25161 4.67164 5.32963 4.68716 5.40842 4.68716C5.48721 4.68716 5.56523 4.67164 5.63803 4.64149C5.71082 4.61133 5.77697 4.56714 5.83268 4.51142L8.15119 2.19291C8.4319 1.922 8.80679 1.7706 9.19691 1.7706C9.58703 1.7706 9.96192 1.922 10.2426 2.19291C10.3803 2.33005 10.4895 2.49301 10.5641 2.67246C10.6386 2.85191 10.677 3.04432 10.677 3.23863C10.677 3.43295 10.6386 3.62535 10.5641 3.80481C10.4895 3.98426 10.3803 4.14722 10.2426 4.28435L7.92412 6.60286C7.86811 6.65841 7.82366 6.7245 7.79332 6.79732C7.76299 6.87014 7.74737 6.94824 7.74737 7.02713C7.74737 7.10601 7.76299 7.18411 7.79332 7.25693C7.82366 7.32975 7.86811 7.39584 7.92412 7.45139C7.97967 7.5074 8.04576 7.55185 8.11858 7.58219C8.1914 7.61253 8.2695 7.62815 8.34839 7.62815C8.42727 7.62815 8.50537 7.61253 8.57819 7.58219C8.65101 7.55185 8.7171 7.5074 8.77265 7.45139L11.0912 5.12691C11.5907 4.62423 11.8711 3.94433 11.8711 3.23565C11.8711 2.52696 11.5907 1.84706 11.0912 1.34439ZM4.00417 8.43138C4.06 8.48676 4.12622 8.53058 4.19903 8.56031C4.27183 8.59005 4.34979 8.60512 4.42843 8.60467C4.50707 8.60512 4.58503 8.59005 4.65784 8.56031C4.73064 8.53058 4.79686 8.48676 4.85269 8.43138L7.79266 5.49141C7.90518 5.37889 7.9684 5.22628 7.9684 5.06715C7.9684 4.90802 7.90518 4.75541 7.79266 4.64289C7.68014 4.53036 7.52753 4.46715 7.3684 4.46715C7.20927 4.46715 7.05666 4.53036 6.94413 4.64289L4.00417 7.58285C3.94816 7.6384 3.90371 7.70449 3.87337 7.77731C3.84303 7.85013 3.82741 7.92823 3.82741 8.00712C3.82741 8.086 3.84303 8.1641 3.87337 8.23692C3.90371 8.30974 3.94816 8.37583 4.00417 8.43138Z"/>
                    </svg>
                    <span class="font-light text-sm">Встреча</span>
                </a>


                <div class="flex flex-row gap-3 items-center w-1/5">
                    <template v-if="transaction.status === 'processing'">
                        <div class="w-2 h-2 shrink-0 bg-slate-600 animate-ping rounded-full"></div>
                        <span class="font-light text-sm text-slate-600">В процессе</span>
                    </template>
                    <template v-else-if="transaction.status === 'holding'">
                        <div class="w-2 h-2 shrink-0 bg-sky-400 rounded-full"></div>
                        <span class="font-light text-sm text-slate-600">Заморожены</span>
                    </template>
                    <template v-else-if="transaction.status === 'done'">
                        <div class="w-2 h-2 shrink-0 bg-green-600 rounded-full"></div>
                        <span class="font-light text-sm text-slate-600">Выполнено</span>
                    </template>
                    <template v-else-if="transaction.status === 'refused'">
                        <div class="w-2 h-2 shrink-0 bg-red-800 rounded-full"></div>
                        <span class="font-light text-sm text-slate-600">Ошибка</span>
                    </template>
                    <template v-else-if="transaction.status === 'returning' || transaction.status === 'returned'">
                        <div class="w-2 h-2 shrink-0 bg-yellow-500 rounded-full"></div>
                        <span class="font-light text-sm text-slate-600">Проведен возврат</span>
                    </template>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    name: "Transactions",
    props:{
        user_id:Number,
    },
    mounted() {
        this.getTransactions();
    },
    data(){
        return {
            amount:50,
            transactions: [],
        }
    },
    methods:{
        getDate(date){
            date = new Date(date);

            var options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
            };

            return date.toLocaleString("ru", options);
        },
        getTransactions(){
            let self = this;
            axios.get('https://timny.ru/api/transactions/'+this.user_id)
                .then(function (data) {
                    self.transactions = data.data;
                })
        }
    }
}
</script>

<style scoped>
*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.my-32{margin-top:8rem;margin-bottom:8rem}.mx-auto{margin-left:auto;margin-right:auto}.mt-6{margin-top:1.5rem}.mt-0\.5{margin-top:.125rem}.mt-0{margin-top:0}.flex{display:flex}.h-4{height:1rem}.h-2{height:.5rem}.w-1\/2{width:50%}.w-1\/3{width:33.333333%}.w-4{width:1rem}.w-1\/5{width:20%}.w-2{width:.5rem}.max-w-6xl{max-width:72rem}.max-w-5xl{max-width:64rem}.shrink-0{flex-shrink:0}@keyframes ping{75%,to{transform:scale(2);opacity:0}}.animate-ping{animation:ping 1s cubic-bezier(0,0,.2,1) infinite}.flex-row{flex-direction:row}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-between{justify-content:space-between}.gap-2{gap:.5rem}.gap-12{gap:3rem}.gap-1{gap:.25rem}.gap-3{gap:.75rem}.divide-y>:not([hidden])~:not([hidden]){--tw-divide-y-reverse: 0;border-top-width:calc(1px * calc(1 - var(--tw-divide-y-reverse)));border-bottom-width:calc(1px * var(--tw-divide-y-reverse))}.divide-slate-300>:not([hidden])~:not([hidden]){--tw-divide-opacity: 1;border-color:rgb(203 213 225 / var(--tw-divide-opacity))}.rounded-2xl{border-radius:1rem}.rounded-full{border-radius:9999px}.bg-slate-200{--tw-bg-opacity: 1;background-color:rgb(226 232 240 / var(--tw-bg-opacity))}.bg-slate-600{--tw-bg-opacity: 1;background-color:rgb(71 85 105 / var(--tw-bg-opacity))}.bg-sky-400{--tw-bg-opacity: 1;background-color:rgb(56 189 248 / var(--tw-bg-opacity))}.bg-green-600{--tw-bg-opacity: 1;background-color:rgb(22 163 74 / var(--tw-bg-opacity))}.bg-red-800{--tw-bg-opacity: 1;background-color:rgb(153 27 27 / var(--tw-bg-opacity))}.bg-yellow-500{--tw-bg-opacity: 1;background-color:rgb(234 179 8 / var(--tw-bg-opacity))}.fill-current{fill:currentColor}.py-3{padding-top:.75rem;padding-bottom:.75rem}.px-10{padding-left:2.5rem;padding-right:2.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-xs{font-size:.75rem;line-height:1rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.font-semibold{font-weight:600}.font-light{font-weight:300}.text-slate-600{--tw-text-opacity: 1;color:rgb(71 85 105 / var(--tw-text-opacity))}.text-slate-700{--tw-text-opacity: 1;color:rgb(51 65 85 / var(--tw-text-opacity))}.text-slate-500{--tw-text-opacity: 1;color:rgb(100 116 139 / var(--tw-text-opacity))}.text-green-500{--tw-text-opacity: 1;color:rgb(34 197 94 / var(--tw-text-opacity))}.text-blue-500{--tw-text-opacity: 1;color:rgb(59 130 246 / var(--tw-text-opacity))}
</style>

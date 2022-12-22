<template>
    <div class="m-16" style="margin-bottom: 10rem;">
        <h1 class="text-2xl mb-4">Споры по оплате</h1>
        <div class="flex flex-col gap-2">
            <div v-for="conflict in conflicts" class="flex flex-row gap-2 justify-between p-8 rounded-lg bg-white">
                <div class="flex flex-col w-10 gap-2">
                    <div>#{{conflict.id}}</div>
                    <div>{{conflict.book_appointment_id}}</div>
                    <div class="text-sm">Сумма: {{conflict.book_appointment.payment}}</div>
                </div>
                <div class="flex w-1/6 flex-col gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Консультант</span>
                        <span>{{conflict.book_appointment.mentor_base.first_name}} {{conflict.book_appointment.mentor_base.last_name}}</span>
                        <a :href="'mailto:'+conflict.book_appointment.mentor_base.email" class="text-indigo-600 text-xs">{{conflict.book_appointment.mentor_base.email}}</a>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Клиент</span>
                        <span>{{conflict.book_appointment.mentee_base.first_name}} {{conflict.book_appointment.mentee_base.last_name}}</span>
                        <a :href="'mailto:'+conflict.book_appointment.mentee_base.email" class="text-indigo-600 text-xs">{{conflict.book_appointment.mentee_base.email}}</a>
                    </div>
                </div>
                <div class="w-5/12 flex flex-col gap-2">
                    <div v-for="log in conflict.conflict_log" class="flex flex-row gap-2 text-xs">
                        <span class="text-indigo-600 uppercase">{{getDatetime(log.time)}}</span>
                        <span class="text-gray-500">{{log.event}}</span>
                    </div>
                </div>
                <div class="w-2/12 flex flex-col gap-2 justify-between">
                    <div class="flex flex-row gap-3 text-sm justify-between"><span class="text-slate-500 uppercase">{{conflict.status}}</span><button @click="inProcess(conflict)" class="uppercase text-indigo-500 hover:text-indigo-700 duration-200" v-if="conflict.status !== 'processing'">В обработку</button></div>
                    <div class="flex flex-col gap-2">
                        <button v-if="conflict.status !== 'done'" @click="resolve(conflict, 'mentor')" class="rounded-lg bg-indigo-500 text-white px-2 py-1 hover:bg-indigo-600 duration-200">В пользу консультанта</button>
                        <button v-if="conflict.status !== 'done'" @click="resolve(conflict, 'mentee')" class="rounded-lg bg-indigo-500 text-white px-2 py-1 hover:bg-indigo-600 duration-200">В пользу клиента</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    name: "Conflicts.vue",
    // props:{
    //   conflicts:Object,
    // },
    mounted() {
        let self = this;
        axios.get('https://timny.ru/api/conflicts')
            .then(function (data) {
                self.conflicts = data.data;
            })
    },
    data(){
        return {
            conflicts: {},
        }
    },
    methods: {
        getDatetime(date) {
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
        inProcess(conflict){
            axios.get('https://timny.ru/api/conflicts/'+conflict.id+'/inProcess')
                .then(function (data) {
                    conflict = data.data;
                })
        },
        resolve(conflict, resolution){
            axios.post('https://timny.ru/api/resolveConflict', {
                Resolution:resolution,
                ConflictId:conflict.id,
            })
                .then(function (data){
                    conflict = data.data;
                });
        }
    }
}
</script>

<style scoped>
*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.m-16{margin:4rem}.mb-4{margin-bottom:1rem}.flex{display:flex}.w-10{width:2.5rem}.w-1\/6{width:16.666667%}.w-5\/12{width:41.666667%}.w-2\/12{width:16.666667%}.flex-row{flex-direction:row}.flex-col{flex-direction:column}.justify-between{justify-content:space-between}.gap-2{gap:.5rem}.gap-4{gap:1rem}.gap-3{gap:.75rem}.rounded-lg{border-radius:.5rem}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-indigo-500{--tw-bg-opacity: 1;background-color:rgb(99 102 241 / var(--tw-bg-opacity))}.p-8{padding:2rem}.px-2{padding-left:.5rem;padding-right:.5rem}.py-1{padding-top:.25rem;padding-bottom:.25rem}.text-2xl{font-size:1.5rem;line-height:2rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-xs{font-size:.75rem;line-height:1rem}.uppercase{text-transform:uppercase}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-indigo-600{--tw-text-opacity: 1;color:rgb(79 70 229 / var(--tw-text-opacity))}.text-slate-500{--tw-text-opacity: 1;color:rgb(100 116 139 / var(--tw-text-opacity))}.text-indigo-500{--tw-text-opacity: 1;color:rgb(99 102 241 / var(--tw-text-opacity))}.text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.duration-200{transition-duration:.2s}.hover\:bg-indigo-600:hover{--tw-bg-opacity: 1;background-color:rgb(79 70 229 / var(--tw-bg-opacity))}.hover\:text-indigo-700:hover{--tw-text-opacity: 1;color:rgb(67 56 202 / var(--tw-text-opacity))}
</style>

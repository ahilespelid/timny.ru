<template>
    <transition name="blur-fade">
        <div ref="modal" v-show="show" @click="close" class="absolute left-0 z-10 w-full min-h-screen h-full backdrop-blur-sm bg-black/30 flex justify-center items-center">
            <transition name="slide-fade">
                <div v-show="show" @click="$event.stopPropagation();" class="w-1/2 max-h-screen bg-white p-6 rounded-xl relative z-20 flex flex-col gap-2">
                    <div class="flex flex-row justify-between items-center w-full text-gray-800">
                        <div class="text-xl font-semibold">Как прошла встреча?</div>
                        <svg v-show="false" @click="close" class="h-5 w-5 fill-current cursor-pointer" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.56066 0.439339C1.97487 -0.146447 1.02513 -0.146446 0.43934 0.43934C-0.146447 1.02513 -0.146447 1.97487 0.43934 2.56066L8.57106 10.6924L0.945426 18.318C0.359639 18.9038 0.359641 19.8536 0.945427 20.4393C1.53121 21.0251 2.48096 21.0251 3.06675 20.4393L10.6924 12.8137L18.318 20.4393C18.9038 21.0251 19.8536 21.0251 20.4393 20.4393C21.0251 19.8536 21.0251 18.9038 20.4393 18.318L12.8137 10.6924L20.9454 2.56066C21.5312 1.97487 21.5312 1.02513 20.9454 0.439342C20.3596 -0.146445 19.4099 -0.146445 18.8241 0.439341L10.6924 8.57106L2.56066 0.439339Z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex flex-col gap-3 mt-3">
                            <div class="flex flex-row gap-2 items-center justify-center my-6" @mouseleave="hover = 0">
                                <span class="text-slate-400 text-sm">Ужасно</span>
                                <svg @mousemove="hover = n" class="cursor-pointer" @click="rating = n" :class="{'fill-yellow-500':(rating >= n && hover >= n) || (rating < hover && hover >= n) || hover === 0 && rating >= n, 'fill-slate-400':(hover < n && rating < n && hover <= rating) || (hover < n && hover > rating) || (hover < rating && hover < n && hover !== 0)}" v-for="n in 5" width="27" height="25" viewBox="0 0 27 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5 0L16.5309 9.32827H26.3393L18.4042 15.0935L21.4351 24.4217L13.5 18.6565L5.5649 24.4217L8.59584 15.0935L0.660737 9.32827H10.4691L13.5 0Z"/>
                                </svg>
                                <span class="text-slate-400 text-sm">Отлично</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-slate-500 text-sm">Отзыв о консультанте</span>
                                <textarea v-model="feedback" class="rounded-lg focus-visible:outline-0 p-4 border border-slate-400 h-28"></textarea>
                                <span class="text-slate-500 text-xs mx-1">Мы стремимся помогать нашим пользователям сделать выбор консультанта, поэтому просим оставить отзыв. Это поле обязательно.</span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-3 w-full mt-4">
                                <button @click="$emit('fault', [{rating:rating, feedback:feedback}])" class="bg-slate-200 hover:bg-slate-300 duration-200 rounded-lg py-2 flex flex-col text-slate-500 items-center">
                                    <span class="font-semibold">Встреча не состоялась</span>
                                    <span class="text-xs">разберемся почему и вернём деньги</span>
                                </button>
                                <button @click="$emit('success', [{rating:rating, feedback:feedback}])" class="bg-green-600 hover:bg-green-700 duration-200 rounded-lg py-2 flex flex-col text-white items-center">
                                    <span class="font-semibold">Встреча состоялась</span>
                                    <span class="text-xs">вознаграждение будет перечислено консультанту</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
import {watch} from 'vue';

export default {
    name: 'MeetEndModal',
    props:{
        show: {
            type: Boolean,
            default: false,
        },
        maxWidth: {
            type: String,
            default: '2xl',
        },
        closeable: {
            type: Boolean,
            default: true,
        },
    },
    watch:{
        show(show){
            if (show) {
                document.body.style.overflow = 'hidden';
                this.$refs.modal.style.top = window.scrollY+'px';
            } else {
                document.body.style.overflow = 'auto';
            }
            return show;
        }
    },
    data(){
        return{
            modal:null,
            rating:null,
            hover:0,
            feedback:null,
        }
    },
    emits: ['close', 'success', 'fault'],
    methods:{
      close() {
          if (this.closeable) {
              this.$emit('close');
          }
      },
        closeOnEscape(e){
            if (e.key === 'Escape' && this.show) {
                this.close();
            }
        }
    },
    mounted() {
        document.addEventListener('keydown', this.closeOnEscape);

    },
    unmounted(){
        document.removeEventListener('keydown', this.closeOnEscape);
        document.body.style.overflow = 'auto';
    },

}
</script>

<style scoped>
.blur-fade-enter-active {
    transition: all 0.2s ease-out;
}

.blur-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.blur-fade-enter,
.blur-fade-leave-to {
    backdrop-filter: blur(0);
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: scale(1.1,1.1);
    opacity: 0;
}

.blur-fade-enter-active[data-v-c4f3150f]{transition:all .2s ease-out}.blur-fade-leave-active[data-v-c4f3150f]{transition:all .2s cubic-bezier(1,.5,.8,1)}.blur-fade-enter-from[data-v-c4f3150f],.blur-fade-leave-to[data-v-c4f3150f]{-webkit-backdrop-filter:blur(0);backdrop-filter:blur(0);opacity:0}.slide-fade-enter-active[data-v-c4f3150f]{transition:all .3s ease-out}.slide-fade-leave-active[data-v-c4f3150f]{transition:all .3s cubic-bezier(1,.5,.8,1)}.slide-fade-enter-from[data-v-c4f3150f],.slide-fade-leave-to[data-v-c4f3150f]{transform:scale(1.1);opacity:0}*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.absolute{position:absolute}.relative{position:relative}.left-0{left:0px}.z-10{z-index:10}.z-20{z-index:20}.my-6{margin-top:1.5rem;margin-bottom:1.5rem}.mx-1{margin-left:.25rem;margin-right:.25rem}.mt-3{margin-top:.75rem}.mt-4{margin-top:1rem}.flex{display:flex}.grid{display:grid}.hidden{display:none}.h-full{height:100%}.h-5{height:1.25rem}.h-28{height:7rem}.max-h-screen{max-height:100vh}.min-h-screen{min-height:100vh}.w-full{width:100%}.w-1\/2{width:50%}.w-5{width:1.25rem}.transform{transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.cursor-pointer{cursor:pointer}.flex-row{flex-direction:row}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-2{gap:.5rem}.gap-3{gap:.75rem}.rounded-xl{border-radius:.75rem}.rounded-lg{border-radius:.5rem}.border{border-width:1px}.border-slate-400{--tw-border-opacity: 1;border-color:rgb(148 163 184 / var(--tw-border-opacity))}.bg-black\/30{background-color:#0000004d}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-slate-200{--tw-bg-opacity: 1;background-color:rgb(226 232 240 / var(--tw-bg-opacity))}.bg-green-600{--tw-bg-opacity: 1;background-color:rgb(22 163 74 / var(--tw-bg-opacity))}.fill-current{fill:currentColor}.fill-yellow-500{fill:#eab308}.fill-slate-400{fill:#94a3b8}.p-6{padding:1.5rem}.p-4{padding:1rem}.py-2{padding-top:.5rem;padding-bottom:.5rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-xs{font-size:.75rem;line-height:1rem}.font-semibold{font-weight:600}.text-gray-800{--tw-text-opacity: 1;color:rgb(31 41 55 / var(--tw-text-opacity))}.text-slate-400{--tw-text-opacity: 1;color:rgb(148 163 184 / var(--tw-text-opacity))}.text-slate-500{--tw-text-opacity: 1;color:rgb(100 116 139 / var(--tw-text-opacity))}.text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.blur{--tw-blur: blur(8px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.backdrop-blur-sm{--tw-backdrop-blur: blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.backdrop-filter{-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,-webkit-backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter,-webkit-backdrop-filter;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.duration-200{transition-duration:.2s}.hover\:bg-slate-300:hover{--tw-bg-opacity: 1;background-color:rgb(203 213 225 / var(--tw-bg-opacity))}.hover\:bg-green-700:hover{--tw-bg-opacity: 1;background-color:rgb(21 128 61 / var(--tw-bg-opacity))}.focus-visible\:outline-0:focus-visible{outline-width:0px}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>

<template>
  <div
    v-if="is_loggedIn"
    class="
      dropdown navbar-nav
      me-2
      d-flex
      justify-content-center
      align-items-start
      align-items-lg-center
      lang-text
      text-dark navbar-nav
    "
  >
    <a
      href="#"
      class="
        dropdown-toggle
        text-white
        d-flex
        px-2
        py-1
        justify-content-center
        align-items-center
      "
      data-bs-toggle="dropdown"
      @click="getNotificates()"
      >
      <span class="text-dark me-2">Уведомления</span>
    </a>
    <div class="notifications dropdown-menu dropdown-menu-end p-2 fw-500" style="width: 20vw;">
      <div class="notificate" v-for="notificate of notificates" :key="notificate.id">
        <a class="dropdown-item text-dark" style="white-space: normal;" :href="url + notificate.link">
          <div>{{ notificate.title }}</div>
          <div>{{ notificate.body }}</div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  import loginMixin from "../mixins/loginMixin.js";
  export default {
    mixins: [loginMixin],

    data () {
      return ({
        notificates: [],
      })
    },
    
    methods: {
      async getNotificates() {
        this.notificates = (await axios
          .get("/push-notificaiton")).data
      },
    }
  }
</script>

<style>
  .notificate:not(:last-child){
    border-bottom: 1px solid gray;
  }
</style>
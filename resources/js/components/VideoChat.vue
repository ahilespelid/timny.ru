<template>
  <div class="col-12">
    <div class="agora-box">
      <div class="agora-input">
        <div class="agora-button">
          <button
            type="button"
            v-if="this.User.role == 'Mentor' && this.appointment_type_id == 2 && this.appointment_status == 1 && this.timeInRange && !this.leftCommunication"
            class="btn btn-primary me-4"
            @click="joinEvent"
            :disabled="disableJoin"
          >
             {{$t('appointment_detail.btn.join_video_call')}}
          </button>
          <button
            type="button"
            v-if="this.User.role == 'Mentor' && this.appointment_type_id == 1 && this.appointment_status == 1  && this.timeInRange && !this.leftCommunication"
            class="btn btn-primary me-4"
            @click="joinEvent"
            :disabled="disableJoin"
          >
             {{$t('appointment_detail.btn.join_audio_call')}}
          </button>
          <button
            type="button"
            v-if="disableJoin"
            class="btn btn-danger"
            @click="leaveEvent"
            plain
            :disabled="!disableJoin"
          >
             {{$t('appointment_detail.btn.leave_appointment')}}
          </button>
        </div>
      </div>
    </div>
    <div class="agora-view" v-if="localStream">
      <div class="row w-100 mt-5">
        <div class="col-md-6">
          <div class="agora-video m-0 m-md-3 mt-md-0 mt-3">
            <StreamPlayer
              :stream="localStream"
              :domId="localStream.getId()"
              :appointment_type_id="appointment_type_id"
              :id="id"
            ></StreamPlayer>
          </div>
        </div>
        <div class="col-md-6">
          <div
            class="agora-video mt-md-0 mt-3"
            :key="index"
            v-for="(remoteStream, index) in remoteStreams"
          >
            <StreamPlayer
              :stream="remoteStreams[0]"
              :domId="remoteStreams[0].getId()"
              :appointment_type_id="appointment_type_id"
              :id="id"
            ></StreamPlayer>
          </div>
        </div>
      </div>
    </div>
      <div
          class="modal fade"
          id="ratingModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="ratingModalLabel"
          aria-hidden="true"
      >
          <div class="modal-dialog" role="document">
              <div class="modal-content border-0">
                  <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="ratingModalLabel"> {{$t('appointment_detail.btn.rate_now')}}</h5>
                      <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                      ></button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="exampleFormControlSelect1" class="text-dark fw-bold fs-5">{{$t('appointment_detail.btn.select_rating')}}</label>
                          <div class="rating">
                              <ul class="rate-area ps-0">
                                  <input type="radio" id="5" v-model="ratings.rate" name="rating" value="5" /><label for="5" title="Amazing">5 звезд</label>
                                  <input type="radio" id="4" v-model="ratings.rate" name="rating" value="4" /><label for="4" title="Good">4 звезды</label>
                                  <input type="radio" id="3" v-model="ratings.rate" name="rating" value="3" /><label for="3" title="Average">3 звезды</label>
                                  <input type="radio" id="2" v-model="ratings.rate" name="rating" value="2" /><label for="2" title="Not Good">2 звезды</label>
                                  <input type="radio" id="1" v-model="ratings.rate" name="rating" value="1" /><label for="1" title="Bad">1 звезда</label>
                              </ul>

                          </div>
                      </div>
                      <br>
                      <br>
                      <div class="form-group  mt-3">
                          <h5 for="review_message" class="text-dark fw-bold fs-5"> {{$t('appointment_detail.btn.comment')}}</h5>
                          <textarea
                              class="form-control mt-3"
                              v-model="ratings.comment"
                              id="review_message"
                              rows="3"
                              :placeholder="$t('appointment_detail.btn.placeholder_comment')"
                          ></textarea>
                      </div>
                  </div>
                  <div class="modal-footer row">
                      <button
                          type="button"
                          class="btn btn-secondary col w-50"
                          v-on:click="markAppointmentAsCompleted(false)"
                      >
                          Встреча не состоялась
                          <br><small>удержать вознаграждение</small>
                      </button>
                      <button
                          type="button"
                          id="submit_data"
                          v-on:click="markAppointmentAsCompleted(true)"
                          class="btn btn-primary col w-50"
                      >
                          Встреча состоялась
                          <br><small>перечислить вознаграждение</small>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import RTCClient from "../agora-rtc-client";
import StreamPlayer from "./stream-player";
import { log } from "../utils/utils";
import loginMixin from "../mixins/loginMixin.js";
import moment from 'moment'
export default {
  components: {
    StreamPlayer,
  },
  mixins: [loginMixin],
  props: ["id", "appointment_type_id", "mentee_id","appointment_status","start_time","end_time","date","showVideoCount"],

  data() {
    return {
      option: {
        appid: "9d686d1bc7354ba7889d5a103f73ff92",
        token: "",
        channel: "",
      },
      disableJoin: false,
      localStream: null,
      remoteStreams: [],
      isMentee: false,
      timeInRange: true,
      leftCommunication:false,
        ratings: {
            rate: "",
            comment: "",
        },
        modal:{},
    };
  },
    mounted() {
    this.modal = new bootstrap.Modal(document.getElementById('ratingModal'), {
            keyboard: false
        })
      },
    watch: {
     showVideoCount: {
     handler(newVal, oldVal){  // here having access to the new and old value

     var stime=moment(this.start_time,'h:mm a');
      var etime=moment(this.end_time,'h:mm a');

      var ctime=moment();

      if(ctime.isAfter(stime) && ctime.isBefore(etime)){
          this.timeInRange = true
}else {
          console.log('Not in Range');
      }
     },
     immediate: true //  Also very important the immediate in case you need it, the callback will be called immediately after the start of the observation
  }
  },
  methods: {
      markAppointmentAsCompleted(stat) {
          const params = {
              BookAppointmentId: this.id,
              ConfirmationStatus: stat,
          };
          let self = this;
      axios.post("/api/customerConfirm", params)
              .then((res) => {
                 // toast.success("Встреча завершена");
                 // self.sendCompletedAppointmentNotification();
                 // self.closeChat();
                  self.submitRating();
              });
      },
      async submitRating() {
          if (!this.ratings.rate || !this.ratings.comment) {
            //  this.$toasted.error("Поле оценки и комментария обязательно");
          } else {
              $("#ratingModal").modal("hide");
             // var toast = this.$toasted;
              var self = this;
              const params = {
                  token: 123,
                  mentee_id: this.User.user_id,
                  mentor_id: this.mentor_id,
                  rating: this.ratings.rate,
                  comments: this.ratings.comment,
                  appointment_id: this.appointment_id,
              };
              const res = await axios
                  .post("/api/create-rating", params)
                  .then((res) => {
                      if (res.data.Status) {
                       //   toast.success(res.data.msg);
                          self.appointmentDetails();
                          window.location='/mentee/appointment-log'
                      }
                      if (!res.data.Status) {
                        //  toast.error("Пожалуйста, заполните все поля...");
                      }
                  });
          }
      },
    async joinEvent() {
      var self = this;

      if (this.appointment_type_id == 2) {
        if (this.User.role == "Mentor") {
          this.sendVideoCallNotification();
        }
        this.rtc
          .joinChannel(this.option)
          .then(() => {
            this.rtc
              .publishStreamVideo()
              .then((stream) => {
                this.localStream = stream;
              })
              .catch((err) => {
                log("publish local error", err);
              });
          })
          .catch((err) => {
            self.generateAgoraToken();
            self.joinEvent();
            log("join channel error", err);
          });
        this.disableJoin = true;
      } else {
        if (this.User.role == "Mentor") {
          this.sendAudioCallNotification();
        }
        console.log(this.option);
        this.rtc
          .joinChannel(this.option)
          .then(() => {
            this.rtc
              .publishStreamAudio()
              .then((stream) => {
                this.localStream = stream;
                // console.log(stream);
              })
              .catch((err) => {
                log("publish local error", err);
              });
          })
          .catch((err) => {
            self.generateAgoraToken();
            self.joinEvent();
            log("join channel error", err);
          });
        this.disableJoin = true;
      }
    },
    leaveEvent() {
        let self = this;
        this.leftCommunication=true;
      this.disableJoin = false;
      this.rtc
        .leaveChannel()
        .then(() => {
            if (this.User.role == "Mentee") {
                self.modal.show();
            }

            console.log('Пользователь покинул чат');
        })
        .catch((err) => {
          log("leave error", err);
        });
      this.localStream = null;
      this.remoteStreams = [];
      this.$emit('leaveAppoinment')

    },

    generateString(length) {
      const characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      let result = "";
      const charactersLength = characters.length;
      for (let i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }

      return result;
    },
    async generateAgoraToken() {
      this.option.channel = this.generateString(10);
      const params = {
        token: 123,
        channel: this.option.channel,
      };
      const res = await axios.get("/api/agoraToken", { params });

      if (res.data && res.data.Status) {
        this.option.token = res.data.data.token;
      }
    },
    async sendAudioCallNotification() {
      const params = {
        token: 123,
        user_id: this.mentee_id,
        body: "Please Join the Call",
        title: "Audio Call From Mentor",
        channel_token:  this.option.token,
        channel_name:  this.option.channel,
        call_type: 'audio',
        link:
          "/mentee/appointment-log-detail/"+
          this.id +
          "?auth_tocken=" +
          this.option.token +
          "&channel_name=" +
          this.option.channel,
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
    async sendVideoCallNotification() {
      const params = {
        token: 123,
        user_id: this.mentee_id,
        body: "Please Join the Call",
        title: "Video Call From Mentor",
        channel_token:  this.option.token,
        channel_name:  this.option.channel,
        call_type: 'video',
        link:
          "/mentee/appointment-log-detail/" +
          this.id +
          "?auth_tocken=" +
          this.option.token +
          "&channel_name=" +
          this.option.channel,
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
    judge(detail) {},
     convertTime12to24(time12h) {
        const [time, modifier] = time12h.split(' ');

        let [hours, minutes] = time.split(':');

        if (hours === '12') {
            hours = '00';
        }

        if (modifier === 'PM') {
            hours = parseInt(hours, 10) + 12;
        }

        return `${hours}:${minutes}`;
        },
         currentDateTime() {
      return moment().format('MMMM Do YYYY, h:mm:ss a')
    }
  },
  created() {
    this.checkLoggedIn();
    this.rtc = new RTCClient();
    let rtc = this.rtc;
    rtc.on("stream-added", (evt) => {
      let { stream } = evt;
      log("[agora] [stream-added] stream-added", stream.getId());
      rtc.client.subscribe(stream);
    });

    rtc.on("stream-subscribed", (evt) => {
      let { stream } = evt;
      log("[agora] [stream-subscribed] stream-added", stream.getId());

      if (!this.remoteStreams.find((it) => it.getId() === stream.getId())) {
        this.remoteStreams.push(stream);
      }
      console.log('remote',this.remoteStreams);
      console.log(stream);
    });

    rtc.on("stream-removed", (evt) => {
      let { stream } = evt;
      log("[agora] [stream-removed] stream-removed", stream.getId());
      this.remoteStreams = this.remoteStreams.filter(
        (it) => it.getId() !== stream.getId()
      );
    });

    rtc.on("peer-online", (evt) => {
      this.$message(`Peer ${evt.uid} is online`);
    });

    rtc.on("peer-leave", (evt) => {
      this.$message(`Peer ${evt.uid} already leave`);
      this.remoteStreams = this.remoteStreams.filter(
        (it) => it.getId() !== evt.uid
      );
    });

    if (this.User.role == "Mentee") {
        if (window.location.href.indexOf("?") > -1) {
               let uri = window.location.href.split("?");
      let params = uri[1].split("&");
      var auth_tocken = params[0].replace("auth_tocken=", "");
      var channel_name = params[1].replace("channel_name=", "");
          this.isMentee = true;
      this.option.token = auth_tocken;
      this.option.channel = channel_name;

      this.joinEvent();
    } else {
      this.generateAgoraToken();
    }
    }
    else
    {
        this.generateAgoraToken();
    }
  },
};
</script>

<style lang="scss" scoped>
.agora-title {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  font-size: 32px;
  font-weight: bold;
  text-align: center;
  color: #2c3e50;
}
.agora-view {
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  height: 400px;
  margin-bottom: 100px;
}
// .agora-video {
//   width: 320px;
//   height: 240px;
//   margin: 20px;
// }
.agora-input {
  margin: 20px;
}
.agora-text {
  margin: 5px;
  font-size: 16px;
  font-weight: bold;
}
.agora-button {
  display: flex;
  justify-content: flex-end;
  margin: 20px;
}
.agora-video {
  width: 100%;
  height: 400px;
}
@media only screen and (max-width: 991.5px) {
    .agora-video {
  width: 100%;
  height: 250px;
}
}

@media only screen and (max-width: 767px) {
  .agora-view {
    height: auto !important;
    margin-bottom: 0px !important;
  }
  .agora-video {
    margin: 0px;
    margin-top: 20px;
    height: 200px;
  }
  .agora-button {
    flex-direction: column;
    margin: 0px;
    .btn-danger {
      margin-top: 10px;
    }
  }
}
</style>

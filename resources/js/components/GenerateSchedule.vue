<template>
    <section class="mentor-profile">
        <div class="schedule-appointment container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-primary fw-bold mb-5 text-center">Расписание</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 pe-lg-0">
                    <!-- <label class="text-primary mb-3">Select Type of Schedule </label> -->
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <h6 class="text-primary mb-3 fw-bold">Выберите тип расписания</h6>
                        <button class="nav-link active w-100 mb-2" id="v-pills-chat-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-chat" type="button" role="tab" aria-controls="v-pills-chat"
                            aria-selected="true" v-on:click="chnageAppointmentType(3)">
                            <i class="fa-solid fa-comment me-2"></i>
                            По расписанию чата
                        </button>
                        <button class="nav-link  w-100 mb-2" id="v-pills-live-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-live" type="button" role="tab" aria-controls="v-pills-live"
                            aria-selected="true" v-on:click="chnageAppointmentType(6)">
                            <i class="fa-solid fa-comment me-2"></i>
                            По живым консультациям
                        </button>
                        <button class="nav-link w-100 mb-2" id="v-pills-video-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-video" type="button" role="tab" aria-controls="v-pills-video"
                            aria-selected="false" v-on:click="chnageAppointmentType(2)">
                            <i class="fa-solid fa-video me-2"></i>
                            Видео консультации
                        </button>
                        <button class="nav-link w-100 mb-2" id="v-pills-audio-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-audio" type="button" role="tab" aria-controls="v-pills-audio"
                            aria-selected="false" v-on:click="chnageAppointmentType(1)">
                            <i class="fa-solid fa-volume-high me-2"></i>
                            Аудио консультации
                        </button>
                        <button class="nav-link w-100 mb-2" id="v-pills-visit-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-visit" type="button" role="tab" aria-controls="v-visit-settings"
                            aria-selected="false" v-on:click="chnageAppointmentType(4)">
                            <i class="fa-solid fa-laptop-house me-2"></i>
                            Консультации на сайте
                        </button>
                        <button class="nav-link w-100 mb-2" id="v-pills-hvisit-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-hvisit" type="button" role="tab" aria-controls="v-visit-settings"
                            aria-selected="false" v-on:click="chnageAppointmentType(5)">
                            <i class="fa-solid fa-home me-2"></i>
                            Консультации на дому
                        </button>
                    </div>
                </div>
                <div class="col-xxl-10 col-lg-9 ps-lg-0">
                    <div class="bg-white schedule-tabs p-4 pb-5 h-100 d-flex justify-content-center align-items-center">
                        <div class="tab-content w-100" id="v-pills-tabContent">
                            <!-- live consultation content -->
                            <div class="tab-pane fade show " id="v-pills-live" role="tabpanel"
                                aria-labelledby="v-pills-live-tab">
                                <h5 class="text-secondary">
                                    <i class="fa-solid fa-comment me-2 text-primary"></i>
                                    Расписание консультаций в режиме реального времени
                                </h5>
                                <p class="schedule-desc">
                                    Вы можете установить плату за консультацию в режиме реального времени.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите плату за консультацию
                                </h6>
                                <div class="schedule-border p-3">
                                    <input type="number" class="form-control border" placeholder="Введите сумму"
                                        v-model="live.fee" />
                                    <div class="position-relative mt-4">
                                        <button type="button" v-on:click="updateLiveFee()" class="
                                            btn btn-secondary
                                            text-white text-capitalize
                                            fw-bold
                                            position-absolute
                                            end-0
                                          ">
                                            Обновить стоимость
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- chat consultation content -->
                            <div class="tab-pane fade show active" id="v-pills-chat" role="tabpanel"
                                aria-labelledby="v-pills-chat-tab">
                                <h5 class="text-secondary">
                                    <i class="fa-solid fa-comment me-2 text-primary"></i>
                                    Расписание консультаций в Чате
                                </h5>
                                <p class="schedule-desc">
                                    Вы можете установить свою плату за консультацию для режима чата.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите Плату за чат
                                </h6>
                                <div class="schedule-border p-3">
                                    <input type="number" class="form-control border" placeholder="Введите сумму"
                                        v-model="chat.fee" />
                                    <div class="position-relative mt-4">
                                        <button type="button" v-on:click="updateChatFee()" class="
                                            btn btn-secondary
                                            text-white text-capitalize
                                            fw-bold
                                            position-absolute
                                            end-0
                                          ">
                                            Обновить стоимость
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- video consultation content -->
                            <div class="tab-pane fade" id="v-pills-video" role="tabpanel"
                                aria-labelledby="v-pills-profile-video">
                                <h5 class="text-secondary">
                                    <i class="fa-solid fa-video me-2 text-primary"></i>
                                    Расписание Видеоконсультаций
                                </h5>
                                <p class="schedule-desc">
                                    Вы можете создать расписание независимо от того, на сколько дней вы будете
                                    доступны через неделю или через месяц. Вы можете установить свои комиссионные
                                    сборы и время, доступное для видеоконсультации в течение дня.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите день для своего расписания
                                </h6>
                                <div class="schedule-border p-3">
                                    <div class="row row-cols-7">
                                        <div class="col">
                                            <label class="">Понедельник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.monday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Вторник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.tuesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Среда</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.wednesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Четверг</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.thursday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Пятница</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.friday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Суббота</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.saturday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Воскресенье</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="videoDaysAvailablity.sunday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                      " v-on:click="changeAvailability">
                                            Обновить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-3 mb-3 mt-5 fw-bold" v-if="showSlotPanel">
                                    Заполните оставшиеся поля, чтобы создать свое расписание
                                </h6>
                                <div class="schedule-border p-3" v-if="showSlotPanel">
                                    <div class="row d-flex align-items-center h-100">
                                        <div class="col-md-6 col-lg-4 mt-2">
                                            <span>Введите Стоимость Видеоконсультации:</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <input type="number" class="form-control border"
                                                placeholder="Сумма" v-model="videoSlot.fee" />
                                        </div>
                                        <div class="col-md-6 col-lg-2 mt-2">
                                            <span>Выберите дни</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <div class="custom-select">
                                                <select name="" id="" class="form-select border"
                                                    v-model="videoSlot.day">
                                                    <option value="" selected>Выбрать день</option>
                                                    <option v-for="day in availableDays" :key="day.id" :value="day.day"
                                                        v-if="day.is_holiday == 0">
                                                        {{ day.day_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="
                      row
                      d-flex
                      align-items-center
                      justify-content-center
                      h-100
                    ">
                                        <div class="col-md-6 col-lg-4 mt-4">
                                            <span>Выбрать временной интервал:</span>
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" timeformat="12h"
                                                :placeholder="'Время начала'" v-model="videoSlot.start_time" />
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" timeformat="12h"
                                                :placeholder="'Время окончания'" v-model="videoSlot.end_time" />
                                        </div>
                                        <div class="col-md-6 col-lg-1 mt-4">
                                            <span>Интервал</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-4">
                                            <input type="number" class="form-control border" placeholder="10мин"
                                                v-model="videoSlot.interval" />
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        mr-custom
                      " v-on:click="generateSlots">
                                            Создать расписание
                                        </button>
                                    </div>
                                    <div class="position-relative mt-4">
                                        <button type="button" class="
                        btn btn-primary
                        text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        px-md-4 px-2
                      " v-on:click="resetSlot">
                                            Сбросить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-4 mt-5 fw-bold" v-if="showSlotPanel">
                                    Создать расписание
                                </h6>
                                <div v-if="showSlotPanel">
                                    <div class="row">
                                        <div class="col-auto w-125" v-for="time in timeSlotsHours" :key="time.id">
                                            <div class="border-slots px-3 py-1 mt-2">
                                                {{ time }}
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="
                      btn btn-secondary
                      text-white text-capitalize
                      fw-bold
                      mt-4
                    " v-on:click="submitVideoSlots">
                                        ОТправить ваше расписание
                                    </button>
                                </div>
                            </div>

                            <!-- audio consultation content -->
                            <div class="tab-pane fade" id="v-pills-audio" role="tabpanel"
                                aria-labelledby="v-pills-audio-tab">
                                <h5 class="text-secondary">
                                    <i class="fa-solid fa-volume-high me-2 text-primary"></i>
                                    Расписание аудиоконсультаций
                                </h5>
                                <p class="schedule-desc">
                                    Вы можете создать расписание независимо от того, на сколько дней вы будете
                                    доступны через неделю или через месяц. Вы можете установить свои комиссионные
                                    сборы и время, доступное для аудиоконсультаций в течение дня.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите дни
                                </h6>
                                <div class="schedule-border p-3">
                                    <div class="row row-cols-7">
                                        <div class="col">
                                            <label class="">Понедельник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.monday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Вторник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.tuesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Среда</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.wednesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Четверг</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.thursday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Пятница</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.friday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Суббота</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.saturday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Воскресенье</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="audioDaysAvailablity.sunday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                      " v-on:click="changeAvailability">
                                            Обновить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-3 mb-3 mt-5 fw-bold" v-if="showSlotPanel">
                                    Заполните оставшиеся поля, чтобы создать свое расписание
                                </h6>
                                <div class="schedule-border p-3" v-if="showSlotPanel">
                                    <div class="row d-flex align-items-center h-100">
                                        <div class="col-md-6 col-lg-4 mt-2">
                                            <span>Введите стоимость аудиоконсультаций:</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <input type="number" class="form-control border"
                                                placeholder="Введите стоимость аудио-консультаций" v-model="audioSlot.fee" />
                                        </div>
                                        <div class="col-md-6 col-lg-2 mt-2">
                                            <span>Выберите дни</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <div class="custom-select">
                                                <select name="" id="" class="form-select border"
                                                    v-model="audioSlot.day">
                                                    <option value="" selected>Выбрать день</option>
                                                    <option v-for="day in availableDays" :key="day.id" :value="day.day"
                                                        v-if="day.is_holiday == 0">
                                                        {{ day.day_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="
                      row
                      d-flex
                      align-items-center
                      justify-content-center
                      h-100
                    ">
                                        <div class="col-md-6 col-lg-4 mt-4">
                                            <span>Выбрать временные интервалы</span>
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время начала'"
                                                v-model="audioSlot.start_time" />
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время окончания'"
                                                v-model="audioSlot.end_time" />
                                        </div>
                                        <div class="col-md-6 col-lg-1 mt-4">
                                            <span>Интервал</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-4">
                                            <input type="number" class="form-control border" placeholder="10мин"
                                                v-model="audioSlot.interval" />
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        mr-custom
                      " v-on:click="generateAudioSlots">
                                            Создать расписание
                                        </button>
                                    </div>
                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-primary
                        text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        px-md-4 px-2
                      " v-on:click="resetSlot">
                                            Сбросить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-4 mt-5 fw-bold" v-if="showSlotPanel">
                                    Создать расписани
                                </h6>
                                <div v-if="showSlotPanel">
                                    <div class="row">
                                        <div class="col-auto w-125" v-for="time in timeSlotsHours" :key="time.id">
                                            <div class="border-slots px-3 py-1 mt-2">
                                                {{ time }}
                                            </div>
                                        </div>
                                    </div>

                                    <button href="" type="button" class="
                      btn btn-secondary
                      text-white text-capitalize
                      fw-bold
                      mt-4
                    " v-on:click="submitVideoSlots">
                                        Сохранить расписание
                                    </button>
                                </div>
                            </div>

                            <!-- onsite or visit content -->
                            <div class="tab-pane fade" id="v-pills-visit" role="tabpanel"
                                aria-labelledby="v-pills-visit-tab">
                                <h5 class="text-secondary"> <i class="fa-solid fa-laptop-house me-2 text-primary"></i>
                                    Расписание консультациф на сайте</h5>
                                <p class="schedule-desc">
                                    Вы можете создать расписание независимо от того, на сколько дней вы будете
                                    доступны через неделю или через месяц. Вы можете установить свои комиссионные
                                    сборы и время, доступное для консультаций на сайте в течение дня.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите дни консультаций
                                </h6>
                                <div class="schedule-border p-3">
                                    <div class="row row-cols-7">
                                        <div class="col">
                                            <label class="">Понедельник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.monday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Вторник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.tuesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Среда</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.wednesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="1">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Четверг</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.thursday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Пятница</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.friday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Суббота</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.saturday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Воскресенье</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="onSiteDaysAvailablity.sunday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                      " v-on:click="changeAvailability">
                                            Update
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-3 mb-3 mt-5 fw-bold" v-if="showSlotPanel">
                                    Заполните оставшиеся поля, чтобы создать свое расписание
                                </h6>
                                <div class="schedule-border p-3" v-if="showSlotPanel">
                                    <div class="row d-flex align-items-center h-100">
                                        <div class="col-md-6 col-lg-4 mt-2">
                                            <span>Введите стоимость консультаций на сайте:</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <input type="text" class="form-control border"
                                                placeholder="Стоимость консультации на сайте" v-model="onSiteSlot.fee" />
                                        </div>
                                        <div class="col-md-6 col-lg-2 mt-2">
                                            <span>Выберите дни</span>
                                        </div>

                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <div class="custom-select">
                                                <select name="" id="" class="form-select border"
                                                    v-model="onSiteSlot.day">
                                                    <option value="" selected>Выбрать день</option>
                                                    <option v-for="day in availableDays" :key="day.id" :value="day.day"
                                                        v-if="day.is_holiday == 0">
                                                        {{ day.day_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="
                      row
                      d-flex
                      align-items-center
                      justify-content-center
                      h-100
                    ">
                                        <div class="col-md-6 col-lg-4 mt-4">
                                            <span>Выбрать временные интервалы</span>
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время начала'"
                                                v-model="onSiteSlot.start_time" />
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время окончания'"
                                                v-model="onSiteSlot.end_time" />
                                        </div>
                                        <div class="col-md-6 col-lg-1 mt-4">
                                            <span>Интервал</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-4">
                                            <input type="number" class="form-control border" placeholder="10мин"
                                                v-model="onSiteSlot.interval" />
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        mr-custom
                      " v-on:click="generateOnSiteSlots">
                                            Создать расписание
                                        </button>
                                    </div>
                                    <div class="position-relative mt-4">
                                        <button href="" type="button" v-on:click="resetSlot" class="
                        btn btn-primary
                        text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        px-md-4 px-2
                      ">
                                            Сбросить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-4 mt-5 fw-bold" v-if="showSlotPanel">
                                    Создать расписание
                                </h6>
                                <div v-if="showSlotPanel">
                                    <div class="row">
                                        <div class="col-auto w-125" v-for="time in timeSlotsHours" :key="time.id">
                                            <div class="border-slots px-3 py-1 mt-2">
                                                {{ time }}
                                            </div>
                                        </div>
                                    </div>

                                    <button href="" type="button" class="
                      btn btn-secondary
                      text-white text-capitalize
                      fw-bold
                      mt-4
                    " v-on:click="submitVideoSlots">
                                        Сохранить расписание
                                    </button>
                                </div>
                            </div>

                            <!-- home visit content -->
                            <div class="tab-pane fade" id="v-pills-hvisit" role="tabpanel"
                                aria-labelledby="v-pills-hvisit-tab">
                                <h5 class="text-secondary"> <i class="fa-solid fa-home me-2 text-primary"></i>
                                    Расписание консультаций дома</h5>
                                <p class="schedule-desc">
                                    Вы можете создать расписание независимо от того, на сколько дней вы будете
                                    доступны через неделю или через месяц. Вы можете установить свои комиссионные
                                    сборы и время, доступное для консультаций дома в течение дня.
                                </p>
                                <h6 class="text-primary mt-3 mb-3 fw-bold">
                                    Выберите дни консультаций
                                </h6>
                                <div class="schedule-border p-3">
                                    <div class="row row-cols-7">
                                        <div class="col">
                                            <label class="">Понедельник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.monday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Вторник</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.tuesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Среда</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.wednesday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="1">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Четверг</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.thursday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Пятница</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.friday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Суббота</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.saturday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="">Воскресенье</label>
                                            <div class="custom-select mb-md-0 mb-3">
                                                <select name="" id="" class="form-select mt-2 border"
                                                    v-model="homeVisitDaysAvailablity.sunday">
                                                    <option value="1" selected>Выходной</option>
                                                    <option value="0">Доступен</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                      " v-on:click="changeAvailability">
                                            Обновить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-3 mb-3 mt-5 fw-bold" v-if="showSlotPanel">
                                    Заполните оставшиеся поля, чтобы создать свое расписание
                                </h6>
                                <div class="schedule-border p-3" v-if="showSlotPanel">
                                    <div class="row d-flex align-items-center h-100">
                                        <div class="col-md-6 col-lg-4 mt-2">
                                            <span>Введите сумму за консультацию:</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <input type="text" class="form-control border"
                                                placeholder="Ввести сумму" v-model="homeVisitSlot.fee" />
                                        </div>
                                        <div class="col-md-6 col-lg-2 mt-2">
                                            <span>Выберите дни</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-2">
                                            <div class="custom-select">
                                                <select name="" id="" class="form-select border"
                                                    v-model="homeVisitSlot.day">
                                                    <option value="" selected>Выбрать день</option>
                                                    <option v-for="day in availableDays" :key="day.id" :value="day.day"
                                                        v-if="day.is_holiday == 0">
                                                        {{ day.day_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="
                      row
                      d-flex
                      align-items-center
                      justify-content-center
                      h-100
                    ">
                                        <div class="col-md-6 col-lg-4 mt-4">
                                            <span>Выбрать временные интервалы</span>
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время начала'"
                                                v-model="homeVisitSlot.start_time" />
                                        </div>
                                        <div class="col-md-3 col-lg-2 mt-4">
                                            <input class="form-control border" type="time" :placeholder="'Время окончания'"
                                                v-model="homeVisitSlot.end_time" />
                                        </div>
                                        <div class="col-md-6 col-lg-1 mt-4">
                                            <span>Интервал</span>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mt-4">
                                            <input type="number" class="form-control border" placeholder="10мин"
                                                v-model="homeVisitSlot.interval" />
                                        </div>
                                    </div>

                                    <div class="position-relative mt-4">
                                        <button href="" type="button" class="
                        btn btn-secondary
                        text-white text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        mr-custom
                      " v-on:click="generateHomeVisitSlots">
                                            Создать расписание
                                        </button>
                                    </div>
                                    <div class="position-relative mt-4">
                                        <button href="" type="button" v-on:click="resetSlot" class="
                        btn btn-primary
                        text-capitalize
                        fw-bold
                        position-absolute
                        end-0
                        px-md-4 px-2
                      ">
                                            Сбросить
                                        </button>
                                    </div>
                                </div>

                                <h6 class="text-primary mt-md-4 mt-5 fw-bold" v-show="showSlotPanel">
                                    Создать расписание
                                </h6>
                                <div v-show="showSlotPanel">
                                    <div class="row">
                                        <div class="col-auto w-125" v-for="time in timeSlotsHours" :key="time.id">
                                            <div class="border-slots px-3 py-1 mt-2">
                                                {{ time }}
                                            </div>
                                        </div>
                                    </div>

                                    <button href="" type="button" class="
                      btn btn-secondary
                      text-white text-capitalize
                      fw-bold
                      mt-4
                    " v-on:click="submitVideoSlots">
                                        Сохранить расписание
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white generate-schedule border-0 mt-5 pb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary py-4 px-5 fw-bold">Сохраненные расписания</h4>
                            </div>
                        </div>
                        <div v-if="mentorAllSchedules">
                            <div class="" v-for="schedule in mentorAllSchedules" :key="schedule.id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="bg-generate-slots px-5 py-2">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <span class="text-dark fw-bold">День:</span>
                                                            <span class="ms-1 text-capitalize">{{ schedule.locale_day }}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="text-dark fw-bold">Стоимость:</span><span
                                                                class="ms-1">{{currency_symbol}} {{ schedule.fee }}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="text-dark fw-bold">Тип консультации:</span>

                                                            <span class="ms-1 text-capitalize"
                                                                v-if="schedule.appointment_type_id == 1">{{
                                                                        $t(
                                                                            "generate_scheduling.generated.audio_calling"
                                                                        )
                                                                }}</span>
                                                            <span class="ms-1"
                                                                v-if="schedule.appointment_type_id == 2">{{
                                                                        $t(
                                                                            "generate_scheduling.generated.video_calling"
                                                                        )
                                                                }}</span>
                                                            <span class="ms-1"
                                                                v-if="schedule.appointment_type_id == 4">{{
                                                                        $t("generate_scheduling.generated.on_site")
                                                                }}</span>
                                                            <span class="ms-1"
                                                                v-if="schedule.appointment_type_id == 5">{{
                                                                        $t("generate_scheduling.generated.home_visit")
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex justify-content-md-end">
                                                        <a type="button" class="bg-transparent"
                                                            v-on:click="deleteSchedule(schedule.id)">
                                                            <i class="fas fa-times text-danger ms-2"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-4 px-5">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-auto w-125" v-for="time in schedule.schedule_slots"
                                                    :key="time.id">
                                                    <div class="border-slots px-3 py-1 mt-2 text-center">
                                                        {{ time.start_time }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
    props: ["url","currency_symbol"],
    mixins: [loginMixin],
    data() {
        return {
            loading: true,
            videoDaysAvailablity: {
                monday: 1,
                tuesday: 1,
                wednesday: 1,
                thursday: 1,
                friday: 1,
                saturday: 1,
                sunday: 1,
            },
            audioDaysAvailablity: {
                monday: 1,
                tuesday: 1,
                wednesday: 1,
                thursday: 1,
                friday: 1,
                saturday: 1,
                sunday: 1,
            },
            onSiteDaysAvailablity: {
                monday: 1,
                tuesday: 1,
                wednesday: 1,
                thursday: 1,
                friday: 1,
                saturday: 1,
                sunday: 1,
            },
            homeVisitDaysAvailablity: {
                monday: 1,
                tuesday: 1,
                wednesday: 1,
                thursday: 1,
                friday: 1,
                saturday: 1,
                sunday: 1,
            },
            appointment_id: 3,
            availableDays: [],
            videoSlot: {
                day: "",
                start_time: "",
                end_time: "",
                interval: "",
                fee: "",
            },
            audioSlot: {
                day: "",
                start_time: "",
                end_time: "",
                interval: "",
                fee: "",
            },
            onSiteSlot: {
                day: "",
                start_time: "",
                end_time: "",
                interval: "",
                fee: "",
            },
            homeVisitSlot: {
                day: "",
                start_time: "",
                end_time: "",
                interval: "",
                fee: "",
            },
            chat: {
                fee: "",
            },
            live:{
                fee:'',
            },
            timeSlots: [],
            timeSlotsHours: [],
            mentorAllSchedules: {},
            mentorAvailableScheduleLoader: true,
            mentor_id: "",
            showSlotPanel: false
        };
    },
    methods: {
        resetSlot() {
            this.timeSlots = [];
            this.audioSlot = {};
            this.videoSlot = {};
            this.onSiteSlot = {};
            this.homeVisitSlot = {};
            this.timeSlotsHours = [];
        },
        async submitVideoSlots() {
            if (this.timeSlots.length > 0) {
                var self = this;
                var toast = this.$toasted;
                if (this.appointment_id == 1) {
                    var params = {
                        token: 123,
                        mentor_id: this.mentor_id,
                        appointment_type_id: this.appointment_id,
                        fee: this.audioSlot.fee,
                        slots: this.timeSlots,
                        interval: this.audioSlot.interval,
                        day: this.audioSlot.day,
                    };
                } else if (this.appointment_id == 2) {
                    var params = {
                        token: 123,
                        mentor_id: this.mentor_id,
                        appointment_type_id: this.appointment_id,
                        fee: this.videoSlot.fee,
                        slots: this.timeSlots,
                        interval: this.videoSlot.interval,
                        day: this.videoSlot.day,
                    };
                } else if (this.appointment_id == 4) {
                    var params = {
                        token: 123,
                        mentor_id: this.mentor_id,
                        appointment_type_id: this.appointment_id,
                        fee: this.onSiteSlot.fee,
                        slots: this.timeSlots,
                        interval: this.onSiteSlot.interval,
                        day: this.onSiteSlot.day,
                    };
                } else {
                    var params = {
                        token: 123,
                        mentor_id: this.mentor_id,
                        appointment_type_id: this.appointment_id,
                        fee: this.homeVisitSlot.fee,
                        slots: this.timeSlots,
                        interval: this.homeVisitSlot.interval,
                        day: this.homeVisitSlot.day,
                    };
                }
                const res = await axios
                    .post("/api/save-mentor-schedule", params)
                    .then((res) => {
                        if (res.data.Status) {
                            toast.success(res.data.msg);
                                (this.videoSlot.day = ""),
                                (this.videoSlot.start_time = ""),
                                (this.videoSlot.end_time = ""),
                                (this.videoSlot.interval = ""),
                                (this.audioSlot.day = ""),
                                (this.audioSlot.start_time = ""),
                                (this.audioSlot.end_time = ""),
                                (this.audioSlot.interval = ""),
                                (this.onSiteSlot.day = ""),
                                (this.onSiteSlot.start_time = ""),
                                (this.onSiteSlot.end_time = ""),
                                (this.onSiteSlot.interval = ""),
                                (this.homeVisitSlot.day = ""),
                                (this.homeVisitSlot.start_time = ""),
                                (this.homeVisitSlot.end_time = ""),
                                (this.homeVisitSlot.interval = ""),
                                (this.timeSlots = []),
                                (this.timeSlotsHours = []),
                                this.getMentorSchedules();
                        }
                        if (res.data.errors) {
                            for (const property in res.data.errors) {
                                this.$toasted.error(res.data.errors[property][0]);
                            }
                        }
                    });
            } else {
                this.$toasted.error("Пожалуйста, создайте первый интервал");
            }
        },
        generateOnSiteSlots() {
            this.timeSlots = [];
            this.timeSlotsHours = [];

            if (this.onSiteSlot.interval < 10 || this.onSiteSlot.interval > 999) {
                this.$toasted.error("Интервал должен быть от 10 до 999 минут");
            } else {
                var local_start_time = this.onSiteSlot.start_time;
                while (local_start_time < this.onSiteSlot.end_time) {
                    this.timeSlots.push(local_start_time);
                    var options = {
                        hour: "numeric",
                        minute: "numeric",
                        // hour12: true,
                    };
                    var date = new Date("Febrndayuary 04, 2011 " + local_start_time);
                    var timeString = date.toLocaleString("ru-RU", options);
                    this.timeSlotsHours.push(timeString);
                    local_start_time = this.addMinutes(
                        local_start_time,
                        this.onSiteSlot.interval
                    );
                    if (local_start_time > this.onSiteSlot.end_time) {
                        break;
                    }
                }
            }
        },
        generateAudioSlots() {
            this.timeSlots = [];
            this.timeSlotsHours = [];

            if (this.audioSlot.interval < 10 || this.audioSlot.interval > 999) {
                this.$toasted.error("Интервал должен быть от 10 до 999 минут");
            } else {
                var local_start_time = this.audioSlot.start_time;
                while (local_start_time < this.audioSlot.end_time) {
                    this.timeSlots.push(local_start_time);
                    var options = {
                        hour: "numeric",
                        minute: "numeric",
                        // hour12: true,
                    };
                    var date = new Date("February 04, 2011 " + local_start_time);
                    var timeString = date.toLocaleString("ru-RU", options);
                    this.timeSlotsHours.push(timeString);
                    local_start_time = this.addMinutes(
                        local_start_time,
                        this.audioSlot.interval
                    );
                    if (local_start_time > this.audioSlot.end_time) {
                        break;
                    }
                }
            }
        },
        generateHomeVisitSlots() {
            this.timeSlots = [];
            this.timeSlotsHours = [];

            if (
                this.homeVisitSlot.interval < 10 ||
                this.homeVisitSlot.interval > 999
            ) {
                this.$toasted.error("Интервал должен быть от 10 до 999 минут");
            } else {
                var local_start_time = this.homeVisitSlot.start_time;
                while (local_start_time < this.homeVisitSlot.end_time) {
                    this.timeSlots.push(local_start_time);
                    var options = {
                        hour: "numeric",
                        minute: "numeric",
                        // hour12: true,
                    };
                    var date = new Date("February 04, 2011 " + local_start_time);
                    var timeString = date.toLocaleString("ru-RU", options);
                    this.timeSlotsHours.push(timeString);
                    local_start_time = this.addMinutes(
                        local_start_time,
                        this.homeVisitSlot.interval
                    );
                    if (local_start_time > this.homeVisitSlot.end_time) {
                        break;
                    }
                }
            }
        },
        generateSlots() {
            this.timeSlots = [];
            this.timeSlotsHours = [];
            if (this.videoSlot.interval < 10 || this.videoSlot.interval > 999) {
                this.$toasted.error("Интервал должен быть от 10 до 999 минут");
            } else {
                var local_start_time = this.videoSlot.start_time;
                while (local_start_time < this.videoSlot.end_time) {
                    this.timeSlots.push(local_start_time);
                    var options = {
                        hour: "numeric",
                        minute: "numeric",
                        // hour12: true,
                    };
                    var date = new Date("February 04, 2011 " + local_start_time);
                    var timeString = date.toLocaleString("ru-RU", options);
                    this.timeSlotsHours.push(timeString);
                    local_start_time = this.addMinutes(
                        local_start_time,
                        this.videoSlot.interval
                    );
                    if (local_start_time > this.videoSlot.end_time) {
                        break;
                    }
                }
            }
        },
        addMinutes(time, minutes) {
            var date = new Date(
                new Date("01/01/2015 " + time).getTime() + minutes * 60000
            );
            var tempTime =
                (date.getHours().toString().length == 1
                    ? "0" + date.getHours()
                    : date.getHours()) +
                ":" +
                (date.getMinutes().toString().length == 1
                    ? "0" + date.getMinutes()
                    : date.getMinutes()) +
                ":" +
                (date.getSeconds().toString().length == 1
                    ? "0" + date.getSeconds()
                    : date.getSeconds());
            return tempTime;
        },
        async changeAvailability() {
            this.loading = true;
            var self = this;
            var toast = this.$toasted;
            //   console.log(this.appointment_id, this.mentor_id);
            if (this.appointment_id == 1) {
                var params = {
                    token: 123,
                    mentor_id: this.mentor_id,
                    appointment_type_id: this.appointment_id,
                    availability: this.audioDaysAvailablity,
                };
            } else if (this.appointment_id == 2) {
                var params = {
                    token: 123,
                    mentor_id: this.mentor_id,
                    appointment_type_id: this.appointment_id,
                    availability: this.videoDaysAvailablity,
                };
            } else if (this.appointment_id == 4) {
                var params = {
                    token: 123,
                    mentor_id: this.mentor_id,
                    appointment_type_id: this.appointment_id,
                    availability: this.onSiteDaysAvailablity,
                };
            } else if (this.appointment_id == 5) {
                var params = {
                    token: 123,
                    mentor_id: this.mentor_id,
                    appointment_type_id: this.appointment_id,
                    availability: this.homeVisitDaysAvailablity,
                };
            }

            const res = await axios
                .post("/api/mark-day-holiday", params)
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        self.mentorAvaiableDays();
                        this.showSlotPanel = true;
                    }
                });
        },
        async mentorAvaiableDays() {
            const params = {
                token: 123,
                mentor_id: this.mentor_id,
                appointment_type_id: this.appointment_id,
            };
            const res = await axios.get("/api/get-available-days-web", { params });
            if (res.data && res.data.Status) {
                console.log(res.data.data.mentorSchedules);
                this.availableDays = res.data.data.mentorSchedules;
                for (let index = 0; index < this.availableDays.length; index++) {
                    if (this.availableDays[index].is_holiday == 1) {
                    } else {
                        if (this.appointment_id == 1) {
                            this.audioDaysAvailablity[this.availableDays[index].day] = 0;
                        } else if (this.appointment_id == 2) {
                            this.videoDaysAvailablity[this.availableDays[index].day] = 0;
                        } else if (this.appointment_id == 4) {
                            this.onSiteDaysAvailablity[this.availableDays[index].day] = 0;
                        } else {
                            this.homeVisitDaysAvailablity[this.availableDays[index].day] = 0;
                        }
                    }
                }
                this.loading = false;
            }
        },
        chnageAppointmentType(type) {
            this.appointment_id = type;
            this.mentorAvaiableDays();
            this.timeSlots = [];
            this.showSlotPanel = false;
        },
        async getChatFee() {
            const params = {
                token: 123,
                mentor_id: this.mentor_id,
                appointment_type_id: this.appointment_id,
            };
            //   console.log(params);
            const res = await axios.get("/api/get-mentor-chat-fee", { params });
            if (res.data && res.data.Status) {
                this.chat.fee = res.data.data.chatFee.fee;
            }
        },
        async updateChatFee() {
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                mentor_id: this.mentor_id,
                appointment_type_id: this.appointment_id,
                fee: this.chat.fee,
            };
            if (this.chat.fee < 100) {
                this.$toasted.error("Стоимость не может быть меньше 100");
            } else {
                const res = await axios
                    .post("/api/save-mentor-chat-fee", params)
                    .then((res) => {
                        if (res.data.Status) {
                            toast.success(res.data.msg);
                        }
                        if (!res.data.Status) {
                            for (const property in res.data.errors) {
                                this.$toasted.error(res.data.errors[property][0]);
                            }
                        }
                    });
            }
        },
        async updateLiveFee() {
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                mentor_id: this.mentor_id,
                appointment_type_id: this.appointment_id,
                fee: this.live.fee,
            };
            if (this.chat.fee < 100) {
                this.$toasted.error("Стоимость не может быть меньше 100");
            } else {
                const res = await axios
                    .post("/api/save-mentor-chat-fee", params)
                    .then((res) => {
                        if (res.data.Status) {
                            toast.success(res.data.msg);
                        }
                        if (!res.data.Status) {
                            for (const property in res.data.errors) {
                                this.$toasted.error(res.data.errors[property][0]);
                            }
                        }
                    });
            }
        },
        async getMentorSchedules() {
            const params = {
                token: 123,
                mentor_id: this.mentor_id,
            };
            const res = await axios.get("/api/get-mentor-schedules", { params });
            if (res.data && res.data.Status) {
                //console.log(res.data.data.mentorSchedules);
                this.mentorAllSchedules = res.data.data.mentorSchedules;
                this.mentorAvailableScheduleLoader = false;
            }
        },
        async deleteSchedule(id) {
            this.loading = true;
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                id: id,
            };
            const res = await axios
                .post("/api/delete-mentor-schedule", params)
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        self.getMentorSchedules();
                    }
                });
        },
        async profileStatus(){
            var toast = this.$toasted;
            var params = {
                token: 123,
                mentor_id: this.mentor_id ,
            };
            // console.log(params)
            const res = await axios
                .get("/api/mentorStatus", {params})
                .then((res) => {
                    // console.log(res.data.data.mentor.is_profile_completed);
                    if (res.data.data.mentor.is_profile_completed) {
                        // toast.success();
                    }else {
                        toast.error("Пожалуйста, заполните свой профиль!");
                        window.location="mentor-profile";
                    }
                });
        }
    },
    created() {
        this.checkLoggedIn();
        this.mentor_id = this.User.user_id;
        this.getChatFee();
        this.getMentorSchedules();
        this.profileStatus();

    },
    mounted() {
        if (this.is_loggedIn && this.User.role == "Mentor") {
        } else {
            window.location.href = this.url + "/login";
            this.$toasted.error("Пожалуйста, Сначала Войдите В Систему");
        }
    }
};
</script>

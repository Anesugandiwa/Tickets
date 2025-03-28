<template>
    <Default>
    <div  class="welcome-page" :style="backgroundStyle">

        <div v-if="$vuetify.display.smAndDown">
            <v-carousel
                style="height: 100vh"
                @update:modelValue="updateCarouselIndex"
                hide-delimiter-background
                hide-delimiters
            >
                <v-carousel-item
                    v-for="(item,i) in $page.props.events"
                    :key="i"
                    class=" slider-home-2 mt-16"

                >
                  <v-container>
                      <v-card class="glass  " >
                          <v-img
                              :src="item.preview_image"
                              height="200"
                              cover
                          />
                          <v-card-text>
                              <h1 class="lead-h1">
                                  <svg class="mb-n1" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M21 17V8H7v9zm0-14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h1V1h2v2h8V1h2v2zm-3.47 8.06l-4.44 4.44l-2.68-2.68l1.06-1.06l1.62 1.62L16.47 10zM3 21h14v2H3a2 2 0 0 1-2-2V9h2z"/></svg>
                                  {{ item.title }}</h1>
                              <v-divider class="my-2" color="primary" />
                          </v-card-text>
                          <div class="glass mx-2  ">
                              <div class="my-2">
                                  <v-icon>mdi-calendar-month</v-icon>&nbsp; Start: {{  goodDate(item.start_date) }}
                              </div>

                              <div class=" my-2">
                                  <v-icon>mdi-calendar-month</v-icon>&nbsp; End: {{  goodDate(item.end_date) }}
                              </div>

                              <div class=" my-2">
                                  <v-icon>mdi-map-marker</v-icon>&nbsp; Venue: {{ item.location }}
                              </div>

                              <div>
                                  <svg class="mb-n2" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h8m-8 4h5m-5 6h8m-8 4h5M3 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1zm0 10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
                                  &nbsp;Details:
                                  <v-divider class="mb-2"/>
                              </div>
                              <div style=" " class="mb-5 px-10" v-text="truncateText(item.description)"></div>

                          </div>
                          <v-divider class="my-3"/>
                          <v-card-actions>
                              <v-spacer></v-spacer>
                              <InertiaLink class="mx-2" :href="route('single.event',item.slug)">
                                  <v-btn variant="flat" color="primary" size="large" class="rounded-xl">
                                      &nbsp;&nbsp;
                                      <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125z"/></svg>
                                      &nbsp; Buy Tickets
                                      &nbsp;&nbsp;
                                  </v-btn>
                              </InertiaLink>

                              <v-btn @click="showSingle(item.preview_image)" variant="outlined" class="rounded-xl" size="large">
                                  View Poster
                              </v-btn>
                              <v-spacer></v-spacer>
                          </v-card-actions>
                      </v-card>
                  </v-container>
                </v-carousel-item>
            </v-carousel>
        </div>
        <div v-else>
            <v-container fluid  v-if="$page.props.events.length > 0">
                <v-carousel
                    hide-delimiters
                    class="slider-home-1 mt-16"
                    @update:modelValue="updateCarouselIndex"
                >
                    <v-carousel-item
                        v-for="(item,i) in $page.props.events"
                        :key="i"
                    >
                        <v-container>
                            <v-row class="d-flex align-center">
                                <v-col cols="12" sm="5">
                                    <v-img
                                        :src="item.preview_image"
                                        :alt="item.title"
                                        class="glass rounded-lg"
                                        cover
                                        height="450"
                                    />
                                </v-col>
                                <v-col cols="12" sm="7">
                                    <v-card class="glass text-center " max-width="650">
                                        <v-card-text>
                                            <h1 class="text-h3">{{ item.title }}</h1>
                                            <v-divider></v-divider>
                                        </v-card-text>

                                        <div class="glass pa-5 mx-5 my-10 d-flex justify-space-between">
                                            <div class="mr-3">
                                                <v-icon>mdi-calendar-month</v-icon>Start: {{  goodDate(item.start_date) }}
                                            </div>

                                            <div class="mr-3">
                                                <v-icon>mdi-calendar-month</v-icon>End: {{  goodDate(item.end_date) }}
                                            </div>

                                            <div class="mr-3">
                                                <v-icon>mdi-map-marker</v-icon>{{ item.location }}
                                            </div>
                                        </div>

                                        <div class="mb-5 px-10"  v-html="item.description"></div>

                                        <v-divider class="my-3"/>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <InertiaLink class="mx-2" :href="route('single.event',item.slug)">
                                                <v-btn variant="flat" color="primary" size="x-large" class="rounded-xl">
                                                    &nbsp;&nbsp;
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125z"/></svg>
                                                    &nbsp; Buy Tickets
                                                    &nbsp;&nbsp;
                                                </v-btn>
                                            </InertiaLink>

                                            <v-btn @click="showSingle(item.preview_image)" variant="outlined" class="rounded-xl" size="x-large">
                                                View Poster
                                            </v-btn>
                                            <v-spacer></v-spacer>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>

                    </v-carousel-item>
                </v-carousel>
            </v-container>
            <v-container v-else fluid>
                <v-carousel
                    hide-delimiters
                    class="slider-home-1 mt-16"
                    cycle
                    :show-arrows="false"
                    :interval="10000"

                >
                    <v-carousel-item
                        v-for="(item,i) in items"
                        :key="i"
                    >

                        <v-row class="d-flex  justify-space-between align-center mx-5">

                            <v-col cols="12" sm="7" class="glass text-center">
                                <h1 class="font-weight-bold mt-5">{{ item.title }}</h1>
                                <v-divider class="my-5" />

                                <div style=" " class="mb-5 px-10" v-text="truncateText(item.description)"></div>

                                <div class="glass mt-5">
                                    <v-btn class="mx-2" size="large">
                                        Contact Us
                                    </v-btn>

                                    <v-btn class="mx-2" size="large" variant="outlined">
                                        Get Started
                                    </v-btn>
                                </div>
                            </v-col>

                            <v-col cols="12" sm="4">
                                <v-img
                                    height="500"
                                    :src="item.src"
                                    :alt="item.src"
                                    class="glass rounded-lg"
                                    cover
                                />
                            </v-col>
                        </v-row>
                    </v-carousel-item>
                </v-carousel>
            </v-container>
        </div>



        <vue-easy-lightbox
            :visible="visibleRef"
            :imgs="imgsRef"
            :index="indexRef"
            @hide="onHide"
        ></vue-easy-lightbox>



    </div>
</Default>


</template>

<script>
import Default from "@/layouts/DefaultLayout.vue";
import moment from "moment";

export default {
    layout:Default,
    data () {
        return {
            items: [
                {
                    title: 'Host your event with us',
                    description: 'Host your event with us',
                    src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                },
                {
                    title: 'Discover Amazing Events',
                    description: 'Explore and attend a variety of events hosted by different organizers.',
                    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                },
                {
                    title: 'Join Our Community',
                    description: 'Become part of a vibrant community by attending events.',
                    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                },
            ],
            activeCarouselIndex: 0,
            model:1,
            visibleRef:false,
            indexRef:0,
            imgs:[]
        }
    },

    // computed: {
    //     backgroundStyle() {
    //         const currentItem = this.$page.props.events[this.activeCarouselIndex]
    //         return {
    //             backgroundImage: `url(${currentItem.preview_image || currentItem.src})`,
    //         };
    //     },
    // },

    methods:{
        goodDate(date){
            return  date
        },

        updateCarouselIndex(index) {
            this.activeCarouselIndex = index;
        },

        truncateText(text) {
            const maxLength = 100;
            if (text.length > maxLength) {
                return text.slice(0, maxLength) + '...';
            }
            return text;
        },

        showSingle(image){
            this.imgsRef = image
            this.onShow()
        },

        onHide(){
            this.visibleRef  = false
        },

        onShow (){
            this.visibleRef  = true
        }
    }
}
</script>

<style>
.slider-home-1{
    min-height: 95vh !important;
    margin-top: -100px;
    padding-top: 110px;
}

.slider-home-2{
    padding-top: 40px;
}
</style>

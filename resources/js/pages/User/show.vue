<template>
    <UserLayout :title="$page.props.event.title">
        <div class="glass pa-3">
            <v-toolbar class="rounded-lg px-2 mb-5" density="comfortable">
                <v-toolbar-title>
                    
                    {{ $page.props.event.title}}
                </v-toolbar-title>
                <v-spacer />

                <InertiaLink :href="route('client.user_dasshboard')">
                    <v-btn variant="flat" color="primary">
                        Back to Events
                    </v-btn>
                </InertiaLink>
            </v-toolbar>
            <div>
            <v-card class="glass">
                <v-img v-if="event.preview_image" :src="'/storage/' + event.preview_image" height="200px" cover></v-img>
                <v-card-title class="text-h6 text-center">{{$page.props.event.title }}</v-card-title>
                <v-card-subtitle class="text-center">
                    <v-icon icon="mdi-map-marker" size="small" class="mr-1"></v-icon>
                    {{ $page.props.event.location }}
                </v-card-subtitle>
                
                 <v-card-text>
                    <div class="text-body-2 text-center">
                        {{ $page.props.event.description }}
                    </div>
                    <div class="d-flex align-center justify-center my-2">
                        <v-icon icon="mdi-calendar-range" size="small" class="mr-1"></v-icon>
                        <span class="text-caption">
                            {{ formatDate($page.props.event.start_date) }} - {{ formatDate($page.props.event.end_date) }}
                        </span>
                    </div>


                 </v-card-text>
            </v-card>
        </div>
        </div>
    </UserLayout>
</template>

<script>
import moment from "moment";
import UserLayout from "@/layouts/UserLayout.vue";

export default {
    components: {
        UserLayout,
    },
    computed: {
        event() {
            return this.$page.props.event;
        }
    },
    methods: {
        formatDate(date) {
            return moment(date).format("MMM D, YYYY");
        },

    },
}
</script>
<script setup>
import UserLayout from '@/layouts/UserLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  events: {
    type: Array,
    default: () => []
  }
});

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>

<template>
  <UserLayout>
    <v-container fluid class="pa-4">
      <v-row>
        <v-col cols="12">
          <v-card class="mb-6" color="surface-variant">
            <v-card-title class="text-h4 font-weight-bold text-primary">
              Upcoming Events
            </v-card-title>
            <v-card-subtitle class="text-h6">
              Browse all our upcoming events
            </v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>

      <v-row v-if="events.length === 0">
        <v-col cols="12">
          <v-alert type="info" variant="tonal">
            No upcoming events found. Please check back later.
          </v-alert>
        </v-col>
      </v-row>

      <v-row v-else>
        <v-col 
          cols="12" 
          sm="6" 
          md="4" 
          lg="3" 
          v-for="event in events" 
          :key="event.id"
        >
          <v-card class="h-100" elevation="3">
            <v-img
              v-if="event.preview_image"
              :src="'/storage/' + event.preview_image"
              height="200px"
              cover
            ></v-img>
            
            <v-card-item>
              <v-card-title class="text-h6">{{ event.title }}</v-card-title>
              <v-card-subtitle class="text-caption">
                <v-icon icon="mdi-calendar" size="small" class="mr-1"></v-icon>
                {{ formatDate(event.start_date) }} to {{ formatDate(event.end_date) }}
              </v-card-subtitle>
              <v-card-subtitle class="text-caption">
                <v-icon icon="mdi-map-marker" size="small" class="mr-1"></v-icon>
                {{ event.location }}
              </v-card-subtitle>
            </v-card-item>

            <v-card-text class="text-body-2 line-clamp-3">
              {{ event.description }}
            </v-card-text>

            <v-card-actions class="justify-space-between">
              <v-btn
                color="primary"
                variant="text"
                prepend-icon="mdi-information"
                @click="router.visit(`/events/${event.id}`)"
              >
                Details
              </v-btn>
              <v-btn
                color="secondary"
                variant="tonal"
                prepend-icon="mdi-ticket"
                @click="router.visit(`/events/${event.id}/register`)"
              >
                Add to Cart
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </UserLayout>
</template>

<style>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
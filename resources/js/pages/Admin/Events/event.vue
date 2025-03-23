<script setup  >
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import DefaultLayout from '@/layouts/DefaultLayout.vue'


const columns = [
    { key: 'id', title: 'ID' },
    { key: 'title', title: 'Title' },
    { key: 'description', title: 'Description'  },
    { key: 'location',  title: 'Location'},
    { key: 'actions',  title: 'Actions'  },
]



const form = useForm({
    title: '',
    description: '',
    slug: '',
    start_date: '',
    end_date: '',
    preview_image: null,
    location: '',
    total_tickets: '',
    is_priced: '',
})

function handleFileUpload(event) {
    const target = event.target;
    if (target.files && target.files[0]) {
        form.preview_image = target.files[0];
    }
}



const submitForm = () => {
    form.post(route('event.store'), {
        onSuccess: () => {
            closeDialog()
            form.reset()
        },
    })
}

const errors = ref({
    title: '',
    description: '',
    slug: '',
    start_date: '',
    end_date: '',
    preview_image: '',
    location: '',
    total_tickets: '',
    is_priced: '',
})

const isDialogOpen = ref(false)
const openDialog = () => (isDialogOpen.value = true)
const closeDialog = () => (isDialogOpen.value = false)

</script>
<template>
    <DefaultLayout >
        <Head title="Add Events" />

        <v-container>
            <v-row class="mb-4">
                <v-col>
                    <v-card elevation="1" class="pa-4">
                        <v-row align="center" justify="space-between">
                            <h1 class="text-h6 font-weight-bold">Events</h1>
                            <v-btn color="success" @click="isDialogOpen = !isDialogOpen">Add Event</v-btn>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Dialog -->
            <v-dialog v-model="isDialogOpen" max-width="800">
                <v-card>
                    <v-card-title class="text-h6">Create New Event</v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="submitForm">
                            <v-row dense>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Title"
                                        v-model="form.title"
                                        :error-messages="errors.title"
                                        required
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Description"
                                        v-model="form.description"
                                        :error-messages="errors.description"
                                        required
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Slug"
                                        v-model="form.slug"
                                        :error-messages="errors.slug"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        type="date"
                                        v-model="form.start_date"
                                        label="Start Date"
                                        :error-messages="errors.start_date"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        type="date"
                                        v-model="form.end_date"
                                        label="End Date"
                                        :error-messages="errors.end_date"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-file-input
                                        label="Preview Image"
                                        @change="handleFileUpload"
                                        :error-messages="errors.preview_image"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Location"
                                        v-model="form.location"
                                        :error-messages="errors.location"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Total Tickets"
                                        v-model="form.total_tickets"
                                        :error-messages="errors.total_tickets"
                                    />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        label="Price"
                                        v-model="form.is_priced"
                                        :error-messages="errors.is_priced"
                                    />
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer />
                        <v-btn color="red" @click="closeDialog">Cancel</v-btn>
                        <v-btn color="green" @click="submitForm">Save Event</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Table -->
            <!-- <v-card elevation="1" class="pa-4">
                <v-data-table :headers="columns" :items="$page.props.events" class="mt-4">
                   <template #item.actions="{ item }">
                       <v-btn color="primary" @click="viewEvent(item)">View</v-btn>
                   </template>
                </v-data-table>
            </v-card> -->
            <div class="glass pa-3">
                <v-data-table
                    :headers="columns"
                    :items="$page.props.events"
                    :search="search"
                >
                    <template v-slot:item.actions="{ item }">
                      <div class="dlex">
                          <v-btn color="info" class="mx-1 no-uppercase" @click="viewEvents(item)">
                              View
                          </v-btn>

                          <v-btn class="mx-1 no-uppercase" @click="viewUser(item)">
                              Edit
                          </v-btn>
                      </div>
                    </template>
                </v-data-table>
            </div>

        </v-container>
    </DefaultLayout>
</template>

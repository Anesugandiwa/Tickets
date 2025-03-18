<template>
    <AppLayout title="create Event">
        <div class="glass pa-3">
            <v-toolbar class="rounded-lg px-2 mb-5 " density="comfortable">
                <v-toolbar-title>
                    <span >Edit Event</span>
                    <span >Add Event</span>

                </v-toolbar-title>
                <v-spacer/>

            </v-toolbar>

            <div class="glass">
                <v-card variant="flat" color="transparent">
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="8">
                                <v-text-field
                                    label="Event Title"
                                    v-model="form.title"
                                    :error-messages="$page.props.errors.title"

                                ></v-text-field>
                                <v-textarea
                                    label="Event Description"
                                    v-model="form.description"
                                    :error-message ="$page.props.errors.description"
                                />
                                <v-row>
                                    <v-col cols="12" sm="6" md="6" lg="6">
                                        <label for="start_date">Select Start Date</label>
                                        <DatePickers
                                            v-model="form.start_date"
                                            valueType="format"
                                            v-model:value="form.start_date"
                                        />

                                        <v-text-field
                                            v-model="form.location"
                                            label="Event Location"
                                            :error-message ="$page.props.errors.location"
                                        />
                                        <br> <br>

                                        <v-text-field
                                            v-model="form.total_tickets"
                                            label="Total Tickets"
                                            type="number"
                                            :error-messages="$page.props.errors.total_tickets"
                                    />

                                    </v-col>

                                    <v-col cols="12" sm="6" md="6" lg="6" >
                                        <label for="start_date">Select End Date</label>
                                        <DatePickers
                                            v-model="form.end_date"
                                            valueType="format"
                                            v-model:value="form.end_date"
                                        />

                                    </v-col>
                                </v-row>

                            </v-col>
                            <v-col cols="12" sm="4">
                            <v-file-input
                                @change="addPreview"
                                v-model="preview_image"
                                label="Select Preview Image"
                               
                                prepend-icon=""
                                variant="outlined"
                                density="comfortable"
                                :error-messages="$page.props.errors.preview_image"
                            />
                            </v-col>
                        </v-row>
                    </v-card-text>

                </v-card>

            </div>

        </div>

    </AppLayout>
</template>
<script>
import AppLayout from '@/layouts/AppLayout.vue';
export default {
    components:{
        AppLayout,
    },

    data(){
        return{
            form: this.$inertia.form({
                title:'',
                description:'',
            })
        }
    }
}
</script>
<script setup  >
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3';
import axios from 'axios'
import Swal from 'sweetalert2'

const organisersList = ref([])
onMounted(async () => {
    try {
        const response = await axios.get(route('admin.organiser.index')) 
        organisersList.value = response.data
    } catch (error) {
        console.error('Error fetching organisers:', error)
    }
})





const columns = [
    { key: 'id', title: 'ID' },
    { key: 'title', title: 'Title' },
    { key: 'description', title: 'Description'  },
    { key: 'location',  title: 'Location'},
    { key: 'organisers',  title: 'Organisers'},
    { key: 'actions',  title: 'Actions'  },
]



const form = useForm({
    title: '',
    description: '',
    
    start_date: '',
    end_date: '',
    preview_image: null,
    location: '',
    total_tickets: '',
    is_priced: '',
    organisers: null, 
})

const errors = ref({
    title: '',
    description: '',
    organisers:'',
    start_date: '',
    end_date: '',
    preview_image: '',
    location: '',
    total_tickets: '',
    is_priced: '',
    
})
// initializing the state of the Dialog
const isDialogOpen = ref(false)
const isEditing = ref(false)

// Open Dialog for new Event 
const openDialog = () => {
    isEditing.value =false
    form.reset()
   isDialogOpen.value = true
}
// closing the Dialog
const closeDialog = () => {
    isDialogOpen.value = false
    form.reset()
}



function handleFileUpload(event) {
    const target = event.target;
    if (target.files && target.files[0]) {
        form.preview_image = target.files[0];
    }
}



const submitForm =() =>{
    
    if (isEditing.value) {
        form.put(route('admin.event.update', form.id), {
            onSuccess: () => {
                closeDialog()
                Swal.fire('Success!', 'Event updated successfully.','success')
            },
            onError: (newErrors) =>{
                errors.value =newErrors
            }

        })
    } else {
        form.post(route('admin.event.store'), {
            onSuccess: () =>{
                closeDialog()
                Swal.fire('Success','Event Created successfully', 'success')
            },
             onError: (newErrors) => {
                errors.value = newErrors

             }
        })
    }
}

const deletEvent = (event) => {
    Swal.fire({
        title: 'Are you sure you want to delete this Event!',
        text: "You won't be able to revert this",
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

    }).then((result)=> {
        if(result.isConfirmed){
            form.delete(route('admin.event.destroy', event.id), {
                onSuccess: () => {
                    Swal.fire(
                        'Deleted!',
                        'Event has been deleted.',
                        'success'
                    )
                },
                onError: () =>{
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    )
                }
            })
        }
    })

   
}

const editEvent = (event) =>{
  
        isEditing.value          =       true
        form.id             =       event.id
        form.title          =        event.title
        form.description =          event.description
       
        form.start_date =           event.start_date
        form.end_date =             event.end_date
        form.location =             event.location
        form.total_tickets  =      event.total_tickets
        form.is_priced =           event.is_priced
        form.organisers = event.organisers
        
        isDialogOpen.value =        true
    }


const viewEvent = (event) => {
    router.visit(route('admin.event.show', event.id));
}

</script>
<template>
    <AdminLayout >
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
            <v-row class="mb-4">
                <v-col>
                    <Chart :labels="labels" :dataset="dataset" />
                </v-col>
            </v-row>


            <!-- Dialog -->
            <v-dialog v-model="isDialogOpen" max-width="800">
                <v-card>
                    <v-card-title class="text-h6">
                     {{ isEditing? 'Edit Event' : 'Create New Event' }}
                    </v-card-title>
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
                                <v-col cols="12" md="6">
                                    <v-select
                                        v-model="form.organisers"
                                        :items="$page.props.organisers"
                                        item-title="name"
                                        item-value="id"
                                        label="Organisers"
                                        multiple
                                        :error-messages="errors.organisers"
                                    />

                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer />
                        <v-btn color="red" @click="closeDialog">Cancel</v-btn>
                        <v-btn color="green" @click="submitForm">
                            {{ isEditing? 'Update Event' : 'Save Event' }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            
            <div class="glass pa-3">
                <v-data-table
                    :headers="columns"
                    :items="$page.props.events"
                    :search="search"
                >

                <template v-slot:item.organisers="{ item }">
                    <v-chip v-if="item.organisers" v-for="organiser in item.organisers" :key="organiser.id">
                        {{  organiser.name }}
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <div class="d-flex">
                        <v-btn color="info" class="mx-1 no-uppercase" @click="viewEvent(item)">
                            View
                        </v-btn>
                        <v-btn class="mx-1 no-uppercase" @click="editEvent(item)">
                            Edit
                        </v-btn>
                        <v-btn color="error" class="mx-1 no-uppercase" @click="deletEvent(item)">
                            Delete
                        </v-btn>
                    </div>
                </template>
            </v-data-table>
        </div>
    </v-container>
    </AdminLayout>
</template>

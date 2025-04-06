<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Swal from 'sweetalert2'

const columns =[
    { key: 'id', title: 'ID' },
    { key:'name', title:'Organiser Name'},
    {key:'email', title:'Email'},
    {key: 'phone_number', title: 'Phone Number'},
    {key: 'organization_name', title:'Organization Name'},
    { key: 'actions',  title: 'Actions'  },
]


const form =useForm({
    name: '',
    email: '',
    phone_number: '',
    organization_name: '',
    profile_image:''
})
const errors = ref({
    name: '',
    email: '',
    phone_number: '',
    organization_name: '',
    profile_image: '',
})
 const isDialogOpen =ref(false)
 const isEditing =ref(false)

 const openDialog =() =>{
    isEditing.value =false
    form.rest()
    isDialogOpen.value =true
 }

 const closeDialog =() => {
    isDialogOpen.value = false
    form.reset()
 }
 const handleFileUpload = (event) => {
    form.profile_image = event.target.files[0]

}
const submitData =() =>{
    if (isEditing.value) {
        form.put(route('oganiser.update', form.id),{
            onSuccess:() =>{
                closeDialog()
                Swal.fire('Success!', 'Organiser updated successfully.','success')
            },
            onError: (newErrors) => {
                errors.value =newErrors

            }
        })

    }else{
        form.post(route('admin.organiser.store'),{
            onSuccess:() =>{
                closeDialog()
                Swal.fire('Success','Organiser Created successfully', 'success')
            },
            onError: (newErrors) => {
                errors.value = newErrors
            }
        })
    }
}

const editOrganiser = (organiser) => {
    isEditing.value = true
    form.id = organiser.id
    form.name =organiser.name
    form.email = organiser.email
    form.phone_number = organiser.phone_number
    form.organization_name = organiser.organization_name
    form.profile_image = organiser.profile_image

    isDialogOpen.value =true
}
const deleteOrganiser = (organiser) => {
    Swal.fire({
        title: 'Are you sure you want to delete the record?',
        text: "You won't be able to revert this!",
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes delete it!"
    }).then((result) =>{
        if (result.isConfirmed){
            form.delete(route('organiser.destroy', organiser.id), {
                onsuccess: () => {
                    Swal.fire(
                        'Deleted!',
                        'Organiser has been deleted.',
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
</script>
<template>
    <AdminLayout>
    <v-container>
        <v-row class="mb-4">
            <v-col>
                <v-card class="pa-4" elevation="1">
                    <v-row align="center" justify="space-between">
                        <h1 class="font-weight bold text-h6">Organisers</h1>
                        <v-btn color="success" @click="isDialogOpen = !isDialogOpen"> Add Organiser</v-btn>

                    </v-row>

                </v-card>
            </v-col>
        </v-row>
        <v-row class="mb-4">
                <v-col>
                    <Chart :labels="labels" :dataset="dataset" />
                </v-col>
        </v-row>
        <v-dialog max-width="800" v-model="isDialogOpen">
            <v-card>
                <v-card-title class="text-h6">
                    {{ isEditing? 'Edit Organiser' : 'Add New Organiser' }} 
                </v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="submitData">
                        <v-row dense>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.name"
                                    label="Name"
                                    :error-messages="errors.name"
                                    required
                                />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    label="Email"
                                    v-model="form.email"
                                    :error-messages="errors.email"
                                    type="email"
                                    required
                                />

                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    label="Phone Number"
                                    v-model="form.phone_number"
                                    required
                                    :error-messages="errors.phone_number"
                                />

                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    label="Organization Name"
                                    v-model="form.organization_name"
                                    required
                                    :error-messages="errors.organization_name"
                                />

                            </v-col>
                            <v-card cols="12" md="6">
                                <v-file-input
                                    label="Organization Logo"
                                    
                                    @change="handleFileUpload"
                                    :error-messages="errors.profile_image"
                                />

                                

                            </v-card>

                        </v-row>

                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn color="red" @click="closeDialog">Cancel</v-btn>
                    <v-btn color="green" @click="submitData">
                        {{ isEditing? 'Update organiser' : 'Save organiser' }}
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
        <div class="glass pa-3">
            <v-data-table
                :headers="columns"
                :items="$page.props.organisers"
                :search ="search"
                >
                <template v-slot:item.actions="{ item }">
                <div class="d-flex">
                        <v-btn color="info" class="mx-1 no-uppercase" @click="(item)">
                            View
                        </v-btn>
                        <v-btn class="mx-1 no-uppercase" @click="editOrganiser(item)">
                            Edit
                        </v-btn>
                        <v-btn color="error" class="mx-1 no-uppercase" @click="deleteOrganiser(item)">
                            Delete
                        </v-btn>
                    </div>

            </template>
               

            </v-data-table>


        </div>

    </v-container>
</AdminLayout>
</template>
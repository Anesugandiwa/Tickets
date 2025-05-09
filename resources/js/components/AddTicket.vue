<template>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <template v-slot:activator="{ props: activatorProps }">
            <v-btn  v-bind="activatorProps" size="small" icon="" variant="elevated" dark>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>

        <v-form @submit.prevent="addTicket">
                <v-card>
                    <v-card-title>
                        Add Ticket Form
                    </v-card-title>

                    <v-card-text>
                        <v-text-field
                            v-model="form.name"
                            :error-messages="$page.props.errors.name"
                            label=" Ticket Name"
                        />

                        <v-row>
                            <v-col cols="5">
                                <v-text-field
                                    v-model="form.price"
                                    :error-messages="$page.props.errors.price"
                                    label="Ticket Price"
                                />
                            </v-col>

                            <v-col cols="7">
                                <v-text-field
                                    v-model="form.total_available"
                                    :error-messages="$page.props.errors.total_available"
                                    label="Total Ticket Available"
                                />
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="5">
                                <v-file-input
                                    variant="outlined"
                                    prepend-inner-icon="mdi-camera"
                                    prepend-icon=""
                                    density="comfortable"
                                    v-model="image"
                                    :error-messages="$page.props.errors.image"
                                    label="Ticket Flier"
                                    @change="addLogo"
                                />
                            </v-col>
                            <v-col cols="7">
                                <v-img
                                    :src="logoDisp"
                                    class="glass"
                                    height="150"
                                />
                            </v-col>
                        </v-row>
                    </v-card-text>

                    <v-card-actions class="glass">
                        <v-spacer/>
                        <v-btn color="warning" variant="tonal" @click="()=>{ this.form.reset(); this.dialog = false}">
                            Cancel
                        </v-btn>
                        <v-btn :loading="form.processing" color="success" variant="flat" class="ml-5"  type="submit">
                            Add Ticket
                        </v-btn>
                    </v-card-actions>
                </v-card>
        </v-form>
    </v-dialog>
</template>
<script >

export default {
    props: ['event'],

    data(){
        return{
            dialog:false,
            logoDisp:'',
            image:'',
            form:this.$inertia.form({
                event_id:this.event.id,
                name:null,
                image:null,
                price:null,
                total_available:null,
            })
        }
    },

    methods:{

        addTicket(){
             this.form.post(route('admin.tickets.store'),{
                 onSuccess:()=>{
                     this.form.reset();
                     this.dialog=false;
                 }
             })
        },

        addLogo(event){
            this.form.image = event.target.files[0];
        }
    }
}
</script>

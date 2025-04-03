<template>

    <v-container>
        <div class="glass pa-3">
            <v-card variant="flat" >
                <v-card-title class="d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 56 56"><path fill="currentColor" fill-rule="evenodd" d="M7.627 16.697L23.812 5.364a4 4 0 0 1 5.57.982l2.553 3.645q.056.08.107.163zM2.147 29.84L1.04 25.708a4 4 0 0 1 2.83-4.898L44.438 9.94a4 4 0 0 1 4.899 2.828l1.151 4.298a3.2 3.2 0 0 1-1.121 3.35a5.001 5.001 0 0 0 2.433 8.903a3.08 3.08 0 0 1 2.576 2.255l1.172 4.377a4 4 0 0 1-2.828 4.899L12.15 51.72a4 4 0 0 1-4.898-2.828l-1.103-4.118a3.48 3.48 0 0 1 1.16-3.6a5.001 5.001 0 0 0-2.37-8.812a3.46 3.46 0 0 1-2.791-2.52m35.478-6.689a3 3 0 1 0-1.553-5.795a3 3 0 0 0 1.553 5.795m2.07 7.728a3 3 0 1 0-1.552-5.796a3 3 0 0 0 1.553 5.796m2.071 7.727a3 3 0 1 0-1.552-5.795a3 3 0 0 0 1.552 5.795"/></svg>
                        &nbsp;
                    <span  v-if="$vuetify.display.smAndDown">
                        My Tickets
                    </span>
                    <span v-else>Purchased Tickets</span>
                    <v-spacer/>

                    <v-dialog v-model="dialog" max-width="500">
                            <template v-slot:activator="{props:activatorProps}">
                                <v-btn
                                    v-if="$vuetify.display.smAndDown"
                                    v-bind="activatorProps"
                                    class="mx-1"
                                    color="success"
                                    variant="tonal"
                                    size="small"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><g fill="currentColor"><path fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718l-.697 2.359l2.32-.648l.379.243A8 8 0 1 0 12 4M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382l1.426-4.829l-.006-.007l-.033-.055A9.96 9.96 0 0 1 2 12" clip-rule="evenodd"/><path d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1 1 0 0 0-.34-.075c-.196 0-.362.098-.49.291c-.146.217-.587.732-.723.886c-.018.02-.042.045-.057.045c-.013 0-.239-.093-.307-.123c-1.564-.68-2.751-2.313-2.914-2.589c-.023-.04-.024-.057-.024-.057c.005-.021.058-.074.085-.101c.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711c-.158-.377-.366-.552-.655-.552c-.027 0 0 0-.112.005c-.137.005-.883.104-1.213.311c-.35.22-.94.924-.94 2.16c0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537c1.412.564 2.081.63 2.461.63c.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276c.192-.534.243-1.117.115-1.329c-.088-.144-.239-.216-.43-.308"/></g></svg>
                                    WhatsApp Me
                                </v-btn>
                                <v-btn
                                    v-else
                                    v-bind="activatorProps"
                                    class="mx-1"
                                    color="success"
                                    variant="tonal"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><g fill="currentColor"><path fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718l-.697 2.359l2.32-.648l.379.243A8 8 0 1 0 12 4M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382l1.426-4.829l-.006-.007l-.033-.055A9.96 9.96 0 0 1 2 12" clip-rule="evenodd"/><path d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1 1 0 0 0-.34-.075c-.196 0-.362.098-.49.291c-.146.217-.587.732-.723.886c-.018.02-.042.045-.057.045c-.013 0-.239-.093-.307-.123c-1.564-.68-2.751-2.313-2.914-2.589c-.023-.04-.024-.057-.024-.057c.005-.021.058-.074.085-.101c.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711c-.158-.377-.366-.552-.655-.552c-.027 0 0 0-.112.005c-.137.005-.883.104-1.213.311c-.35.22-.94.924-.94 2.16c0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537c1.412.564 2.081.63 2.461.63c.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276c.192-.534.243-1.117.115-1.329c-.088-.144-.239-.216-.43-.308"/></g></svg>
                                    WhatsApp
                                </v-btn>
                            </template>

                        <v-form @submit.prevent="whatsAppMe">
                            <v-card>
                                <v-card-title>
                                    WhatsApp & Email Form
                                </v-card-title>
                                <v-card-text>
                                    <v-text-field
                                        prepend-inner-icon="mdi-whatsapp"
                                        label="WhatsApp No"
                                        v-model="whatsAppMeForm.phoneNumber"
                                        :error-messages="$page.props.errors.phoneNumber"
                                        persistent-hint
                                        hint="Include country code"
                                    />
                                    <v-text-field
                                        prepend-inner-icon="mdi-email-outline"
                                        label="Email Address"
                                        v-model="whatsAppMeForm.email"
                                        :error-messages="$page.props.errors.email"
                                    />
                                </v-card-text>
                                <v-card-actions class="glass">
                                    <v-btn @click="dialog =false" color="warning" variant="outlined">
                                        Cancel
                                    </v-btn>
                                    <v-btn :loading="whatsAppMeForm.processing" type="submit" color="success" variant="flat">
                                        Send Me
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-form>
                    </v-dialog>
                </v-card-title>
                    <vue3-html2pdf
                        v-if="selectedTicket"
                        :show-layout="false"
                        :float-layout="false"
                        :enable-download="true"
                        :preview-modal="false"
                        :paginate-elements-by-height="1400"
                        :filename="selectedTicket.name"
                        :pdf-quality="2"
                        :manual-pagination="false"
                        pdf-format="a4"
                        pdf-orientation="portrait"
                        pdf-content-width="800px"
                        ref="html2Pdf"
                    >
                        <template  v-slot:pdf-content>
                             <div class="glass">
                                 <div  class="d-flex justify-space-between">
                                     <img
                                         style="width: 80%"
                                         class="rounded-lg"
                                         :src="selectedTicket.ticket.image"
                                         height="auto"
                                     />

                                     <img
                                         style="width: 20%"
                                         class="rounded-lg"
                                         :src="selectedTicket.qr_path"
                                         height="auto"
                                     />
                                 </div>
                             </div>
                        </template>
                    </vue3-html2pdf>

                    <div
                        class="ticket glass my-3 "
                        v-for="(ticket, i) in $page.props.tickets"
                        :key="i"
                    >
                        <div class=" d-flex mb-2 rounded-lg">
                                <h3 v-if="!$vuetify.display.smAndDown" class="mx-2">
                                    Reference No: <b>{{ $page.props.referenceNumber }}</b>
                                </h3>

                                <h4 v-else class="ml-2 _12px">
                                    REF: <br> <b>{{ $page.props.referenceNumber }}</b>
                                </h4>
                                <v-spacer/>

                            <v-btn
                                v-if="$vuetify.display.smAndDown"
                                @click="selectTicket(ticket)"
                                   class="mx-1" variant="flat"
                                size="small"
                                icon="mdi-download"
                            >
                            </v-btn>
                            <v-btn v-else @click="selectTicket(ticket)"
                                   class="mx-1" variant="flat">
                                <v-icon>mdi-download</v-icon>
                                    Download
                            </v-btn>
                        </div>


                        <div v-if="$vuetify.display.smAndDown" class="d-flex justify-center">
                            <img
                                class="rounded-lg"
                                :src="ticket.ticket.image"
                                height="60"
                            />

                            <img
                                class="rounded-lg"
                                :src="ticket.qr_path"
                                height="60"
                            />
                        </div>

                        <div v-else class="my-2 d-flex justify-center">
                            <img
                                class="rounded-lg"
                                :src="ticket.ticket.image"
                                height="150"
                            />

                            <img
                                class="rounded-lg"
                                :src="ticket.qr_path"
                                height="150"
                            />
                        </div>
                    </div>
            </v-card>
        </div>
    </v-container>
</template>

<script  >
import Default from "@/Layouts/Default.vue";
import jsPDF from 'jspdf'
import  Vue3Html2pdf  from 'vue3-html2pdf'

export default {
    layout: Default,
    components: {
        Vue3Html2pdf
    },

    data(){
        return{
            selectedTicket:null,
            whatsAppMeForm:this.$inertia.form({
                referenceNumber:this.$page.props.referenceNumber,
                phoneNumber:'+263',
                email:'',
            }),
            dialog:false
        }
    },

    methods: {
        selectTicket(ticket) {
            this.selectedTicket = ticket;
            // Wait for the DOM to update before generating the PDF
            this.$nextTick(() => {
                this.downloadPDF();
            });
        },

        downloadPDF() {
            if (this.$refs.html2Pdf) {
                this.$refs.html2Pdf.generatePdf();
            }

            this.$nextTick(() => {
                this.selectedTicket = null;
            });
        },

        whatsAppMe(){
            this.whatsAppMeForm.post(route('whatsapp.me'),{
                onSuccess:()=>{
                    this.dialog = false
                }
            })
        }
    }
}
</script>
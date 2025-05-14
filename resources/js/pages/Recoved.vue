<script setup>
</script>
<template>
      <v-container>
           <div class="glass">
           <v-toolbar>
               <div class="d-flex align-center">
                   <div class="d-flex align-center text-h5 mx-2">
                       <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M7.378 11.63h-.75zm0 .926l-.562.497a.75.75 0 0 0 1.08.044zm2.141-1.015a.75.75 0 0 0-1.038-1.082zm-2.958-1.038a.75.75 0 1 0-1.122.994zm8.37-1.494a.75.75 0 1 0 1.102-1.018zM12.045 6.25c-2.986 0-5.416 2.403-5.416 5.38h1.5c0-2.137 1.747-3.88 3.916-3.88zm-5.416 5.38v.926h1.5v-.926zm1.269 1.467l1.622-1.556l-1.038-1.082l-1.622 1.555zm.042-1.039l-1.378-1.555l-1.122.994l1.377 1.556zm8.094-4.067a5.42 5.42 0 0 0-3.99-1.741v1.5a3.92 3.92 0 0 1 2.889 1.26zm.585 3.453l.56-.498a.75.75 0 0 0-1.08-.043zm-2.139 1.014a.75.75 0 1 0 1.04 1.082zm2.96 1.04a.75.75 0 0 0 1.12-.997zm-8.393 1.507a.75.75 0 0 0-1.094 1.026zm2.888 2.745c2.993 0 5.434-2.4 5.434-5.38h-1.5c0 2.135-1.753 3.88-3.934 3.88zm5.434-5.38v-.926h-1.5v.926zm-1.27-1.467l-1.619 1.555l1.04 1.082l1.618-1.555zm-.04 1.04l1.38 1.554l1.122-.996l-1.381-1.555zM7.952 16.03a5.45 5.45 0 0 0 3.982 1.719v-1.5c-1.143 0-2.17-.48-2.888-1.245z"/><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464c.974.974 1.3 2.343 1.41 4.536"/></g></svg>
                       <span class="ml-2">
                                Recover Your Ticket
                       </span>
                   </div>
               </div>
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
           </v-toolbar>

               <v-card variant="flat">
                   <v-card-text v-if="$page.props.tickets.length > 0">
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
                   </v-card-text>
                   <v-card-text v-else >
                            <h1>
                                No Ticket Found
                            </h1>
                   </v-card-text>
               </v-card>
           </div>
       </v-container>

</template>
<template>
    <AdminLayout :title="$page.props.event.title">
        <div class="glass pa-3">
            <v-toolbar class="rounded-lg px-2 mb-5" density="comfortable">
                <v-toolbar-title>
                    <svg class="mb-n1" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><path fill="currentColor" d="M6.94 2c.416 0 .753.324.753.724v1.46c.668-.012 1.417-.012 2.26-.012h4.015c.842 0 1.591 0 2.259.013v-1.46c0-.4.337-.725.753-.725s.753.324.753.724V4.25c1.445.111 2.394.384 3.09 1.055c.698.67.982 1.582 1.097 2.972L22 9H2v-.724c.116-1.39.4-2.302 1.097-2.972s1.645-.944 3.09-1.055V2.724c0-.4.337-.724.753-.724"/><path fill="currentColor" d="M22 14v-2c0-.839-.004-2.335-.017-3H2.01c-.013.665-.01 2.161-.01 3v2c0 3.771 0 5.657 1.172 6.828S6.228 22 10 22h4c3.77 0 5.656 0 6.828-1.172S22 17.772 22 14" opacity="0.5"/><path fill="currentColor" d="M18 17a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-5 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0"/></svg>
                    {{ $page.props.event.title}}
                </v-toolbar-title>
                <v-spacer />

                <InertiaLink :href="route('event.index')">
                    <v-btn   variant="flat" color="primary">
                        Back to Events
                    </v-btn>
                </InertiaLink>
            </v-toolbar>


            <div class="glass" >
                <v-card variant="flat" color="transparent">
                    <v-tabs  v-model="tab" >

                        <v-tab value="one">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1m-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1m-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2z" clip-rule="evenodd"/></svg>
                            &nbsp;Event Details
                        </v-tab>

                        <v-tab value="three">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 32 32"><path fill="currentColor" d="M30 6V4h-3V2h-2v2h-1c-1.103 0-2 .898-2 2v2c0 1.103.897 2 2 2h4v2h-6v2h3v2h2v-2h1c1.103 0 2-.897 2-2v-2c0-1.102-.897-2-2-2h-4V6zm-6 14v2h2.586L23 25.586l-2.292-2.293a1 1 0 0 0-.706-.293H20a1 1 0 0 0-.706.293L14 28.586L15.414 30l4.587-4.586l2.292 2.293a1 1 0 0 0 1.414 0L28 23.414V26h2v-6zM4 30H2v-5c0-3.86 3.14-7 7-7h6c1.989 0 3.89.85 5.217 2.333l-1.49 1.334A5 5 0 0 0 15 20H9c-2.757 0-5 2.243-5 5zm8-14a7 7 0 1 0 0-14a7 7 0 0 0 0 14m0-12a5 5 0 1 1 0 10a5 5 0 0 1 0-10"/></svg>
                            &nbsp;Sold Tickets
                        </v-tab>

                        <v-tab value="stats">
                            <svg class="mt-n2" xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8 14v-4h1v4h5V5h1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2h1v2zm4.853-10.146l-2.999 3a1.5 1.5 0 0 1-2.538 1.568l-2.714.904L4 9.527a1.5 1.5 0 1 1-.316-.948L7 7.473a1.5 1.5 0 0 1 2.146-1.327l3-3a1.5 1.5 0 1 1 .707.707"/></svg>
                            &nbsp;Sales Statistics
                        </v-tab>

                        <v-tab value="analytics">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M7 18v-2m5 2v-3m5 3v-5M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12"/><path d="M5.992 11.486c2.155.072 7.042-.253 9.822-4.665m-1.822-.533l1.876-.302c.228-.029.564.152.647.367l.495 1.638"/></g></svg>
                            &nbsp;Analytics
                        </v-tab>

                        <v-tab value="performance">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M6.5 17.5v-3m5 3v-9m5 9v-4m5-8a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M21.496 11s.004.34.004 1c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12c0-4.478 0-6.717 1.391-8.109C5.282 2.5 7.521 2.5 12 2.5h1"/></g></svg>
                            &nbsp;Performance Statistics
                        </v-tab>
                    </v-tabs>
                    <v-divider color="primary" />

                    <v-tabs-window v-model="tab">
                        <v-tabs-window-item value="one">
                            <v-card>
                                <v-card-title class="mt-5">
                                    Event Details
                                </v-card-title>

                                <v-card-text>

                                    <v-row>
                                        <v-col cols="12" sm="4">
                                            <v-img
                                                class="rounded-lg glass"
                                                cover
                                                height="500"
                                                :src="$page.props.event.preview_image"
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="8">
                                            <h2> Event Description</h2>
                                            <v-divider class="my-5"/>

                                            <div v-html="$page.props.event.description"></div>

                                            <br>
                                              <div  style="z-index: 1" class="d-flex justify-space-between glass pa-5 ">
                                                  <h3 class="w-50"><v-icon>mdi-calendar-month</v-icon>Start: {{  goodDate($page.props.event.start_date) }}</h3>

                                                  <h3 class="w-50"><v-icon>mdi-calendar-month</v-icon>End: {{  goodDate($page.props.event.end_date) }}</h3>
                                              </div>

                                                <div class="d-flex justify-space-between mt-5 pa-5 glass">
                                                    <h3 class="w-50"><v-icon>mdi-map-marker</v-icon> Venue: {{ $page.props.event.location }}</h3>

                                                    <h3 class="w-50"><v-icon>mdi-file-compare</v-icon> Total Tickets: {{ $page.props.event.total_tickets  }}</h3>
                                                </div>

                                                <div class="  mt-5    ">


                                                    <div v-if="$page.props.event.is_priced">
                                                        <v-card class="glass-shadow" variant="flat">
                                                            <v-toolbar  density="comfortable" color="white">
                                                                <v-toolbar-title>
                                                                    Tickets
                                                                </v-toolbar-title>
                                                                <v-spacer/>

                                                                <AddTicket :event="$page.props.event" />
                                                            </v-toolbar>
                                                            <v-card-text>

                                                                <div v-if="$page.props.event.tickets">
                                                                    <div
                                                                        v-for="(ticket,i) in $page.props.event.tickets"
                                                                        :key="i"
                                                                        class="d-flex glass"
                                                                    >
                                                                        <div>
                                                                            <img
                                                                                width="150"
                                                                                :src="ticket.image"
                                                                                class="rounded-lg glass"
                                                                                alt="Image"
                                                                            />
                                                                        </div>

                                                                        <div class="ml-5">
                                                                            <h2>
                                                                                {{ ticket.name }}
                                                                            </h2>
                                                                            <h1>
                                                                                $ {{ ticket.price }}
                                                                            </h1>
                                                                            <h3>{{ ticket.total_available }} Seats</h3>
                                                                        </div>
                                                                        <v-spacer/>

                                                                        <div  >
                                                                            <v-btn color="error" icon="" size="small" @click="deleteTicket(ticket)">
                                                                                <v-icon>mdi-trash-can</v-icon>
                                                                            </v-btn>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <v-alert v-else type="warning">
                                                                    No Tickets added
                                                                </v-alert>
                                                            </v-card-text>
                                                        </v-card>
                                                    </div>

                                                    <div v-else>
                                                        <v-btn block color="success" size="large" dark>
                                                            Free
                                                        </v-btn>
                                                    </div>
                                                </div>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-tabs-window-item>

                        <v-tabs-window-item value="three">
                            <v-card variant="flat" color="transparent">
                                <v-card-title>
                                    Sold Tickets
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="headers"
                                        :items="$page.props.event.purchases"
                                        :search="search"
                                    >
                                        <template v-slot:item.ticket="{ item }">
                                            <img
                                                class=" my-1"
                                                width="150"
                                                :src="item.ticket.image"
                                            />
                                        </template>

                                        <template v-slot:item.created_at="{ item }">
                                                    {{ displayDate(item.created_at).daymY }}
                                        </template>

                                        <template v-slot:item.status="{ item }">
                                            <v-chip size="small" v-if="item.status == 1" color="error" >
                                                Used
                                            </v-chip >
                                            <v-chip size="small" v-else color="success" >
                                                Active
                                            </v-chip>
                                        </template>

                                        <template v-slot:item.qr_path="{ item }">
                                            <img
                                                height="75"
                                                class=" my-1"
                                                :src="item.qr_path"
                                            />
                                        </template>

                                        <template v-slot:item.actions="{ item }">
                                            <div class="d-flex justify-end">
                                                <v-btn @click="viewDetails(item)" class="mx-1"   icon size="small" color="blue">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><path fill="currentColor" d="M5 11h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2m0 10h4c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2m8-16v4c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2m2 16h4c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2"/></svg>
                                                </v-btn>

                                                <v-btn class="mx-1" color="error" icon size="small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M20.5 6h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79s-2.195.81-4.856.81h-.774c-2.66 0-3.99 0-4.856-.81c-.865-.809-.953-2.136-1.13-4.79l-.46-6.9"/><path stroke-linecap="round" d="m9.5 11l.5 5m4.5-5l-.5 5" opacity="0.5"/><path d="M6.5 6h.11a2 2 0 0 0 1.83-1.32l.034-.103l.097-.291c.083-.249.125-.373.18-.479a1.5 1.5 0 0 1 1.094-.788C9.962 3 10.093 3 10.355 3h3.29c.262 0 .393 0 .51.019a1.5 1.5 0 0 1 1.094.788c.055.106.097.23.18.479l.097.291A2 2 0 0 0 17.5 6" opacity="0.5"/></g></svg>
                                                </v-btn>
                                            </div>
                                        </template>
                                    </v-data-table>
                                </v-card-text>
                            </v-card>
                        </v-tabs-window-item>

                        <v-tabs-window-item value="stats">
                            Sales Statistics: <br>

                            Total tickets sold per event <br>
                            Revenue generated by event or time period <br>
                            Ticket sales trends (daily, weekly, or monthly)
                        </v-tabs-window-item>

                        <v-tabs-window-item value="analytics">

                            <apexchart width="500" type="area" :options="options" :series="series"></apexchart>
                            User Engagement Statistics: <br>

                            Number of unique users who purchased tickets <br>
                            Average tickets bought per user <br>
                            Most popular events based on user interactions
                        </v-tabs-window-item>

                        <v-tabs-window-item value="performance">

                            <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
                            Event Performance Statistics: <br>

                            Percentage of tickets sold vs. total available <br>
                            Conversion rate from views to ticket purchases <br>
                            Most popular ticket types (e.g., VIP, General Admission)
                        </v-tabs-window-item>
                    </v-tabs-window>
                </v-card>
            </div>

        </div>
    </AdminLayout>
</template>

<script>
import moment from "moment";
import AdminLayout from "@/layouts/AdminLayout.vue";

import AddTicket from '@/components/AddTicket.vue'
import {displayDate} from "../../../Composables/Dates.js";
    export default {
        components: {
            AddTicket,
            AdminLayout,
        },

        data(){
            return{
                tab:null,
                search:'',
                headers:[
                    { title: 'ID', key: 'id', align: 'start' },
                    { title: 'QR', key: 'qr_path', sortable: false},
                    { title: 'Ticket', key: 'ticket', sortable: false},
                    { title: 'Name', key: 'ticket.name', sortable: false},
                    { title: 'Status', key: 'status', align: 'end' },
                    { title: 'Date', key: 'created_at', align: 'end' },
                    { title: 'More', key: 'actions', sortable: false , align: 'end'},
                ],
                options: {
                    chart: {
                        id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                    }
                },
                series: [{
                    name: 'series-1',
                    data: [30, 40, 45, 50, 49, 60, 70, 91]
                }]
            }
        },

         methods:{
             displayDate,

             goodDate(date){
                 return moment(date).format("d-MMMM-YYYY");
             },

             deleteTicket(ticket){
                 this.$swal.fire({
                     title: "Are you sure you want to delete this Ticket?",
                     icon: 'question',
                     showDenyButton: true,
                     confirmButtonText: "Delete",
                     denyButtonText: `Cancel`,
                 }).then((result) => {
                     if (result.isConfirmed) {

                         this.$inertia.visit(route('admin.tickets.destroy', ticket), {
                             method: 'delete',
                             onSuccess:()=>{
                                 this.$swal.fire({
                                     title: "Ticket Deleted Successfully",
                                     icon: 'success',
                                 })
                             }
                         });
                     }
                 });
             }

         }
    }
</script>

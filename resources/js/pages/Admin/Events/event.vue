<script setup lang="ts">
import { Dialog, DialogContent, DialogHeader, DialogFooter } from '@/components/ui/dialog';
import { Popover, PopoverTrigger, PopoverContent } from '@/components/ui/popover';


  import { Head, Link } from '@inertiajs/vue3'
  import AppLayout from '@/layouts/AppLayout.vue';
  import { type BreadcrumbItem } from '@/types';
  import { Button } from '@/components/ui/button';
//   import Calendar from '@/components/ui/calendar/Calendar.vue';
  import { Calendar as CalendarIcon } from 'lucide-vue-next';
  import  {Calendar }  from '@/components/ui/calendar';
 
  import {useForm} from '@inertiajs/vue3';
  import { Input } from "@/components/ui/input";
  import { Label } from '@/components/ui/label';
  import DataTable from '@/components/DataTable.vue';
   

  import {ref} from 'vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';

const columns = [
      { field: 'id', header: 'ID' },
      { field: 'title', header: 'Title' },
      { field: 'description', header: 'Description' },
      { field: 'location', header: 'Location' },
      { field: 'actions', header: 'Actions' },
  ]
  function viewEvent(row: any) {
      console.log('Viewing event:', row.id)
  }
  
const form = useForm({
    title:          '',
    description:    '',
    slug:           '',
    start_date:      null as DateValue  | null,
    end_date:        null as DateValue  | null,
    preview_image:  null as File | null,
    location:       '',
    total_tickets:  '',
    is_priced:      '',
 })
 function handleFileUpload(event: Event) {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    form.preview_image = target.files[0]
  }
}
const formatDate = (date: Date | null) => {
  if (!date) return 'Pick a date';
  return date.toLocaleDateString();
};
 const submitForm =() =>{
    const payload = {
    ...form.data(),
    start_date: form.start_date ? new Date(form.start_date).toISOString().split('T')[0] : null,
    end_date: form.end_date ? new Date(form.end_date).toISOString().split('T')[0] : null,
  };
    form.post(route('events.store'),{
        onSuccess:() =>{
            closeDialog();
            form.reset();
        },
    });
 };

 const isDialogOpen = ref(false);

 const openDialog =() =>{
    isDialogOpen.value =true;
 };

 const closeDialog = () =>{
    isDialogOpen.value =false;
 }
 
 const breadcrumbs: BreadcrumbItem[] = [
      {
          title: 'Add Events',
          href: route(''),
      },
  ];


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title ="Add Events"/>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <CustomCard
                    title="All Events"
                    icon=""
                    :number="$page.props.total"
                    description=""
                />
            </div>
            <div class="flex justify-between mb-4 bg-primary p-3 rounded-sm">
                <h1 class="text-xl font-bold text-white">Events</h1>
                <Button
                    @click="openDialog"
                    as="a"
                    variant="outline"
                    class="bg-[#67B446] text-white"
                >
                    Add Event
                </Button>
            </div>
            <Dialog v-model:open="isDialogOpen">
                <DialogContent class="max-w-4xl">
                    <DialogHeader>
                        <DialogTitle>
                            Create New Event
                        </DialogTitle>
                    </DialogHeader>


            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semi-bold mb-4">Create a new Event</h2>
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block mb-2 font-medium">Title</label>
                            <Input 
                                id="name" 
                                type="text" 
                                required autofocus :tabindex="1" 
                                autocomplete="title" 
                                v-model="form.title" 
                                placeholder="Enter Title" 
                            />

                        </div>

                        <div>
                            <label for="description" class="block mb-2 font-medium">Description</label>
                            <Input 
                                id="description"
                                required autofocus :tabindex="1" 
                                v-model="form.description"
                                placeholder="Enter Description"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focuse:ring-2 focus:ring-primary "
                                rows="4"
                            />
                        </div>
                        <div>
                            <label for="slug" class="block mb-2 font-medium">Slug</label>
                            <Input
                                id="slug"
                                placeholder="Enter slug"
                                v-model="form.slug"
                                class="w-full"
                            />
                        </div>
                        <div>
                            <label for="start_date" class="block mb-2 font-medium">Start Date</label>
                            <!-- <Input
                                id ="start_date"
                                v-model="form.start_date"
                                placeholder="Enter start Date"
                                class="w-full"
                            /> -->
                            <Popover>
                                <PopoverTrigger as-child>
                                    <Button
                                     variant="outline"
                                     class="w-full justify-start text-left font-normal"
                                     
                                     >
                                     <CalendarIcon class="mr-2 h-4 w-4"></CalendarIcon>
                                     <span>{{ formatDate(form.start_date) }}</span>

                                    </Button>

                                </PopoverTrigger>
                                <PopoverContent class="w-auto p-0">
                                    <Calendar v-model="form.start_date" />
                                </PopoverContent>
                            </Popover>

                        </div>
                        <div>
                            <label for="end_date" class="block mb-2 font-medium">End Date</label>
                            <!-- <Input 
                                id="end_date"
                                v-model="form.end_date"
                                placeholder="Enter End Date"
                                class="w-full"
                            /> -->
                            <Popover>
                                <PopoverTrigger as-child>
                                    <Button
                                        variant="outline"
                                        class="w-full justify-start text-left font-normal"
                                    >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    <span>{{ formatDate(form.end_date) }}</span>
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar v-model="form.end_date" />
                            </PopoverContent>
                        </Popover>
                        </div>
                        <div>
                            <label for="preview_image" class="block mb-2 font-medium">Enter Image</label>
                            <Input 
                                id="preview_image"
                                type="file"
                                @change="handleFileUpload"
                                placeholder="Enter preview Image"
                                class="w-full"
                            />


                        </div>
                        <div>
                            <label for="location" class="block mb-2 font-medium">Enter Location</label>
                            <Input 
                                id="location"
                                v-model="form.location"
                                placeholder="Enter location "
                                class="w-full"
                            />


                        </div>
                        <div>
                            <label for="total_tickets" class="block mb-2 font-medium">Enter number of Tickets</label>
                            <Input 
                                id="total_tickets"
                                v-model="form.total_tickets"
                                placeholder="Enter Tickets"
                                class="w-full"
                            />


                        </div>
                        <div>
                            <label for="is_priced" class="block mb-2 font-medium">Price</label>
                            <Input 
                                id="is_priced"
                                v-model="form.is_priced"
                                placeholder="Enter Price"
                                class="w-full"
                            
                            />


                        </div>
                    </div>
                </form>
                <DialogFooter class="flex justify-center gap-4">
                    <Button @click="closeDialog" variant="outline" class="px-6 py-2 bg-red-500 hover:bg-red-600">
                        Cancel
                    </Button>
                    <Button
                        @click=""
                        class="bg-[#67B446] text-white hover:bg-[#559c3a]"
                    >
                        Save Event
                    </Button>
                </DialogFooter>

            </div>
                </DialogContent>
        </Dialog>
            <div>
                <DataTable :columns="columns" :data="$page.props.events">
                    <template #actions="{row}">
                        <Button @click="viewEvent(row)">view</Button>

                    </template>

                </DataTable>
            </div>

        </div>


  </AppLayout>
</template>

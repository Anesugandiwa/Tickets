<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3';

const drawer = ref(null)

const menues = ref([
    {
        name: "Dashboard",
        path: route('client.user_dasshboard'),
        icon: "mdi-monitor-dashboard",
        id: 1,
    },



]);

function logout() {
    router.post('/logout', {}, {
        onSuccess: () => {
            // window.location.reload()
        },
    });
}
</script>



<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer">
            <v-list density="compact">
                <div class="mb-1 mx-1  d-flex">
                    <div>
                        <img  height="55" src="/images/logo.jpg"  alt="Logo"/>
                    </div>
                   <div>
                       <b>{{ $page.props.auth.user.name }} </b> <br />
                       <small>
                           {{ $page.props.auth.user.email }}
                       </small>
                   </div>
                </div>
                <v-divider />
                <v-list-subheader class="my-3"> User Portal </v-list-subheader>

                <!--list-->

                <InertiaLink
                    v-for="(item, i) in menues"
                    :key="i"
                    :href="item.path"
                    class="InertiaLink"
                >
                    <v-list-item nav class="mx-3">
                        <template v-slot:prepend>
                            <v-icon :icon="item.icon"></v-icon>
                        </template>
                        <v-list-item-title>&nbsp; {{ item.name }}</v-list-item-title
                        >
                    </v-list-item>
                </InertiaLink>

                <div class="pa-6 px-2 userbottom">
                    <v-sheet class="bg-primary rounded-lg pa-1">
                        <div class="d-flex align-center justify-space-between">
                            <div>
                                <h4
                                    class="ml-1 d-flex align-center font-weight-semibold"
                                >
                                    {{ $page.props.auth.user.name }}
                                </h4>
                            </div>
                            <div>

                                   <v-btn
                                        @click="logout()"
                                       color="success"
                                       icon="mdi-location-exit"
                                       variant="elevated"
                                   />
                            </div>
                        </div>
                    </v-sheet>
                </div>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>Application</v-app-bar-title>
            <v-spacer/>

            <v-btn :href="route('home')">
                Website
            </v-btn>
        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
           <v-container fluid class="mt-3">
               <slot></slot>
           </v-container>
        </v-main>
    </v-app>
</template>
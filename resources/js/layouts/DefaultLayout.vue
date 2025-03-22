<template>
    <v-app id="inspire">
        <v-app-bar flat>
            <a href="/">
                <img src="/images/logo.jpg" alt="" height="50">
            </a>

            <v-spacer></v-spacer>
            <InertiaLink :href="route('login')" class="mx-1">
                <v-btn color="primary" variant="elevated" class="no-uppercase">
                    Login
                </v-btn>
            </InertiaLink>

            <InertiaLink :href="route('register')" class="mx-1">
                <v-btn color="primary" variant="elevated" class="no-uppercase">
                    Create Account
                </v-btn>
            </InertiaLink>

        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
            <v-container fluid>
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>
</template>

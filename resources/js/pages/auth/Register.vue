<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import DefaultLayout from '@/layouts/DefaultLayout.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    name:'',
    email: '',
    password: '',
    password_confirmation: '',
    remember: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <DefaultLayout>
        <Head title="Register"/>
        <v-container>
            <v-form @submit.prevent="submit" class="mt-15">
                <v-card class="mx-auto glass" max-width="500">
                    <v-card-title class="my-5">
                        Registration Form
                    </v-card-title>

                    <v-card-text>
                        <v-text-field
                            id="name"
                            label="Name"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            v-model="form.name"
                            placeholder="Full Name"
                            :error-messages="form.errors.name"
                        />
                        <v-text-field
                            id="email"
                            type="email"
                            label="Email address"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="email@example.com"
                            :error-messages="form.errors.email"
                        />


                        <div class="d-flex align-center ">
                            <div  :tabindex="3">
                                <v-checkbox label="Remember me" id="remember" v-model:checked="form.remember" :tabindex="4" />
                            </div>
                            <v-spacer/>
                            <div v-if="canResetPassword" :href="route('password.request')"  :tabindex="5">
                                Forgot password?
                            </div>
                        </div>
                        <v-text-field
                            id="password"
                            type="password"
                            required
                            label="Password"
                            :tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="Password"
                            :error-messages="form.errors.password"
                        />
                        <v-text-field
                       
                            id="password_confirmation"
                            type="password"
                            required
                            label="Confirm Password"
                            :tabindex="4"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirm password"
                            :error-messages="form.errors.password_confirmation"
                        />
                    </v-card-text>
                    <v-card-actions>
                        <!-- <v-btn rounded size="x-large" type="submit" class="no-uppercase" block variant="elevated" :tabindex="4" :loading="form.processing">
                            Log in
                        </v-btn> -->
                        <v-btn rounded size="x-large" type="submit" class="no-uppercase" block variant="elevated" :tabindex="4" :loading="form.processing">
                            Create account

                        </v-btn>
                        
                    </v-card-actions>

                    <v-card-text>
                        Already have an account?
                        <InertiaLink :href="route('login')" >
                            <v-btn class="no-uppercase" variant="text" :tabindex="5">LogIn</v-btn>
                        </InertiaLink>
                    </v-card-text>
                </v-card>


            </v-form>
        </v-container>
    </DefaultLayout>
</template>

/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Composables
import { createVuetify } from 'vuetify'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
    theme: {
        themes: {
            light: {
                colors: {
                    accent: "#3F4195",
                    surface: "#fafafa",
                    primary: "#F58634",
                    error: "#c20d0d",
                    success: "#41a748",
                },
            },
            dark: {
                colors: {
                    accent: "#3F4195",
                    surface: "#fafafa",
                    primary: "#F58634",
                    error: "#c20d0d",
                    success: "#41a748",
                },
            },
        },
    },


    defaults: {
        VCard: {
            rounded: "lg",
        },

        VTextField: {
            variant: "outlined",
            density: "comfortable",
            color: "primary",
        },

        VFileInput: {
            variant: "outlined",
            density: "comfortable",
            color: "primary",
        },

        VTextarea: {
            variant: "outlined",
            density: "comfortable",
            color: "primary",
        },

        VSelect: {
            variant: "outlined",
            density: "comfortable",
            color: "primary",
        },

        VAutoComplete: {
            variant: "outlined",
            density: "comfortable",
            color: "primary",
        },

        VTooltip: {
            location: "top",
        },

        VBtn: {
            variant: "flat",
            color: "primary",
        },
    },

})

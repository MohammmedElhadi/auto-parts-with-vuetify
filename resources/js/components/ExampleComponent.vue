<template>
    <v-container>
        <v-btn color="primary" @click="diraction()"> diraction</v-btn>
        <v-btn color="primary" @click="light()"> theme</v-btn>

    </v-container>
</template>

<script>
import demandModal from "./demandModal.vue";
import Notifications from './notifications.vue';
export default {

    components: { demandModal, Notifications },
    mounted() {
        console.log("Component mounted.");
    },


    methods: {
        light() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        },
        diraction() {
            this.$vuetify.rtl = !this.$vuetify.rtl;
        },

    },
};
</script>

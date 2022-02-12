<template>
    <v-card class="mx-auto" width="800">
        <v-card-title class="white--text indigo darken-1">
            Notifications
            <v-spacer></v-spacer>
            <v-btn color="white" class="text--primary" fab small>
                <v-icon>mdi-bell</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-virtual-scroll :items="notifications" :item-height="50" height="300">
            <template v-slot:default="{ item }">

                <v-list-item>
                    <!-- <v-list-item-avatar>
                            <v-avatar
                                :color="item.color"
                                size="56"
                                class="white--text"
                            >
                                {{ item.initials }}
                            </v-avatar>
                        </v-list-item-avatar> -->

                    <v-list-item-content>
                        <v-list-item-title>Demande qui conserne {{item.demande.types[0].nom_fr}}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action >
                            <v-btn depressed small>
                                <!-- <router-link v-bind:to="'/api/demandes/'+item.demande.id " replace> View demande</router-link> -->
                                <router-link :to="{name:'demande',
                                                 params : {id : item.demande.id }
                                                 }"> View demande</router-link>
                                <v-icon color="orange darken-4" right>
                                    mdi-open-in-new
                                </v-icon>
                            </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </template>
        </v-virtual-scroll>
    </v-card>
</template>
<script>
export default {
    props: ["notifications"],
    // methods : {
    //       getNotifications() {
    //         axios
    //             .get(route("notification.index"))
    //             .then((repsponse) => {
    //                 // console.log(repsponse.data)
    //             //    return repsponse.data;
    //                 this.notifications = repsponse.data;
    //                 // console.log(this.notifications[0].data.demande);
    //             })
    //             .catch((error) => {
    //                 console.log(error);
    //                 return ['no data found'];
    //             });
    //     },
    // },
    created() {
        // console.log(this.notifications);
    },
    computed: {
        items() {
            //   this.getNotifications();
            //   const notis = this.notifications;
            return this.notifications;
        },
    },
};
</script>

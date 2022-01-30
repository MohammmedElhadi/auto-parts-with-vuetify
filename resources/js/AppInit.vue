<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app clipped>
            <v-list dense>
                <v-list-item link to="/">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/demandes">
                    <v-list-item-action>
                        <v-icon>mdi-buffer</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Demandes</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/products">
                    <v-list-item-action>
                        <v-icon>mdi-buffer</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Products</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>Application</v-toolbar-title>
            <demand-modal></demand-modal>
            <v-spacer></v-spacer>
            <v-menu
                v-model="menu"
                :close-on-content-click="false"
                :nudge-width="200"
                offset-x
                left
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" icon>
                        <v-badge
                            v-if="notifications"
                            :content="notifications.length"
                            :value="notifications.length"
                            color="red"
                        >
                            <v-icon>mdi-bell</v-icon>
                        </v-badge>
                    </v-btn>
                </template>

                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title
                                    >Notifications</v-list-item-title
                                >
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-btn icon>
                                    <v-icon>mdi-radiobox-marked</v-icon>
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>
                        <div
                            v-for="(notification, index) in this.notifications"
                            :key="index">
                            <v-list-item>
                                <v-list-item-title
                                    >{{notification.type}}</v-list-item-title
                                >
                            <v-list-item-icon>
                                <v-icon>mdi-format-list-bulleted-type</v-icon>
                            </v-list-item-icon>
                            </v-list-item>
                        </div>
                    </v-list>
                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn text @click="menu = false"> Cancel </v-btn>
                        <v-btn color="primary" text @click="menu = false">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </v-app-bar>

        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <span>© {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>
</template>

<script>
import demandModal from "./components/demandModal.vue";
export default {
    components: { demandModal },
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
        notifications: null,
    }),
    methods: {
        getNotifications() {
            axios
                .get(route("notification.index"))
                .then((repsponse) => {
                    this.notifications = repsponse.data;
                    console.log(this.notifications.length);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.$vuetify.theme.dark = true;
        this.getNotifications();
        //console.log(vuVar)
    },
};
</script>

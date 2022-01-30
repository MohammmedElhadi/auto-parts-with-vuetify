<template>
    <v-card  class="pa-2"     cla ss="mx-auto" outlined>
        <v-list-item three-line>
            <v-list-item-content>

                <div class="text-overline mb-4">
                    Demande n° : #{{ demande.demande.id }}
                </div>
                <v-list-item-title class="text-h5 mb-1">
                    <v-row>
                    <v-col>
                    <v-chip close-icon="mdi-close-outline" color="red" outlined
                        >{{demande.type.nom_fr}}</v-chip
                    >
                    <v-chip v-if="demande.category" close-icon="mdi-close-outline" color="yellow" outlined
                        >{{demande.category.nom_fr}}</v-chip
                    >
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col>
                    <v-chip v-if="demande.marque" close-icon="mdi-close-outline" color="green" outlined
                        >{{demande.marque.nom_fr}}</v-chip
                    >

                    <v-chip v-if="demande.modele" close-icon="mdi-close-outline" color="green" outlined
                        >{{demande.modele.nom_fr}}</v-chip
                    >
                    </v-col>
                    </v-row>
                </v-list-item-title>
                <v-list-item-subtitle
                    >
                    <div v-if="demande.marque"></div>
                    </v-list-item-subtitle
                >
                <v-list-item-subtitle>
                    <v-expansion-panels>
                        <v-expansion-panel>
                            <v-expansion-panel-header
                                expand-icon="mdi-menu-down"
                            >
                                Détail
                            </v-expansion-panel-header>
                            <v-expansion-panel-content
                                >{{demande.demande.note}}
                                </v-expansion-panel-content
                            >
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-avatar
                tile
                size="80"
                color="grey"
            ></v-list-item-avatar>
        </v-list-item>

        <v-card-actions>
            <v-btn outlined rounded text> Button </v-btn>
            <v-expansion-panels accordion>
                <v-expansion-panel >
                    <v-expansion-panel-header> Offer </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        Offer Information
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
            <v-btn outlined rounded text> Button </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
export default {
    props: ["demande"],
    created() {
        // console.log(this.demande.user_id);
    },
};
</script>

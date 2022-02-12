<template>
    <!-- <div id="demandeDetail" > -->
    <div id="demandeDetail" :key="demande.data.id">
        <v-card class="pa-2" cla ss="mx-auto" outlined>
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="text-overline mb-4">
                        Demande n° : #{{ demande.data.id }}
                        <v-icon>mdi-google-maps</v-icon
                        >{{ demande.data.wilaya_id }}
                    </div>
                    <v-spacer></v-spacer>
                    <v-list-item-title class="text-h5 mb-1">
                        <v-row>
                            <v-col>
                                <v-chip
                                    close-icon="mdi-close-outline"
                                    color="red"
                                    outlined
                                    >{{ demande.type.nom_fr }}</v-chip
                                >
                                <v-chip
                                    v-if="demande.category"
                                    close-icon="mdi-close-outline"
                                    color="yellow"
                                    outlined
                                    >{{ demande.category.nom_fr }}</v-chip
                                >
                            </v-col>
                            <v-spacer></v-spacer>
                            <v-col>
                                <v-chip
                                    v-if="demande.marque"
                                    close-icon="mdi-close-outline"
                                    color="green"
                                    outlined
                                    >{{ demande.marque.nom_fr }}</v-chip
                                >

                                <v-chip
                                    v-if="demande.modele"
                                    close-icon="mdi-close-outline"
                                    color="green"
                                    outlined
                                    >{{ demande.modele.nom_fr }}</v-chip
                                >
                            </v-col>
                        </v-row>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        <div v-if="demande.marque"></div>
                    </v-list-item-subtitle>
                    <v-list-item-subtitle>
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-header
                                    expand-icon="mdi-menu-down"
                                >
                                    Détail
                                </v-expansion-panel-header>
                                <v-expansion-panel-content
                                    >{{ demande.data.note }}
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-list-item-subtitle>
                  <v-img
            src="https://www.swag.de/fileadmin/revolution/slide-content-3.png"
        ></v-img>
                </v-list-item-content>
            </v-list-item>

            <v-card-actions>
                <v-expansion-panels accordion>
                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            Offer
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-row>
                                <v-col md="6" cols="12">
                                    <v-autocomplete
                                        dense
                                        :items="wilayas"
                                        item-text="code"
                                        item-value="id"
                                        label="Wilaya de la demande"
                                        prepend-icon="mdi-google-maps"
                                        required
                                        v-model="offer.wilaya_id"
                                    >
                                        <template v-slot:item="slotProps"
                                            >{{ slotProps.item.code }}-{{
                                                slotProps.item.name
                                            }}
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col md="6" cols="12" >
                                    <!-- etat -->
                                    <v-autocomplete
                                        dense
                                        :items="etats"
                                        item-text="nom_fr"
                                        item-value="id"
                                        label="Etat de la pièce"
                                        prepend-icon="mdi-circle"
                                        required
                                        v-model="offer.etat_id"
                                    >
                                    </v-autocomplete>
                                </v-col>
                            </v-row>

                            <v-text-field
                                dense
                                placeholder="Prix offert"
                                v-model="offer.prix_offert"
                                prepend-icon="mdi-circle"
                                suffix="DZD"
                            ></v-text-field>
                              <v-textarea
                                                clearable
                                                auto-grow
                                                dense
                                                clear-icon="mdi-close-circle"
                                                label="Description"
                                                v-model="offer.note"
                                            ></v-textarea>
                            <v-btn
                                dense
                                fa-flip-horizontal
                                outlined
                                rounded
                                text
                                color="success"
                                @click="SubmitOffer()"
                            >
                                Reppondre
                            </v-btn>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
export default {
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data: () => ({
        etats: [],
        wilayas: [],
        demande: null,
        offer: {
            user_id: 10, // get the auth user id
            wilaya_id: "",
            etat_id: "",
            demande_id : "",
            prix_offert: "",
            note: "",
        },
    }),
    created() {
        this.getWilayas();
        this.getEtat();
        this.getDemande();
        console.log(this.demande.id)
        // this.demande_id = this.demande.id;

    },
    methods: {
        getWilayas() {
            axios
                .get(route("wilaya.index"))
                .then((repsponse) => {
                    this.wilayas = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getEtat() {
            axios
                .get(route("etat.index"))
                .then((repsponse) => {
                    this.etats = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getDemande() {
            axios
                .get(route("demande.show", this.$route.params))
                .then((repsponse) => {
                    this.demande = repsponse.data;
                    console.log(this.demande);
                })
                .catch(() => {
                    return ["no data found"];
                });
        },
        SubmitOffer(){
             axios
                .post(route("demande.offer" ,this.demande.data.id),{
                        offer : this.offer })
                .then((repsponse) => {
                    // this.demande = repsponse.data;
                    // console.log(this.demande);
                })
                .catch(() => {
                    return ["no data found"];
                });
        }
    },
};
</script>

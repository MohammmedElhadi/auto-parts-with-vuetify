<template>
    <div>

        <div v-for="(demande, index) in demandes" :key="index">
            <div class="my-5"></div>
            <demande :demande = "demande"></demande>
        </div>
    </div>
</template>
<script>
import Demande from '../components/Demande.vue'
export default {
  components: { Demande },
  data: () => ( {
      demandes : []
  }),
   methods: {
        // step 1
        getDemandes() {
            axios
                .get(route("demande.index"))
                .then((repsponse) => {
                    this.demandes = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
   },
  created(){
      this.getDemandes();
  },
  mounted(){
    //   console.log(this.demandes)
  }

}
</script>

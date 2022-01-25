<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ header }}</div>

                    <div class="card-body">

                        <example-component></example-component>

                    </div>
                    <demand-wizard></demand-wizard>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import DemandModal from '../components/demandModal.vue'
import DemandWizard from '../components/DemandWizard.vue'
import ExampleComponent from '../components/ExampleComponent.vue'
    export default {
  components: { ExampleComponent, DemandModal, DemandWizard },
        data() {
            return {
                'header': 'Dashboard'
            }
        }
    }
</script>

<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <h2>Your Dog</h2>
            </div>
            <div class="col-sm-12" v-if="pets.length">
                <div class="form-group">
                    <label class="col-md-2 control-label">Your Pet</label>
                    <div class="col-md-10">
                        <select
                                v-model="selectedPetId"
                        >
                            <option value="0">Select ...</option>
                            <option v-for="pet in pets" :value="pet.id">{{ pet.name }}</option>
                            <option value="-1">Add a pet...</option>
                        </select>
                    </div>
                </div>
                <br />
                <br />
            </div>
        </div>

        <div class="row" v-if="showNewPetForm || pets.length === 0">
            <div class="col-sm-12">
                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="pet_name">Name:</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="pet_name"
                               v-model="newPetData.name"
                               class="form-control"
                               id="pet_name"
                               placeholder=""
                               autocomplete="off"
                               style="text-align: center;"
                               autofocus
                               required
                        >
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="pet_breed">Breed:</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="pet_breed"
                               v-model="newPetData.breed"
                               class="form-control"
                               id="pet_breed"
                               placeholder=""
                               autocomplete="off"
                               style="text-align: center;"
                               autofocus
                               required
                        >
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="pet_weight">Weight:</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="pet_weight"
                               v-model="newPetData.weight"
                               class="form-control"
                               id="pet_weight"
                               placeholder=""
                               autocomplete="off"
                               style="text-align: center;"
                               autofocus
                               required
                        >
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-primary"
                        @click="saveNewPet()"
                >Save</button>
            </div>
        </div>
    </div>
</template>

<script>
import eventBus from '../../events/eventBus';
import swal from 'sweetalert2';

export default {
    data() {
        return {
            selectedPet: {},
            selectedPetId: null,
            pets: [],
            newPetData: {},
            showNewPetForm: false,
        };
    },
    methods: {
        getPets() {
            let vm = this;
            axios.get('/api/user/pets')
                .then(response => {
                    vm.pets = response.data;
                })
                .catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Unable to fetch pets..',
                        type: 'error',
                    });
                })
        },
        createPet() {
            let vm = this;
            axios.post('/api/pets', vm.newPetData)
                .then(function(response) {
                    swal('Welcome ' + response.data.name + ' to the family!');
                    vm.setPet(response.data);
                })
        },
        setPet(pet) {
            this.selectedPetId = pet.id;
        },
        saveNewPet() {
            let vm = this;
            axios.post('/api/user/pets', vm.newPetData)
                .then(function(response) {
                    console.log(response.data);
                    vm.pets = response.data;
                    swal('You list of pets has been updated.');
                })
                .catch(function(error) {
                    swal('There was an error....');
                });
        }
    },
    watch: {
        selectedPetId(petId, oldPetId) {
            if (petId < 0) {
                this.showNewPetForm = true;
            } else {
                this.showNewPetForm = false;
                this.eventBus.emit('selectedPetChanged', { pet_id: petId });
            }
        }
    },
    mounted() {
        this.getPets();
    }
}
</script>

<style>

</style>
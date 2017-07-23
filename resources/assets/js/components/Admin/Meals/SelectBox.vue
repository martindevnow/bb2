<template>
    <section>
        <div class="form-group">
            <span class="meal-title">{{ label }}</span>
            <select class="form-control meal-select"
                    :id="selectedId"
                    v-model="selectedMeal"
            >
                <option v-for="meal in meals"
                        :selected="meal.id === selectedMeal.id"
                        :value="meal">{{ meal.label }}</option>
            </select>
        </div>
        <div class="ajax-success-message">Updated</div>
    </section>
</template>

<script>
export default {
    props: ['day', 'package_id', 'label', 'preset_meal_id'],
    data() {
        return {
            selectedMeal: {},
            meals: []
        }
    },
    mounted() {
        this.loadMeals();
        if (this.preset_meal_id != 0) {
            let meals = this.meals.filter((meal) => {
                return meal.id == this.preset_meal_id;
            });
            if (meals.length !== 1) {
                return null;
            }
            this.selectedMeal = meals[0];
        }
    },
    computed: {
        selectedId() {
            return 'select-' + this.day + 'B';
        }
    },
    methods: {
        loadMeals() {
            let vm = this;
            axios.get('/api/meals').then(function(response) {
                vm.meals = response.data;
            }).catch(function(error) {
                console.log(error);
            })
        }
    },
    watch: {
        selectedMeal(newMeal, oldMeal) {
            if (newMeal == 'Breakfast' || newMeal == 'Dinner' || newMeal == '')
                return ;

            axios.post('/admin/packages/' + this.package_id + '/setMeal', {
                'meal_id': this.selectedMeal.id,
                'calendar_code': this.day
            }).then(function(response) {
                $('.ajax-success-message').show().delay(3000).fadeOut(350);
            }).catch(function(error) {
                alert('There was an error.');
            });
        }
    }

}
</script>

<style>
    .ajax-success-message {
        display: none;
        background: #c3eca5;
        border: 1px solid rgba(150, 177, 132, 0.38);
        position: fixed;
        right: 20px;
        bottom: 40px;
        height: 6rem;
        width: 20rem;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
</style>
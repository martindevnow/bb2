<template>
    <section>
        <div class="form-group">
            <select class="form-control meal-select"
                    :id="selectedId"
                    v-model="meal"
            >
                <option>{{ defaultMeal.label }}...</option>
                <option v-for="meal in meals"
                        :value="meal">{{ meal.label }}</option>
            </select>
        </div>
        <div class="ajax-success-message">Updated</div>
    </section>
</template>

<script>
export default {
    props: ['day', 'package_id', 'meals', 'label', 'defaultMeal'],
    data() {
        return {
            meal: {}
        }
    },
    mounted() {
        if (this.defaultMeal == '') {
            this.defaultMeal = { label: this.label };
        }
    },
    computed: {
        selectedId() {
            return 'select-' + this.day + 'B';
        }
    },
    methods: {
    },
    watch: {
        meal(newMeal, oldMeal) {
            if (newMeal == 'Breakfast' || newMeal == 'Dinner' || newMeal == '')
                return ;

            axios.post('/admin/packages/' + this.package_id + '/setMeal', {
                'meal_id': this.meal.id,
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
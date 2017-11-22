<template>
    <div>
        <admin-topping-selector v-for="(topping, index) in toppings"
                                :key="index"
                                v-model="toppings[index]"
                                :deletable="true"
                                @delete="removeTopping(index)"
        ></admin-topping-selector>
        <button class="btn btn-primary btn-block"
                @click="addTopping()"
        >Add Topping</button>


        <div class="">
            <admin-addresses-creator></admin-addresses-creator>
        </div>

        <div class="row">
            <admin-address-selector userId="8" v-model="address"></admin-address-selector>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            toppings: [],
            address: {},
        };
    },
    methods: {
        addTopping() {
            this.toppings.push({});
        },
        removeTopping(index) {
            this.toppings.splice(index, 1);
        }
    }

}
</script>

<style>

</style>
<template>
    <div>



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
<template>
    <div>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
            <tr>
                <td>Name</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="meat in collection">
                <td>{{ meat.label }}</td>
                <td>
                    <button class="btn btn-primary btn-xs">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: [],
    data() {
        return {
            collection: [],
        }
    },
    mounted() {
        this.getCollection();
    },
    methods: {
        getCollection() {
            let vm = this;
            axios.get('/api/meats')
                .then(response => vm.collection = response.data)
                .catch(error => vm.errors = error);
        }
    },
}
</script>

<style>

</style>
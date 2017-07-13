<template>
    <div>
        <div class="form-group is-empty">
            <label for="selected_pet_name" class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
                <input type="email" class="form-control" id="selected_pet_name" placeholder="Name"> </div>
        </div>

        <div class="form-group is-empty">
            <label for="selected_pet_weight" class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
                <input type="email" class="form-control" id="selected_pet_weight" placeholder="Weight"> </div>
        </div>

        <div class="form-group">
            <label for="selected_package" class="col-md-2 control-label">Package</label>
            <div class="col-md-10">
                <div class="btn-group bootstrap-select form-control">
                    <select id="selected_package"
                            class="form-control selectpicker"
                            data-dropup-auto="false"
                            tabindex="-98">
                        <option>Basic</option>
                        <option>Classic </option>
                        <option>Premium</option>
                        <option>Prey</option>
                    </select></div>
            </div>
        </div>

        <div class="form-group">
            <label for="selected_package" class="col-md-2 control-label">Activity Level</label>
            <div class="col-md-10">
                <div class="btn-group bootstrap-select form-control">
                    <select id="selected_activity_level"
                            class="form-control selectpicker"
                            data-dropup-auto="false"
                            tabindex="-98">
                        <option>Low</option>
                        <option>Medium </option>
                        <option>High</option>
                        <option>Prey</option>
                    </select></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [],
    data() {
        return {};
    },
    methods: {

    },
}
</script>

<style>

</style>
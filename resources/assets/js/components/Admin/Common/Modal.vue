<template>

    <div class="modal fade in" role="dialog" style="padding-right: 15px; display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="$emit('close')">
                        ×
                    </button>
                    <h4 class="modal-title">
                        <slot name="title"></slot>
                    </h4>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="$emit('close')">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="processChildForm()">
                        <slot name="submit"></slot>
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</template>

<script>
export default {
    props: [],
    data() {
        return {};
    },
    methods: {
        processChildForm() {
            console.log(this.$slots.body);
            this.$slots.body[0].componentInstance.alertMe();
        }
    }

}
</script>

<style>

</style>
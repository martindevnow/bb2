<template>

    <div class="modal fade in" role="dialog" style="padding-right: 15px; display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="closeModal()">
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
                    <button type="button" class="btn btn-default" @click="closeModal()">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="processChildForm()">
                        <slot name="submit">Submit</slot>
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</template>

<script>
    import eventBus from '../../../events/eventBus';

export default {
    props: [],
    data() {
        return {};
    },
    methods: {
        processChildForm() {
            console.log('body', this.$slots.body);
            this.$slots.body[0].componentInstance.processForm();
        },
        closeModal(params) {
            this.$emit('close');
        }
    },
    mounted() {
        eventBus.$on('order-marked-as-paid', this.closeModal(order_id));
    },
    beforeDestroy() {
        eventBus.$off('order-marked-as-packed', this.closeModal(order_id));
    }

}
</script>

<style>

</style>
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
    props: ['model_type', 'model_id'],
    data() {
        return {};
    },
    methods: {
        processChildForm() {
            let vm = this;
            console.log('body', this.$slots.body);
            // TODO
            // This should return a promise.... then i can handle closing the form here FFS....
            // and Then, i can avoid all of this $emitting BS...
            this.$slots.body[0].componentInstance.processForm()
                .then(response => {
                    console.log('success....');
                    vm.closeModal();
                })
                .catch(error => {
                    console.log('error.response', error.response);
                    let errorMessage = '';
                    for (let propertyName in error.response.data.errors) {
                        errorMessage = errorMessage + ' ' + error.response.data.errors[propertyName];
                    }
                    console.log(errorMessage);
                });
        },
        closeModal() {
            return this.$emit('close');
        }
    },

}
</script>

<style>

</style>
<template>
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 15px; display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        <slot name="header">
                            Packed Order
                        </slot>
                    </h4>
                </div>
                <div class="modal-body">

                    <slot name="body">
                        Load your component in here...
                    </slot>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</template>

<script>
    import { mapState } from 'vuex';

    export default {
        props: [],
        data() {
            return {};
        },
        computed: mapState(['selected', 'show'])
    }
</script>

<style scoped>
.modal-body {
    margin-top: 0;
}
</style>
<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            Packed Order
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            Load your component in here...
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
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

<style>

</style>
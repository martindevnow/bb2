<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            Log a Payment
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <admin-payment-logger @close="$emit('close')"></admin-payment-logger>
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
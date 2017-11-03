<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('content') }"
                >
                    <label for="content">content</label>
                    <textarea class="form-control"
                              id="content"
                              name="content"
                              v-model="form.content"
                    ></textarea>
                    <span class="help-block">{{ errors.get('content') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="closeNoteCreatorModal()"
                >
                    Cancel
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import hasErrors from '../../../mixins/hasErrors';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import swal from 'sweetalert2'

    export default {
        mixins: [
            hasErrors
        ],
        props: [],
        data() {
            return {
                form: {
                    content: '',
                },
            };
        },
        methods: {
            ...mapActions('notes', [
                'closeNoteCreatorModal',
            ]),
            save() {
                let vm = this;
                let modelName = this.targeted.type;
                let modelId = this.targeted.model.id;
                axios.post('/admin/api/notes', {
                    ...this.form,
                    modelName,
                    modelId,
                }).then(response => {
                    swal('success', 'Saved', 'success');
                    vm.$emit('saved');
                }).catch(error => {
                    vm.errors.record(error.response.data.errors);
                })
            }
        },
        computed: {
            ...mapState('notes', [
                'targeted',
            ]),
        }
    }
</script>

<style>

</style>
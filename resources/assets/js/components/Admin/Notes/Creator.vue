<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">
            <h1>Existing Notes</h1>
            <div class="col-sm-12" v-if="targeted.model.comment"></div>
            <div class="col-sm-12" v-for="note in targeted.model.notes">
                {{ note.content }}
                <button class="btn btn-xs btn-danger"
                        @click="deleteNote(note.id)"
                >
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
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
                <button class="btn btn-success btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="$emit('cancelled')"
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
    import * as noteActions from "../../../vuex/modules/notes/actionTypes";

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
            save() {
                let vm = this;
                let modelName = this.targeted.type;
                let modelId = this.targeted.model.id;
                this.$store.dispatch('notes/' + noteActions.SAVE, {
                    ...this.form, modelName, modelId,
                }).then(response => {
                    swal('success', 'Saved', 'success');
                    vm.$emit('saved');
                }).catch(error => {
                    vm.errors.record(error.response.data.errors);
                });
            },
            deleteNote(id) {
                this.$store.dispatch('notes/' + noteActions.DELETE, id)
                .then(response => {
                    alert('deleted');
                }).catch(error => {
                    console.log(error);
                    alert('error');
                });
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
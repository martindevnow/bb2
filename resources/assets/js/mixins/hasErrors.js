import Errors from '../models/Errors';

export default {
    data() {
        return {
            errors: new Errors()
        }
    },
    mounted() {
        console.log('mounted the hasErrors mixin');
        this.errors = new Errors();
    }
}
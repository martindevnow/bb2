import Errors from '../models/Errors';

export default {
    data() {
        return {
            errors: new Errors()
        }
    },
    mounted() {
        this.errors = new Errors();
    }
}
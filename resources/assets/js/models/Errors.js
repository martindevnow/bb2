export default class Errors {
    constructor() {
        this.errors = {};
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    has(field) {
        return  !! this.errors[field];
    }

    record(errors) {
        this.errors = { ...this.errors, ...errors };
    }

    clear(field) {
        console.log('clearing .. ' + field);
        delete this.errors[field];
    }
}
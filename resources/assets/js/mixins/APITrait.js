import eventBus from './../events/eventBus';

export default {
    data() {
        return {
            resourceUri: "",
            modelType: "",
            dataModelName: "",
        }
    },
    methods: {
        setResource(uri) {
            this.resourceUri = uri;
        },
        setModelType(name) {
            this.modelType = name;
            this.dataModelName = 'selected' + name;
        },
        toUnderscore(stringVar) {
            let replaced = stringVar.replace(/[a-z][A-Z]/g, function(str, offset) {
                return str[0].toLowerCase() + '_' + str[1].toLowerCase();
            });
            return replaced[0].toLowerCase() + replaced.slice(1);
        },
    }
}
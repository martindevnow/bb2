export default {
    data() {
        return {
            sortable: {
                sortKey: '',
                filterKey: '',
            },
        };
    },
    computed: {

    },
    methods: {
        filteredData (data) {
            if (! this.sortable || ( ! this.sortable.filterKey && ! this.sortable.sortKey) ) {
                return data;
            }

            let sortKey = this.sortable.sortKey;
            let filterKey = this.sortable.filterKey && this.sortable.filterKey.toLowerCase();

            let order = this.sortOrders[sortKey] || 1;
            // let data = this.collection;
            if (filterKey) {
                data = data.filter(function (row) {
                    return Object.keys(row).some(function (key) {
                        if (row[key] !== null && typeof row[key] === 'object')
                        {
                            // the value of this item is an object... search one level deeper
                            return Object.keys(row[key]).some(function (sec_key) {
                                return String(row[key][sec_key]).toLowerCase().indexOf(filterKey) > -1;
                            });
                        }
                        return String(row[key]).toLowerCase().indexOf(filterKey) > -1;
                    });
                })
            }
            if (sortKey) {
                data = data.slice().sort(function (a, b) {
                    a = a[sortKey];
                    b = b[sortKey];
                    return (a === b ? 0 : a > b ? 1 : -1) * order;
                })
            }
            return data;
        },
        sortBy (key) {
            this.sortable.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
    },
    filters : {
        capitalize (str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    },
}
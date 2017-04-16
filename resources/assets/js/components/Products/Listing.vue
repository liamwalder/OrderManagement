<script>
    import eventHub from '../../src/EventHub.js';
    import ListingMixin from '../Listing/Table.vue';

    export default {

        mixins: [ ListingMixin ],

        mounted: function () {
            var self = this;
            eventHub.$on('search', function (searchTermValue) {
                self.search(searchTermValue);
            });
            eventHub.$on('successfulSubmission', function () {
                self.getData(self.lastApiUrlCalled);
            });
        },

        methods: {
            transform(value, key) {
                let newValue = '';
                if (key == 'description') {
                    newValue = value.substring(0, 50) + '...';
                } else {
                    newValue = value;
                }
                value = newValue;
                return value;
            },
            edit: function(entry) {
                eventHub.$emit('editProduct', entry);
            }
        }

    }
</script>

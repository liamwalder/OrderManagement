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
                if (key == 'addresses') {
                    newValue += '<ul>';
                    value.forEach(function(address, key) {
                        newValue += '<li>'
                        if (value.length > 1) {
                            if (address.primary == 1) {
                                newValue += '<strong>PRIMARY</strong> ';
                            }
                        }
                        newValue += address.address_1 + ', '
                                + address.address_2 + ', '
                                + address.town + ', '
                                + address.county + ', '
                                + address.postcode
                                + '</li>';
                        newValue = newValue.replace('null,', '');
                    });
                    newValue += '</ul>';
                } else {
                    newValue = value;
                }

                value = newValue;
                return value;
            },

            edit: function(entry) {
                eventHub.$emit('editCustomer', entry);
            }

        }

    }
</script>

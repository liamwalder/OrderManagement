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
        },

        methods: {

            transform(value, key) {
                let newValue = '';
                if (key == 'address') {
                    newValue += '<ul>';
                    newValue += '<li>'
                    newValue += value.address_1 + ', '
                            + value.address_2 + ', '
                            + value.town + ', '
                            + value.county + ', '
                            + value.postcode
                            + '</li>';
                    newValue = newValue.replace('null,', '');
                    newValue += '</ul>';
                } else if(key == 'customer') {
                    newValue = value.firstname + ' ' + value.surname;

                } else if(key == 'value') {
                    newValue = '£'+value;

                } else if (key == 'status') {
                    let className  = '';
                    if (value == 'Placed') {
                        className = '';
                    } else if (key == 'Processed') {
                        className = 'orange';
                    } else if (key == 'Completed') {
                        className = 'green';
                    }
                    newValue = '<span class="status ' + className + '">' + value + '</span>';
                } else {
                    newValue = value;
                }

                value = newValue;
                return value;
            },

            remove(entry) {
                console.log('remove');
            },

            edit(entry) {
                window.location = '/orders/edit/' + entry.id;
            }

        }

    }
</script>

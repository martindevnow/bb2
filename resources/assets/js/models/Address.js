
export class Address {}

export const loadAddressFromData = function(data) {
    let address = new Address();

    address.id                  = data.id;
    address.active              = data.active;
    address.name                = data.name;
    address.description         = data.description;
    address.company             = data.company;
    address.street_1            = data.street_1;
    address.street_2            = data.street_2;
    address.city                = data.city;
    address.province            = data.province;
    address.postal_code         = data.postal_code;
    address.country             = data.country;

    address.phone               = data.phone;
    address.buzzer              = data.buzzer;

    address.addressable_id      = data.addressable_id;
    address.addressable_type    = data.addressable_type;

    return address;
};
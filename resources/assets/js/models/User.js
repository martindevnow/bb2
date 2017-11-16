import {loadPetFromData} from "./Pet";

export class User {
    getPets() {
        if (! this.pets) {
            return '';
        }

        return this.pets.map(pet => {
            return pet.name;
        }).join(', ');
    }
}

export const loadUserFromData = function(data) {
    let user = new User();

    user.id                     = data.id;
    user.name                   = data.name;
    user.email                  = data.email;
    user.first_name             = data.first_name;
    user.last_name              = data.last_name;
    user.phone_number           = data.phone_number;
    user.stripe_id              = data.stripe_id;
    user.stripe_customer_id     = data.stripe_customer_id;
    user.stripe_active          = data.stripe_active;
    user.subscription_end_at    = data.subscription_end_at;

    user.pets = data.pets ? data.pets.map(pet => {
        return loadPetFromData(pet);
    }) : null;

    // ToDo: build a loader for Addresses...
    user.addresses = data.addresses ? data.addresses : null;

    return user;
};
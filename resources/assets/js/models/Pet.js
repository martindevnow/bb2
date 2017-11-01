import {loadUserFromData} from "./User";

export class Pet {
    ownerName() {
        return (!! this.owner) ? this.owner.name : '';
    }
}

export const loadPetFromData = function (data) {
    let pet = new Pet();

    pet.id = data.id;
    pet.name = data.name;
    pet.breed = data.breed;
    pet.weight = data.weight;
    pet.species = data.species;
    pet.activity_level = data.activity_level;
    pet.birthday = data.birthday;
    pet.daily_meals = data.daily_meals;
    pet.owner = data.owner ? loadUserFromData(data.owner) : null;
    return pet;
};
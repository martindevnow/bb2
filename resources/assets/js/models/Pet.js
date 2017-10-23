import {loadUserFromData} from "./User";

export class Pet {

}

export const loadPetFromData = function (data) {
    let pet = new Pet();
    pet.name = data.name;
    pet.breed = data.breed;
    pet.weight = data.weight;
    pet.species = data.species;
    pet.activity_level = data.activity_level;
    pet.birthday = data.birthday;
    pet.owner = data.owner ? loadUserFromData(data.owner) : null;
    return pet;
};
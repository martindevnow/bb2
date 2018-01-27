
export class Courier {}

export const loadCourierFromData = function(data) {
    let courier = new Courier();

    courier.id      = data.id;
    courier.code    = data.code;
    courier.label   = data.label;

    return courier;
};
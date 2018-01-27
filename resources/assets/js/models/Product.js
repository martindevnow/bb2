export class Product {
}

export const loadProductFromData = function(data) {
    let product = new Product();

    product.id =            data.id;
    product.name =          data.name;
    product.description =   data.description;
    product.description_long = data.description_long;
    product.size =          data.size;
    product.sku =           data.sku;
    product.ingredients =   data.ingredients;
    product.price =         Number.parseFloat(data.price);
    product.active =         data.active;

    return product;
};
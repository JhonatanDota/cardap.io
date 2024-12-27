import { MenuItemModel } from "../models/menuModels";

export const MENU_ITEM_1: MenuItemModel = {
  id: 1,
  name: "Cheese Burguer",
  price: 28.99,
  ingredients: [
    "Queijo",
    "Tomate",
    "Carne",
    "Alface",
    "Barbecue",
    "Maionese",
    "Pão Brioche",
    "Ervilha",
    "Milho",
  ],
  description:
    "Ingredientes selecionados para um Burguer maravilhoso e saboroso!.",
  image: null,
  available: true,
};

export const MENU_ITEM_2: MenuItemModel = {
  id: 2,
  name: "Pizza Margherita",
  price: 45.5,
  ingredients: ["Mussarela", "Manjericão", "Molho de tomate"],
  description: "Clássica pizza italiana com ingredientes frescos.",
  image:
    "https://www.biggerbolderbaking.com/wp-content/uploads/2020/11/Homemade-Dunkin-Donuts-WS-Thumb-scaled.jpg",
  available: true,
};

export const MENU_ITEM_3: MenuItemModel = {
  id: 3,
  name: "Salada Caesar",
  price: 22.0,
  ingredients: ["Alface", "Croutons", "Molho Caesar", "Parmesão"],
  description: "Leve e deliciosa para uma refeição saudável.",
  image:
    "https://www.shutterstock.com/image-photo/fried-salmon-steak-cooked-green-600nw-2489026949.jpg",
  available: true,
};

export const MENU_ITEM_4: MenuItemModel = {
  id: 4,
  name: "Sushi Combo",
  price: 78.9,
  ingredients: ["Salmão", "Arroz", "Nori", "Cream Cheese"],
  description: "Seleção especial de sushis frescos.",
  image:
    "https://cdn.sanity.io/images/cctd4ker/production/9dfaeda73538877faf9c927ec8c8d6863c2c2111-4800x3200.jpg?w=3840&q=75&fit=clip&auto=format",
  available: false,
};

export const MENU_ITEM_5: MenuItemModel = {
  id: 5,
  name: "Brownie de Chocolate",
  price: 12.5,
  ingredients: ["Chocolate", "Manteiga", "Açúcar", "Ovos"],
  description: "Doce irresistível para os amantes de chocolate.",
  image:
    "https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Pizza-3007395.jpg/1200px-Pizza-3007395.jpg",
  available: true,
};

export type MenuModel = {
  id: number;
  sections: MenuSectionModel[];
};

export type MenuSectionModel = {
  id: number;
  name: string;
  items: MenuItemModel[];
  order: number;
};

export type MenuItemModel = {
  id: number;
  name: string;
  price: number;
  ingredients: string[];
  description: string;
  image: string | null;
  available: boolean;
};

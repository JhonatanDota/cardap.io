import { MenuSectionModel } from "../models/menuModels";
import { MENU_ITEM_1, MENU_ITEM_2, MENU_ITEM_3 } from "./menuItem";

export const MENU_SECTION_1: MenuSectionModel = {
  id: 1,
  name: "Burguers",
  items: [MENU_ITEM_1, MENU_ITEM_2, MENU_ITEM_3],
  order: 1,
};

export const MENU_SECTION_2: MenuSectionModel = {
  id: 2,
  name: "Doces",
  items: [MENU_ITEM_2],
  order: 1,
};

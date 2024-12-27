import { AddressModel } from "../models/addressModels";

export const ADDRESS_1: AddressModel = {
  id: 1,
  street: "123 Main Street",
  number: "101",
  neighborhood: "Downtown",
  city: "New York",
  postalCode: "10001",
  state: "NY",
  complement: null,
};

export const ADDRESS_2: AddressModel = {
  id: 2,
  street: "456 Oak Avenue",
  number: "205B",
  complement: "Apt 3C",
  neighborhood: "Greenfield",
  city: "Los Angeles",
  postalCode: "90001",
  state: "CA",
};

export const ADDRESS_3: AddressModel = {
  id: 3,
  street: "789 Pine Road",
  number: "32",
  neighborhood: "Sunnyvale",
  city: "San Francisco",
  postalCode: "94101",
  state: "CA",
  complement: null,
};

import { AddressModel } from "../models/addressModels";

export function addressFormatter(address: AddressModel): string {
  return `${address.street}, ${address.number} - ${address.neighborhood} - ${address.city}/${address.state}`;
}

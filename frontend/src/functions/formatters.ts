import { AddressModel } from "../models/addressModels";

export function addressFormatter(address: AddressModel): string {
  return `${address.street}, ${address.number} - ${address.neighborhood} - ${address.city}/${address.state}`;
}

export function currencyFormatter(
  number: number,
  locale: string = "pt-BR",
  currency: string = "BRL"
): string {
  return Intl.NumberFormat(locale, {
    style: "currency",
    currency: currency,
  }).format(number);
}

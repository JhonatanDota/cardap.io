import { PaymentMethodEnum } from "../enums/payment";
import { PaymentMethodModel } from "../models/paymentMethodModels";

export const PAYMENT_METHODS_1: PaymentMethodModel[] = [
  PaymentMethodEnum.CASH,
  PaymentMethodEnum.CREDIT_CARD,
  PaymentMethodEnum.PIX,
];

export const PAYMENT_METHODS_2: PaymentMethodModel[] = [PaymentMethodEnum.PIX];

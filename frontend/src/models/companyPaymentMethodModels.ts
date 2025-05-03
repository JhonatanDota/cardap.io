import { PaymentMethodEnum } from "../enums/payment";

export default interface CompanyPaymentMethodModel {
  id: number;
  companyId: number;
  paymentMethod: PaymentMethodEnum;
}

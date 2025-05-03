import {
  PaymentMethodEnum,
  PaymentMethodReadableEnum,
} from "../../enums/payment";

import PixIcon from "../../icons/PixIcon";
import CreditCardIcon from "../../icons/CreditCardIcon";
import CashIcon from "../../icons/CashIcon";

export type PaymentMethodConstantType = {
  slug: PaymentMethodEnum;
  name: PaymentMethodReadableEnum;
  icon: React.ReactNode;
};

export const paymentMethodsConstant: PaymentMethodConstantType[] = [
  {
    slug: PaymentMethodEnum.PIX,
    name: PaymentMethodReadableEnum.PIX,
    icon: <PixIcon />,
  },
  {
    slug: PaymentMethodEnum.CREDIT_CARD,
    name: PaymentMethodReadableEnum.CREDIT_CARD,
    icon: <CreditCardIcon />,
  },
  {
    slug: PaymentMethodEnum.CASH,
    name: PaymentMethodReadableEnum.CASH,
    icon: <CashIcon />,
  },
  {
    slug: PaymentMethodEnum.DEBIT_CARD,
    name: PaymentMethodReadableEnum.DEBIT_CARD,
    icon: <CreditCardIcon />,
  },
];

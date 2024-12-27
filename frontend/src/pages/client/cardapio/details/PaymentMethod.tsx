import { PaymentMethodsModel } from "../../../../models/paymentMethodModels";
import {
  PaymentMethodEnum,
  PaymentMethodReadableEnum,
} from "../../../../enums/payment";

import CashIcon from "../../../../icons/CashIcon";
import PixIcon from "../../../../icons/PixIcon";
import CreditCardIcon from "../../../../icons/CreditCardIcon";

interface PaymentMethodProps {
  paymentMethods: PaymentMethodsModel;
}

export default function PaymentMethod(props: PaymentMethodProps) {
  const { paymentMethods } = props;

  const paymentMethodIconsMap = {
    [PaymentMethodEnum.CASH]: <CashIcon />,
    [PaymentMethodEnum.PIX]: <PixIcon />,
    [PaymentMethodEnum.CREDIT_CARD]: <CreditCardIcon />,
  };

  return (
    <div className="flex flex-col items-center gap-1 md:gap-3">
      <h3 className="uppercase text-base md:text-xl font-medium">
        Formas de Pagamento
      </h3>

      <div className="grid grid-cols-2 gap-y-2">
        {paymentMethods.map((paymentMethod, index) => (
          <div
            className="flex flex-row items-center gap-2 md:gap-3"
            key={index}
          >
            <svg className="w-8 md:w-10 h-8 md:h-10">
              {paymentMethodIconsMap[paymentMethod]}
            </svg>

            <span className="text-sm md:text-lg">
              {PaymentMethodReadableEnum[paymentMethod]}
            </span>
          </div>
        ))}
      </div>
    </div>
  );
}

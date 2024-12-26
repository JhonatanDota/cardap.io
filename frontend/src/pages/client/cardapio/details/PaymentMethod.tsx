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
    <div className="flex flex-col items-center gap-1">
      <h3 className="uppercase text-base font-medium">Formas de Pagamento</h3>

      <div className="grid grid-cols-2 gap-y-2 justify-items-center">
        {paymentMethods.map((paymentMethod, index) => (
          <div className="flex flex-row items-center gap-2" key={index}>
            <svg className="w-8 h-8">
              {paymentMethodIconsMap[paymentMethod]}
            </svg>

            <span className="text-sm font-medium">
              {PaymentMethodReadableEnum[paymentMethod]}
            </span>
          </div>
        ))}
      </div>
    </div>
  );
}

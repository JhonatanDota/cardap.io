import { PaymentMethodsModel } from "../../../../models/paymentMethodModels";

import PaymentMethod from "./PaymentMethod";

interface CardapioDetailsProps {
  paymentMethods: PaymentMethodsModel;
}

export default function CardapioDetails(props: CardapioDetailsProps) {
  const { paymentMethods } = props;

  return (
    <div className="flex justify-between p-3">
      <PaymentMethod paymentMethods={paymentMethods} />
    </div>
  );
}

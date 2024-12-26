import { OpeningHoursModel } from "../../../../models/openingHoursModels";
import { PaymentMethodsModel } from "../../../../models/paymentMethodModels";

import PaymentMethod from "./PaymentMethod";
import OpeningHour from "./OpeningHour";

interface CardapioDetailsProps {
  paymentMethods: PaymentMethodsModel;
  openingHours: OpeningHoursModel;
}

export default function CardapioDetails(props: CardapioDetailsProps) {
  const { paymentMethods, openingHours } = props;

  return (
    <div className="flex flex-col justify-between gap-6 p-3">
      <PaymentMethod paymentMethods={paymentMethods} />
      <OpeningHour openingHours={openingHours} />
    </div>
  );
}

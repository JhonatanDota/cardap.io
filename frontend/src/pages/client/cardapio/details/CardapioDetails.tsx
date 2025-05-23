import { CompanyOpeningHourModel } from "../../../../models/CompanyOpeningHoursModels";
import { PaymentMethodsModel } from "../../../../models/paymentMethodModels";

import PaymentMethod from "./PaymentMethod";
import OpeningHour from "./OpeningHour";

interface CardapioDetailsProps {
  paymentMethods: PaymentMethodsModel;
  openingHours: CompanyOpeningHourModel[];
}

export default function CardapioDetails(props: CardapioDetailsProps) {
  const { paymentMethods, openingHours } = props;

  return (
    <div className="flex flex-col justify-between gap-6 md:gap-10 p-3 md:p-6">
      <PaymentMethod paymentMethods={paymentMethods} />
      <OpeningHour openingHours={openingHours} />
    </div>
  );
}

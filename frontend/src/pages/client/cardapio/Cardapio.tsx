import { useEffect } from "react";
import { useParams } from "react-router-dom";

import CardapioHeader from "./header/CardapioHeader";
import CardapioDetails from "./details/CardapioDetails";
import CardapioMenu from "./menu/CardapioMenu";
import CardapioFooter from "./CardapioFooter";

export default function Cardapio() {
  const params = useParams();
  const cardapioSlug: string | undefined = params.slug;

  useEffect(function () {
    console.log(cardapioSlug);
  }, []);

  return (
    <div className="flex flex-col w-full md:w-1/2 md:m-auto">
      {/* <CardapioHeader company={COMPANY_1} address={ADDRESS_1} />
      <CardapioDetails
        paymentMethods={PAYMENT_METHODS_1}
        openingHours={OPENING_HOURS_1}
      />
      <CardapioMenu menu={MENU_1} /> */}
      <CardapioFooter />
    </div>
  );
}

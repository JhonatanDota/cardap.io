import { COMPANY_1 } from "../../../data/companies";
import { ADDRESS_1 } from "../../../data/addresses";
import { PAYMENT_METHODS_1 } from "../../../data/paymentMethods";

import { useEffect } from "react";
import { useParams } from "react-router-dom";

import CardapioHeader from "./header/CardapioHeader";
import CardapioDetails from "./details/CardapioDetails";
import CardapioItems from "./CardapioItems";
import CardapioFooter from "./CardapioFooter";

export default function Cardapio() {
  const params = useParams();
  const cardapioSlug: string | undefined = params.slug;

  useEffect(function () {
    console.log(cardapioSlug);
  }, []);

  return (
    <div className="flex flex-col">
      <CardapioHeader company={COMPANY_1} address={ADDRESS_1} />
      <CardapioDetails paymentMethods={ PAYMENT_METHODS_1 }/>
      <CardapioItems />
      <CardapioFooter />
    </div>
  );
}

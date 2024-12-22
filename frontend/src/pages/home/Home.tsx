import FeatureHighlight from "./components/FeatureHighlight";

import HamburguerIcon from "./icons/HamburguerIcon";
import PizzaIcon from "./icons/PizzaIcon";
import DinnerIcon from "./icons/DinnerIcon";

export default function Home() {
  return (
    <div className="flex flex-col justify-center items-center m-10 font-nunito-sans">
      <img
        className="w-full"
        src="/images/logos/CardapioBlackLogo.png"
        alt="Cardap.io"
      />

      <h3 className="text-lg font-bold text-orange-600 text-center my-10">
        Crie e personalize seu Cardap.io de forma descomplicada e
        rápida.
      </h3>

      <div className="grid grid-cols-1 gap-5">
        <FeatureHighlight
          icon={<HamburguerIcon />}
          title="Crie"
          text="Crie o seu Cardap.io e facilite a sua vida e a do seu cliente na hora do pedido."
        />

        <FeatureHighlight
          icon={<PizzaIcon />}
          title="Personalize"
          text="Personalize o Cardap.io com a cara do seu delivery."
        />

        <FeatureHighlight
          icon={<DinnerIcon/>}
          title="Gerencie"
          text="Gerencie o progresso das suas vendas, acompanhando tanto as entregas quanto as finanças."
        />
      </div>
    </div>
  );
}
